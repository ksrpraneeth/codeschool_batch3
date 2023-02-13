app.controller(
    "employeeMasterController",
    function ($scope, $rootScope, userService) {
        if (!$rootScope.loggedIn) {
            $state.go("loginState");
        }

        // Employees
        $scope.employees = [];
        $scope.loading = true;
        userService
            .getEmployees()
            .then((response) => {
                if (response.data.status) {
                    $scope.employees = response.data.data;
                    if (response.data.data.length == 0) {
                        showError("No Employees Found");
                    }
                } else {
                    if (response.data.message) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong");
                        console.log(response.data);
                    }
                }
            })
            .catch(function (response) {
                if (response.data.message) {
                    showError(response.data.message);
                } else {
                    showError("Something went wrong");
                    console.log(response.data);
                }
            })
            .finally(() => {
                $scope.loading = false;
            });
    }
);
