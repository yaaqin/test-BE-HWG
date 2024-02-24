<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\book;
use App\Models\actifity;
use App\Models\categori;

class bookController extends Controller

{
    //get all book
    function getAllBook(){
        $result = book::all();
        if($result->count()>0){ 
            return response()->json([
                "status" => 200,
                "list-book" => $result
            ], 200);
        }else {
            return response()->json([
                "status" => 404,
                "msg" => 'Data tidak ditemukan'
            ], 200);
        }
    }

    //get all book, status == dipinjam
    function Pinjam(){
        $result = Book::where('status', 'dipinjam')->get();
        return response()->json([
            "status" => 200,
               "book-detail" => $result
           ], 200);
        }

    //get book by id
    function show($id){
        $result = book::find($id);
        return response()->json([
            "status" => 200,
               "book-detail" => $result
           ], 200);
   
    }

    //create / add list book
    function addData(Request $request){
        $data = $request->all();

        $response = book::create($data);

        return response()->json([
            "status" => 201,
            "msg" => 'your book success to added'
           ], 201);
    }

    function editBuku(Request $request, book $book){
        if ($request->has('kategori') && $request->has('nama')) {
            $book->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit nama dan kategori",
                "detail buku setelah diedit" => $book
                ], 200);
         }else if ($request->has('nama')) {
            $book->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit nama",
                "detail buku setelah diedit" => $book,
            ], 200);
        } else if ($request->has('kategori')) {
            $book->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit kategori",
                "detail buku setelah diedit" => $book
               ], 200);
        } else {
            return response()->json([
                "msg" => "Berikan input perubahan dengan benar",
                "nilai perubahan" => ["nama", "kategori"],
                "msg2" => "isi setidaknya 1 dari nilai perubahan"
               ], 200);
        }
    }

    //delete book
    function Delete(book $book){
       $book->delete();
       return response()->json([
        "status" => 200,
        "msg" => 'your data has deleted'
       ], 200);
    }

    //CRUD CATEGORI

    //add kategori
    function addKategori(Request $request){
        $kategori = $request->all();

        categori::create($kategori);

        return response()->json([
            "status" => 201,
            "msg" => 'your category success to added'
           ], 201);
    }

    //get all kategori
    function allKategori(){
        $result = categori::all();

        return response()->json([
            "status" => 201,
            "All kategori" => $result
           ], 201);
    }


    //delete kategori
    function DeleteKategori(categori $categori){
        $categori->delete();
        return response()->json([
         "status" => 200,
         "msg" => 'categori has deleted'
        ], 200);
     }

    //Peminjaman
    function pinjamBuku($id, $user_id){
        $buku = book::find($id);
        $action = actifity::all();

        $isUserHasBorrowed = collect($action)->filter(function ($data) use ($user_id) {
            return $data['user_id'] == $user_id && $data["actifity"] === "pinjam";
        });
        if($user_id > 5){
            return "user id tidak terdaftar di server";
        // }else if($isUserHasBorrowed != null){
        //     return response()->json([
        //         "msg" => "user ini sudah meminjam buku, harap kembalikan buku terlebih dahulu",
        //         "detail" => $isUserHasBorrowed
        //    ], 404);
        }else if ($buku == null || $buku->status == 'dipinjam'){
            return response()->json([
                "msg" => "buku tidak tersedia, harap pilih buku yang lain"
           ], 404);
        }else {
            $buku->update([
                'status' => 'dipinjam',
            ]);
            actifity::create([
                'user_id' => $user_id,
                'book_id' => $id,
                'actifity' => "pinjam"
            ]);
    
            return response()->json([
                "status" => 200,
                "id buku yang dipinjam" => $id,
                "user peminjam" => $user_id,
                "msg" => "buku berhasil dipinjam",
                "detail buku yang dipinjam" => $buku
               ], 200);
        }
        }

    //pengebalian buku
    function restoreBuku($id, $user_id){
        $action = actifity::all();
        $isBookBorrowed = collect($action)->filter(function ($data) use ($user_id, $id) {
            return $data['user_id'] == $user_id && $data["book_id"] == $id && $data["actifity"] === "pinjam";
        });

        $isBookNotBorrowed = collect($action)->filter(function ($data) use ($user_id, $id) {
            return $data['user_id'] == $user_id && $data["book_id"] == $id && $data["actifity"] === "tersedia";
        });

        $book = book::find($id);

        $listBook = collect($action)->filter(function ($data) use ($user_id, $id) {
            return $data['user_id'] == $user_id &&  $data["actifity"] === "pinjam";
        });

        if($user_id > 5){  //validasi user
            return "user id tidak terdaftar di server";
        }else if ($book == null || $book->status == 'tersedia'){ //validasi double action
            return response()->json([
                "msg" => "buku ini belum dipinjam",
                "data buku yang dipinjam" => $listBook //jika user tidak meminjam buku apapun maka akan tampil object kosong
            ]);
        }else if ($isBookBorrowed){ //jika ada history bahwa user pernah meminjam buku dengan id terkait
            // actifity::create([
            //     'user_id' => $user_id,
            //     'book_id' => $id,
            //     'actifity' => "pengembalian"
            // ]);   
            $isBookBorrowed->update([
                "actifity" => "buku telah dikembalikan"
            ]);
            $book->update([
            'status' => 'tersedia',
        ]);
        return response()->json([
                "status" => 200,
                "buku yang dikembalikan" => $id,
                "user peminjam" => $user_id,
                "msg" => "buku berhasil dikembalikan",
                "detail buku yang dikembalikan" => $book
            ], 200);
        }
        }

        // get all actifity
        function allActifity(){
            $result = actifity::all();

            return response()->json([
                "status" => 201,
                "Data" => $result
            ], 201);
        }

        //delete actifity
        function dellActifity(actifity $actifity){
           
                $actifity->delete();
                return response()->json([
                    "status" => 201,
                    "msg" => 'actifity has deleted'
                ], 201);
            
        }

    
    //add book with validator
    // public function postBook(Request $request){
    //     $validator = Validator::make($request->all(), [

    //         'id' => 'required|num|max:32',
    //         'nama' => 'required|string|max:191',
    //         'kategory' => 'required|string|max:191',
    //         'status' => 'required|string|max:191'
    //     ]);
    //     if($validator->fails()){ 
    //         return response()->json([
    //             "status" => 422,
    //             "errors" => $validator->messages()
    //         ], 422);
    //     }else {
    //         $result = book::create([
    //             'nama' => $request->nama,
    //             'kategory' => $request->kategory,
    //             'status' => $request->status,
    //         ]);

    //         if($book){
    //             return response()->json([
    //                 "status" => 200,
    //                 "msg" => 'book added successfully'
    //             ], 200);
    //         }else {
    //             return response()->json([
    //                 "status" => 500,
    //                 "msg" => 'Something Wrong!!'
    //             ], 500);
    //         }
    //     }
    // }
}
