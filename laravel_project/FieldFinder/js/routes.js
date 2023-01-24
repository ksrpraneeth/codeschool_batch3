let app = angular.module("myApp", ["ui.router"]);

app.config(["$stateProvider", "$urlRouterProvider", "$locationProvider", function($stateProvider, $urlRouterProvider, $locationProvider) {
    
    $stateProvider
    .state('home', {
        url: '/',
        templateUrl: 'home.html'
    })
    .state('register', {
        url: '/register',
        templateUrl: 'register.html'
    })
    .state('login', {
        url: '/login',
        templateUrl: 'login.html'
    })



    $urlRouterProvider.otherwise("/");
    $locationProvider.html5Mode(true);
}]);