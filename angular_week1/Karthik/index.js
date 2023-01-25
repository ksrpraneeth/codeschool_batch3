var app = angular.module('voter', []);

app.controller('voterDetails', function ($scope) {
    $scope.details = [
        { id: '101', name: 'Karthik', age: '21', phNo: '8457123691', email: 'karthik@gmail.com', address: 'Shadnagar' },
        { id: '102', name: 'Bhanu', age: '22', phNo: '9857123691', email: 'bhanu@gmail.com', address: 'Hyderabad' },
        { id: '103', name: 'Sampath', age: '24', phNo: '9589123691', email: 'sampath@gmail.com', address: 'Khammam' },
        { id: '104', name: 'Manoj', age: '26', phNo: '9589124591', email: 'manoj@gmail.com', address: 'Parigi' },
        { id: '104', name: 'Yashwanth', age: '50', phNo: '9852124591', email: 'yaswanth@gmail.com', address: 'Jadcherla' }
    ];
    $scope.CheckUncheckHeader = function () {
        $scope.IsAllChecked = true;
        for (var i = 0; i < $scope.details.length; i++) {
            if (!$scope.details[i].Selected) {
                $scope.IsAllChecked = false;
                break;
            }
        };
    };
    $scope.CheckUncheckHeader();

    $scope.CheckUncheckAll = function () {
        for (var i = 0; i < $scope.details.length; i++) {
            $scope.details[i].Selected = $scope.IsAllChecked;
        }
    };
});
