<?php

#namespace App\Http\Controllers;
namespace indaleto\configuration;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class configurationController extends Controller
{
	private $configuration;
	public function __construct(){
		$this->configuration = new  Configuration;
	}

    public function addUser(Request $request){
    	$i=$this->configuration->addUser([
			'name' =>$request->input('name'),
			'email' => $request->input('email'),
			'type' => $request->input('type')]);
		return redirect("admin/users/$i");
    }

    public function delUser($id) {
		$this->configuration->remUser($id);
		return redirect('/admin/users');
	}

	public function editUser(Request $request, $id) {
		$this->configuration->editUser($id,[
			'name' =>$request->input('name'),
			'email' => $request->input('email'),
			'type' => $request->input('type')]);
		return redirect("admin/users/$id");
	}

	public function sendResetPasswordLink($id) {
		$this->configuration->resetPassword($id);
		return redirect("admin/users/$id");		
	}

	public function remLogo(){
		$this->configuration->removeConfig('imagem');
		return redirect('/admin/settings');
	}

	public function editSettings(Request $request){
			
		$this->configuration->setConfig('empresa',$request->input('empresa'));
		if ($request->hasFile('imagem') && $request->file('imagem')->isValid()){
			$filename = $request->file('imagem');
			$ext = $filename->getClientOriginalExtension();
			$path = public_path() . '/img/uploads';
			$this->configuration->setConfig('imagem','/img/uploads/backofficeImg.'.$ext);
			$filename->move($path, 'backofficeImg.'.$ext);
		}
		return redirect('/admin/settings');
	}

}
