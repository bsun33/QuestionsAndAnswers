Question and Answers platform

![image](http://github.com/bsun33/QuestionsAndAnswers/raw/master/qa.png


-------test in local-------

$ php -S localhost:8080 -t public

-------migration--------

$ php artisan make:migration create_table_tableName --create=tableName

$ php artisan migrate

$ php artisan migrate:rollback

-------make model--------

$ php artisan make:model model_name


-------Routes--------

-User Model:

    /api/signup ?username & password

    /api/login  ?username & password

    /api/logout

-Question Model:

    /api/questions/add  ?title

    /api/questions/change   ?id

    /api/questions/read     ?(id) & (limit) & (page)

    /api/questions/remove   ?id

-Answer Model:

    /api/answer/add  ?question_id & content

    /api/answer/change  ?answer_id & content

    /api/answer/read  ?answer_id || question_id

-Comment Model:

    /api/comment/add    ?content & (answer_id || question_id) || reply_to

    /api/comment/read   ?(answer_id || question_id)



Angular:

$ npm install angular jquery angular-ui-router normalize-css