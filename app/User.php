<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    /*register*/

    public function signup()
    {

        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password)
            return err('user name and password can not be blank');

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];

        /*check if user exists*/
        $user_exist = $this->where('username', $username)
                            ->exists();

        if($user_exist)
            return success(['msg' => 'username already exists']);

        /*encrypt password*/
        $hashed_password = Hash::make($password);

        /*save to db*/
        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;

        if($user->save())
            return success(['user_id' => $user->id]);
        else
            return err('db insert failed');

    }

    /*login*/
    public function login()
    {
        /*check if username or password is empty in requests*/
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password)
            return err('user name and password can not be blank');

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];


        /*check if user exists*/
        $user = $this->where('username', $username)
                     ->first();

        if(!$user)
            return error('username does not exist');

        /*check if password is right*/
        $hashed_password = $user->password;
        if(!hash::check($password, $hashed_password))
            return error('password is wrong');

        /*write user info to session*/
        session()->put('user_id', $user->id);
        session()->put('username', $user->username);

        return success(['user_id' => $user->id]);
    }

    /*logout*/
    public function logout()
    {
        //session()->flush();
        /*delete username*/
        session()->forget('username');
        /*delete user_id*/
        session()->forget('user_id');

        return redirect('/');
    }

    /*check if username or password is empty in requests*/
    public function has_username_and_password()
    {
        $username = rq('username');
        $password = rq('password');


        if($username && $password)
            return [$username, $password];
        else
            return false;
    }

    /*check if user is logged in*/
    public function is_logged_in()
    {
        /*if user_id exists in session, return it, otherwise return false*/
       return session('user_id') ? : 'Not logged in';
    }


}
