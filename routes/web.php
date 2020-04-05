<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'HomeController@test')->name('test');

/**
 * CMS route.
 */
Route::prefix(config('app.admin_prefix'))->group(function () // sample 'admin'
{
	Auth::routes(['register' => false]);
	Route::middleware(['auth', 'superadmin'])->group(function () {
		Route::get('/', 'Admin\DashboardController@index')->name('admin.index');
		Route::resource('users', 'Admin\UserController', ['as' => 'admin']);
		Route::get('/genre', 'GenreController@index');
		Route::get('/movie', 'MovieController@index');
		Route::get('/testing', 'Admin\UserController@testing');

	});
});


