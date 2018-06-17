<!doctype html>
<html lang="zh" ng-app="qa">
    <head>
        <meta charset="utf-8">

        <title>Q&amp;A</title>

        <link rel="stylesheet" href="/node_modules/normalize-css/normalize.css">
        <link rel="stylesheet" href="/css/base.css">

        <script src="/node_modules/jquery/dist/jquery.js"></script>
        <script src="/node_modules/angular/angular.js"></script>
        <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
        <script src="/js/base.js"></script>
    </head>
    <body>
        <div class="navbar clearfix">
            <div class="container">
                <div class="fl">
                    <div class="navbar-item brand">Q &amp; A</div>
                    <div class="navbar-item">
                        <input type="text"/>
                    </div>
                </div>

                <div class="fr">
                    <a ui-sref="home" class="navbar-item">Home</a>
                    <a ui-sref="login" class="navbar-item">Login</a>
                    <a ui-sref="signup" class="navbar-item">Signup</a>
                </div>
            </div>
        </div>

        <div class="page">
            <div ui-view>

            </div>
        </div>

    </body>

    <script type="text/ng-template" id="home.tpl">
        <div class="login container">
                eeeeee
        </div>

    </script>

    <script type="text/ng-template" id="login.tpl">
        <div class="login container">
            <h1>Login</h1>
            
        </div>
    </script>

    <script type="text/ng-template" id="signup.tpl">
        <div ng-controller="SignupController" class="container signup">
            <div class="card">
                <h1>Signup</h1>
                [: User.signup_data:]
                <form name="signup_form" ng-submit="User.signup()">
                    <div class="input-group">
                        <lable>Username: </lable>
                        <input name="username" 
                            type="text" 
                            ng-minlength="2"
                            ng-maxlength="24"
                            ng-model="User.signup_data.username"
                            ng-model-options="{debounce: 300}"
                            required />
                    
                    </div>

                    <div ng-if="signup_form.username.$touched" class="input-error-set">
                        <div ng-if="signup_form.username.$error.required">username required
                        </div>
                        <div ng-if="signup_form.username.$error.maxlength ||
                        signup_form.username.$error.minlength">username length should be between 4 and 24 characters
                        </div>
                        <div ng-if="User.signup_username_exists">username already exists
                        </div>

                    </div>

                    <div class="input-group">
                        <lable>Password: </lable>
                        <input name="password" 
                            type="password" 
                            ng-minlength="2"
                            ng-maxlength="30"
                            ng-model="User.signup_data.password"
                            required/>
                    
                    </div>

                    <div ng-if="signup_form.password.$touched" class="input-error-set">
                        <div ng-if="signup_form.password.$error.required">password required
                        </div>
                        <div ng-if="signup_form.password.$error.maxlength ||
                        signup_form.password.$error.minlength">password length should be between 6 and 30 characters
                        </div>

                    </div>

                    <button type="submit"
                            ng-disabled="signup_form.$invalid">
                        sign up</button>
                </form>
            </div>
        </div>
    </script>
</html>
