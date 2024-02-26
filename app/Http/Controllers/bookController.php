<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\listBook;
use App\Models\actifity;
use App\Models\categori;

class bookController extends Controller

{
    //get all book
    function getAllBook(){
        $result = listBook::all();
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
        $result = listBook::where('status', 'dipinjam')->get();
        if ($result->count()>0){
            return response()->json([
                "status" => 200,
                "book-detail" => $result
            ], 200);
        }else {
            return response()->json([
                "status" => 404,
                "msg" => "semua buku tersedia untuk saat ini"
            ], 404);
        }
        }

    //get book by id
    function show($id){
        $result = listBook::find($id);
        if($result != null){ 
            $categori = $result->kategory_id;
            $bookCategori = categori::find($categori);
            return response()->json([
                "status" => 200,
                "kategory" => $bookCategori,
                "book-detail" => $result
               ], 200);
        }else{
            return response()->json([
                "status" => 404,
                "msg" => 'Data tidak ditemukan'
            ], 200);
        }
        
   
    }

    // create / add list book
    function addData(Request $request){
        $data = $request->all();

        $response = listBook::create($data);

        return response()->json([
            "status" => 201,
            "msg" => 'your book success to added'
           ], 201);
    }

    function editBuku(Request $request, listBook $listBook){
        if ($request->has('kategory_id') && $request->has('nama')) {
            $listBook->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit nama dan kategori",
                "detail buku setelah diedit" => $listBook
                ], 200);
         }else if ($request->has('nama')) {
            $listBook->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit nama",
                "detail buku setelah diedit" => $listBook,
            ], 200);
        } else if ($request->has('kategory_id')) {
            $listBook->update($request->all());
            return response()->json([
                "msg" => "anda telah berhasil mengedit kategori",
                "detail buku setelah diedit" => $listBook
               ], 200);
        } else {
            return response()->json([
                "msg" => "Berikan input perubahan dengan benar",
                "nilai perubahan" => ["nama", "kategory_id"],
                "msg2" => "isi setidaknya 1 dari nilai perubahan"
               ], 200);
        }
    }

    //delete book
    function Delete(listBook $listBook){
       $book->delete();
       return response()->json([
        "status" => 200,
        "msg" => 'your data has deleted'
       ], 200);
    }
    
    //add book with validator
    // public function postBook(ValAddBook $request){
        // $book = new listBook();
        // $book->id = $request->input('id');
        // $book->nama = $request->input('nama');
        // $book->kategory_id = $request->input('kategory_id');
        // $book->status = $request->input('status');
    
        // $book->save();
    
        // return "Book added successfully!";
        // $validator = Validator::make($request->all(), [

        //     'id' => 'required|num|max:32',
        //     'nama' => 'required|string|max:191',
        //     'kategory_id' => 'required|integer|max:191',
        //     'status' => 'required|string|max:191'
        // ]);
        // if($validator->fails()){ 
        //     return response()->json([
        //         "status" => 422,
        //         "errors" => $validator->messages()
        //     ], 422);
        // }else {
        //     $result = book::create([
        //         'nama' => $request->nama,
        //         'kategory' => $request->kategory,
        //         'status' => $request->status,
        //     ]);

        //     if($book){
        //         return response()->json([
        //             "status" => 200,
        //             "msg" => 'book added successfully'
        //         ], 200);
        //     }else {
        //         return response()->json([
        //             "status" => 500,
        //             "msg" => 'Something Wrong!!'
        //         ], 500);
        //     }
        // }
    // }
}
