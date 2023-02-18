app.factory("loadingInterceptor", function ($q) {
    return {
        request: function (config) {
            document.getElementById("loadingScreen").classList.remove("d-none");
            return config;
        },
        response: function (response) {
            document.getElementById("loadingScreen").classList.add("d-none");
            return response;
        },
        responseError: function (rejection) {
            document.getElementById("loadingScreen").classList.add("d-none");
            return $q.reject(rejection);
        },
    };
});