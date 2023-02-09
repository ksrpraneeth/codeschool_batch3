app.controller("EmployeeController", function ($scope, $http) {
    $scope.employees = [];
    $scope.prev = "";
    $scope.next = "";
    $scope.pages = 1;
    $scope.currentPage = 1;
    $scope.getEmployees = function (pageNo) {
        $http({
            url: "http://127.0.0.1:8000/api/employees?page=" + (pageNo + 1),
            method: "GET",
        })
            .then((response) => {
                if (response.data.status) {
                    $scope.employees = response.data.data.data;
                    $scope.prev = "";
                    $scope.next = "";
                    if (response.data.data.prev_page_url) {
                        $scope.prev = response.data.data.prev_page_url;
                    }
                    if (response.data.data.next_page_url) {
                        $scope.next = response.data.data.next_page_url;
                    }
                    $scope.pages = response.data.data.last_page;
                    $scope.currentPage = response.data.data.current_page;
                } else {
                    showError(response.data.message);
                }
            })
            .catch((response) => {
                showError(response.data.message);
            });
    };
    $scope.getEmployees($scope.currentPage - 1);
});