app.service("AddAgencyService", function ($http) {
    this.getIfscCodeDetails = function (ifsc_code) {
        return $http({
            url: SERVER + '/ifsc-code/get-by-code',
            method: "POST",
            data: {
                ifsc_code
            }
        })
    };
    this.createAgency = function (agencyDetails) {
        return $http({
            url: SERVER + '/agencies',
            method: "POST",
            data: agencyDetails
        })
    };

    this.getAgencyByAccountNumber = function (account_number) {
        return $http({
            url: SERVER + '/agencies/get-by-account-number',
            method: "POST",
            data: {
                account_number
            }
        })
    };

    this.updateAgency = function (id, data) {
        return $http({
            url: SERVER + '/agencies/'+id,
            method: "PUT",
            data: data
        })
    };
});
