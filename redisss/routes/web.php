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
    // return view('welcome');
    // print_r(app()->make('redis'));
    // $redis-> set("key1", "value");
    // return $redis->get("key1");
    $visits = Redis::incr('visits');
    return $visits;
});
