app.controller(
    "BillEntryController",
    function ($scope, BillEntryService, AddAgencyService, $filter) {
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
        $scope.headOfAccount = "";
        $scope.referenceNumber = "";
        $scope.purpose = "";
        $scope.scrutinyItems = [];
        $scope.attachments = [];
        $scope.remark = "";

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
            $scope.agencyAcNoChanged();
            $scope.agencyList = [];
            $scope.headOfAccount = "";
            $scope.referenceNumber = "";
            $scope.purpose = "";
            $scope.scrutinyItems = [];
            $scope.attachments = [];
            $scope.remark = "";
            $scope.getHoas();
            $scope.getScrutinyItems();
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
            $scope.attachments = [];
            $scope.remark = "";
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
                agency_name: $scope.agencyDetails.agency_name,
                agency_bank_name:
                    $scope.agencyDetails.ifsc_code_details.bank_name,
                agency_bank_branch:
                    $scope.agencyDetails.ifsc_code_details.branch,
                agency_ifsc_code: $scope.agencyDetails.ifsc_code,
                agency_account_number: $scope.agencyDetails.account_number,
                agency_gst: $scope.agencyDetails.gst_no,
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

        $scope.getHoas = function () {
            if (!$scope.formType) return;
            BillEntryService.getHoasByFormType($scope.formType)
                .then((response) => {
                    $scope.hoas = response.data.data;
                })
                .catch((response) => {
                    if (response.data.message != undefined) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                });
        };

        $scope.getScrutinyItems = function () {
            $scope.scrutinyItems = [];
            if (!$scope.formType) return;
            BillEntryService.getScrutinyItemsByFormType($scope.formType)
                .then((response) => {
                    $scope.scrutinyItems = response.data.data;
                    response.data.data.forEach((item, index) => {
                        $scope.scrutinyItems[index] = {
                            desc: item.scrutiny_desc,
                            answer: "yes",
                        };
                    });
                })
                .catch((response) => {
                    if (response.data.message != undefined) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                    }
                });
        };

        $scope.addFile = function () {
            var file = document.getElementById("formFile").files[0];
            if (file == undefined) {
                showError("No File Selected!");
                return;
            }
            $scope.attachments.push({
                name: file.name,
                remark: $scope.remark,
                file: file,
            });
            $scope.remark = "";
            document.getElementById("formFile").value = null;
        };

        $scope.submitBill = function () {
            let formData = new FormData();
            let data = {
                form_type_id: $scope.formType,
                hoa: $scope.headOfAccount,
                reference_number: $scope.referenceNumber,
                purpose: $scope.purpose,
                gross: $filter("sumOfAmount")($scope.agencyList, "gross"),
                pt: $filter("sumOfAmount")($scope.agencyList, "pt"),
                tds: $filter("sumOfAmount")($scope.agencyList, "tds"),
                gst: $filter("sumOfAmount")($scope.agencyList, "gst"),
                gis: $filter("sumOfAmount")($scope.agencyList, "gis"),
                thn: $filter("sumOfAmount")($scope.agencyList, "thn"),
                net: $filter("sumOfAmount")($scope.agencyList, "net"),
            };
            for (let i = 0; i < $scope.agencyList.length; i++) {
                formData.append(
                    "bill_agencies[" + i + "][agency_name]",
                    $scope.agencyList[i].agency_name
                );
                formData.append(
                    "bill_agencies[" + i + "][agency_bank_name]",
                    $scope.agencyList[i].agency_bank_name
                );
                formData.append(
                    "bill_agencies[" + i + "][agency_bank_branch]",
                    $scope.agencyList[i].agency_bank_branch
                );
                formData.append(
                    "bill_agencies[" + i + "][agency_ifsc_code]",
                    $scope.agencyList[i].agency_ifsc_code
                );
                formData.append(
                    "bill_agencies[" + i + "][agency_account_number]",
                    $scope.agencyList[i].agency_account_number
                );
                formData.append(
                    "bill_agencies[" + i + "][agency_gst]",
                    $scope.agencyList[i].agency_gst
                );
                formData.append(
                    "bill_agencies[" + i + "][gross]",
                    $scope.agencyList[i].gross
                );
                formData.append(
                    "bill_agencies[" + i + "][pt]",
                    $scope.agencyList[i].pt
                );
                formData.append(
                    "bill_agencies[" + i + "][tds]",
                    $scope.agencyList[i].tds
                );
                formData.append(
                    "bill_agencies[" + i + "][gst]",
                    $scope.agencyList[i].gst
                );
                formData.append(
                    "bill_agencies[" + i + "][gis]",
                    $scope.agencyList[i].gis
                );
                formData.append(
                    "bill_agencies[" + i + "][thn]",
                    $scope.agencyList[i].thn
                );
                formData.append(
                    "bill_agencies[" + i + "][net]",
                    $scope.agencyList[i].net
                );
            }
            for (let i = 0; i < $scope.scrutinyItems.length; i++) {
                formData.append(
                    "scrutiny_answers[" + i + "][desc]",
                    $scope.scrutinyItems[i].desc
                );
                formData.append(
                    "scrutiny_answers[" + i + "][answer]",
                    $scope.scrutinyItems[i].answer
                );
            }
            for (let key in data) {
                formData.append(key, data[key]);
            }
            $scope.attachments.forEach((file) => {
                formData.append("files[]", file.file);
            });

            BillEntryService.createBill(formData)
                .then((response) => {
                    showSuccess(response.data.message);
                    $scope.getFormTypes();
                })
                .catch((response) => {
                    if (response.data.data) {
                        $scope.errors = response.data.data;
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong!");
                        console.log(response.data);
                    }
                });
        };
    }
);
