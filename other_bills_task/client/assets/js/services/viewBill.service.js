app.service("ViewBillService", function ($http) {
    this.getBill = function (tbr_no) {
        return $http({
            url: SERVER + "/transaction/view",
            method: "POST",
            data: {
                tbr_no
            }
        });
    };
});
