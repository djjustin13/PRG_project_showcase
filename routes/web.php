<?php

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

Route::get('/', 'ProjectsController@index');
Route::get('/about', 'PagesController@about');


Route::get('/projects/{project}/rate', 'RatingController@get');
Route::get('/projects/{project}/rate/{rating}', 'RatingController@create');

Route::resource('projects', 'ProjectsController');
Route::put('projects/changeState/{id}', 'ProjectsController@changeState');

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/categories', 'CategoriesController@index');
Route::post('/dashboard/categories/store', 'CategoriesController@store');
Route::delete('/dashboard/categories/delete/{id}', 'CategoriesController@destroy');


Route::resource('/dashboard/users', 'UsersController');
Route::get('/dashboard/profile', 'UsersController@edit');
Route::get('/dashboard/profile/resetpassword', 'UsersController@changePassword');

Auth::routes();