app.controller(
    "LoginController",
    function ($scope, $rootScope, $state, userService) {
        $scope.formErrors = {};
        $scope.rememberMe = false;

        $scope.clearErrors = function (field) {
            $scope.formErrors[field] = "";
        };

        $scope.login = function () {
            $scope.formErrors = {};
            $scope.errorMessage = "";
            if (!$scope.email) {
                $scope.formErrors.email = ["Email is required"];
            }
            if (!$scope.password) {
                $scope.formErrors.password = ["Password is required"];
            }

            if (!Object.keys($scope.formErrors).length) {
                userService
                    .login($scope.email, $scope.password, $scope.rememberMe)
                    .then((response) => {
                        if (response.data.status) {
                            showError("Logged In Successfully");
                            localStorage.setItem("token", response.data.data);
                            $rootScope.loggedIn = true;
                            $state.go("homeState");
                        } else {
                            if (response.data.message) {
                                showError(response.data.message);
                                $scope.formErrors = response.data.data;
                            } else {
                                showError("Something went wrong");
                                console.log(response.data);
                            }
                        }
                    })
                    .catch((response) => {
                        console.log(response);
                        if (response.data.message) {
                            showError(response.data.message);
                        } else {
                            console.log(response.data);
                            showError("Something went wrong");
                        }
                    });
            }
        };
    }
);
