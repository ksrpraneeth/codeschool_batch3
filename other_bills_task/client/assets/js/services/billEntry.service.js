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

    this.getHoasByFormType = function (id) {
        return $http({
            url: SERVER + `/formNumber/formType/${id}/hoas`,
            method: "GET",
        });
    };

    this.getScrutinyItemsByFormType = function (id) {
        return $http({
            url: SERVER + `/formNumber/formType/${id}/scrutinyItems`,
            method: "GET",
        });
    };
});
