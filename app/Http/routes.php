<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//DB::listen(function($sql, $bindings, $time){var_dump($sql);});

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::resource('articles', 'ArticlesController');

Route::get('/problems', [
    'as'   => 'problems.index',
    'uses' => 'ProblemsController@index'
]);
Route::post('/problems/create', [
    'as'   => 'problems.store',
    'uses' => 'ProblemsController@store',
    'middleware' => 'auth'
]);
Route::post('/problems/create/data', [
    'as'   => 'problems.store.data',
    'uses' => 'ProblemsController@storeData',
    'middleware' => 'auth'
]);
Route::get('/problems/create/{step?}', [
    'as'   => 'problems.create',
    'uses' => 'ProblemsController@create',
    'middleware' => 'auth'
]);
Route::get('/problems/new', 'ProblemsController@newProblems')->middleware('auth');
Route::get('/problems/preview/{id?}', 'ProblemsController@preview')->middleware('auth');
Route::get('/problems/{problem}', [
    'as' => 'problems.show',   'uses' => 'ProblemsController@show'
]);

Route::get('/user/{name}', 'UsersController@show');

Route::get('/rank', 'RankController@index');

Route::get('/solutions',  'SolutionsController@index');
Route::post('/solutions', 'SolutionsController@store');
Route::get('/solutions/{id}', 'SolutionsController@show');
Route::get('/submit/{id}','SolutionsController@create')->middleware('auth');

