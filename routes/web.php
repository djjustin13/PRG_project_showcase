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

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::resource('users', 'UsersController');

