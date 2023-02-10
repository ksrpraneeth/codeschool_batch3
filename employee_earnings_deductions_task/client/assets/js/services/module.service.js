app.service("moduleService", function ($http, $state, $rootScope) {
    this.getById = function (id) {
        return $http({
            url: SERVER_URL + "/module/" + id,
            method: "GET"
        });
    }
});
