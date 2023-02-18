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
        controller: "AddAgencyController",
    };
    let billEntryRoute = {
        name: "billEntryRoute",
        url: "/billEntry",
        templateUrl: "./views/billEntry.html",
        controller: "BillEntryController",
    };
    let previewBillRoute = {
        name: "previewBillRoute",
        url: "/previewBill?tbrNo",
        templateUrl: "./views/previewBill.html",
        controller: "PreviewBillController",
    };

    $stateProvider.state(homeRoute);
    $stateProvider.state(addAgencyRoute);
    $stateProvider.state(billEntryRoute);
    $stateProvider.state(viewBillRoute);

    $urlRouterProvider.otherwise("/");
});
