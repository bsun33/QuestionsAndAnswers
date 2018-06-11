;(function()
{
    'use strict';

    angular.module('qa', [])
        .config(function($interpolateProvider)
        {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');
        })

        .controller('TestController', function($scope)
        {
            $scope.name = 'Bob';
        })
})();