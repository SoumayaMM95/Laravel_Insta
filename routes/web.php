<?php

use Illuminate\Support\Facades\Route;

use App\Mail\NewUserWelcomeMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/email', function(){
  return new NewUserWelcomeMail();
});

Route::post('follow/{user}','FollowsController@store');
//the index method shows all the resources,
Route::get('/','PostsController@index');

// it is important to order the Routes
//the first 2 routes are conflicting
//everything with a variable like {post} should be at the end
Route::get('/p/create', 'PostsController@create');
Route::post('/p', 'PostsController@store');
Route::get('/p/{post}', 'PostsController@show');//this route is taking everything comming after the p so if we put it above the first route, the first rout will not work



Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit'); //this will show the edit form
Route::PATCH('/profile/{user}', 'ProfilesController@update')->name('profile.update'); //this will do the updating proccess after editing
