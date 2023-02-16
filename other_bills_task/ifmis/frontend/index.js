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
    $scope.agencyDetailsError="";
    $scope.searchAgencyDetails=[];
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
    //add agency details to db
    $scope.AgencyBtn=function(){
      $http({
        method:"POST",
        url:"http://127.0.0.1:8000/api/agencydetails",
        data:{
          agency_name:$scope.agency_name,
          account_number:$scope.account_number,
          account_number_confirmation:$scope.account_number_confirmation,
          ifsc_code:$scope.ifsc_code
        },
      }).then(
        function success(response){
          if(response.data.status==true){
            $scope.agencyDetailsError="";
            alert(response.data.message);
            console.log(response.data.data);
          }
          else{
            alert(response.data.message);
          }
        },
        function error(response)
        {
          $scope.agencyDetailsError="";
          $scope.agencyDetailsError= response.data.errors[Object.keys(response.data.errors)[0]][0];
        }
      )
    }
    //
    //search agency details on entering account number
    $scope.accountNumber="";
    $scope.InvalidAccNo="";
    $scope.SearchAgencyBtn=function(){
      $http({
        method:"POST",
        url:"http://127.0.0.1:8000/api/searchagency",
        data:{
          account_number:$scope.accountNumber,
        },
      }).then(
        function success(response){
          if(response.data.status==true){
            $scope.InvalidAccNo="";
            //Show and hide display details
            $scope.agencyDetailsDisplay=true;
            $scope.searchAgencyDetails=response.data.data;
            console.log(response.data.data);
          }
          else{
            $scope.InvalidAccNo=response.data.message;
            $scope.searchAgencyDetails="";
          }
        },
        function error(response)
        {
          //
        }
      )
    }
    //Update existing agency details
    $scope.newAgencyNameError="";
    $scope.UpdateAgencyBtn=function(){
      $http({
        method:"POST",
        url:"http://127.0.0.1:8000/api/updateagency/" + $scope.searchAgencyDetails.id,
        data:{
          agency_name:$scope.agency_name,
          ifsc_code:$scope.ifsc_code
        },
      }).then(
        function success(response){
          if(response.data.status==true){
            $scope.newAgencyNameError="";
            alert(response.data.message);
            console.log(response.data.data);
          }
          else{
            alert(response.data.message);
          }
        },
        function error(response)
        {
          $scope.newAgencyNameError= response.data.errors[Object.keys(response.data.errors)[0]][0];
        }
      )
    }
    //common hide show scope variables
    $scope.remove=function()
    {
      $scope.ifscError="";
      $scope.ifscdetails=[];
      $scope.ifsc_code="";
      $scope.searchAgencyDetails=[];
      $scope.account_number="";
      $scope.agencyDetailsDisplay=false;

    }
 });
 