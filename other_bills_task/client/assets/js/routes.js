app.config(function ($stateProvider, $urlRouterProvider) {
    let homeRoute = {
        name: "homeRoute",
        url: "/",
        templateUrl: "./views/home.html",
    };
    let addAgencyRoute = {
        name: "addAgencyRoute",
        url: "/addAgency",
        templateUrl: "./views/addAgency.html",
        controller: "AddAgencyController"
    };

    $stateProvider.state(homeRoute);
    $stateProvider.state(addAgencyRoute);

    $urlRouterProvider.otherwise("/");
});
