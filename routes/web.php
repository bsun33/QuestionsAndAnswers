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

function err($msg = null)
{
    return ['status' => 0, 'msg' => $msg];
}

function success($data_to_merge = null)
{
    $data = ['status' => 1];
    if($data_to_merge)
        $data = array_merge($data, $data_to_merge);
    return $data;
}

//return user instance
function user_ins(){
    return new App\User;
}

Route::get('/', function () {
    return view('welcome');
});

Route::any('api/user/signup', function () {
    return user_ins()->signup();

});
