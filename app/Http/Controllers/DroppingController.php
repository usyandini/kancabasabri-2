<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\PaymentJournalDropping;

class DroppingController extends Controller
{

    protected $model;

    public function __construct(PaymentJournalDropping $JDropping)
    {
        $this->model = $JDropping;
    }

    public function index() 
    {
        return view('dropping.index');
    }

    public function table()
    {
    	return view('table');
    }

    public function getAll(){
        $dropping = $this->model->get();
        $result = [];
        foreach ($dropping as $value) {
            $result[] = [
                'account'       => $value->OFFSETACCOUNT, 
                'journalnum'    => $value->JOURNALNUM, 
                'transdate'     => $value->TRANSDATE, 
                'credit'        => 'IDR '. number_format($value->CREDIT, 2),
                'mainaccount'   => $value->OFFSETMAINACCOUNT,
                'company'       => $value->COMPANY
            ];
        }
        return response()->json($result);
    }

    public function tarik_tunai()
    {
    	return view('dropping.tariktunai');
    }

    public function pengembalian()
    {
    	return view ('pengembalian');
    }

    public function penambahan()
    {
    	return view ('penambahan');
    }

    public function redirect($url, $statusCode = 303)
    {
       header('Location: ' . $url, true, $statusCode);
       die();
    }
}
