app.controller("AddAgencyController", function ($scope, AddAgencyService) {
    $scope.radioSelect = "AddAgency";
    $scope.addAgency = {};
    $scope.editAgency = {};
    $scope.agencyFound = false;
    $scope.errors = [];
    $scope.acNoSearch = "";
    $scope.getIfscCodeDetails = function (ifscCode) {
        $scope.errors.ifsc_code = [];
        $scope.ifscCodeDetails = {};
        AddAgencyService.getIfscCodeDetails(ifscCode)
            .then((response) => {
                $scope.ifscCodeDetails = response.data.data;
            })
            .catch((response) => {
                if (response.data.message) {
                    $scope.errors.ifsc_code = response.data.data.ifsc_code;
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });
    };
    $scope.clearData = function () {
        $scope.addAgency = {};
        $scope.editAgency = {};
        $scope.errors = [];
        $scope.ifscCodeDetails = {};
        $scope.agencyFound = false;
        $scope.acNoSearch = "";
    };
    // Add Agency Functions
    $scope.checkAccountNumber = function () {
        AddAgencyService.getAgencyByAccountNumber(
            $scope.addAgency.account_number
        ).then(() => {
            showError("Account Number Already Exists");
        });
    };
    $scope.addNewAgency = function () {
        $scope.errors = {};
        if (!$scope.addAgency.agency_name) {
            $scope.errors.agency_name = ["Agency Name is required"];
        }
        if (!$scope.addAgency.account_number) {
            $scope.errors.account_number = [
                "Agency Account Number is required",
            ];
        }

        if (
            $scope.addAgency.account_number !=
            $scope.addAgency.confirm_account_number
        ) {
            $scope.errors.confirm_account_number = [
                "Confirm Account Number and Account Number should be same",
            ];
        }

        if (!$scope.addAgency.ifsc_code) {
            $scope.errors.ifsc_code = ["IFSC Code is required"];
        }

        if (Object.keys($scope.errors).length != 0) {
            showError("Please check the data");
            return;
        }
        AddAgencyService.createAgency($scope.addAgency)
            .then((response) => {
                showSuccess(response.data.message);
                $scope.clearData();
            })
            .catch((response) => {
                if (response.data.message) {
                    $scope.errors = response.data.data;
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });
    };

    // Edit Agency Functions
    $scope.getAgency = function () {
        $scope.editAgency = {};
        $scope.errors = [];
        $scope.agencyFound = false;
        AddAgencyService.getAgencyByAccountNumber($scope.acNoSearch)
            .then((response) => {
                $scope.editAgency = response.data.data;
                $scope.agencyFound = true;
            })
            .catch((response) => {
                if (response.data.message) {
                    showError(response.data.message);
                } else {
                }
            });
    };
    $scope.updateAgency = function () {
        let data = {};
        if ($scope.editAgency.newAgencyName) {
            data["agency_name"] = $scope.editAgency.newAgencyName;
        }
        if ($scope.editAgency.newGstNo) {
            data["gst_no"] = $scope.editAgency.newGstNo;
        }
        if ($scope.editAgency.newIfscCode) {
            data["ifsc_code"] = $scope.editAgency.newIfscCode;
        }
        if (Object.keys(data).length > 0) {
            AddAgencyService.updateAgency($scope.editAgency.id, data)
                .then((response) => {
                    showSuccess("Agency/Party Updated Succesfully");
                    $scope.clearData();
                })
                .catch((response) => {
                    if (response.data.message) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                });
        } else {
            showError("Nothing changed to update!");
        }
    };
});