let app = angular.module("app", ["ui.router"]);

app.run(function ($rootScope) {
    $rootScope.loggedIn = false;
    if (localStorage.getItem("token")) {
        $rootScope.loggedIn = true;
    }
});

app.run(function ($rootScope, $state) {
    $rootScope.$on(
        "$stateChangeStart",
        function (event, toState) {
            console.log("change started");
            if (toState.name === "loginState" && $rootScope.loggedIn) {
                event.preventDefault();
                $state.go("homeState");
            }
        }
    );
});

// Constants
let SERVER_URL = "http://127.0.0.1:8000/api";

// Custom Functions
function showError(msg) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "left", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
    }).showToast();
}
