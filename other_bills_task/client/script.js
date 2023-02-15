let app = angular.module('ifmis', ['ui.router'])

app.config(['$stateProvider', function ($stateProvider) {
    $stateProvider
      .state('addAgency', {
        url: '/addAgency',
        templateUrl: 'addAgency.html'
      });
      $stateProvider
      .state('billEntry', {
        url: '/billEntry',
        templateUrl: 'billEntry.html'
      });
    }
]);
app.controller('AddAgencyController',function($scope,$http){
  $scope.editable="false",
  $scope.ifscCode=""
  $scope.searchIfscCode=function()
})
