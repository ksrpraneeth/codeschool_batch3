app.service("AddAgencyService", function ($http) {
    this.getIfscCodeDetails = function (ifsc_code) {
        return $http({
            url: SERVER + '/ifscCode/getByCode',
            method: "POST",
            data: {
                ifsc_code
            }
        })
    };
    this.createAgency = function (agencyDetails) {
        return $http({
            url: SERVER + '/agency/create',
            method: "POST",
            data: agencyDetails
        })
    };

    this.getAgencyByAccountNumber = function (account_number) {
        return $http({
            url: SERVER + '/agency/getByAccountNumber',
            method: "POST",
            data: {
                account_number
            }
        })
    };

    this.updateAgency = function (id, data) {
        return $http({
            url: SERVER + '/agency/update/'+id,
            method: "POST",
            data: data
        })
    };
});
