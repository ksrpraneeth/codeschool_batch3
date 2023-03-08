var ifmsApp = angular.module('ifmsMod', ['ui.router']);
ifmsApp.config(['$urlRouterProvider', '$stateProvider', function ($urlRouterProvider, $stateProvider) {

    $urlRouterProvider.otherwise('/billEntry');
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


        //  $scope.bankDetails = [];
        $http.post('http://127.0.0.1:8000/api/employeeDetails', Data)
            .then(function (response) {
                if (response.data.status) {
                    $scope.employeeDetails = response.data.data;
                    $scope.empId = response.data.data.id;

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


    $scope.earnings = function () {
        $http.post('http://127.0.0.1:8000/api/earningType')
            .then(function (response) {
                if (response.data.status) {
                    $scope.earningType = response.data.data;

                    // swal(response.data.message, "", "success")
                    $scope.optionArr = $scope.earningType;
                    $scope.earningstatus = true;
                    $scope.deductionstatus = false;
                }

                else {
                    // swal(response.data.message, "", "error")
                }

            }, function (error) {


            });

    }
    $scope.deductions = function () {
        $http.post('http://127.0.0.1:8000/api/deductionType')
            .then(function (response) {
                if (response.data.status) {
                    $scope.deductionType = response.data.data;
                    $scope.optionArr = $scope.deductionType;


                    $scope.deductionstatus = true;
                    $scope.earningstatus = false;
                }

                else {

                }

            }, function (error) {


            });


    }


    $scope.earningStatic = [];
    $scope.deductionStatic = [];
    $http.get('http://127.0.0.1:8000/api/EarningAndDeductions')
        .then(function (response) {
            if (response.data.status) {
                $scope.earningStatic = response.data.data[0];
                $scope.deductionStatic = response.data.data[1];

                // swal(response.data.message, "", "success")

            }

            else {
                swal(response.data.message, "", "error")
                // $scope.employeeDetailHide = false
            }

        }, function (error) {


        });
    $scope.tableHide = false;
    $scope.employeeBillList = [];
    $scope.earningitemCount = 0;
    $scope.deductionitemCount = 0;
    $scope.dueParticulars = 2;
    $scope.drawnParticulars = 2;
    $scope.differnce = 2;

    $scope.showfrontendtable = []
    
    $scope.earningmenustatus = []
    $scope.deductionmenustatus = []
    
    $scope.totalEarningFrontend = []
    $scope.totalDeductionFrontend = []

    $scope.earningstatus = false;
    $scope.deductionstatus = false;
    $scope.addAmount = function (amount, edType_id, startdate, enddate) {
        if (!amount) {
            swal("", "Please enter the amount .", "error")
        }
        else if (amount < 0) {
            swal("", "Please enter the amount correctly.", "error")
        } 
        // else if (!edType_id) {
        //     swal("", "Please enter the add type.", "error")
        // }
        else if (!startdate) {
            swal("", "Please enter the start date.", "error")
        }
        else if (!enddate) {
            swal("", "Please enter the end date.", "error")
        }
        $scope.tableHide = true;
        $scope.totalEarningFrontend = []
        $scope.totalDeductionFrontend = []
        $scope.earningmenustatus = [];
        let arrayindex =0;
        $scope.deductionmenustatus = [];
        $scope.showfrontendtable = []
        $scope.earningitemCount = 0;
        $scope.deductionitemCount = 0;
        $scope.dueParticulars = 2;
        $scope.drawnParticulars = 2;
        $scope.difference = 2;
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

            if ($scope.loopstatus) {
                arrayindex = $scope.employeeBillList.length

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



        let multipledateGross = 0;
        let multipledateDeduction = 0;

        $scope.employeeBillList[arrayindex].earning.forEach(element => {
            multipledateGross = multipledateGross + element.amount
        });
        $scope.employeeBillList[arrayindex].deduction.forEach(element => {
            multipledateDeduction = multipledateDeduction + element.amount
        })


        $scope.employeeBillList[arrayindex].multipledateGross = multipledateGross;
        $scope.employeeBillList[arrayindex].multipledateDeduction = multipledateDeduction;
        // console.log($scope.employeeBillList)


        $scope.totalGross = 0;
        $scope.totalDeduction = 0;
        $scope.totalNet = 0;
        for (let i = 0; i < $scope.employeeBillList.length; i++) {

            for (let j = 0; j < $scope.employeeBillList[i].earning.length; j++) {
                // console.log($scope.employeeBillList[i].earning[j].amount)

                $scope.totalGross = $scope.totalGross + $scope.employeeBillList[i].earning[j].amount;
            }


        }

        for (let i = 0; i < $scope.employeeBillList.length; i++) {
            // $scope.multipledateDeduction = 0;
            for (let j = 0; j < $scope.employeeBillList[i].deduction.length; j++) {

                console.log($scope.employeeBillList[i].deduction[j].amount)
                // $scope.multipledateDeduction = $scope.multipledateDeduction + $scope.employeeBillList[i].deduction[j].amount

                $scope.totalDeduction = $scope.totalDeduction + $scope.employeeBillList[i].deduction[j].amount;
            }
            // console.log($scope.totalDeduction)

        }
        $scope.totalNet = $scope.totalGross - $scope.totalDeduction






        // else {

        //     //     $scope.totalGross=$scope.totalGross+amount;
        //     //     $scope.totalDeduction=$scope.totalDeduction+amount;

        //     //    let billData={amount:amount,edType:edType,startdate:startdate,enddate:enddate,totalGross:$scope.totalGross,totalDeduction:$scope.totalDeduction}
        //     //    $scope.employeeBillList.push(billData)
        //     //    console.log($scope.employeeBillList)


        // }
        $scope.earningStatic.forEach(element => {
            let count = 0;
            $scope.employeeBillList.forEach(element2 => {
                element2.earning.forEach(element3 => {
                    if (element.id == element3.amountId) {
                        count = count + 1
                    }
                });
            });
            $scope.earningmenustatus.push(count);
            console.log($scope.earningmenustatus)

        })
        $scope.deductionStatic.forEach(element => {
            let count = 0;
            $scope.employeeBillList.forEach(element2 => {
                element2.deduction.forEach(element3 => {
                    if (element.id == element3.amountId) {
                        count = count + 1
                    }
                });
            });
            $scope.deductionmenustatus.push(count);
            console.log($scope.deductionmenustatus)


        })
        // colspanpro
        let earningActiveMenuCount = 0;
        let deductionActiveMenuCount = 0;
        $scope.earningmenustatus.forEach(element => {
            if (element != 0) {
                earningActiveMenuCount = earningActiveMenuCount + 1;
            }
        })
        $scope.deductionmenustatus.forEach(element => {
            if (element != 0) {
                deductionActiveMenuCount = deductionActiveMenuCount + 1;
            }
        });
        $scope.earningitemCount = earningActiveMenuCount;
        $scope.deductionitemCount = deductionActiveMenuCount;
        if ($scope.earningitemCount == 0 && $scope.deductionitemCount == 0) {
            $scope.earningitemCount = 0;
            $scope.deductionitemCount = 0;
            $scope.dueParticulars = 2;
            $scope.drawnParticulars = 2;
            $scope.differnce = 2;
        }

        else if ($scope.earningitemCount == 0 || $scope.deductionitemCount == 0) {
            $scope.dueParticulars = $scope.earningitemCount + $scope.deductionitemCount + 1;
            $scope.differnce = $scope.earningitemCount + $scope.deductionitemCount + 1;
            $scope.drawnParticulars = $scope.earningitemCount + $scope.deductionitemCount + 1;
        }
        else {
            $scope.dueParticulars = $scope.earningitemCount + $scope.deductionitemCount;
            $scope.differnce = $scope.earningitemCount + $scope.deductionitemCount;
            $scope.drawnParticulars = $scope.earningitemCount + $scope.deductionitemCount;
        }


        // araay for frontend table
        for (let i = 0; i < $scope.employeeBillList.length; i++) {
            let earningNewArr = []
            let deductionNewArr = []
            
            let earninglStatus = true;
            let deductionlstatus = true;

            for (let j = 0; j < $scope.earningStatic.length; j++) {
                let obj = {}
                let status = false
                for (let k = 0; k < $scope.employeeBillList[i].earning.length; k++) {
                    if ($scope.earningStatic[j].id == $scope.employeeBillList[i].earning[k].amountId) {
                        obj.id = $scope.earningStatic[j].id;
                        obj.amount = $scope.employeeBillList[i].earning[k].amount;
                        status = true;
                        earninglStatus = false;
                    }
                }
                if (!status) {
                    obj.id = $scope.earningStatic[j].id;
                    obj.amount = 0
                }
                earningNewArr.push(obj)

            }

            for (let l = 0; l < $scope.deductionStatic.length; l++) {
                let obj = {}
                let status = false

                for (let m = 0; m < $scope.employeeBillList[i].deduction.length; m++) {

                    if ($scope.deductionStatic[l].id == $scope.employeeBillList[i].deduction[m].amountId) {
                        console.log(55)
                        obj.id = $scope.deductionStatic[l].id;
                        obj.amount = $scope.employeeBillList[i].deduction[m].amount;
                        status = true;
                        deductionlstatus = false
                    }
                }
                if (!status) {
                    obj.id = $scope.deductionStatic[l].id;
                    obj.amount = 0;
                }
                deductionNewArr.push(obj)

            }

            $scope.totalGross1 = $scope.totalGross1 + $scope.employeeBillList[i].multipledateGross;
            $scope.totaldeduction1 = $scope.totaldeduction1 + $scope.employeeBillList[i].multipledateDeduction;
            $scope.showfrontendtable.push({
                startdate: $scope.employeeBillList[i].startdate,
                enddate: $scope.employeeBillList[i].enddate,
                deductionItemArray: deductionNewArr,
                earningItemArray: earningNewArr,
                Gross: $scope.employeeBillList[i].multipledateGross,
                totaldeduction: $scope.employeeBillList[i].multipledateDeduction,
                // earningstatus: earninglStatus,
                // deductionstatus: deductionlstatus

            })
        }

        $scope.earningStatic.forEach((element, index) => {
            let sum = 0;
            $scope.showfrontendtable.forEach(element2 => {
                sum = sum + element2.earningItemArray[index].amount
            });
            $scope.totalEarningFrontend.push({
                id: element.id,
                name: element.name,
                amount: sum
            })
        });

        $scope.deductionStatic.forEach((element, index) => {
            let sum = 0;
            $scope.showfrontendtable.forEach((element2) => {
                sum = sum + element2.deductionItemArray[index].amount

            });

            $scope.totalDeductionFrontend.push({
                id: element.id,
                name: element.name,
                amount: sum
            })
        });
        // console.log($scope.totalEarningArray)
        // console.log($scope.totaldeductionArray)



    }

    


    $scope.earning = function () {
        let zero = false;
        $scope.earningmenustatus.forEach(function (element) {
            if (element !== 0) {
                zero = true;
            }

        });
        return !zero;
    }
    $scope.deduction= function () {
        let zero = false;
        $scope.deductionmenustatus.forEach(function (element) {
            if (element !== 0) {
                zero = true;
            }

        });
        return !zero;
    }

    // adding to the backend table
    $scope.addEmployeeToBill = function (amount, edType_id, startdate, enddate) {

        if (!amount) {
            swal("", "Please enter the amount .", "error")
        }
        else if (amount < 0) {
            swal("", "Please enter the amount correctly.", "error")
        }
        // else if (!edType_id) {
        //     swal("", "Please enter the add type.", "error")
        // }
        else if (!startdate) {
            swal("", "Please enter the start date.", "error")
        }
        else if (!enddate) {
            swal("", "Please enter the end date.", "error")
        }
        else {
            data = {
                empId: $scope.empId, totalAmount: $scope.totalGross, totalDeduction: $scope.totalDeduction,

                totalNet: $scope.totalNet, employeeBillList: $scope.employeeBillList
            }
            console.log(data)


            $http.post('http://127.0.0.1:8000/api/addEmployeeToBill', data)
                .then(function (response) {
                    if (response.data.status) {


                        swal(response.data.message, "", "success")
                        $state.reload();
                    }

                    else {
                        // swal(response.data.message, "", "error")
                    }

                }, function (error) {


                });
        }
    }

});