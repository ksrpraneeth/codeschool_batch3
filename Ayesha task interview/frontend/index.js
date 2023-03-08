var app = angular.module("app", ["ui.router"]).filter("sumColumn", function () {
  return function (dataSet, columnToSum) {
    let sum = 0;
    for (let i = 0; i < dataSet.length; i++) {
      sum += parseFloat(dataSet[i][columnToSum]) || 0;
    }
    return sum;
  };
});
app.config([
  "$stateProvider",
  function ($stateProvider) {
    $stateProvider
      .state("paySlips", {
        url: "/paySlips",
        templateUrl: "employee.html",
      })
      .state("table", {
        url: "/table",
        templateUrl: "table.html",
      });
  },
]);
//convert the earnings and deductions id to amount
app.filter("idToAmount", function () {
  return function (items, idToFind) {
    var filtered = items.filter(function (item) {
      return item.id === idToFind;
    });
    if (filtered.length > 0) {
      return filtered[0].amount;
    } else {
      return "";
    }
  };
});
//sum of all the earnings across all dates into second table
app.filter("sumOfEarningType", function () {
  return function (id, EmpArray) {
    let sum = 0;
    for (let i = 0; i < EmpArray.length; i++) {
      let index = EmpArray[i].earnings.findIndex(function (items) {
        return items.id == id;
      });
      if (index != -1)
      {sum += EmpArray[i].earnings[index].amount;
      }
    }
    return sum;
  };
});
//sum of all deductions across all dates into second table
app.filter("sumOfDednType", function () {
  return function (id, EmpArray) {
    let sum = 0;
    for (let i = 0; i < EmpArray.length; i++) {
      let index = EmpArray[i].dedns.findIndex(function (items) {
        return items.id == id;
      });
      if (index != -1) sum += EmpArray[i].dedns[index].amount;
    }
    return sum;
  };
});
app.controller("EmployeeController", function ($scope, $http) {
  //Search for employee
  $scope.InvalidEmp = "";
  $scope.SearchBtn = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/employeedetails",
      data: {
        emp_code: $scope.emp_code,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.InvalidEmp = "";
          //Show and hide display details
          $scope.EmpDetailsDisplay = true;
          $scope.SearchEmpDetails = response.data.data;
          console.log(response.data.data);
        } else {
          $scope.InvalidEmp = response.data.message;
          $scope.SearchEmpDetails = "";
        }
      },
      function error(response) {
        $scope.InvalidEmp = "";
        $scope.InvalidEmp =
          response.data.errors[Object.keys(response.data.errors)[0]][0];
      }
    );
  };
  //get earnings and deductions type into select box
  $scope.getOptions = function () {
    $scope.type=null;
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/earningtypes",
      data: {},
    }).then(
      function (response) {
        // console.log(response.data.data[0]);
        $scope.salaryDetails = response.data.data;
        // $scope.dedns = response.data.data[1];
        console.log($scope.salaryDetails);
      },
      function error(response) {
        //
      }
    );
  };
  //add button to get the employee table
  $scope.fromDate = "";
  $scope.toDate = "";
  $scope.amount = "";
  $scope.earningArray = new Set();
  $scope.dednsArray = new Set();
  $scope.EmpArray = [];
  $scope.totalEarnings = 0;
  $scope.totalDeductions = 0;
  $scope.addBtn = function () {
    if (
      $scope.fromDate == "" ||
      $scope.toDate == "" ||
      $scope.amount == "" ||
      $scope.type == ""
    ) {
      swal("Error", "Please enter all the required values!", "error");
    } else {
      $scope.displayTable = true;
      let fromDate = $scope.fromDate;
      let toDate = $scope.toDate;
      let selectedValue = $scope.selectedValue;
      let type;
      let typeid;
      let amount = $scope.amount;
      if (selectedValue == "Earning") {
        //store in type variable-earnings array[index stored in ng-model].value
        type = $scope.salaryDetails[$scope.type].name;
        typeid = $scope.salaryDetails[$scope.type].id;
      }
      if (selectedValue == "Deduction") {
        type = $scope.salaryDetails[$scope.type].name;
        typeid = $scope.salaryDetails[$scope.type].id;
      }
      //find index of particular object in EmpArray and return index of the item that matches the ng-model entered in input dates
      var index = $scope.EmpArray.findIndex(function (item) {
        return item.fromDate === fromDate && item.toDate === toDate;
      });
      //if index is not found it will return -1
      //date is not found so create details woth the new date
      if (index == -1) {
        let bill = {
          fromDate: fromDate,
          toDate: toDate,
          earnings: [],
          dedns: [],
        };
        if (selectedValue == "Earning") {
          bill.earnings.push({
            type: type,
            id: typeid,
            amount: amount,
          });
          $scope.earningArray.add($scope.type);
        }
        $scope.totalEarnings += amount;
        if (selectedValue == "Deduction") {
          bill.dedns.push({
            type: type,
            id: typeid,
            amount: amount,
          });
          $scope.totalDeductions += amount;
          $scope.dednsArray.add($scope.type);
        }

        $scope.EmpArray.push(bill);
      } else {
        //check if in that particular index ie fromDate and toDate earning type is already present or not
        if (selectedValue == "Earning") {
          let earningIndex = $scope.EmpArray[index].earnings.findIndex(
            function (item) {
              return item.id === typeid;
            }
          );
          //if earning is not present
          if (earningIndex == -1) {
            //in EmpArray of the particular index of the dates entered and in earnings array push
            $scope.EmpArray[index].earnings.push({
              type: type,
              id: typeid,
              amount: amount,
            });
            $scope.totalEarnings += amount;
            $scope.earningArray.add($scope.type);
          } else {
            swal("Error", "Earning already exists!", "error");
          }
        }
        if (selectedValue == "Deduction") {
          let dednIndex = $scope.EmpArray[index].dedns.findIndex(function (
            item
          ) {
            return item.id === typeid;
          });
          if (dednIndex == -1) {
            $scope.EmpArray[index].dedns.push({
              type: type,
              id: typeid,
              amount: amount,
            });
            $scope.totalDeductions += amount;
            $scope.dednsArray.add($scope.type);
          } else {
            swal("Error", "Deduction already exists!", "error");
          }
        }
      }
      //     $scope.displayTable=true;
      //     if($scope.selectedValue=='option1')
      //     {
      //       $scope.earningArray.push({
      //         earning:$scope.type,
      //         amount:$scope.amount
      //     });
      //     $scope.EmpArray.push({
      //         toDate: $scope.toDate,
      //         fromDate:$scope.fromDate,
      //         earning:$scope.earningArray,
      //       })
      //     }
      //     if($scope.selectedValue=='option2')
      // {
      //   $scope.dednArray.push({
      //     dedn:$scope.type,
      //     amount:$scope.amount
      // })
      //   $scope.EmpArray.push({
      //     dedn:$scope.dednArray,
      //     toDate: $scope.toDate,
      //     fromDate:$scope.fromDate,
      //   })
      // }
      console.log($scope.earningArray);
    }
  };
  $scope.convertSet = function (set) {
    return Array.from(set);
  };
  //submit payslip
  $scope.submitBtn=function()
  {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/paySlip",
      data: {
        emp_code: $scope.emp_code,
        emp_array:JSON.stringify($scope.EmpArray),
      },
    }).then(
      function success(response) {
      swal("Success",response.data.message,"success");
      },
      function error(response) {
        //
      }
    );
  }
});
