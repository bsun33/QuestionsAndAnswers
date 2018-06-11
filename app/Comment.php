<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    /*add comment api*/
    public function add()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if content is empty*/
        if(!rq('content'))
            return err('empty content');

        /*check question id and answer id, only one can be in the requests*/
        if(
        (!rq('question_id') && !rq('answer_id')) ||
        (rq('question_id') && rq('answer_id')))
            return err('question_id or answer_id is required');

        if(rq('question_id'))
        {
            /*comment to questions*/
            $question = question_ins()->find(rq('question_id'));
            if(!$question)
                return err('question not exists');

            $this->question_id = rq('question_id');
        }else
        {
            /*comment to answers*/
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer)
                return err('answer not exists');

            $this->answer_id = rq('answer_id');
        }

        /*check if reply to a comment*/
        if(rq('reply_to'))
        {
            /*check if target comment exists*/
            $target = $this->find(rq('reply_to'));
            if(!$target)
                return err('target not exists');

            /*check if user is reply to his own comment*/
            if($target->user_id == session('user_id'))
                return err('invalid reply to,can not reply to yourself');
            $this->reply_to = rq('reply_to');
        }

        $this->content = rq('content');
        $this->user_id = session('user_id');

        return $this->save() ?
            success(['comment_id' => $this->id]) :
            err('db insert failed');
    }


}
