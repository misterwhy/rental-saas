<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// No need for 'use Illuminate\Routing\Controller;' anymore

class HomeController extends Controller // This should now work
{
    public function index()
    {
        return view('welcome'); // This should now work
    }
}