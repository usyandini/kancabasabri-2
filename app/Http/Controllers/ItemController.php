<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;


use App\Models\AkunBank;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;

class ItemController extends Controller
{
    public function index()
    {
    	return view('master.item.index');
    }

    public function create()
    {
    	return view('master.item.tambah');
    }

}
