const app = angular.module("app", ["ui.router"]);
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push(function () {
        return {
            request: function (config) {
                let token = localStorage.getItem("token");
                config.headers.Authorization = "Bearer " + token;
                return config;
            },

            responseError: function (response) {
                console.log(response.data.message);
                if (response.data.status) {
                    if (response.data.message == "LOGOUT") {
                        localStorage.clear();
                        location.href = "index.html";
                    }
                }
                return response;
            },
        };
    });
});
app.controller("mainController", function ($scope, $http) {
    $scope.user_name = "";
    if (localStorage.getItem("user_name")) {
        $scope.user_name = localStorage.getItem("user_name");
    } else {
        $http({
            url: "http://127.0.0.1:8000/api/user/get",
            method: "get",
        }).then(
            (response) => {
                if (response.data.status) {
                    $scope.user_name = response.data.data.name;
                    localStorage.setItem("user_name", response.data.data.name);
                } else {
                    alert("");
                }
            },
            (response) => {
                alert(response.data.message);
            }
        );
    }
    $scope.logout = async () => {
        await $http({
            url: "http://127.0.0.1:8000/api/user/get",
            method: "get",
        });
        localStorage.clear();
        location.href = "index.html";
    };
});
