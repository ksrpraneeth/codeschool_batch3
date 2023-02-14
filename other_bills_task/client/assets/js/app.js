let app = angular.module("app", ["ui.router"]);
let SERVER = "http://127.0.0.1:8000/api";
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
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push("loadingInterceptor");
});

// Custom Functions
function showError(err) {
    Toastify({
        text: err,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #b02900, #c9853d)",
        },
    }).showToast();
}

function showSuccess(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
    }).showToast();
}
