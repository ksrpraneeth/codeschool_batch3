app.controller("HeaderController", function ($scope) {
    $scope.menu = [
        {
            "title": "Home",
            "state": "homeState"
        },
        {
            "title": "Login",
            "state": "loginState",
            "showWhen": "loggedIn==false"
        },
        {
            "title": "My Profile",
            "state": "loginState",
            "showWhen": "loggedIn==true"
        }
    ];
});
