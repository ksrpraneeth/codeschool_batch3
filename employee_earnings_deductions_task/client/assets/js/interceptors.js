app.config(function ($httpProvider) {
    $httpProvider.interceptors.push(function ($rootScope, $state) {
        return {
            request: function (config) {
                // same as above
                if (localStorage.getItem("token")) {
                    config.headers.Authorization =
                        "Bearer " + localStorage.getItem("token");
                }
                return config;
            },

            responseError: function (response) {
                // same as above
                if (response.status == 401) {
                    showError("Session Expired Please Login Again!");
                    localStorage.clear();
                    $rootScope.loggedIn = false;
                    $state.go("loginState");
                }
            },
        };
    });
});
