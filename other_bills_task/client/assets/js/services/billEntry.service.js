app.service("BillEntryService", function ($http) {
    this.getFormNumbers = function () {
        return $http({
            url: SERVER + "/form-numbers",
            method: "GET",
        });
    };

    this.getFormTypes = function (id) {
        return $http({
            url: SERVER + `/form-numbers/${id}/form-types`,
            method: "GET",
        });
    };

    this.getHoasByFormType = function (id) {
        return $http({
            url: SERVER + `/form-numbers/form-types/${id}/hoas`,
            method: "GET",
        });
    };

    this.getScrutinyItemsByFormType = function (id) {
        return $http({
            url: SERVER + `/form-numbers/form-types/${id}/scrutiny-items`,
            method: "GET",
        });
    };

    this.createBill = function (data) {
        return $http({
            url: SERVER + "/transactions",
            method: "POST",
            transformRequest: angular.identity,
            headers: { "Content-Type": undefined },
            data,
        });
    };
});
