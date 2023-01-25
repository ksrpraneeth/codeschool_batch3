let app = angular.module("app", ["ui.router"]);
app.config(function ($stateProvider, $urlRouterProvider) {
    let homeRoute = {
        name: "home",
        url: "/",
        templateUrl: "templates/dashboard/home.html",
    };
    let employeesRoute = {
        name: "employees",
        url: "/employees",
        templateUrl: "templates/dashboard/employees.html",
        controller: "TabController",
    };
    let employeeListRoute = {
        name: "employees.list",
        url: "/list",
        templateUrl: "templates/dashboard/employee/list.html",
        controller: "EmployeeController",
    };
    let employeeAddRoute = {
        name: "employees.add",
        url: "/add",
        templateUrl: "templates/dashboard/employee/add.html",
        controller: "AddEmployeeController",
    };
    let employeeViewRoute = {
        name: "employees.view",
        url: "/view/:id",
        templateUrl: "templates/dashboard/employee/view.html",
        controller: "ViewEmployeeController",
    };
    $stateProvider.state(homeRoute);
    $stateProvider.state(employeesRoute);
    $stateProvider.state(employeeListRoute);
    $stateProvider.state(employeeAddRoute);
    $stateProvider.state(employeeViewRoute);
    $urlRouterProvider.otherwise("/");
});
app.controller("NavbarController", function ($scope) {
    $scope.navbarLinks = [
        { name: "Dashboard", state: "home" },
        { name: "Employees", state: "employees" },
    ];
});
app.controller("EmployeeController", function ($scope, $http) {
    $scope.employees = [];
    $http({
        url: "http://127.0.0.1:8000/api/employees",
        method: "GET",
    })
        .then((response) => {
            if (response.data.status) {
                $scope.employees = response.data.data;
            } else {
                showError(response.data.message);
            }
        })
        .catch((response) => {
            showError(response.data.message);
        });
});
app.controller("TabController", function ($scope) {
    $scope.tabs = [
        { title: "List", state: "employees.list" },
        { title: "Add Employee", state: "employees.add" },
    ];
});
app.controller("AddEmployeeController", function ($scope, $http) {
    $scope.employee = {};

    $scope.addEmployee = function (employee) {
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
                showError("Not found");
            });
    };
});
app.controller(
    "ViewEmployeeController",
    function ($scope, $http, $stateParams) {
        $scope.editable = false;
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
            });
        $scope.saveEmployee = function (employee) {
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
                    showError("Not found");
                    $scope.editable = false;
                });
        };
    }
);
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
