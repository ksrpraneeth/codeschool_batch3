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