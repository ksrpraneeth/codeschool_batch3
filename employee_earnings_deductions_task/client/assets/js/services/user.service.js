app.service("userService", function ($http, $state, $rootScope) {
    this.login = function (email, password, rememberMe) {
        return $http({
            url: SERVER_URL + "/user/login",
            method: "POST",
            data: {
                email,
                password,
                rememberMe,
            },
        });
    };
    this.logout = function () {
        localStorage.clear();
        $rootScope.loggedIn = false;
        $state.go("loginState");
    };
    this.getModules = function () {
        return $http({
            url: SERVER_URL + "/user/getModules",
            method: "GET"
        });
    }

    this.getEmployees = function () {
        return $http({
            url: SERVER_URL + "/user/getEmployees",
            method: "GET"
        });
    }

    this.getBillIds = function () {
        return $http({
            url: SERVER_URL + "/user/getBillIds",
            method: "GET"
        });
    }
});
