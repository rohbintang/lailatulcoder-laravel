<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboarcontroller extends Controller
{
    public function dashboard()
    {
        return view('welcome');
    }
}
