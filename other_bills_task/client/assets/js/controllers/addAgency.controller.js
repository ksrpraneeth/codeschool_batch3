app.controller("AddAgencyController", function ($scope, AddAgencyService) {
    $scope.type = "AddAgency";
    $scope.ifscCodeErrors = [];
    $scope.addAgency = {
        name: "",
        accountNumber: "",
        confirmAccountNumber: "",
        gstNo: "",
        ifscCode: "",
    };
    $scope.editAgency = {
        name: "",
        accountNumber: "",
        confirmAccountNumber: "",
        gstNo: "",
        ifscCode: "",
        newName: "",
        newGstNo: "",
        newIfscCode: "",
    };
    $scope.getIfscCodeDetails = function (ifscCode) {
        $scope.ifscCodeErrors = [];
        $scope.ifscCodeDetails = {};
        AddAgencyService.getIfscCodeDetails(ifscCode)
            .then((response) => {
                $scope.ifscCodeDetails = response.data.data;
            })
            .catch((response) => {
                if (response.data.message) {
                    $scope.ifscCodeErrors = response.data.data.ifsc_code;
                    showError(response.data.message);
                } else {
                    showError("Something went wrong!");
                }
            });
    };
    $scope.addNewAgency = function(){
        
    }
});
