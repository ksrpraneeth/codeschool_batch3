app.controller(
    "employeeMasterController",
    function ($scope, $rootScope, userService) {
        if (!$rootScope.loggedIn) {
            $state.go("loginState");
        }

        // Employees
        $scope.employees = [];
        $scope.billIds = [];
        $scope.loading = false;
        $scope.filter = "";

        // Functions
        $scope.changedFilter = function (value) {
            if (value == "billIdFilter") {
                $scope.getBillIds();
            }
            $scope.billIdInput = "";
            $scope.bankAcNoInput = "";
            $scope.employeeCodeInput = "";
        };

        $scope.getBillIds = function () {
            if ($scope.billIds.length > 0) return;
            userService
                .getBillIds()
                .then((response) => {
                    if (response.data.status) {
                        $scope.billIds = response.data.data;
                        if (response.data.data.length == 0) {
                            showError("No Bill IDs Found");
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
        };
        $scope.getEmployees = function (type) {
            switch(type){
                
            }
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
        };
    }
);
