<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testApi;
use App\Http\Controllers\bookController;

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
Route::delete("delete/{book}",[bookController::class,"Delete"]);
Route::put("edit-buku/{book}",[bookController::class,"editBuku"]);

// Route::post("list-book",[bookController::class,"postBook"]);

//kategori CRUD
Route::post("add-kategori",[bookController::class,"addKategori"]);
Route::get("kategori",[bookController::class,"allKategori"]);
Route::delete("kategori/{categori}",[bookController::class,"DeleteKategori"]);

//data pinjam buku
Route::post("pinjam-buku/{id}/{user_id}",[bookController::class,"pinjamBuku"]);
Route::post("restore/{id}/{user_id}",[bookController::class,"restoreBuku"]);
Route::get("actifity",[bookController::class,"allActifity"]);
Route::delete("actifity/{actifity}",[bookController::class,"dellActifity"]);
