if('user_token' in localStorage){
    window.location.replace('home.html');
}
var loginmodule = angular.module('loginModule', []);

loginmodule.controller('loginController', function ($scope, $http) {
    $scope.email = '';
    $scope.password = '';


    $scope.loginfunction = function (email, password) {
        let data = { Email: email, Password: password }
        $http.post("api/loginapi.php", data).then(
            function (response) {
                console.log(response.data)
                if(response.data.status){
                    localStorage.setItem('token',response.data.Data[0]);
                    localStorage.setItem('username',response.data.Data[1]);
                    localStorage.setItem('phonenumber',response.data.Data[2]);
                    swal("Login Succesfully", "", "success");
                    location.replace('home.html')
                }
                else{
                    swal(response.data.message, "", "error");
                }

            },
            function (error) { 
                swal('Error', JSON.stringify(error), "error");
            }
        );
    }


    //photo slider

  
})