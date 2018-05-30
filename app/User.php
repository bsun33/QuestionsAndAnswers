<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    //sign up

    public function signup()
    {
        $username = Request::get('username');
        $password = Request::get('password');

        /*check if username or password is empty in requests*/
        if(!$username || !$password)
            return err('user name and password can not be blank');

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
}
