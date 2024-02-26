<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\categori;


class kategoriController extends Controller
{
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

    //edit kategori
    function editKategori(Request $request, $nama){
        $categoriEdited = categori::where('nama', $nama)->first();
        $newCategori = $request->nama;
        if ($categoriEdited != null){
            $categoriEdited->nama = $newCategori;
            $categoriEdited->save();
            return response()->json([
                "status" => 201,
                "msg" => 'kategori berhasil dirubah, sesuaikan kategori buku anda kembali'
               ], 201);
        }else {
            return response()->json([
                "status" => 404,
                "msg" => 'your category have to edit is not found'
               ], 404);
        }
    }

    //delete kategori
    function DeleteKategori($nama){
        $categoriHaveToDelete = categori::where('nama', $nama)->first();
        // return $categoriHaveToDelete;
        if ($categoriHaveToDelete != null){
            $categoriHaveToDelete->delete();
            return response()->json([
                "status" => 200,
                "msg" => 'categori has deleted, please check and change book in this category'
            ], 200);
        } else {
            return response()->json([
                "status" => 404,
                "msg" => 'your category have to delete is not found'
               ], 404);
        }
     }

}
