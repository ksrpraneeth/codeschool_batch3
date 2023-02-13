app.controller(
    "ModuleController",
    function ($scope, $rootScope, $state, moduleService, $stateParams) {
        $scope.module = {};
        $scope.loading = true;
        moduleService
            .getById($stateParams.id)
            .then((response) => {
                $scope.module = response.data.data;
            })
            .catch((response) => {
                if (response.status === 404) {
                    showError("Module not found");
                    $state.go("dashnoardState");
                } else {
                    if (response.data.message) {
                        showError(response.data.message);
                    } else {
                        showError("Something went wrong");
                    }
                }
            })
            .finally(() => {
                $scope.loading = false;
            });
    }
);
