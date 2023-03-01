var app=angular.module("app",['ui.router']);
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
          })
    }
]);
app.controller("EmployeeController", function ($scope, $http) {
    //Search for employee
    $scope.InvalidEmp = "";
    $scope.SearchBtn= function () {
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
              $scope.InvalidEmp=response.data.message;
              $scope.SearchEmpDetails = "";
            }
          },
          function error(response) {
            $scope.InvalidEmp="";
            $scope.InvalidEmp= response.data.errors[Object.keys(response.data.errors)[0]][0];
          }
        );
      };
      //get earnings and deductions type into select box
    $scope.selectedValue='option1';
        $http({
            method: "POST",
            url: "http://127.0.0.1:8000/api/earningtypes",
            data: {},
          }).then(
            function (response) {
              console.log(response.data.data[0]);
              $scope.earnings = response.data.data[0];
              $scope.dedns=response.data.data[1]
            },
            function error(response) {
             //
            }
          )
         //add button
          $scope.fromDate="";
          $scope.toDate="";
          $scope.amount="";
          $scope.earningArray=new Set();
          $scope.dednArray=new Set();
          $scope.EmpArray=[];
          
          $scope.addBtn=function(){
            if($scope.fromDate=='' || $scope.toDate=='' || $scope.amount=='' || $scope.type=='')
            {
                alert('Please enter all the required values!');
            }
            else{
              $scope.displayTable=true;
              let fromDate=$scope.fromDate;
              let toDate=$scope.toDate;
              let selectedValue=$scope.selectedValue;
              let type;
              let typeid;
              let amount = $scope.amount;
              if(selectedValue == 'option1'){
                type = $scope.earnings[$scope.type].earning_type;
                typeid = $scope.earnings[$scope.type].id;
              }
              if(selectedValue == 'option2'){
                type = $scope.dedns[$scope.type].dedn_type;
                typeid = $scope.dedns[$scope.type].id;
              }
              var index = $scope.EmpArray.findIndex(function(item){
                return (item.fromDate === fromDate && item.toDate === toDate)

            });
            if(index==-1)
            {
              let bill = {
                fromDate:fromDate,
                toDate:toDate,
                earnings: [],
                dedns:[]
              };
              if(selectedValue == 'option1'){
                bill.earnings.push({
                  type: type,
                  id: typeid,
                  amount: amount
                })
                $scope.earningArray.add({
                  id: typeid,
                  type: type
                })
              }
              if(selectedValue == 'option2'){
                bill.dedns.push({
                  type: type,
                  id: typeid,
                  amount: amount
                })
                $scope.dednArray.add({
                  id: typeid,
                  type: type
                })
              }

              $scope.EmpArray.push(bill);
            }
            else{
              if(selectedValue=='option1')
              {
                let earningIndex=$scope.EmpArray[index].earnings.findIndex(function(item){
                  return (item.id === typeid )
                })
                if(earningIndex==-1){
                 $scope.EmpArray[index].earnings.push({
                  type: type,
                  id: typeid,
                  amount: amount});
                  $scope.earningArray.add({
                    id: typeid,
                    type: type
                  })
                }
                else
                {
                  alert('Earning already exists!')
                }
              }
              if(selectedValue=='option2')
              {
                let dednIndex=$scope.EmpArray[index].dedns.findIndex(function(item){
                  return (item.id === typeid )
                })
                if(dednIndex==-1){
                 $scope.EmpArray[index].dedns.push({
                  type: type,
                  id: typeid,
                  amount: amount});
                  $scope.dednsArray.add({
                    id: typeid,
                    type: type
                  })
                }
                else
                {
                  alert('Deduction already exists!')
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
           console.log($scope.EmpArray);
             
            }
          }  
});