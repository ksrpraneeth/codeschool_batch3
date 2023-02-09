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