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
                    // showError(response.data.message);
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
    $scope.ifscCodeChanged = function(){
        $scope.ifscCodeDetails = {};
        $scope.errors.ifsc_code = [];
    }
    $scope.checkAccountNumber = function () {
        if (!$scope.addAgency.account_number) {
            return;
        }
        AddAgencyService.getAgencyByAccountNumber(
            $scope.addAgency.account_number
        ).then(() => {
            $scope.errors.account_number = [
                "An account with this number already exists. Please choose a different account number",
            ];
        });
    };
    $scope.validateAccountNumbers = function () {
        if (
            $scope.addAgency.account_number !=
            $scope.addAgency.confirm_account_number
        ) {
            $scope.errors.confirm_account_number = [
                "The Confirm Account Number field must match the Account Number field",
            ];
        }
    };
    // Add Agency Functions
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
                "The Confirm Account Number field must match the Account Number field",
            ];
        }

        if (!$scope.addAgency.ifsc_code) {
            $scope.errors.ifsc_code = ["IFSC Code is required"];
        }
        if (!$scope.ifscCodeDetails.bank_name) {
            $scope.errors.ifsc_code = ["Enter IFSC Code and Click on Search button"];
        }
        if (Object.keys($scope.errors).length != 0) {
            // showError("Please check the data");
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
                    // showError(response.data.message);
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
