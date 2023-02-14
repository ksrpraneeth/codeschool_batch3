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
});
