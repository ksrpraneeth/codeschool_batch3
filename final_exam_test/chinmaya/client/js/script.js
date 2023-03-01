var myApp = angular.module('myApp', []);

myApp.run(function ($rootScope) {
    $rootScope.url = 'http://127.0.0.1:8000/api/';
})

myApp.controller('supplimentaryBillcontroller', function ($scope, $http, $rootScope) {
    $scope.billTypes = [];
    $scope.tableShowvalue = false;

    $scope.employeeDetailsHideValue = false;
    $scope.employeeName = ''
    $scope.earnings = [];
    $scope.deduction = [];
    $scope.Employeecode = '';
    //array for loding the earning and deduction options
    $scope.AmountArray = [];
    //getting the earnings and deduction
    $http.get($rootScope.url + 'earninganddeduction')
        .then(
            function (response) {
                if (response.data.status) {
                    $scope.earnings = response.data.data[0];
                    $scope.deduction = response.data.data[1];
                    $scope.AmountArray = response.data.data[0];
                }
                else {
                    swal("", response.data.message, "error");
                }
            }, function (error) {

            }
        )
    //geting the bill types
    $http.get($rootScope.url + 'billtypes').then(
        function (response) {

            if (response.data.status) {
                $scope.billTypes = response.data.data
            }
            else {

                swal("", response.data.message, "error");
            }

        }, function (error) {

        }
    )
    //employee search
    $scope.searchEmployee = function (employeeid) {
        $http.post('http://127.0.0.1:8000/api/employeesearch', { employeeId: employeeid }).then(
            function (response) {
                if (response.data.status) {
                    $scope.employeeName = response.data.data[0].name;
                    $scope.Employeecode = response.data.data[0].employee_unique_id;
                    $scope.employeeDetailsHideValue = true;
                }
                else {
                    swal("", response.data.message, "error");
                    $scope.employeeDetailsHideValue = false;
                }

            }, function (error) {

            }
        )
    }

    //function for chnaging the option fo rthe earnings and deduction
    $scope.earningstatus = true;
    $scope.deductionstatus = false;
    $scope.earningOption = function () {
        $scope.AmountArray = $scope.earnings
        $scope.earningstatus = true;
        $scope.deductionstatus = false;
    }


    $scope.deductionoption = function () {
        $scope.AmountArray = $scope.deduction
        $scope.earningstatus = false;
        $scope.deductionstatus = true;
    }

    // ading amount to the table
    $scope.amountArray = [];
    $scope.earningitemSize = 0;
    $scope.deductionItemSize = 0;
    $scope.duePartition = 2;
    $scope.drawnparticulars = 2;
    $scope.differnce = 2;
    $scope.dateArray = []
    $scope.frontendtable = []
    //declaring the deduction and earning
    $scope.earningmenustatus = []
    $scope.deductionmenustatus = []
    //storing the total amountv for deduction and earning
    $scope.totalEarningArray = []
    $scope.totaldeductionArray = []



    $scope.addAmount = function (stratdate, enddate, amount, amounttypeid) {

        if (!stratdate || !enddate) {
            swal("", "Please enter date.", "error");
            return;
        }
        if (!amounttypeid) {
            swal("", "Please select the Type.", "error");
            return;
        }
        if (!amount) {
            swal("", "Please add some amount.", "error");
            return;
        }
        if (amount <= 0) {
            swal("", "Amount should be greter than ZERO.", "error");
            return;
        }


        $scope.totalEarningArray = []
        $scope.totaldeductionArray = []
        $scope.loopstatus = true
        $scope.frontendtable = []
        $scope.tableShowvalue = true;
        let arrayindex = 0
        let status = true;
        $scope.earningitemSize = 0;
        $scope.deductionItemSize = 0;
        $scope.duePartition = 2;
        $scope.drawnparticulars = 2;
        $scope.differnce = 2;
        let sdate = new Date(stratdate).getFullYear() + '-' + new Date(stratdate).getMonth() + '-' + new Date(stratdate).getDate()
        let edate = new Date(enddate).getFullYear() + '-' + new Date(enddate).getMonth() + '-' + new Date(enddate).getDate()
        $scope.totalGross = 0
        $scope.totaldeductionn = 0
        $scope.earningmenustatus = []
        $scope.deductionmenustatus = []




        //ading amount for date
        if ($scope.amountArray.length == 0) {
            if ($scope.earningstatus) {
                let earning = { amountId: amounttypeid, amount: amount }

                $scope.amountArray.push({
                    startDate: sdate,
                    endDate: edate,
                    earning: [earning],
                    deduction: []

                })

            }
            else {
                let deduction = { amountId: amounttypeid, amount: amount }
                $scope.amountArray.push({
                    startDate: sdate,
                    endDate: edate,
                    earning: [],
                    deduction: [deduction]

                })
            }
        }
        else {

            $scope.amountArray.forEach((element, index) => {
                if ($scope.loopstatus) {

                    if (element.startDate == sdate && element.endDate == edate) {
                        arrayindex = index
                        if ($scope.earningstatus) {
                            if (element.earning.length == 0) {
                                element.earning.push({ amountId: amounttypeid, amount: amount })
                                $scope.loopstatus = false
                            }
                            else {
                                element.earning.forEach(element2 => {
                                    if (element2.amountId == amounttypeid) {
                                        swal("", "Amount Alredy exist for the date.", "error");
                                        status = false
                                        $scope.loopstatus = false
                                    }

                                });
                                if (status) {
                                    element.earning.push({ amountId: amounttypeid, amount: amount })
                                    $scope.loopstatus = false
                                }

                            }

                        }

                        else {
                            if (element.deduction.length == 0) {
                                element.deduction.push({
                                    amountId: amounttypeid, amount: amount
                                })
                                $scope.loopstatus = false


                            }
                            else {
                                element.deduction.forEach(element2 => {
                                    if (element2.amountId == amounttypeid) {
                                        swal("", "Amount Alredy exist for the date.", "error");
                                        $scope.loopstatus = false

                                    }

                                    else {
                                        element.deduction.push({ amountId: amounttypeid, amount: amount })
                                        $scope.loopstatus = false
                                    }
                                });
                            }
                        }

                    }


                }


            });

            if ($scope.loopstatus) {

                arrayindex = $scope.amountArray.length
                if ($scope.earningstatus) {
                    let earning = { amountId: amounttypeid, amount: amount }

                    $scope.amountArray.push({
                        startDate: sdate,
                        endDate: edate,
                        earning: [earning],
                        deduction: []

                    })
                    $scope.loopstatus = false
                }
                else {
                    let deduction = { amountId: amounttypeid, amount: amount }
                    $scope.amountArray.push({
                        startDate: sdate,
                        endDate: edate,
                        earning: [],
                        deduction: [deduction]

                    })
                    $scope.loopstatus = false
                }

            }
        }

        let totalearning = 0;
        let totaldeduction = 0;


        $scope.amountArray[arrayindex].earning.forEach(element => {
            totalearning = totalearning + element.amount
        });
        $scope.amountArray[arrayindex].deduction.forEach(element => {
            totaldeduction = totaldeduction + element.amount
        })


        $scope.amountArray[arrayindex].totalEarning = totalearning;
        $scope.amountArray[arrayindex].totalDeduction = totaldeduction;




        $scope.earnings.forEach(element => {
            let count = 0
            $scope.amountArray.forEach(element2 => {
                element2.earning.forEach(element3 => {
                    if (element.id == element3.amountId) {
                        count = count + 1
                    }
                });
            });
            $scope.earningmenustatus.push(count);
        });


        $scope.deduction.forEach(element => {
            let count = 0
            $scope.amountArray.forEach(element2 => {
                element2.deduction.forEach(element3 => {
                    if (element.id == element3.amountId) {
                        count = count + 1
                    }
                });
            });
            $scope.deductionmenustatus.push(count)
        });


        //colspan property calculation
        let earningActiveMenuCount = 0;
        let deductionActiveMenucount = 0;
        $scope.earningmenustatus.forEach(element => {
            if (element != 0) {
                earningActiveMenuCount = earningActiveMenuCount + 1;
            }
        });

        $scope.deductionmenustatus.forEach(element => {
            if (element != 0) {
                deductionActiveMenucount = deductionActiveMenucount + 1;
            }
        });

        $scope.earningitemSize = earningActiveMenuCount;
        $scope.deductionItemSize = deductionActiveMenucount;
        if ($scope.earningitemSize == 0 && $scope.deductionItemSize == 0) {
            $scope.earningitemSize = 0;
            $scope.deductionItemSize = 0;
            $scope.duePartition = 2;
            $scope.drawnparticulars = 2;
            $scope.differnce = 2;
        }

        else if ($scope.earningitemSize == 0 || $scope.deductionItemSize == 0) {
            $scope.duePartition = $scope.earningitemSize + $scope.deductionItemSize + 1;
            $scope.differnce = $scope.earningitemSize + $scope.deductionItemSize + 1;
            $scope.drawnparticulars = $scope.earningitemSize + $scope.deductionItemSize + 1;
        }
        else {
            $scope.duePartition = $scope.earningitemSize + $scope.deductionItemSize;
            $scope.differnce = $scope.earningitemSize + $scope.deductionItemSize;
            $scope.drawnparticulars = $scope.earningitemSize + $scope.deductionItemSize;
        }

        //genarating array for showing code in bill table


        for (let i = 0; i < $scope.amountArray.length; i++) {
            let earningNew = []
            let deductionNew = []
            console.log($scope.amountArray[i].deduction)
            let earninglStatus = true;
            let deductionlstatus = true;

            for (let j = 0; j < $scope.earnings.length; j++) {
                let obj = {}
                let status = false
                for (let k = 0; k < $scope.amountArray[i].earning.length; k++) {
                    if ($scope.earnings[j].id == $scope.amountArray[i].earning[k].amountId) {
                        obj.id = $scope.earnings[j].id;
                        obj.amount = $scope.amountArray[i].earning[k].amount;
                        status = true;
                        earninglStatus = false;
                    }
                }
                if (!status) {
                    obj.id = $scope.earnings[j].id;
                    obj.amount = 0
                }
                earningNew.push(obj)

            }

            for (let l = 0; l < $scope.deduction.length; l++) {
                let obj = {}
                let status = false

                for (let m = 0; m < $scope.amountArray[i].deduction.length; m++) {

                    if ($scope.deduction[l].id == $scope.amountArray[i].deduction[m].amountId) {
                        console.log(55)
                        obj.id = $scope.deduction[l].id;
                        obj.amount = $scope.amountArray[i].deduction[m].amount;
                        status = true;
                        deductionlstatus = false
                    }
                }
                if (!status) {
                    obj.id = $scope.deduction[l].id;
                    obj.amount = 0;
                }
                deductionNew.push(obj)

            }
            $scope.totalGross = $scope.totalGross + $scope.amountArray[i].totalEarning;
            $scope.totaldeductionn = $scope.totaldeductionn + $scope.amountArray[i].totalDeduction;
            $scope.frontendtable.push({
                startdate: $scope.amountArray[i].startDate,
                enddate: $scope.amountArray[i].endDate,
                dedctionArray: deductionNew,
                earningArray: earningNew,
                Gross: $scope.amountArray[i].totalEarning,
                totaldeduction: $scope.amountArray[i].totalDeduction,
                earningstatus: earninglStatus,
                deductionstatus: deductionlstatus

            })
        }
        console.log($scope.frontendtable)

        $scope.earnings.forEach((element, index) => {
            let sum = 0;
            $scope.frontendtable.forEach(element2 => {
                sum = sum + element2.earningArray[index].amount
            });
            $scope.totalEarningArray.push({
                id: element.id,
                name: element.name,
                amount: sum
            })
        });

        $scope.deduction.forEach((element, index) => {
            let sum = 0;
            $scope.frontendtable.forEach((element2) => {
                sum = sum + element2.dedctionArray[index].amount

            });

            $scope.totaldeductionArray.push({
                id: element.id,
                name: element.name,
                amount: sum
            })
        });

       





    }


    //saving data in the backend

    $scope.submitBillBackend = function (employeeid, billtypeid) {


        if (!billtypeid) {
            swal("", "Please select bill type.", "error");
            return
        }

        let formdata = { employeeId: employeeid, totalearning: $scope.totalGross, totaldeduction: $scope.totaldeductionn, billtypeId: billtypeid, amount: $scope.amountArray }

        console.log(formdata)

        $http.post($rootScope.url + 'savetransaction', formdata).then(
            function (response) {
                if (response.data.status) {
                    swal("", response.data.message, "success")
                        .then(() => {
                            $state.go($state.current, {}, { reload: true });
                        });
                    return
                }
                swal("", response.data.message, "error");
            }, function (error) {

            }
        )
    }

})