<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TransaksiController extends Controller
{
    public function index() 
    {
        return view('transaksi.input', ['filters' => null]);
    }

    public function view_transaksi()
    {
    	return view('transaksi.viewtransaksi');
    }
}
