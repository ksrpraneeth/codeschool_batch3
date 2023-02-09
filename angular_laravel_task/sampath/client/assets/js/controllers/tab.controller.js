app.controller("TabController", function ($scope) {
    $scope.tabs = [
        { title: "List", state: "employees.list" },
        { title: "Add Employee", state: "employees.add" },
    ];
});