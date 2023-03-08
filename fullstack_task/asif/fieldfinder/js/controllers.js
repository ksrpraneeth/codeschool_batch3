
// app.service("CheckSessionService", function($http, $scope) {

//     this.isUserLoggedIn = function() {
//         let userData = localStorage.getItem("userData") ? JSON.parse(localStorage.getItem("userData")) : null ;
//         console.log(userData);
//         if(userData == null) {
//             return false;
//         }
//         let request  = {
//             method: 'GET',
//             url: 'http://127.0.0.1:8000/api/checkSession',
//             headers: {
//                 'Authorization': 'Bearer ' + userData.token
//             }
//         };
//         $scope.status = false;
//         $http(request).then(function success(response) {
//             // let status = response.data.status;

//             // if(resData.status) {
//             //     console.log(resData.status);
//             //     return true;
//             // }
//             // return resData.status;
//             // console.log(status);
//             $scope.status = response.data.status; 
//             // return true;
//         }, function error(response) {
//             return false;
//         });
//         // if($scope.status) {
//         //     console.log($scope.status);
//         //     return true;
//         // }
//         console.log("status=" +$scope.status);
//         return $scope.status;
//     }
// });

app.service("CheckSessionService", function(){

    this.checkSession = function() {
        if(localStorage.getItem('userData')) {
            return true;
        }
        return false;
    };

});


app.controller("HomeController", function($rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

});


app.controller("AboutController", function($rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

});


app.controller("ContactController", function($rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

});



app.controller("UsersController", function($scope, $http, $state, $rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

    $scope.passwordMatch = function() {
        return $scope.registrationFormData.password === $scope.registrationFormData.password_confirmation;
    }


    $scope.register = function() {
        
        $scope.dbErrors = [];
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/register',
            data: $scope.registrationFormData
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                swal({
                    title: "Success",
                    text: result.message,
                    icon: "success",
                    button: "Close",
                });
                $state.go('login');
            }
        },
        function error(response) {
            const errors = response.data.errors;
            $scope.dbErrors = {
                fullname: ('fullname' in errors) ? errors.fullname[0] : '',
                phone: ('phone' in errors) ? errors.phone[0] : '',
                email: ('email' in errors) ? errors.email[0] : '',
                password: ('password' in errors) ? errors.password[0] : ''
            }
        });
    }


    $scope.login = function() {
        $scope.dbErrors = [];
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/login',
            data: $scope.loginFormData
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                swal({
                    title: "Success",
                    text: result.message,
                    icon: "success",
                    button: "Close",
                });
                localStorage.setItem("userData", JSON.stringify(result.authorization));
                $rootScope.isUserLoggedIn = true;
                $state.go('venues');
            }
        },
        function error(response) {
            swal({
                title: "Failed",
                text: response.data.message,
                icon: "error",
                button: "Close",
            });
        });
    };

});


app.controller("VenuesController", function($scope, $http, $state, $rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

    // get all the venues details from the database
    $scope.getVenues = function() {
        $http.get("http://127.0.0.1:8000/api/getVenues")
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.venuesList = resData.data;
            }
        });
    };
    $scope.getVenues();
    
    $scope.getAllCities = function() {
        $http.get("http://127.0.0.1:8000/api/getCities")
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.citiesList = resData.data;
            }
        });
    }
    $scope.getAllCities();


    $scope.getAllSports = function() {
        $http.get("http://127.0.0.1:8000/api/getSports")
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.sportsList = resData.data;
            }
        });
    }
    $scope.getAllSports();


    // function to make a valid venue name to be displayed in the url by using venue name and area   
    $scope.makeUrl = function(str1, str2) {
        let result = str1 + " " + str2;
        result = result.toLowerCase();
        result = result.replace(/ /g, "-");
        return result;
    }

    // redirecting to booking page with the venue id and valid venue name(url)
    $scope.bookVenue = function(id, name, area) {
        var venueName = $scope.makeUrl(name, area);
        $state.go('bookVenue', {
            id: id,
            venueName: venueName
        });
    }

});


app.controller("BookingsController", function($scope, $http, $state, $stateParams, $rootScope, CheckSessionService) {

    if(CheckSessionService.checkSession == true) {
        $rootScope.isUserLoggedIn = true;
    }

    
    // to get venue details
    if($stateParams.id != null) {
        localStorage.setItem("venue_id", $stateParams.id);
    }
    $scope.id = localStorage.getItem("venue_id");

    $scope.getVenueDetails = function() {
        $scope.venueDetails = [];
        $http.get("http://127.0.0.1:8000/api/getVenueDetails", {params: {id: $scope.id} })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.venueDetails = resData.data;
            }
        });
    };
    $scope.getVenueDetails();


    // for bookings dates
    let date = new Date();
    let year = date.toLocaleString("default", { year: "numeric" });
    let month = date.toLocaleString("default", { month: "2-digit" });
    let day = date.toLocaleString("default", { day: "2-digit" });
    
    // today's date
    $scope.todaysDate = year + "-" + month + "-" + day;


    // date after 5 days
    let endDate = date.setDate(date.getDate() + 4);
    let dateAfterFourDays = new Date(endDate);
    year = dateAfterFourDays.toLocaleString("default", { year: "numeric" });
    month = dateAfterFourDays.toLocaleString("default", { month: "2-digit" });
    day = dateAfterFourDays.toLocaleString("default", { day: "2-digit" });
    $scope.dateAfterFourDays = year + "-" + month + "-" + day;

    
    $scope.getAvailableSports;
});



app.controller("LogoutController", function($scope, $http, $state) {

    $scope.logout = function() {

        if(!localStorage.getItem('userData')) {
            return $state.go('home');
        }

        let data = JSON.parse(localStorage.getItem('userData'));
        let token = data.token;
        $http({
            method: 'GET',
            url: 'http://127.0.0.1:8000/api/logout',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                swal({
                    title: "Success",
                    text: result.message,
                    icon: "success",
                    button: "Close",
                });
                localStorage.removeItem("userData");
                $state.go('home');
            }
        });
    };
    $scope.logout();
});