<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testApi extends Controller
{
   function getData(){
    return ["nama"=>"yaqin", "umur"=>"22tahun", "email"=>"yaaqin.me@test.com"];
   }

   function listBuku(){
      $nama = "John Doe";
      // return book::all();
   }
}
