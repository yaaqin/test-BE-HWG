<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testApi;
use App\Http\Controllers\bookController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\actionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("data",[testApi::class,"getData"]);


//book CRUD
Route::get("list-book",[bookController::class,"getAllBook"]);
Route::get("show-book/{id}",[bookController::class,"show"]);
Route::get("dipinjam",[bookController::class,"Pinjam"]);
Route::post("add-book",[bookController::class,"addData"]);
Route::delete("delete/{listBook}",[bookController::class,"Delete"]);
Route::put("edit-buku/{listBook}",[bookController::class,"editBuku"]);

// Route::post("list-book",[bookController::class,"postBook"]);

//kategori CRUD
Route::post("add-kategori",[kategoriController::class,"addKategori"]);
Route::get("kategori",[kategoriController::class,"allKategori"]);
Route::put("kategori/{nama}",[kategoriController::class,"editKategori"]);
Route::delete("kategori/{nama}",[kategoriController::class,"DeleteKategori"]);

//data pinjam buku
Route::post("pinjam-buku/{id}/{user_id}",[actionController::class,"pinjamBuku"]);
Route::post("restore/{id}/{user_id}",[actionController::class,"restoreBuku"]);
Route::get("actifity",[actionController::class,"allActifity"]);
Route::delete("actifity/{actifity}",[actionController::class,"dellActifity"]);
