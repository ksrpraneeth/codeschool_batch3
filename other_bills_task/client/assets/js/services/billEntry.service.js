app.service("BillEntryService", function ($http) {
    this.getFormNumbers = function () {
        return $http({
            url: SERVER + "/formNumber/all",
            method: "GET",
        });
    };

    this.getFormTypes = function (id) {
        return $http({
            url: SERVER + `/formNumber/${id}/formTypes`,
            method: "GET",
        });
    };
});
