<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('layouts.blog.list');
    }

    
    public function create()
    {
        return view('blog.tambah');
    }
}
