let app = angular.module('ifmis', ['ui.router'])

app.config(['$stateProvider', function ($stateProvider) {
    $stateProvider
      .state('addAgency', {
        url: '/addAgency',
        templateUrl: 'addAgency.html'
      });
    }
]);
