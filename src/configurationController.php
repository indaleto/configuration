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
            $c=new configurationTable;
            $c->configuration='settings';
            $c->key='showMenuHeader';
            $c->value='N';
            $c->save();
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
            $c=new usersTable;
            $c->name='indaleto';
            $c->email='indaleto@gmail.com';
            $c->password=Hash::make('123456');
            $c->type='A';
            $c->save();
        }
        return true;
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
