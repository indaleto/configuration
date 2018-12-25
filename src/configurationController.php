<?php

namespace indaleto\configuration;

/**********************************************************************
IMPLEMENTAÇÃO: MÉTODOS DISPONÍVEIS:

Utilizadores
getUser($id)
remUser($id)
editUser($id)
addUser() -->POST
resetPassword($id)

Configurações 
getConfig($key,$default)
removeConfig($key)
setConfig($key,$value)

public function getUsers() 
public function viewUser($id) 
public function viewUsers() 
public function viewSettings()
public function editProfile(Request $request)
public function remProfileLogo()

Utilização:
Em Routes/web.php definir:

Route::get('/admin/users/{id}', 'XPTOController@viewUser'); -->Obtém e Apresenta user
Route::get('/admin/settings','settingsController@viewSettings'); -->Obtém e Apresenta Configurações

As operações para adicionar, alterar e remover um utilizador devem ter como links:

/admin/users/add
/admin/users/$ID/edit (POST)
/admin/users/$ID/del
/admin/users/$ID/resetPassword

As operações para alterar as configurações e para remover o logo devem ter como links
/admin/settings/edit (POST)
/admin/settings/remLogo

************************************************************************/

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\User;
use Yajra\Datatables\Datatables;

class configurationTable extends Model
{
    protected $fillable = [
        'configuration', 'key', 'value'
    ];

     protected $table = 'configuration';
}

class usersTable extends Authenticatable 
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';
}

class logsTable extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'scheme','host','path', 'url','querystring', 'ip', 'post'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $table = 'logs';
}

//Class que executa algumas alterações ou fornece informações
class Configuration{

    public function __construct(){
        if (!Schema::hasTable('configuration')){
            Schema::create('configuration', function($table)
            {
                $table->increments('id');
                $table->string('configuration');
                $table->string('key');
                $table->string('value');
                $table->timestamps();
            });   
        }
        if (!Schema::hasTable('logs')){
            Schema::create('logs', function($table)
            {
                $table->increments('id');
                $table->integer('user');
                $table->string('scheme');
                $table->string('host');
                $table->string('path');
                $table->text('querystring');
                $table->text('post');
                $table->string('ip');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('users')){
            Schema::create('users', function($table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('remember_token')->nullable();
                $table->timestamps();
                $table->enum('type',['A','O']);
            });
        }
        return true;
    }
    /*****************************************************************

    Implementação dos métodos genéricos

    *******************************************************************/
    public function logPage($auth){

        /*Isto deve ser chamado em Auth/Middlware/Authenticate.php
        $c=new \indaleto\configuration\Configuration;
        $c->logPage($this->auth);*/
        if (!Schema::hasTable('logs')){
            Schema::create('logs', function($table)
            {
                $table->increments('id');
                $table->integer('user');
                $table->string('scheme');
                $table->string('host');
                $table->string('path');
                $table->text('querystring');
                $table->text('post');
                $table->string('ip');
                $table->timestamps();
            });
        }
        if ($auth->check()){
            $u=$auth->user()->id;
        }
        else{
            $u=0;
        }
        $l=url()->full();
        $parsedUrl = parse_url($l);
        
        $c=new \indaleto\configuration\logsTable;
        $c->scheme=$parsedUrl['scheme'];
        $c->host=$parsedUrl['host'];
        if (isset($parsedUrl['path']))
            $c->path=$parsedUrl['path'];
        else
            $c->path='';
        if (isset($parsedUrl['query']))
            $c->querystring=$parsedUrl['query'];
        else
            $c->querystring="";
        $c->user=$u;
        $c->ip=$_SERVER['REMOTE_ADDR'];
        $post="";
        foreach ($_POST as $param_name => $param_val) {
            if ($param_name!='_token')
                $post.= "Param: $param_name; Value: $param_val | ";
        }
        $c->post=$post;
        $c->save();
        $l="URL: ".$c->scheme."://".$c->host.$c->path." QUERYTRING: ".$c->querystring;
        Log::info("User: $u $l");
    }
    /*****************************************************************

    Implementação dos métodos relativos aos Perfil do Utilizador que fez login

    *******************************************************************/
    public function getProfile(){
        return \App\User::find(Auth::user()->id);
    }
    public function getProfileAvatar(){
        if (!Auth::check())return '';
        if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.jpg')){
            return '/img/avatar/'.Auth::user()->id.'.jpg';
        }
        else if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.png')){
            return '/img/avatar/'.Auth::user()->id.'.png';
        }
        else{
            return '/img/avatar/noProfile.png';
        }
    }
    public function editProfile($campos){
        $u=\App\User::find(Auth::user()->id);
        foreach ($campos as $key => $value) {
            $u[$key]=$value;
        }
        $u->save();
    }
    /*****************************************************************

    Implementação dos métodos relativos aos utilizadores

    *******************************************************************/
    public function getUser($id){
        return usersTable::find($id);
    }

    public function remUser($id){
        usersTable::where('id',$id)->delete();
        return true;
    }

    public function editUser($id,$campos){
        $u=usersTable::find($id);
        foreach ($campos as $key => $value) {
            $u[$key]=$value;
        }
        $u->save();
    }

    public function addUser($campos){
        $u=new usersTable;
        foreach ($campos as $key => $value) {
            $u[$key]=$value;
        }
        $u->password=Hash::make('SDF|||456911$');
        $u->save();
        //envia email para atribuir password
        $credentials = ['email' => $u->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        return $u->id;
    }

    public function resetPassword($id){
        $u=usersTable::find($id);
        $credentials = ['email' => $u->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });        
        return true;
    }
    /*****************************************************************

    Implementação dos métodos relativos às configurações

    *******************************************************************/
    private function GetConfiguration($key){
        return configurationTable::where('configuration','settings')->where('key',$key)->first();
    }

    private function valueOrDefault($config,$default){
        if ($config==null){
            return $default;
        }else{
            return $config->value;
        }
    }

    public function getConfig($key,$default=''){
        $info=$this->GetConfiguration($key);
        return $this->valueOrDefault($info,$default);
    }

    public function removeConfig($key){
        configurationTable::where('configuration','settings')->where('key',$key)->delete();
    }

    public function setConfig($key,$value){
        $config=$this->GetConfiguration($key);
        if ($config==null){
            $config=new configurationTable;
            $config->configuration='settings';
            $config->key=$key;
        }
        $config->value=$value;
        $config->save();
    }
}

class configurationController extends Controller
{
	public $configuration;
	public function __construct(){
		$this->configuration = new  Configuration;
	}

    //PARA AUTENTICACAO:
    public function showLoginForm(){
        return view('adminConfiguration::auth/login');
    }

    //PARA DATATABLES
    public function getUsers() {
        return Datatables::of(User::all())->make(true);
    }

    //Para as view dos utilizadores e configuração
    public function viewUser($id) {
        $dados = new \indaleto\configuration\Configuration;
        return view('adminConfiguration::admin/user', ['user' => $dados->getUser($id)]);
        return view('adminConfiguration::admin/user', ['user' => $dados->getUser($id)]);
    }
    public function viewUsers() {
        return view('adminConfiguration::admin/users');
    }

    public function viewSettings(){
        $dados=new \indaleto\configuration\Configuration;
        return view('adminConfiguration::admin/settings',[ 'empresa' => $dados->getConfig('empresa',''), 'imagem' => $dados->getConfig('imagem',"/img/brand/logo.svg")]);
    }

    //Para o perfil
    public function editProfile(Request $request){
        $this->configuration->editProfile([
            'name' =>$request->input('name'),
            'email' => $request->input('email')]);
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $filename = $request->file('imagem');
            $ext = $filename->getClientOriginalExtension();
            $path = public_path() . '/img/avatar';
            if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.jpg')){
                unlink(public_path().'/img/avatar/'.Auth::user()->id.'.jpg');
            }
            if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.png')){
                unlink(public_path().'/img/avatar/'.Auth::user()->id.'.png');
            }
            $filename->move($path, Auth::user()->id.'.'.$ext);
        }

        if ($request->input('password')==$request->input('password2')){
            $this->configuration->editProfile(['password' => Hash::make($request->input('password'))]);
            return redirect("/profile?msgInfo=Os dados foram alterados.");
        }
        else if($request->input('password2')!="" && $request->input('password')!=$request->input('password2')){
            return redirect("/profile?msgError=As password não são iguais.");
        }
        else if($request->input('password2')=="" && $request->input('password')!=$request->input('password2')){
            return redirect("/profile?msgInfo=Os dados foram alterados.");
        }
        else{
            return redirect("profile");
        }
    }

    //Remove o avatar do perfil
    public function remProfileLogo(){
        if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.jpg')){
            unlink(public_path().'/img/avatar/'.Auth::user()->id.'.jpg');
        }
        if (file_exists(public_path().'/img/avatar/'.Auth::user()->id.'.png')){
            unlink(public_path().'/img/avatar/'.Auth::user()->id.'.png');
        }
        return redirect('profile?msgInfo=O avatar foi removido.');
    }

    public function addUser(Request $request){
    	$i=$this->configuration->addUser([
			'name' =>$request->input('name'),
			'email' => $request->input('email'),
			'type' => $request->input('type')]);
		return redirect("admin/users/$i?msgInfo=O utilizador foi criado.");
    }

    public function delUser($id) {
		$this->configuration->remUser($id);
		return redirect('/admin/users?msgInfo=O utilizador foi eliminado.');
	}

	public function editUser(Request $request, $id) {
		$this->configuration->editUser($id,[
			'name' =>$request->input('name'),
			'email' => $request->input('email'),
			'type' => $request->input('type')]);
		return redirect("admin/users/$id?msgInfo=O utilizador foi alterado.");
	}

	public function sendResetPasswordLink($id) {
		$this->configuration->resetPassword($id);
		return redirect("admin/users/$id?msgInfo=O link para alteração da password foi enviado.");		
	}

	public function remLogo(){
		$this->configuration->removeConfig('imagem');
		return redirect('/admin/settings?msgInfo=O logotipo da empresa foi removido.');
	}

	public function editSettings(Request $request){
			
		$this->configuration->setConfig('empresa',$request->input('empresa'));
		if ($request->hasFile('imagem') && $request->file('imagem')->isValid()){
			$filename = $request->file('imagem');
			$ext = $filename->getClientOriginalExtension();
			$path = public_path() . '/img/brand';
			$this->configuration->setConfig('imagem','/img/brand/backofficeImg.'.$ext);
			$filename->move($path, 'backofficeImg.'.$ext);
		}
		return redirect('/admin/settings?msgInfo=Os dados da empresa foram alterados.');
	}

}
