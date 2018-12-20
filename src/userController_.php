<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
	}

    public function viewUser($id) {
    	$dados = new \indaleto\configuration\Configuration;
		return view('/admin/user', ['user' => $dados->getUser($id)]);
	}

	public function viewUsers() {
		return view('/admin/users');
	}
}
