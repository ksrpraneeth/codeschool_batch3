app.controller(
    "BillEntryController",
    function ($scope, BillEntryService, AddAgencyService) {
        $scope.billTypeRadio = "otherBill";
        $scope.formNumbers = [];
        $scope.formTypes = [];
        $scope.agencyAcNo = "";
        $scope.agencyFound = false;
        $scope.grossAmount = 0;
        $scope.ptAmount = 0;
        $scope.tdsAmount = 0;
        $scope.gstAmount = 0;
        $scope.gisAmount = 0;
        $scope.thnAmount = 0;
        $scope.agencyNet = 0;
        $scope.agencyList = [];

        // Constructer HTTP calls
        BillEntryService.getFormNumbers()
            .then((response) => {
                if (response.data.data.length > 0) {
                    $scope.formNumbers = response.data.data;
                } else {
                    showError("No Form Numbers found!");
                }
            })
            .catch((response) => {
                if (response.data.message) {
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });

        // Functions
        $scope.getFormTypes = function () {
            $scope.formTypes = [];
            if (!$scope.formNumber) return;
            BillEntryService.getFormTypes($scope.formNumber)
                .then((response) => {
                    if (response.data.data.length > 0) {
                        $scope.formTypes = response.data.data;
                    } else {
                        showError("No Form Types Found with this Form Number");
                    }
                })
                .catch((response) => {
                    if (response.data.message != undefined) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                });
        };

        $scope.formTypeChanged = function () {
            $scope.agencyAcNo = "";
            $scope.agencyFound = false;
            $scope.grossAmount = 0;
            $scope.ptAmount = 0;
            $scope.tdsAmount = 0;
            $scope.gstAmount = 0;
            $scope.gisAmount = 0;
            $scope.thnAmount = 0;
            $scope.agencyNet = 0;
            $scope.agencyAcNoChanged();
        };

        $scope.searchAgency = function () {
            $scope.agencyAcNoChanged();
            if ($scope.agencyAcNo == "") {
                showError("Please Enter Account Number:");
                return;
            }
            AddAgencyService.getAgencyByAccountNumber($scope.agencyAcNo)
                .then((response) => {
                    $scope.agencyDetails = response.data.data;
                    $scope.agencyFound = true;
                })
                .catch((response) => {
                    if (response.data.message != undefined) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                });
        };

        $scope.agencyAcNoChanged = function () {
            $scope.agencyFound = false;
            $scope.grossAmount = 0;
            $scope.ptAmount = 0;
            $scope.tdsAmount = 0;
            $scope.gstAmount = 0;
            $scope.gisAmount = 0;
            $scope.thnAmount = 0;
            $scope.agencyNet = 0;
        };

        $scope.updateAgencyNet = function () {
            try {
                $scope.agencyNet =
                    parseInt($scope.grossAmount) +
                    parseInt($scope.ptAmount) +
                    parseInt($scope.tdsAmount) +
                    parseInt($scope.gstAmount) +
                    parseInt($scope.gisAmount) +
                    parseInt($scope.thnAmount);
            } catch (e) {
                showError("Please check the amount's");
                console.log(e.message);
            }
        };

        $scope.addAgency = function () {
            if (parseInt($scope.grossAmount) == 0 || $scope.grossAmount == "") {
                showError("Gross Amount should be greater than 1₹");
                return;
            }
            if ($scope.agencyNet < 1 || isNaN($scope.agencyNet)) {
                showError("Please check the amount's");
                return;
            }
            $scope.agencyList.push({
                name: $scope.agencyDetails.agency_name,
                bank_name: $scope.agencyDetails.ifsc_code_details.bank_name,
                branch: $scope.agencyDetails.ifsc_code_details.branch,
                ifsc_code: $scope.agencyDetails.ifsc_code,
                ac_no: $scope.agencyDetails.account_number,
                gross: $scope.grossAmount,
                pt: $scope.ptAmount,
                tds: $scope.tdsAmount,
                gst: $scope.gstAmount,
                gis: $scope.gisAmount,
                thn: $scope.thnAmount,
                net: $scope.agencyNet,
            });
            $scope.agencyAcNo = "";
            $scope.agencyFound = false;
            $scope.grossAmount = 0;
            $scope.ptAmount = 0;
            $scope.tdsAmount = 0;
            $scope.gstAmount = 0;
            $scope.gisAmount = 0;
            $scope.thnAmount = 0;
            $scope.agencyNet = 0;
        };
    }
);
