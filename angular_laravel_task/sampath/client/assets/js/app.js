let app = angular.module("app", ["ui.router"]);
app.config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state("login", {
            url: "/login",
            templateUrl: "templates/login.html",
            controller: "LoginController",
        })
        .state("register", {
            url: "/register",
            templateUrl: "templates/register.html",
            controller: "RegisterController",
        });
    $urlRouterProvider.otherwise("/login");
});
app.controller("RegisterController", function ($scope, $http) {
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
                    showError("User Regsitered Succesffully!");
                } else {
                    if (response.data.message) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                }
            },
            (response) => {
                if (response.data.errors) {
                    $scope.errors = response.data.errors;
                } else {
                    showError("Something went wrong!");
                }
            }
        );
    };
});
app.controller("LoginController", function ($scope, $http) {
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
                    showError("User Regsitered Succesffully!");
                    let token = response.data.data;
                    localStorage.setItem("token", token);
                    location.href = "dashboard.html";
                } else {
                    if (response.data.message) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                }
            },
            (response) => {
                if (response.data.errors) {
                    $scope.errors = response.data.errors;
                } else {
                    showError("Something went wrong!");
                }
            }
        );
    };
});

function showError(message) {
    Toastify({
        text: message,
        duration: 2000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
    }).showToast();
}
