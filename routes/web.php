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

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => ['auth']
],function () {

    Route::get('/awemeUsers', 'AwemeUserController@index');

    Route::get('/awemeUserCreate/getQrCode', 'AwemeUserCreateController@getQrCode');
    Route::get('/awemeUserCreate/checkQrCode/{token?}', 'AwemeUserCreateController@checkQrCode');
    Route::get('/awemeUserCreate/getUserInfo', 'AwemeUserCreateController@getUserInfo');

    Route::get('/awemeUsersAll','AwemeUserAllController@index');

    Route::get('/awemeUsers/followTasks','FollowTaskController@index');
    Route::post('/awemeUsers/{awemeUserId}/followTask','FollowTaskController@store');

    Route::get('/followTasks/{followTask}/addFans','FollowTaskController@addFans');
});
