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

    /*update answer*/
    public function change()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if answer id exists*/
        if(!rq('answer_id') || !rq('content'))
            return err('answer id and content are required');

        $answer = $this->find(rq('answer_id'));
        if(!$answer)
            return err('answer id not exists');

        if($answer->user_id != session('user_id'))
            return err('permission denied');

        $answer->content = rq('content');

        return $answer->save() ?
            success() :
            err('db update failed');


    }

    public function read()
    {
        if(!rq('answer_id') && !rq('question_id'))
            return err('answer id or question id required');

        /*check single answer*/
        if(rq('answer_id'))
        {
            $answer = $this->find(rq('answer_id'));
            if(!$answer)
                return err('answer not exists');

            return success(['data' => $answer]);
        }

        /*check if question exists*/
        if(!question_ins()->find(rq('question_id')))
            return err('question id not exists');

        /*check all answers under same questions*/
        $answers = $this->where('question_id', rq('question_id'))
                        ->get()
                        ->keyBy('id');

        return success(['data' => $answers]);
    }
    /*vote api*/
    public function vote()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        if(!rq('answer_id') || !rq('vote'))
            return err('answer_id and vote should not be blank');

        $answer = $this->find(rq('answer_id'));

        if(!$answer)
            return err('answer not exist');

        /*1 - agree, 2- object*/
        $vote = rq('vote') <= 1 ? 1 : 2;

        /*check if the user has already voted for the answer,
        * if voted before, delete the vote.
        */
        $vote_ins = $answer->users()
                ->newPivotStatement()
                ->where('user_id', session('user_id'))
                ->where('answer_id', rq('answer_id'))
                ->delete();

        /*add record in answer_user table*/
        $answer->users()->attach(session('user_id'),['vote' => $vote]);

        return success();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
                    ->withPivot('vote')
                    ->withTimestamps();
    }
}
