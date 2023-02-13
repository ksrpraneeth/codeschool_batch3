var app = angular.module('loginMod', ['ui.router']);

app.config(['$urlRouterProvider', '$stateProvider', function($urlRouterProvider, $stateProvider){
    $urlRouterProvider.otherwise('/loginpage');
    $stateProvider
        .state('register', {
            url: '/register',
            templateUrl: 'register.html',
            controller: 'registerCtrl'
        })
    .state('loginpage', {
        url: '/loginpage',
        templateUrl: 'loginpage.html',
        controller:'loginCtrl'
    })
}])



app.controller("loginCtrl", function ($scope, $http) {
    $scope.email = '';
    $scope.password = '';
    $scope.login = function (email, password) {
        let data = { email: email, password: password }
        console.log(data)
        $http.post(" http://127.0.0.1:8000/api/login", data).then(
            function success(response) {

                // console.log(response.data.status)
                // console.log(response.data.token)
                if (response.data.status) {
                    //  localStorage.setItem("user", JSON.stringify(response.data.Data))
                    localStorage.setItem('token',JSON.stringify(response.data.token))
                    swal("Login Successfully", "", "success")
                      location.replace('index.html');
                }
                else {
                    swal(response.data.message, "", "error")
                }  
                

            },
            function error(response){
                swal(response.data.message, "", "error")
            }
            
        )
    }

});
app.controller("registerCtrl", function ($scope,$http) {
    $scope.name = '';
    $scope.email = '';
    $scope.password = '';
    $scope.register = function (name, email, password) {
        let data = { name: name, email: email, password: password }
        console.log(data)
        $http.post(" http://127.0.0.1:8000/api/register", data).then(
            function (response) {
                console.log(response)
                if (response.data.status) {


                    swal("Register Successfully", "", "success")
                    //  location.replace('login.html');
                    // location.reload();
                    $state.go('loginpage');
                }
                else {
                    swal(response.data.message, "", "error")
                }

            }
        )
    }
});
