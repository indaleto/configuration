<?php

namespace indaleto\configuration;
use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Schema;
class configurationTable extends Model
{
    protected $fillable = [
        'configuration', 'key', 'value'
    ];

     protected $table = 'configuration';
}

class Configuration{

    public function __construct(){
        if (Schema::hasTable('configuration')) return true;
        Schema::create('configuration', function($table)
        {
            $table->increments('id');
            $table->string('configuration');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
    }

    private function GetConfiguration($key){
        return configurationTable::where('configuration','settings')->where('key',$key)->first();
    }

    private function valueOrNull($config,$default){
        if ($config==null){
            return $default;
        }else{
            return $config->value;
        }
    }

    public function getConfig($key,$default){
        $info=$this->GetConfiguration($key);
        return $this->valueOrNull($info,$default);
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

class ConfigurationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->make('indaleto\configuration\settingsController');
    }

}
