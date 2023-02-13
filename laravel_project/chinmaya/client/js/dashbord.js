
function getToken() {
    return "Bearer " + (localStorage.getItem('token'));
}

var dashbordModule = angular.module('DashbordModule', ['ui.router']);

dashbordModule.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state('dashbordhome', {
            url: '/home',
            templateUrl: 'dashbordhome.html'
        })

    $stateProvider
        .state('mybooking', {
            url: '/mybooking',
            templateUrl: 'mybooking.html'
        })

    $stateProvider
        .state('booknow', {
            url: '/booknow',
            templateUrl: 'booknow.html'
        })

    $urlRouterProvider.otherwise('/home');
}])

//----------------------------------------list of controllers-------------------------------


//dashbord controller
dashbordModule.controller('dashbordController', function ($http, $scope) {
    $scope.name = ''
    $http({
        method: "POST",
        url: 'http://127.0.0.1:8000/api/dashbord',
        headers: { 'Authorization': getToken() }
    }).then(
        function (response) {

            if (response.status != 200) {
                location.replace('index.html');
                localStorage.clear();
            }
            if (response.data.status) {
                $scope.name = response.data.username;
            }

        }, function (error) {
            console.log(error)
            location.replace('index.html');
            localStorage.clear();
        }
    )
})

//all stadium list
dashbordModule.controller('allStadiumController', function ($scope, $http,$state) {
    $scope.timeslotshow = false
    $scope.stadiumlist = [];
    $scope.price_show = false
    $scope.bookbutton_hide = false

    $http.get('http://127.0.0.1:8000/api/allStadium').then(
        function (response) {
            if (response.data.status) {
                $scope.stadiumlist = response.data.data
            }
        }, function (error) {

        }
    )
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    $scope.today = yyyy + '-' + mm + '-' + dd;

    $scope.sportsname = [];

    $scope.bokingdate = ''
    $scope.bookground = function (groundid) {

        $http.post('http://127.0.0.1:8000/api/sports', { groundid: groundid }).then(
            function (response) {
                if (response.data.status) {
                    $scope.sportsname = response.data.data

                }
            }, function (error) {

            }
        )
    }


    //cheack availbale slots
    $scope.timeslots = []
    $scope.ground_price = 0

    $scope.timeslot = function (groundid, gameid, date) {

        let day = new Date(date);
        let formdata = { ground_id: groundid, sport_id: gameid, booking_date: day, day_id: day.getDay() + 1 }

        $http.post('http://127.0.0.1:8000/api/availabletimeslot', formdata).then(
            function (response) {
                if (response.data.status) {
                    $scope.timeslotshow = true
                    $scope.ground_price = response.data.data[0].price
                    $scope.timeslots = response.data.data[0].slots
                    $scope.price_show = true
                    $scope.bookbutton_hide = true;
                }
                else {

                    swal("", response.data.message, "error")
                        .then(() => {
                            
                        });


                }
            }, function (error) {
                console.log(error)
            }
        )

    }

    //booknow function
    $scope.bookgroundgame = function (slot_id, booking_date) {

        var formdata = { slot_id: slot_id, booking_date: booking_date }
        if (!slot_id) {
            swal("", "Please Select the time slot", "error");
        }
        else {
            $http({
                method:'POST',
                url:'http://127.0.0.1:8000/api/bookground', 
                data:formdata,
                headers: { 'Authorization': getToken() }})
                .then(
                function (response) {
                    if (response.data.status) {
                        swal("", response.data.message, "success")
                        .then(() => {
                            $state.go('booknow')
                        });
                    }
                }, function (error) {
console.log(error)
                }
            )
        }
    }
})




//logout controller
dashbordModule.controller('logutcontroller', function ($scope, $http) {
    $scope.logout = function () {
        $http.post('http://127.0.0.1:8000/api/logout').then(
            function (response) {
                if (response.data.status) {
                    localStorage.clear();
                    location.replace('index.html');
                }
            }, function (error) {
                console.log(error);
                localStorage.clear();
                location.replace('index.html');
            }
        )
    }
})

dashbordModule.controller('bookingHistoryController',function($scope,$http){
    $scope.booking_history=[]
    $http({
        method:"POST",
        url:'http://127.0.0.1:8000/api/bokking_history',
        headers: { 'Authorization': getToken() }
        
    }).then(
        function(response){
if(response.data.status){
    console.log(response.data.data)
    $scope.booking_history=response.data.data

}
else{
    swal("", response.data.message, "error")
    .then(() => {
        location.replace('dashbord.html');
    });
}
        }
    )
    
})
