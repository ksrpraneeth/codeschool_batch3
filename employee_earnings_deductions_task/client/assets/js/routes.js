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
    let dashboardState = {
        name: "dashboardState",
        url: "/dashboard",
        templateUrl: "./views/dashboard.html",
        controller: "DashboardController",
    };
    let moduleViewState = {
        name: "moduleViewState",
        url: "/dashboard/module/:id",
        templateUrl: "./views/module.html",
        controller: "ModuleController"
    };
    let employeeMasterstate = {
        name: "moduleViewState.employeeMasterstate",
        url: "/employeeMaster",
        templateUrl: "./views/menuItems/employeeMaster.html",
        controller: "ModuleController"
    };
    

    $stateProvider.state(homeState);
    $stateProvider.state(loginState);
    $stateProvider.state(dashboardState);
    $stateProvider.state(moduleViewState);
    $stateProvider.state(employeeMasterstate);

    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise('/');
});
