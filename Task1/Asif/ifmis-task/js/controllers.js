app.controller("AddNewAgencyController", function($scope, $http) {

    // variable to show the agency add/edit form on click of radio button
    $scope.selectAgencyFormAction = "add";
    
    
    // functions to check bank account availability
    function hasErrors() {
        return $scope.addSingleAgencyForm.bank_account_number.$invalid;
    }

    $scope.loading = false;
    $scope.checkBankAccount = function() {
        
        if (!hasErrors()) {
            $scope.loading = true;
            $http({
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/checkBankAccount',
                data: {
                    'bank_account_number': $scope.addSingleAgencyFormData.bank_account_number
                }
            })
            .then(function(response) {
                const result = response.data;
                if(!result.status) {
                    swal({
                        title: "Warning",
                        text: result.message,
                        icon: "warning",
                        button: "Close",
                    });     
                }
            });
        }

        $scope.loading = false;
    };




    // function to get bank details from database on ifsc search button
    $scope.getBankDetails = function() {
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/getBankDetails',
            data: {
                'ifsc_code': $scope.addSingleAgencyFormData.ifsc_code
            }
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                $scope.bankDetails = result.data[0];
            }
            else {
                $scope.bankDetails = false;
                swal({
                    title: "Failed",
                    text: result.message,
                    icon: "error",
                    button: "Close",
                });
            }
        },
        function error(response) {
            $scope.bankDetails = false;
            swal({
                title: "Failed",
                text: response.data.message,
                icon: "error",
                button: "Close",
            });
        });
    };



    // function to clear form data
    $scope.resetForm = function(formId) {
        document.getElementById(formId).reset();
    }


    // function to match account number input
    $scope.accountNumberMatch = function() {
        return $scope.addSingleAgencyFormData.bank_account_number === $scope.addSingleAgencyFormData.bank_account_number_confirmation;
    }


    // function to add agency details in the database
    $scope.addAgencyDetails = function() {
        $scope.dbErrors = [];
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/addAgencyDetails',
            data: $scope.addSingleAgencyFormData
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
                $scope.bankDetails = false;
                $scope.resetForm('addSingleAgencyForm');
            }
        },
        function error(response) {

            const errors = response.data.errors;
            $scope.dbErrors = {
                agency_name: ('agency_name' in errors) ? errors.agency_name[0] : '',
                bank_account_number: ('bank_account_number' in errors) ? errors.bank_account_number[0] : '',
                ifsc_code: ('ifsc_code' in errors) ? errors.ifsc_code[0] : '',
                gst_number: ('gst_number' in errors) ? errors.gst_number[0] : ''
            }

        });
    };




    // get agency details to edit
    $scope.getAgencyDetails = function() {
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/getAgencyDetails',
            data: {
                'bank_account_number': $scope.getAgencyDetailsFormData.bank_account_number
            }
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                $scope.agencyDetails = result.data[0];
            }
            else {
                $scope.agencyDetails = false;
                swal({
                    title: "Failed",
                    text: result.message,
                    icon: "error",
                    button: "Close",
                });
            }
        },
        function error(response) {
            $scope.agencyDetails = false;
            swal({
                title: "Failed",
                text: response.data.message,
                icon: "error",
                button: "Close",
            });
        });
    }



    // search new ifsc details
    $scope.searchNewIfsc = function() {

        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/getBankDetails',
            data: {
                'ifsc_code': $scope.updateAgencyDetailsFormData.ifsc_code
            }
        })
        .then(function success(response) {
            const result = response.data;
            if(result.status) {
                $scope.isIfscValid = true;
                $scope.bankDetails = result.data[0];
            }
            else {
                $scope.bankDetails = false;
                $scope.isIfscValid = false;
                swal({
                    title: "Failed",
                    text: result.message,
                    icon: "error",
                    button: "Close",
                });
            }
        },
        function error(response) {
            $scope.bankDetails = false;
            swal({
                title: "Failed",
                text: response.data.message,
                icon: "error",
                button: "Close",
            });
        });
    }



    // updating agency data in the database
    $scope.updateAgencyDetails = function() {

        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/updateAgencyDetails',
            data: {
                'id': $scope.agencyDetails.id,
                'agency_name': $scope.updateAgencyDetailsFormData.agency_name,
                'gst_number': $scope.updateAgencyDetailsFormData.gst_number,
                'ifsc_code': $scope.updateAgencyDetailsFormData.ifsc_code
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
                $scope.agencyDetails = false;
                $scope.bankDetails = false;
                $scope.isIfscValid = true;
                $scope.resetForm('updateAgencyDetailsForm');
                $scope.resetForm('updateAgencyDetailsForm');
            }
            else {
                swal({
                    title: "Failed",
                    text: result.message,
                    icon: "error",
                    button: "Close",
                });
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
    }
});

    






app.controller("BillEntryController", function($scope, $http) {

    $scope.selectBillEntryForm = "otherBills";

    $scope.getFormNumbers = function() {
        $http({
            method: 'GET',
            url: 'http://127.0.0.1:8000/api/getFormNumbers',
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.formNumbers = resData.data;
            }
        });
    }
    $scope.getFormNumbers();



    $scope.getFormTypes = function() {
        $http({
            method: 'GET',
            url: 'http://127.0.0.1:8000/api/getFormTypes',
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.formTypes = resData.data;
            }
        });
    }
    $scope.getFormTypes();



    $scope.getScrutinyItems = function() {

        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/getScrutinyItems',
            data: {
                'form_type_id': formTypeId
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.scrutinyItems = resData.data;
            }
        });
    }


});