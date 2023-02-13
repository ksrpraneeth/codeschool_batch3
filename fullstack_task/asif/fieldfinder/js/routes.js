let app = angular.module("myApp", ["ui.router"]);

app.config(["$stateProvider", "$urlRouterProvider", "$locationProvider", function($stateProvider, $urlRouterProvider, $locationProvider) {
    
    $stateProvider
    .state('home', {
        url: '/',
        templateUrl: 'home.html',
        controller: 'HomeController'
    })
    .state('about', {
        url: '/about',
        templateUrl: 'about.html',
        controller: 'AboutController'
    })
    .state('contact', {
        url: '/contact',
        templateUrl: 'contact.html',
        controller: 'ContactController'
    })
    .state('register', {
        url: '/register',
        templateUrl: 'register.html',
        controller: 'UsersController'
    })
    .state('login', {
        url: '/login',
        templateUrl: 'login.html',
        controller: 'UsersController'
    })
    .state('logout', {
        url: '/logout',
        templateUrl: 'logout.html',
        controller: 'LogoutController'
    })
    .state('venues', {
        url: '/venues',
        templateUrl: 'venues.html',
        controller: 'VenuesController'
    })
    .state('bookVenue', {
        url: '/venues/:venueName',
        templateUrl: 'book_venue.html',
        controller: 'BookingsController',
        params: {
            id: null
        }
    });

    $urlRouterProvider.when("/", function($state) {
        $state.go("venues");
    });


    $urlRouterProvider.otherwise("/");
    $locationProvider.html5Mode(true);
}]);