app.controller("ViewBillController", function ($scope, ViewBillService) {
    $scope.transactionTbr = "";
    $scope.bill = {};
    $scope.viewBill = function () {
        if (!$scope.transactionTbr) {
            showError("Transaction TBR Number is required");
            return;
        }
        ViewBillService.getBill($scope.transactionTbr)
            .then((response) => {
                $scope.bill = response.data.data;
                const viewBillModal = new bootstrap.Modal("#viewBillModal");
                viewBillModal.show();
            })
            .catch((response) => {
                if (response.data.message != undefined) {
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });
    };
});