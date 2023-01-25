var homemodule=angular.module('homeModule',['ui.router']);
homemodule.config(['$stateProvider',function($stateProvider){
    $stateProvider
    .state('employee',{
        url:'/employee',
        templateurl:'employee.html'
    })
}])