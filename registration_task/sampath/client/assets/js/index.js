const app = angular.module("app", ["ui.router"]);
app.controller("indexController", function ($scope) {
    $scope.type = "register";
    $scope.changeType = (type) => {
        $scope.type = type;
    };
});
app.controller("registerController", function ($scope, $http) {
    $scope.errors = {};
    $scope.register = ($event) => {
        $event.preventDefault();
        if (!$scope.email || !$scope.name || !$scope.password) {
            alert("Please enter all the details!");
            return;
        }
        let data = {
            email: $scope.email,
            password: $scope.password,
            name: $scope.name,
        };

        $http({
            url: "http://127.0.0.1:8000/api/user/register",
            method: "POST",
            data,
        }).then(
            (response) => {
                if (response.data.status) {
                    $scope.changeType("login");
                    alert("User Regsitered Succesffully!");
                } else {
                    if (response.data.message) {
                        alert(response.data.message);
                    } else {
                        alert("Something went wrong!");
                    }
                }
            },
            (response) => {
                if (response.data.errors) {
                    $scope.errors = response.data.errors;
                } else {
                    alert("Something went wrong!");
                }
            }
        );
    };
});
app.controller("loginController", function ($scope, $http) {
    $scope.errors = {};
    $scope.login = ($event) => {
        $event.preventDefault();
        if (!$scope.email || !$scope.password) {
            alert("Please enter all the details!");
            return;
        }
        let data = {
            email: $scope.email,
            password: $scope.password,
        };

        $http({
            url: "http://127.0.0.1:8000/api/user/login",
            method: "POST",
            data,
        }).then(
            (response) => {
                if (response.data.status) {
                    alert("User Regsitered Succesffully!");
                    let token = response.data.data;
                    localStorage.setItem("token", token);
                    location.href = "dashboard.html";
                } else {
                    if (response.data.message) {
                        alert(response.data.message);
                    } else {
                        alert("Something went wrong!");
                    }
                }
            },
            (response) => {
                if (response.data.errors) {
                    $scope.errors = response.data.errors;
                } else {
                    alert("Something went wrong!");
                }
            }
        );
    };
});
