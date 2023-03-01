var homepagemodule = angular.module('homemodule', ['ui.router']);


homepagemodule.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

    $stateProvider
        .state('loginpage', {
            url: '/loginpage',
            templateUrl: 'loginpage.html'
        })

    $stateProvider
        .state('registarion', {
            url: '/registration',
            templateUrl: 'registration.html'
        })

    $urlRouterProvider.otherwise('/loginpage')
}])


homepagemodule.controller('homepageController', function ($scope, $http) {
    $scope.email = '';
    $scope.password = '';
    $scope.firstname='';
    $scope.lastname='';
    $scope.dob='';
    //login function
    $scope.login = function (email,password) {
        
        var formdata = {email: email, password:password }
         console.log(formdata)
        $http.post("http://127.0.0.1:8000/api/login", formdata).then(
            function (response) {
                console.log(response.data);
                if(response.data.status){
                    swal('', 'LOGIN SUCCESFULLY', "success");
                    localStorage.setItem('userdata',JSON.stringify(response.data.Data))
                 location.replace('dashbord.html')
                }
            }, function (error) {
                console.log(error);

                console.log(error.data.message)
                // swal('Error', JSON.stringify(error), "error");
                swal('Error', error.data.message, "error");
            }
        )
    }

    //registration 

    $scope.register = function (email, password,firstname,lastname,dob) {
        var formdata = { email: email, password: password ,firstname:firstname,lastname:lastname,dob:dob}
        console.log(formdata);
        $http.post("http://127.0.0.1:8000/api/home", formdata).then(
            function (response) {
                console.log(response.data);
                if(response.data.status){
               console.log(response);
               swal('', 'Registration succesfully', "success");
                }
                else{
                    swal('Error', response.data.message, "error");
                }
            }, function (error) {
                console.log(error);

                console.log(error.data.message)
                // swal('Error', JSON.stringify(error), "error");
                swal('Error', error.data.message, "error");
            }
        )
    }
})