let app = angular.module("app", ["ui.router"]);
app.run(function () {
    if (!localStorage.getItem("token")) {
        showError("Please Login Again!");
        window.location.href = "/";
    }
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

