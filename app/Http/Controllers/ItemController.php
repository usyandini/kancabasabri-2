<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ItemController extends Controller
{
    public function index()
    {
    	return view('master.index');
    }

    public function tambahItem()
    {
    	return view('master.add-item');
    }

}
