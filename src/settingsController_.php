<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class settingsController extends \App\Http\Controllers\Controller
{

	public function __construct() {
		$this->middleware('auth');
	}

    public function viewSettings(){
    	$dados=new \indaleto\configuration\Configuration;
		return view('/admin/settings',[ 'empresa' => $dados->getConfig('empresa',''), 'imagem' => $dados->getConfig('imagem',"/img/brand/logo.svg")]);
	}
}
