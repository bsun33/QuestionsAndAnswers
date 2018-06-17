;(function()
{
    'use strict';

    angular.module('qa', ['ui.router',
                    ])
        .config([
            '$interpolateProvider',
            '$stateProvider',
            '$urlRouterProvider',
            function($interpolateProvider,
                         $stateProvider,
                         $urlRouterProvider)
        {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            $stateProvider
                .state('home', {
                    url: '/home',
                    templateUrl: "home.tpl"
                })
                .state('login', {
                    url: '/login',
                    templateUrl: "login.tpl"
                })

                .state('signup', {
                    url: '/signup',
                    templateUrl: "signup.tpl"
                })
        }])

        .service('UserService', [
            '$http',
            '$state',
            function($http,$state){
                var me = this;
                me.signup_data = {};
                me.signup = function(){
                    $http.post('api/signup', me.signup_data)
                    .then(function(r){
                        console.log('r', r);
                        if(r.data.status)
                            me.signup_data = {};
                            $state.go('login');
                    }, function(e){
                        console.log('e', e);
                    })
                }
                me.username_exists = function(){
                    $http.post('api/user/exist', 
                        {username: me.signup_data.username})
                        .then(function(r){
                            console.log('r', r);
                            if(r.data.status && r.data.count)
                                me.signup_username_exists = true;
                            else
                                me.signup_username_exists = false;

                        }, function(e){
                            console.log('e', e);
                        })
                }
        }])

        .controller('SignupController',[
            '$scope',
            'UserService',
            function($scope,UserService){
                $scope.User = UserService;

                $scope.$watch(function(){
                    return UserService.signup_data;
                }, function(n, o){
                    console.log('n', n);
                    if(n.username != o.username)
                        UserService.username_exists();
                }, true); 
            }])

})();