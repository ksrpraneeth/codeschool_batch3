let app = angular.module("app", []);
app.filter("sumOfArray", () => {
    return (input) => {
        let sum = 0;
        for (let i = 0; i < input.length; i++) {
            sum += parseInt(input[i].amount);
        }
        return sum;
    };
});

app.controller("mainController", ($scope, $http, $filter) => {
    // All Fields and Scope Variables
    {
        $scope.selectedFilter = "";
        $scope.billIDs = [];
        $scope.searchQuery = "";
        $scope.employees = [];
        $scope.employee = "";
        $scope.monthYear = "";
        $scope.earningDeductionType = "";
        $scope.earningsDeductions = [];
        $scope.earningAddingValue = "";
        $scope.amount = "";
        $scope.currentBill = {
            employee: "",
            monthYear: "",
            earnings: [],
            deductions: [],
        };
        $scope.sBill = [];
        $scope.viewBill = {
            earnings: [],
            deductions: [],
        };
    }

    // Watchers
    // Selected Filter Watcher
    $scope.$watch("selectedFilter", () => {
        $scope.searchQuery = "";
    });
    $scope.$watch("employees", () => {
        $scope.employee = "";
    });
    $scope.$watch("employee", () => {
        $scope.monthYear = "";
        $scope.earningDeductionType = "";
        $scope.earningsDeductions = [];
        $scope.earningAddingValue = "";
        $scope.amount = "";
    });
    $scope.$watch("earningDeductionType", (value) => {
        $scope.earningsDeductions = [];
        $scope.earningAddingValue = "";
        $scope.amount = "";

        // Get Earnings Deductions
        {
            let url = "";
            if (value == "earning") {
                url = "/api/getEmployeeEarnings.php";
            } else {
                if (value == "deduction") {
                    url = "/api/getEmployeeDeductions.php";
                }
            }
            if (url == "") return;
            let data = { empId: $scope.employee };
            data = $.param(data);
            $http({
                url: url,
                method: "POST",
                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded;charset=utf-8;",
                },
                data,
            }).then((response) => {
                if (response.data.status && response.data.data.length > 0) {
                    $scope.earningsDeductions = response.data.data;
                } else {
                    alert("Not found!");
                    return;
                }
            });
        }
    });

    // Default Functions
    // Getting Bill Id's
    $http({
        url: "./api/getUserBillids.php",
        method: "POST",
    }).then((response) => {
        if (!response.data.status) {
            alert("No Bill ID's where present");
            return;
        }
        $scope.billIDs = response.data.data;
    });

    // Custom Functions
    // Get Employees
    // Getting employees
    $scope.getEmployees = function () {
        $scope.employees = [];
        let url = "";
        let data = "";
        switch ($scope.selectedFilter) {
            case "billID":
                url = "/api/getEmployeesByBillID.php";
                data = { billId: $scope.searchQuery };
                break;
            case "empCode":
                url = "/api/getEmployeeByEmpCode.php";
                data = { empCode: $scope.searchQuery };
                break;
            case "accNo":
                url = "/api/getEmployeeByBankAcNo.php";
                data = { bankAcNo: $scope.searchQuery };
                break;
        }
        data = $.param(data);
        $http({
            url: url,
            method: "POST",
            headers: {
                "Content-Type":
                    "application/x-www-form-urlencoded;charset=utf-8;",
            },
            data: data,
        }).then((response) => {
            if (response.data.status && response.data.data.length > 0) {
                $scope.employees = response.data.data;
            } else {
                alert("No Employees Found!");
                return;
            }
        });
    };

    // Sum of Array
    $scope.sumOfArray = (input) => {
        let sum = 0;
        for (let i = 0; i < input.length; i++) {
            sum += parseInt(input[i].amount);
        }
        return sum;
    };
    $scope.sumOfAmount = (input, field) => {
        let sum = 0;
        for (let i = 0; i < input.length; i++) {
            sum += parseInt(input[i][field]);
        }
        return sum;
    };

    // Button Clicks
    // On Add BIll button click
    $scope.addToCurrentBill = () => {
        if ($scope.currentBill.employee != $scope.employee) {
            $scope.currentBill.employee = $scope.employee;
            $scope.currentBill.earnings = [];
            $scope.currentBill.deductions = [];
        }
        if ($scope.monthYear != $scope.currentBill.monthYear) {
            $scope.currentBill.monthYear = $scope.monthYear;
        }
        if ($scope.earningDeductionType == "earning") {
            let found = $scope.currentBill.earnings.find(
                (o) => o.id === $scope.earningAddingValue
            );
            if (found) {
                alert("Already Exists!");
                return;
            }
            $scope.currentBill.earnings.push({
                id: $scope.earningAddingValue,
                name: $("#addingOption option:selected").text(),
                amount: $scope.amount,
            });
        } else {
            let found = $scope.currentBill.deductions.find(
                (o) => o.id === $scope.earningAddingValue
            );
            if (found) {
                alert("Already Exists!");
                return;
            }
            $scope.currentBill.deductions.push({
                id: $scope.earningAddingValue,
                name: $("#addingOption option:selected").text(),
                amount: $scope.amount,
            });
        }
    };

    // On Add Employee Bill
    $scope.addToSBill = () => {
        let currentEmployee = $scope.employees.find(
            (ele) => ele.id == $scope.employee
        );
        $scope.sBill.push({
            empId: $scope.employee,
            employee: currentEmployee.name,
            empCode: currentEmployee.emp_code,
            month: $scope.monthYear.getMonth() + 1,
            year: $scope.monthYear.getFullYear(),
            earnings: $scope.currentBill.earnings,
            deductions: $scope.currentBill.deductions,
            earningsTotal: $scope.sumOfArray($scope.currentBill.earnings),
            deductionsTotal: $scope.sumOfArray($scope.currentBill.deductions),
            netTotal:
                $scope.sumOfArray($scope.currentBill.earnings) -
                $scope.sumOfArray($scope.currentBill.deductions),
        });
        $scope.currentBill = {
            employee: "",
            monthYear: "",
            earnings: [],
            deductions: [],
        };
        $scope.selectedFilter = "";
        $scope.employees = [];
    };

    // View Bill Button
    $scope.showBill = (index) => {
        $scope.viewBill = $scope.sBill[index];
    };

    $scope.submitBill = () => {
        let data = {
            bills: JSON.stringify($scope.sBill),
            totalEarnings: $scope.sumOfAmount($scope.sBill, "earningsTotal"),
            totalDeductions: $scope.sumOfAmount(
                $scope.sBill,
                "deductionsTotal"
            ),
        };
        data = $.param(data);
        $http({
            url: "/api/submitBill.php",
            method: "POST",
            headers: {
                "Content-Type":
                    "application/x-www-form-urlencoded;charset=utf-8;",
            },
            data,
        }).then((response) => {
            if (response.data.status) {
                $scope.selectedFilter = "";
                $scope.billIDs = [];
                $scope.searchQuery = "";
                $scope.employees = [];
                $scope.employee = "";
                $scope.monthYear = "";
                $scope.earningDeductionType = "";
                $scope.earningsDeductions = [];
                $scope.earningAddingValue = "";
                $scope.amount = "";
                $scope.currentBill = {
                    employee: "",
                    monthYear: "",
                    earnings: [],
                    deductions: [],
                };
                $scope.sBill = [];
                $scope.viewBill = {
                    earnings: [],
                    deductions: [],
                };
                alert("Token: " + response.data.data.token);
            }
        });
    };
});
