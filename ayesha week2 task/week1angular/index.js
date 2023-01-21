var app=angular.module("app",[]);
app.controller("registerController",function($scope,$http,$window)
{
    $scope.register=function()
    {
        $http({
            method:'POST',
            url:'http://127.0.0.1:8000/api/registerUser',
            data:{email:$scope.email,
                //backend:frontend
                fullName:$scope.fullName,
                username:$scope.username,
                password:$scope.password,
                password_confirmation:$scope.confirmPassword
            }
        }).then(function success(response)
        {
            if(response.data.status==true){
                alert(response.data.message);
                $window.location.href='login.html';
            }
            else
            {
                $scope.error = response.data.message;
            }
            
        },
            function error(response){
                $scope.error = response.data.errors[Object.keys(response.data.errors)[0]][0];
            })
    }
    //login 
    $scope.login=function()
    {
        $http({
            method:'POST',
            url:'http://localhost:8000/api/loginUser',
            data:{
                username:$scope.username,
                password:$scope.password
            }
        }).then(function success(response)
        {
            if(response.data.status==true){
                $window.location.href='homepage.html';
            } else {
                alert(response.data.message)
            }
        },
            function error(response){
                if(response.data.errors){
                    alert("Login Failed check data!")
                }
            })
    }

});