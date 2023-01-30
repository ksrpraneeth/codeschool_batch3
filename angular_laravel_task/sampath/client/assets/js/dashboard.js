let app = angular.module("app", ["ui.router"]);
app.run(function () {
    if (!localStorage.getItem("token")) {
        showError("Please Login Again!");
        window.location.href = "/";
    }
});
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
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push(function ($q) {
        return {
            request: function (config) {
                config.headers.Authorization =
                    "Bearer " + localStorage.getItem("token");
                return config;
            },

            response: function (response) {
                if (response.data.message == "LOGOUT") {
                    localStorage.removeItem("token");
                    window.location.href = "/";
                    return null;
                }
                return response;
            },
        };
    });
});
app.controller("NavbarController", function ($scope, $http) {
    $scope.navbarLinks = [
        { name: "Dashboard", state: "home" },
        { name: "Employees", state: "employees.list" },
    ];
    $scope.logout = function () {
        $http({
            url: "http://127.0.0.1:8080/api/user/logoutUser",
            method: "GET",
        });
        localStorage.removeItem("token");
        location.href = "/";
    };
});
app.controller("EmployeeController", function ($scope, $http) {
    $scope.employees = [];
    $scope.prev = "";
    $scope.next = "";
    $scope.pages = 1;
    $scope.currentPage = 1;
    $scope.getEmployees = function (pageNo) {
        $http({
            url: "http://127.0.0.1:8000/api/employees?page=" + (pageNo + 1),
            method: "GET",
        })
            .then((response) => {
                if (response.data.status) {
                    $scope.employees = response.data.data.data;
                    $scope.prev = "";
                    $scope.next = "";
                    if (response.data.data.prev_page_url) {
                        $scope.prev = response.data.data.prev_page_url;
                    }
                    if (response.data.data.next_page_url) {
                        $scope.next = response.data.data.next_page_url;
                    }
                    $scope.pages = response.data.data.last_page;
                    $scope.currentPage = response.data.data.current_page;
                } else {
                    showError(response.data.message);
                }
            })
            .catch((response) => {
                showError(response.data.message);
            });
    };
    $scope.getEmployees($scope.currentPage - 1);
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
app.controller("DashboardController", function ($scope) {});
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
