app.service("userService", function ($http, $state) {
    this.login = function (email, password, rememberMe) {
        return $http({
            url: SERVER_URL + "/user/login",
            method: "POST",
            data: {
                email,
                password,
                rememberMe,
            },
        })
    };
});
