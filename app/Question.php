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
        /*check if there is id in request params, if exists, return that specific question*/
        if(rq('id'))
            return success([$this->find(rq('id'))]);

        /*if client send how many entries to display on one page,
         * use that
        */
        $limit = rq('limit') ?:15;

        /*skip use for paging*/
        $skip = (rq('page') ? (rq('page') - 1) : 0) * $limit;

        /*get a collection, only displays fileds that are passed in get*/
        return $this->orderBy('created_at')
                    ->limit($limit)
                    ->skip($skip)
                    ->get(['id', 'title', 'desc', 'user_id'])
                    ->keyBy('id');
    }

    /*remove questions*/
    public function remove()
    {
        /*check if user logged in*/
        if(!user_ins()->is_logged_in())
            return err('logging required');

        /*check if question id is sent in request*/
        if(!rq('id'))
            return err('question id is required');

        /*find the corresponding question model matching with passed question_id*/
        $question = $this->find(rq('id'));

        if(!$question)
            return err('question not exists!');

        /*check if the question belongs to the current user*/
        if($question->user_id != session('user_id'))
            return err('permission denied');

        return $question->delete() ?
            success() :
            err('db delete failed');
    }
}
