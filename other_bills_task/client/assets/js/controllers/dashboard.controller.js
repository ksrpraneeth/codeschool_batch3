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
        {
            name: "Bill Entry",
            state: "billEntryRoute",
            icon: "fas fa-receipt"
        },
        {
            name: "View Bill",
            state: "viewBillRoute",
            icon: "fas fa-eye"
        },
    ];
});
