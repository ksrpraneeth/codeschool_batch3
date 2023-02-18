app.controller(
    "PreviewBillController",
    function ($scope, ViewBillService, $stateParams) {
        $scope.billFound = false;
        $scope.bill = {};
        ViewBillService.getBill($stateParams.tbrNo)
            .then((response) => {
                $scope.bill = response.data.data;
                $scope.billFound = true;
            })
            .catch((response) => {
                console.log(response);
                if (response.data.message != undefined) {
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });
    }
);
