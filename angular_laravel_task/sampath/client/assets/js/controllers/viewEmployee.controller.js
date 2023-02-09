app.controller(
    "ViewEmployeeController",
    function ($scope, $http, $stateParams) {
        $scope.editable = false;
        $scope.addSalary = {};

        $http({
            url: "http://127.0.0.1:8000/api/employees/" + $stateParams.id,
            method: "GET",
        })
            .then((response) => {
                if (response.data.status) {
                    $scope.employee = response.data.data;
                    $scope.employee.dob = new Date($scope.employee.dob);
                } else {
                    showError(response.data.message);
                }
            })
            .catch((response) => {
                showError("Not found");
            })
            .finally(() => {});
        $scope.saveEmployee = function (employee) {
            $scope.errors = [];

            $http({
                url: "http://127.0.0.1:8000/api/employees/" + $stateParams.id,
                method: "PUT",
                data: employee,
            })
                .then((response) => {
                    if (response.data.status) {
                        showError("Succesfully Updated!");
                        $scope.editable = false;
                    } else {
                        showError(response.data.message);
                        $scope.editable = false;
                    }
                })
                .catch((response) => {
                    $scope.errors = response.data.errors;
                    showError("Error updating employee");
                })
                .finally(() => {});
        };
        $scope.addNewSalary = function (salary) {
            $scope.salaryErrors = [];

            $http({
                url:
                    "http://127.0.0.1:8000/api/employees/" +
                    $stateParams.id +
                    "/salaries",
                method: "POST",
                data: salary,
            })
                .then((response) => {
                    if (response.data.status) {
                        showError("Succesfully Inserted!");
                        const myModal = new bootstrap.Modal(
                            document.getElementById("addNewSalaryModal")
                        );
                        myModal.hide();
                        $scope.addSalary = {};
                    } else {
                        showError(response.data.message);
                    }
                })
                .catch((response) => {
                    $scope.salaryErrors = response.data.errors;
                    showError("Error Inserting Salary");
                })
                .finally(() => {});
        };
    }
);