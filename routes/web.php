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

Route::get('/', function () {
    $thread = EntityManager::find(App\Entities\Thread::class, 1);

    update($thread, ['title' => 'p', 'body' => 'a']);

    dd($thread);

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
