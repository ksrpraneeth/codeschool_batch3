var homeModule = angular.module('homeModule', ['ui.router']);

homeModule.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state('homepage', {
            url: '/homepage',
            templateUrl: 'homepage.html'
        })

    $stateProvider
        .state('sports', {
            url: '/sports',
            templateUrl: 'sports.html'
        })

    $stateProvider
        .state('stadium', {
            url: '/stadium',
            templateUrl: 'stadium.html'
        })

    $stateProvider
        .state('needhelp', {
            url: '/needhelp',
            templateUrl: 'needhelp.html'
        })


    $stateProvider
        .state('registration', {
            url: '/registration',
            templateUrl: 'registration.html'
        })

    $stateProvider
        .state('login', {
            url: '/login',
            templateUrl: 'login.html'
        })

        $stateProvider.state('dashbord',{
            url:'/dashbord',
            templateUrl:'dashbord.html'
        })


    $urlRouterProvider.otherwise('/homepage');
}])

//-------------------------------------------------------list of controllers-------------------------------------------

//Register controller

homeModule.controller('registrationController', function ($scope, $http,$state) {
    $scope.firstname = '';
    $scope.lastname = '';
    $scope.email = '';
    $scope.phone = '';
    $scope.password = '';

//Firstname validation
$scope.firstNameValidation=function(){
    $scope.firstNameError=''
    if(!$scope.firstname){
      $scope.firstNameError='Please fill the firstname.';
    }
    else if(/[^a-zA-Z]/.test($scope.firstname)){
        $scope.firstNameError='Special character are not allowed.';
    }
    else if(($scope.firstname).length>18){
        $scope.firstNameError='Maximum 18 character allowed.';
    }
}

//lastnamevalidation
$scope.lastNameValidation=function(){
    $scope.lastNameError=''

    if(!$scope.lastname){
        $scope.lastNameError='Please fill the lastname.'
    }

    else if(/[^a-zA-Z]/.test($scope.lastname)){
        $scope.firstNameError='Special character are not allowed.';
    }

    else if(($scope.lastname).length>10){
        $scope.firstNameError='Maximum 10 character allowed.';
    }
}

// Email validation

$scope.emailValidation=function(){
    $scope.emailError='';
    if(!$scope.email){
        $scope.emailError='Please fill the email field'
    }
    else if(/[^a-z0-9.@]/.test($scope.email)){
        $scope.emailError='Special character are not allowed'
    }
}

//Mobile number validation

$scope.phoneNumberValidation=function(){
$scope.phoneNumberError=''
if(!$scope.phone){
    $scope.phoneNumberError='Please enter your number'
}

}

    $scope.registration = function (firstname, lastname, email, phone, password) {

        if (!firstname || !lastname || !email || !phone || !password) {
            swal("", "Please fill all the required fields.", "error");
        }
        else {
            $http.post(
                'http://127.0.0.1:8000/api/registration',
             { firstname: firstname, lastname: lastname, email: email, phone: phone, password: password })
             
             .then(
                function (response) {
                    if (response.data.status) {
                        swal("", response.data.message, "success")
                            .then(() => {
                                $state.go('login')
                            });
                    }
                }, function (error) {
                    swal("", error.data.message, "error");
                }
            )
        }
    }
})

//login controller
homeModule.controller('loginController', function ($scope, $http,$state) {
    $scope.email = '';
    $scope.password = '';

    $scope.passwordError = '';



    //email field validation
    $scope.emailValidation = function () {
        $scope.emailError = '';
        if (!$scope.email) {
            $scope.emailError = 'Please fill the required field.';
        }
        if (/[^a-z0-9@.]/.test($scope.email)) {
            $scope.emailError = 'Special characters are not allowed.';
        }

        if (($scope.email).length > 35) {
            $scope.emailError = 'Maximum 35 character are allowed.'
        }
    }
    //password field validation
    $scope.passwordValidation = function () {
        $scope.passwordError = '';

        if (!$scope.password) {
            $scope.passwordError = 'Please fill the password field'
        }

        if (($scope.password).length > 10) {
            $scope.password = 'Maximum 10 character are allowed'
        }

    }



    $scope.login = function (email, password) {
        let status = true
        $scope.passwordError = ''
        $scope.emailError = ''
        if (!email) {
            $scope.emailError = 'Please provide the above field.'
            status = false
        }

        if (!password) {
            $scope.passwordError = 'Please provide the password.'
            status = false
        }



        if (status) {
            $http.post('http://127.0.0.1:8000/api/login', { email: email, password: password }).then(
                function (response) {
                    console.log(response);
                    if (response.data.status) {

                        swal("", 'Login Suceesfully', "success")
                            .then(() => {
                                localStorage.setItem('token', response.data.authorisation.token);

                                location.replace('dashbord.html');
                            });

                    }
                },
                function (error) {
                    console.log(error)
                    swal("", error.data.message, "error");
                }
            )
        }


    }
})

//home page controller

homeModule.controller('indexpageController', function ($scope, $http) {
    $scope.playgroundhide = false
    $scope.sportstypehide = false
    $scope.timeslothide = false
    $scope.amounthide = false
    $scope.booknowbuttonhide = false


    //state name
    $scope.statelist = [];
    $scope.gamename = [];
    $http.post('http://127.0.0.1:8000/api/statelist').then(
        function (response) {
            if (response.data.status) {
                $scope.statelist = response.data.data[0]
                $scope.gamename = response.data.data[1]

            }
        },
        function (error) {
            swal("", error.data.message, "error");
        }
    )
    //finding the stadium list

    $scope.groundlist = [];

    $scope.pincodesearch = function (stateid, pincode) {
        var formdata = { stateid: stateid, pincode: pincode };
        console.log(formdata)
        $http.post('http://127.0.0.1:8000/api/groundlist', formdata).then(
            function (response) {
                if (response.data.status) {
                    $scope.groundlist = response.data.data;
                    $scope.playgroundhide = true

                }
                else {
                    $scope.playgroundhide = false;
                    swal("", response.data.message, "error");

                }
            },
            function (error) {
                swal("", error.data.message, "error");
            }
        )
    }

    //changing the sports sub categorey 
    $scope.sportstype = [];
    $scope.changesportcategory = function (gameid) {


        $http.post('http://127.0.0.1:8000/api/sportstype', { gameid: gameid }).then(
            function (response) {
                console.log(response)
                if (response.data.status) {

                    $scope.sportstype = response.data.data
                    console.log($scope.sportstype)
                    $scope.sportstypehide = true
                }
                else {
                    $scope.sportstypehide = false
                    $scope.spotstypeid = 0
                }
            }, function (error) {

            }
        )
    }

    //opening the booking menu
    $scope.showbooknow = function (gameid, sportstypeid, groundname) {
        if ($scope.sportstypehide) {
            var formdata = { gameid: sportstypeid, stadiumid: groundname }
        }
        else {
            var formdata = { gameid: gameid, stadiumid: groundname }
        }

        $http.post('http://127.0.0.1:8000/api/gameavailable', formdata).then(
            function (response) {
                if (!response.data.status) {
                    $scope.booknowbuttonhide = false
                    swal("", response.data.message, "error");
                }
                else {
                    $scope.booknowbuttonhide = true
                }
            }, function (error) {

            }
        )


    }

    $scope.bookAndLogin = function () {
        location.replace('http://localhost/playgroundapp/client/index.html#!/login');
    }
})

//sportspagecontroller

homeModule.controller('sportscontroller', function ($scope, $http) {
    $scope.sports = [];
    $http.post('http://127.0.0.1:8000/api/sportslist').then(
        function (response) {
            $scope.sports = response.data.data;
        }, function (error) {

        }
    )


})


