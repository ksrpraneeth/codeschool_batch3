var ifmsApp = angular.module('ifmsMod', ['ui.router']);
ifmsApp.config(['$urlRouterProvider', '$stateProvider', function ($urlRouterProvider, $stateProvider) {

    $urlRouterProvider.otherwise('/addAgency');
    $stateProvider

        .state('billEntry', {
            url: '/billEntry',
            templateUrl: 'billEntry.html'
        })



}]);
ifmsApp.controller("billEntryController", function ($scope, $http, $state) {
    $scope.employeeDetailHide = false
    $scope.searchEmpCode = function (empCode) {

        let Data = { empCode: $scope.empCode }
        console.log(Data);

        //  $scope.bankDetails = [];
        $http.post('http://127.0.0.1:8000/api/employeeDetails', Data)
            .then(function (response) {
                if (response.data.status) {
                    $scope.employeeDetails = response.data.data;
                    $scope.empId = response.data.data.id;
                    console.log($scope.empId)
                    swal(response.data.message, "", "success")
                    $scope.employeeDetailHide = true
                }

                else {
                    swal(response.data.message, "", "error")
                    $scope.employeeDetailHide = false
                }

            }, function (error) {
                //   console.error('Error sending data:', error);

            });
    }
    $scope.optionArr = [];
    $scope.earningDeductionArr = [];

    $scope.earnings = function () {
        $http.post('http://127.0.0.1:8000/api/earningType')
            .then(function (response) {
                if (response.data.status) {
                    $scope.earningType = response.data.data;

                    // swal(response.data.message, "", "success")
                    $scope.optionArr = $scope.earningType;
                    $scope.earningstatus = true;
                    $scope.deductionstatus = false;
                    console.log($scope.earningType)



                }

                else {
                    // swal(response.data.message, "", "error")
                }

            }, function (error) {
                //   console.error('Error sending data:', error);

            });

    }
    $scope.deductions = function () {
        $http.post('http://127.0.0.1:8000/api/deductionType')
            .then(function (response) {
                if (response.data.status) {
                    $scope.deductionType = response.data.data;
                    $scope.optionArr = $scope.deductionType;
                    // swal(response.data.message, "", "success")
                    // $scope.earningDeductionArr=$scope.employeeBillList;
                    $scope.deductionstatus = true;
                    $scope.earningstatus = false;
                }

                else {
                    // swal(response.data.message, "", "error")
                }

            }, function (error) {
                //   console.error('Error sending data:', error);

            });
        // $scope.combineArr=$scope.earningType.concat($scope.deductionType);
        // console.log(combineArr);

    }
    $scope.employeeBillList = [];
    // $scope.totalGross = 0;
    // $scope.totalDeduction = 0;
    $scope.earningstatus = false;
    $scope.deductionstatus = false;
    $scope.addAmount = function (amount, edType_id, startdate, enddate) {
        $scope.loopstatus = true
        let status = true
        let stdate = new Date(startdate).getFullYear() + '-' + new Date(startdate).getMonth() + '-' + new Date(startdate).getDate()
        let eddate = new Date(enddate).getFullYear() + '-' + new Date(enddate).getMonth() + '-' + new Date(enddate).getDate()
        if ($scope.employeeBillList.length == 0) {
            let obj = { amountId: edType_id, amount: amount }
            if ($scope.earningstatus) {
                $scope.employeeBillList.push({
                    startdate: stdate,
                    enddate: eddate,
                    earning: [obj],
                    deduction: []
                })

            }
            else {
                $scope.employeeBillList.push({
                    startdate: stdate,
                    enddate: eddate,
                    earning: [],
                    deduction: [obj]

                })
            }
        }
        else {
            $scope.employeeBillList.forEach((element, index) => {
                if ($scope.loopstatus) {

                    if (element.startdate == stdate && element.enddate == eddate) {
                        arrayindex = index
                        if ($scope.earningstatus) {
                            if (element.earning.length == 0) {
                                element.earning.push({ amountId: edType_id, amount: amount })
                                $scope.loopstatus = false
                            }
                            else {
                                element.earning.forEach(element2 => {
                                    if (element2.amountId == edType_id) {
                                        swal("", "Amount Alredy exist for the date.", "error");
                                        status = false
                                        $scope.loopstatus = false
                                    }

                                });
                                if (status) {
                                    element.earning.push({ amountId: edType_id, amount: amount })
                                    $scope.loopstatus = false
                                }

                            }

                        }

                        else {
                            if (element.deduction.length == 0) {
                                element.deduction.push({
                                    amountId: edType_id, amount: amount
                                })
                                $scope.loopstatus = false
                            }
                            else {
                                element.deduction.forEach(element2 => {
                                    if (element2.amountId == edType_id) {
                                        swal("", "Amount Alredy exist for the date.", "error");
                                        $scope.loopstatus = false

                                    }
                                    else {
                                        element.deduction.push({ amountId: edType_id, amount: amount })
                                        $scope.loopstatus = false
                                    }
                                });
                            }
                        }

                    }


                }

              
            })

            if($scope.loopstatus){
                
                    let obj = { amountId: edType_id, amount: amount }
                    if ($scope.earningstatus) {
                        $scope.employeeBillList.push({
                            startdate: stdate,
                            enddate: eddate,
                            earning: [obj],
                            deduction: []
                        })
                        $scope.loopstatus = false
        
                    }
                    else {
                        $scope.employeeBillList.push({
                            startdate: stdate,
                            enddate: eddate,
                            earning: [],
                            deduction: [obj]
        
                        })
                        $scope.loopstatus = false
                    }
                
            }

        }

        console.log($scope.employeeBillList)
      
      
        $scope.totalGross = 0;
        $scope.totalDeduction = 0;
        $scope.totalNet = 0;
        for (let i = 0; i < $scope.employeeBillList.length; i++) {
            $scope.multipledateGross=0;
            for (let j = 0; j < $scope.employeeBillList[i].earning.length; j++) {
                // console.log($scope.employeeBillList[i].earning[j].amount)
                $scope.multipledateGross=$scope.multipledateGross+$scope.employeeBillList[i].earning[j].amount
                $scope.totalGross = $scope.totalGross + $scope.employeeBillList[i].earning[j].amount;
            }
            console.log($scope.multipledateGross)
            // console.log($scope.totalGross)

        }

        for (let i = 0; i < $scope.employeeBillList.length; i++) {
            $scope.multipledateDeduction=0;
            for (let j = 0; j < $scope.employeeBillList[i].deduction.length; j++) {
         
                console.log($scope.employeeBillList[i].deduction[j].amount)
                $scope.multipledateDeduction=$scope.multipledateDeduction+$scope.employeeBillList[i].deduction[j].amount

                $scope.totalDeduction = $scope.totalDeduction + $scope.employeeBillList[i].deduction[j].amount;
            }
            // console.log($scope.totalDeduction)

        }
        $scope.totalNet = $scope.totalGross - $scope.totalDeduction

       



        // if (!amount) {
        //     swal("", "Please enter the amount .", "error")
        // }
        // else if (amount < 0) {
        //     swal("", "Please enter the amount correctly.", "error")
        // }
        // // else if (!edType_id) {
        // //     swal("", "Please enter the add type.", "error")
        // // }
        // else if (!startdate) {
        //     swal("", "Please enter the start date.", "error")
        // }
        // else if (!enddate) {
        //     swal("", "Please enter the end date.", "error")
        // }
        // else {

        //     //     $scope.totalGross=$scope.totalGross+amount;
        //     //     $scope.totalDeduction=$scope.totalDeduction+amount;

        //     //    let billData={amount:amount,edType:edType,startdate:startdate,enddate:enddate,totalGross:$scope.totalGross,totalDeduction:$scope.totalDeduction}
        //     //    $scope.employeeBillList.push(billData)
        //     //    console.log($scope.employeeBillList)


        // }


    }

    $scope.addEmployeeToBill = function (amount, edType_id, startdate, enddate) {

        if (!amount) {
            swal("", "Please enter the amount .", "error")
        }
        // else if (amount < 0) {
        //     swal("", "Please enter the amount correctly.", "error")
        // }
        // // else if (!edType_id) {
        // //     swal("", "Please enter the add type.", "error")
        // // }
        // else if (!startdate) {
        //     swal("", "Please enter the start date.", "error")
        // }
        // else if (!enddate) {
        //     swal("", "Please enter the end date.", "error")
        // }
        else {
            data = {
                empId: $scope.empId, totalAmount: $scope.totalGross, totalDeduction: $scope.totalDeduction,multipledateGross:$scope.multipledateGross,
                multipledateDeduction:$scope.multipledateDeduction,
                totalNet: $scope.totalNet, employeeBillList: $scope.employeeBillList
            }
            console.log(data)

            $http.post('http://127.0.0.1:8000/api/addEmployeeToBill',data)
                .then(function (response) {
                    if (response.data.status) {


                        // swal(response.data.message, "", "success")
                    }

                    else {
                        // swal(response.data.message, "", "error")
                    }

                }, function (error) {
                    //   console.error('Error sending data:', error);

                });
        }
    }
});