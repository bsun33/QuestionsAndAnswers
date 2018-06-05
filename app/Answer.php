<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //

    public function add()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if params have question_id and content*/
        if(!rq('question_id') || !rq('content'))
            return err('question_id and content are required');
        /*check if question exist*/
        $question = question_ins()->find(rq('question_id'));
        if(!$question)
            return err('question not exist');

        /*check if duplicated answers*/
        $answered = $this->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
             ->count();

        if($answered)
            return('duplicate answers');

        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = session('user_id');

        return $this->save() ?
                success(['id' => $this->id]) :
                err('db insert failed');
    }
}
