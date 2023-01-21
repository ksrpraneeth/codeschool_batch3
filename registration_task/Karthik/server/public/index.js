var app = angular.module('user', []);
app.controller('RegisterController', function ($scope, $http) {
  $scope.fullNameInput = "";
  $scope.emailInput = "";
  $scope.phoneNumberInput = "";
  $scope.dobInput = "";
  $scope.passwordInput = "";
  $scope.confirmPasswordInput = "";
  $scope.register = function () {

    $http({
      url: "/api/register",
      method: "POST",
      data: {
        full_name: $scope.fullNameInput,
        email: $scope.emailInput,
        phone_number: $scope.phoneNumberInput,
        dob: $scope.dobInput,
        password: $scope.passwordInput,
        password_confirmation: $scope.confirmPasswordInput
      }
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
          if (responseData.data.status) {
            alert(responseData.data.message);
            location.assign("./home.html");
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);

        })
  }
});
app.controller('LoginController', function ($scope, $http) {
  $scope.emailInput = "";
  $scope.passwordInput = "";
  $scope.login = function () {

    $http({
      url: "/api/Login",
      method: "POST",
      data: {
        email: $scope.emailInput,
        password: $scope.passwordInput,
      }
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
          if (responseData.data.status) {
            alert(responseData.data.message);
            location.assign("./home.html");
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);

        })
  }
});