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

use App\Helpers\DouYin\FollowUserHelper;
use App\Services\AwemeUserService;

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
    Route::get('/awemeUsers/{awemeUserId}/followTask','FollowTaskController@store');

});


Route::get('/test',function () {
    $awemeUserService = new AwemeUserService();
    $followUserHelper = new FollowUserHelper();

    $followUserHelper->followUsers($awemeUserService->getFollowedAwemeUser(), $awemeUserService->getFollowAwemeUser());
});

