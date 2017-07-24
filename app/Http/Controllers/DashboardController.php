<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\PaymentJournalDropping;

class DashboardController extends Controller
{
	protected $user;

	public function __construct(User $user, PaymentJournalDropping $ft)
	{
		$this->user = $user;
		$this->ft = $ft;
	}

    public function index()
    {
    	return view('dashboard.index');
    }
}
