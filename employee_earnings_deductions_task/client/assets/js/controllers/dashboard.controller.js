app.controller(
    "DashboardController",
    function ($scope, $rootScope, $state, userService) {
        if (!$rootScope.loggedIn) {
            $state.go("loginState");
        }

        // Modules
        $scope.modules = [];
        $scope.loading = true;
        userService
            .getModules()
            .then((response) => {
                if (response.data.status) {
                    $scope.modules = response.data.data;
                    $scope.loading = false;
                    if (response.data.data.length == 0) {
                        showError("No Modules Found");
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
            });
    }
);
