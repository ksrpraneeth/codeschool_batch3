app.controller("DashboardController", function ($scope) {
    $scope.menu = [
        {
            name: "Home",
            state: "homeRoute",
            icon: "fas fa-home"
        },
        {
            name: "Add New Agency",
            state: "addAgencyRoute",
            icon: "fas fa-plus"
        },
    ];
});
