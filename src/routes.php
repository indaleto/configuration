<?php 

Route::group(['middleware' => ['web']], function(){
	Route::get('login', function(){
		return view('adminConfiguration::auth/login');
	})->name('login');
	Route::get('register', function(){
		return view('adminConfiguration::auth/register');
	})->name('register');
	Route::get('password/reset', function(){
		return view('adminConfiguration::auth.passwords.email');
	});
	Route::get('password/reset/{token}', function(){
		return view('adminConfiguration::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
	});

	Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
	Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
	Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');


	Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
	Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');;
	Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset');


});


Route::group(['middleware' => ['web', 'auth']], function(){
		
	Route::post('/admin/users/add', 'indaleto\configuration\configurationController@addUser');
	Route::post('/admin/users/add', 'indaleto\configuration\configurationController@addUser');
	Route::get('/admin/users/{id}/del', 'indaleto\configuration\configurationController@delUser');
	Route::post('/admin/users/{id}/edit', 'indaleto\configuration\configurationController@editUser');
	Route::get('/admin/users/{id}/resetPassword', 'indaleto\configuration\configurationController@sendResetPasswordLink');

	Route::post('/admin/settings/edit','indaleto\configuration\configurationController@editSettings');
	Route::get('/admin/settings/remLogo','indaleto\configuration\configurationController@remLogo');

	Route::get('profile','indaleto\configuration\configurationController@profile');
	Route::post('profile/edit','indaleto\configuration\configurationController@editProfile');
	Route::get('profile/remLogo','indaleto\configuration\configurationController@remProfileLogo');

	/*** Rotas para apresentar Utilizadores e Configurações ****/
	Route::get('/admin/users/{id1}', 'indaleto\configuration\configurationController@viewUser');
	Route::get('/admin/users', 'indaleto\configuration\configurationController@viewUsers');
	Route::get('/admin/settings','indaleto\configuration\configurationController@viewSettings');

	Route::get('get-data-my-datatables', ['as' => 'get.users', 'uses' => 'indaleto\configuration\configurationController@getUsers']);

});

