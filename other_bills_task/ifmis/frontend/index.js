 var app=angular.module("app",['ui.router']);
 app.config([
    "$stateProvider",
    function ($stateProvider) {
      $stateProvider
        .state("addAgency", {
          url: "/addAgency",
          templateUrl: "addAgency.html",
        })
        .state("billEntry", {
            url: "/billEntry",
            templateUrl: "billEntry.html",
          })
    }
 ]);
 app.controller("AgencyController",function($scope)
 {
    $scope.edit="false";
 })