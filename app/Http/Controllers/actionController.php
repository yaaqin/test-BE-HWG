<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\actifity;
use App\Models\listBook;

class actionController extends Controller
{
    //Peminjaman
    function pinjamBuku($id, $user_id){
        $buku = listBook::find($id);
        $action = actifity::all();

        $isUserHasBorrowed = collect($action)->filter(function ($data) use ($user_id) {
            return $data['user_id'] == $user_id && $data["actifity"] === "pinjam";
        });
        if($user_id > 5){  //inisiasi user dengan id 1-5 (untuk history peminjaman)
            return "user id tidak terdaftar di server";
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
        $findAction = actifity::where('actifity', "pinjam")->get();

        // return $findAction;

        $action = actifity::all();
        $book = listBook::where("id" , $id)->get();
        $statusBuku = $book[0]->status;
        
        if($user_id > 5){  //validasi user 
            return "user id tidak terdaftar di server";
        }else if ($statusBuku ==  'tersedia'){ //validasi double action
            return response()->json([
                "msg" => "buku ini belum dipinjam"
            ]);
        }else if ($findAction){
            $findAction[0]->update([
                "actifity" => "buku telah dikembalikan"
            ]);
            $book[0]->update([
                    'status' => 'tersedia',
                    ]);
            return response()->json([
                "msg" => "buku berhasil dikembalikan",
                "detail" => $findAction
            ]);
        
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
}
