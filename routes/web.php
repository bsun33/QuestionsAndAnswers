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

function rq($key=null, $default=null)
{
    if(!$key)
        return Request::all();
    return Request::get($key, $default);
}

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

function question_ins(){
    return new App\Question;
}

function answer_ins(){
    return new App\Answer;
}

Route::get('/', function () {
    return view('welcome');
});

Route::any('api/signup', function () {
    return user_ins()->signup();

});

Route::any('api/login', function () {
    return user_ins()->login();

});

Route::any('api/logout', function () {
    return user_ins()->logout();

});

Route::any('api/questions/add', function () {
    return question_ins()->add();

});

Route::any('api/questions/change', function () {
    return question_ins()->change();

});

Route::any('api/questions/read', function () {
    return question_ins()->read();

});

Route::any('api/questions/remove', function () {
    return question_ins()->remove();

});

Route::any('api/answer/add', function () {
    return answer_ins()->add();

});

Route::any('api/answer/change', function () {
    return answer_ins()->change();

});

Route::any('api/answer/read', function () {
    return answer_ins()->read();

});

Route::any('api/answer/remove', function () {
    return answer_ins()->remove();

});

Route::any('test', function () {
    return user_ins()->is_logged_in();

});
