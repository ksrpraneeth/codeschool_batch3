var dashbordmodule=angular.module('dashbordModule',[]);


dashbordmodule.controller('dashbordController',function($scope){
    var data=JSON.parse(localStorage.getItem('userdata'));

    $scope.name=data[0]['firstname']+' '+data[0]['lastname'];
    $scope.email=data[0]['email'];
    $scope.dob=data[0]['dob'];
    $scope.logout=function(){
        localStorage.clear();
        location.replace('login.html')
    }
})