app.controller("AddEmployeeController", function ($scope, $http) {
    $scope.employee = {};

    $scope.addEmployee = function (employee) {
        $scope.errors = [];

        $http({
            url: "http://127.0.0.1:8000/api/employees",
            method: "POST",
            data: employee,
        })
            .then((response) => {
                if (response.data.status) {
                    showError("Succesfully Insrted!");
                    $scope.employee = {};
                } else {
                    showError(response.data.message);
                }
            })
            .catch((response) => {
                if (response.data.status == false) {
                    $scope.errors = response.data.errors;
                    showError("Errors Occured!");
                    return;
                }
                showError(response.data.message);
            })
            .finally(() => {});
    };
});