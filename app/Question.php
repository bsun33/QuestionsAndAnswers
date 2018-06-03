<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /*create questions*/
    public function add()
    {
        //dd(rq());

        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if have title*/
        if(!rq('title'))
            return err('question title required');

        /*save question title, user_id and desc(if have) in db*/
        $this->title = rq('title');
        $this->user_id = session('user_id');
        if(rq('desc'))
            $this->desc = rq('desc');

        return $this->save()?
            success(['question_id' => $this->id]) :
            err('db insert failed');
    }

    /*update questions*/
    public function change()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if question id is sent in request*/
        if(!rq('id'))
            return err('question id is required');

        /*find the question in db*/
        $question = $this->find(rq('id'));

        if(!$question)
            return err('question not exists!');

        if($question->user_id != session('user_id'))
            return err('permission denied');

        if(rq('title'))
            $question->title = rq('title');

        if(rq('desc'))
            $question->desc = rq('desc');

        /*save data*/
        return $question->save()?
            success() :
            err('db insert failed');
    }

    public function read()
    {
        return 1;
    }
}
