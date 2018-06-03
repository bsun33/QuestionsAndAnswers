Question and Answers platform


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

