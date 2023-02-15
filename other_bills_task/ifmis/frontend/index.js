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
 //show edit and add agency
 app.controller("AgencyController",function($scope,$http)
 {
    $scope.edit="false";
    $scope.ifscdetails=[];
    $scope.ifscError="";
    //fetch ifsc code details from db on button click
    $scope.IfscCodeBtn=function(){
      $http({
        method:"POST",
        url:"http://127.0.0.1:8000/api/ifsccode",
        data:{
          ifsc_code:$scope.ifsc_code,
        },
      }).then(
        function success(response){
          if(response.data.status==true){
            $scope.ifscdetails=response.data.data;
            $scope.ifscError="";
            console.log(response.data.data);
          }
        },
        function error(response)
        {
          $scope.ifscdetails="";
         $scope.ifscError= response.data.errors[Object.keys(response.data.errors)[0]][0];
        }
      )
    }
 });
 