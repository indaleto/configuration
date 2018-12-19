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
});

//Route::post('/admin/users/add', 'configurationController@addUser');
