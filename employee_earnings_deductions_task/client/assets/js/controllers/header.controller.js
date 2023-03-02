app.controller("HeaderController", function ($scope, userService) {
    $scope.menu = [
        {
            title: "Home",
            state: "homeState",
            showWhen: "loggedIn==false",
        },
        {
            title: "Login",
            state: "loginState",
            showWhen: "loggedIn==false",
        },
        {
            title: "Modules",
            state: "dashboardState",
            showWhen: "loggedIn==true",
        },
        // {
        //     title: "My Profile",
        //     state: "loginState",
        //     showWhen: "loggedIn==true",
        // },
    ];

    $scope.logout = () => {
        userService.logout();
    };
});
