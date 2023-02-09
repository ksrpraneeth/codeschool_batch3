app.config(function ($stateProvider, $locationProvider, $urlRouterProvider) {
    let homeState = {
        url: "/",
        name: "homeState",
        templateUrl: "./views/home.html",
    };
    let loginState = {
        name: "loginState",
        url: "/login",
        templateUrl: "./views/login.html",
        controller: "LoginController",
    };

    $stateProvider.state(homeState);
    $stateProvider.state(loginState);

    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/');
});
