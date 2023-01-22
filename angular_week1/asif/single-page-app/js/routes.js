var app = angular.module("myApp", ["ui.router", "ng"]);

// app.service()

app.config(["$stateProvider", "$urlRouterProvider", "$locationProvider", function($stateProvider, $urlRouterProvider, $locationProvider) {
    
    $stateProvider
    .state('index', {
        url: '/',
        templateUrl: 'home.html',
        // controller: 'commonScripts'
    })
    .state('home', {
        url: '/',
        templateUrl: 'home.html'
    })
    .state('employeesData', {
        url: '/employeesData',
        templateUrl: 'employeesData.html',
        controller: 'getEmployeesData'
    })
    .state('employeesSalaries', {   
        url: '/employeesSalaries',
        templateUrl: 'employeesSalaries.html'
    })
    

    $urlRouterProvider.otherwise("/");

    $locationProvider.html5Mode(true);


}]);