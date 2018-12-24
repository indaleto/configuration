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

});

