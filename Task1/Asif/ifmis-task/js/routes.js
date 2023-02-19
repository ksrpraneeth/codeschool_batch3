let app = angular.module("myApp", ["ui.router"]);

app.config(["$stateProvider", "$locationProvider", "$urlRouterProvider", function($stateProvider, $locationProvider, $urlRouterProvider) {

    $stateProvider
    .state('home', {
        url: '/',
        templateUrl: 'home.html'
    })
    .state('addNewAgency', {
        url: '/addNewAgency',
        templateUrl: 'addNewAgency.html',
        controller: 'AddNewAgencyController'
    })
    .state('billEntry', {
        url: '/billEntry',
        templateUrl: 'billEntry.html',
        controller: 'BillEntryController'
    })
    .state('printBill', {
        url: '/printBill',
        templateUrl: 'printBill.html'
    });


    $urlRouterProvider.otherwise("/");
    $locationProvider.html5Mode(true);

}]);