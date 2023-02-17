app.service("ViewBillService", function ($http) {
    this.getBill = function (tbr_no) {
        return $http({
            url: SERVER + "/transactions/get-by-tbr-no",
            method: "POST",
            data: {
                tbr_no
            }
        });
    };
});
