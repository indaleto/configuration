<?php 


Route::group(['middleware' => ['web', 'auth']], function(){
		
	Route::post('/admin/users/add', 'indaleto\configuration\configurationController@addUser');
	Route::post('/admin/users/add', 'indaleto\configuration\configurationController@addUser');
	Route::get('/admin/users/{id}/del', 'indaleto\configuration\configurationController@delUser');
	Route::post('/admin/users/{id}/edit', 'indaleto\configuration\configurationController@editUser');
	Route::get('/admin/users/{id}/resetPassword', 'indaleto\configuration\configurationController@sendResetPasswordLink');

	Route::post('/admin/settings/edit','indaleto\configuration\configurationController@editSettings');
	Route::get('/admin/settings/remLogo','indaleto\configuration\configurationController@remLogo');

	Route::post('profile/edit','indaleto\configuration\configurationController@editProfile');
	Route::get('profile/remLogo','indaleto\configuration\configurationController@remProfileLogo');

	/*** Rotas para apresentar Utilizadores e Configurações ****/
	Route::get('/admin/users/{id1}', 'indaleto\configuration\configurationController@viewUser');
	Route::get('/admin/users', 'indaleto\configuration\configurationController@viewUsers');
	Route::get('/admin/settings','indaleto\configuration\configurationController@viewSettings');

	Route::get('get-data-my-datatables', ['as' => 'get.users', 'uses' => 'indaleto\configuration\configurationController@getUsers']);

	// Authentication Routes...
	$this->get('admin/login', 'indaleto\configuration\configurationController@showLoginForm')->name('login');
	$this->post('admin/login', 'Auth\LoginController@login');
	$this->post('admin/logout', 'Auth\LoginController@logout')->name('logout');

	// Registration Routes...
	$this->get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	$this->post('admin/register', 'Auth\RegisterController@register');

	// Password Reset Routes...
	$this->get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	 $this->post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	$this->get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	$this->post('admin/password/reset', 'Auth\ResetPasswordController@reset');

});

//Route::post('/admin/users/add', 'configurationController@addUser');
