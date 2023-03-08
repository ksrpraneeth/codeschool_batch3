// Custom AngularJS Filter for Capitalizing First Letter of Word
app.filter('capitalize', function() {
    return function(input) {
      return (angular.isString(input) && input.length > 0) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : input;
    }
});

// Controller Functions for the Page employeesData.html
app.controller("EmployeesDataController", function($scope, $http) {

    // DOM Functionalities
    $scope.dismissModal = function(modalId) {
        var myModal = document.getElementById(modalId);
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
    }
    $scope.resetForm = function(formId) {
        document.getElementById(formId).reset();
    }


    // get employeesData table data
    $scope.employeesData = [];
    $scope.getEmployeesData = function() {
        $http.get('api/getEmployeesData.php')
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeesDataError = "";
                $scope.employeesData = resData.data;
            }
            else {
                $scope.employeesDataError = resData.message;
            }
        });
    }
    $scope.getEmployeesData();


    // get working status filter data
    $scope.workingStatusArr = [];
    $http.get('api/getWorkingStatus.php')
    .then(function(response) {
        const resData = response.data;
        if(resData.status) {
            $scope.workingStatusArr = resData.data;
        }
    });


    // get designations filter data
    $scope.designationsArr = [];
    $http.get('api/getDesignations.php')
    .then(function(response) {
        const resData = response.data;
        if(resData.status) {
            $scope.designationsArr = resData.data;
        }
    });


    // get locations filter data
    $scope.locationsArr = [];
    $http.get('api/getLocations.php')
    .then(function(response) {
        const resData = response.data;
        if(resData.status) {
            $scope.locationsArr = resData.data;
        }
    });
    

    // filter employeesData table on click of search button
    $scope.filterBy = function(selectedWorkingStatus, selectedDesignation, selectedLocation) {
        $scope.employeesData = [];
        $http({
            method: 'POST',
            url: 'api/getEmployeesData.php',
            data: {
                workingStatusId: selectedWorkingStatus,
                designationId: selectedDesignation,
                locationId: selectedLocation
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeesDataError = "";
                $scope.employeesData = resData.data;
            }
            else {
                $scope.employeesDataError = resData.message;
            }
        });
    };


    // clear filters dropdown selections and display all employees data on click of clear button
    $scope.clearFilters = function() {
        $scope.selectedWorkingStatus = "";
        $scope.selectedDesignation = "";
        $scope.selectedLocation = "";
        $scope.getEmployeesData();
    };


    // add new employee form validation rules
    $scope.nameRegex = /^[A-Z]+$/i;
    $scope.mobileNumberRegex = /^\d{10}$/;
    $scope.todaysDate = new Date().toISOString().split("T")[0];
    $scope.minDateOfBirth = new Date(new Date().setDate(new Date().getDate()-6500)).toISOString().split("T")[0];

    
    // add new employee form submission
    $scope.addNewEmployee = function() {
        $scope.addNewEmployeeFormErrors = [];
        $http({
            method: 'POST',
            url: 'api/addNewEmployee.php',
            data: {
                surname: $scope.surname,
                firstName: $scope.firstName,
                lastName: $scope.lastName,
                dateOfJoining: $scope.dateOfJoining,
                dateOfBirth: $scope.dateOfBirth,
                mobileNumber: $scope.mobileNumber,
                grossSalary: $scope.grossSalary,
                gender: $scope.gender,
                workingStatus: $scope.workingStatus,
                designation: $scope.designation,
                location: $scope.location
            },
        })
        .then(function success(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.dismissModal('addNewEmployeeModal');
                swal({
                    title: "Success",
                    text: resData.message,
                    icon: "success",
                    button: "Close",
                });
                $scope.getEmployeesData();
            }
            else if(resData.errors) {
                $scope.addNewEmployeeFormErrors = resData.errors;
            }
            else {
                $scope.dismissModal('addNewEmployeeModal');
                swal({
                    title: "Failed",
                    text: "Error Adding New Employee Details!",
                    icon: "error",
                    button: "Close",
                });
                $scope.getEmployeesData();
            }
        },
        function error(response) {
            $scope.dismissModal('addNewEmployeeModal');
            swal({
                title: "Failed",
                text: response.data.message,
                icon: "error",
                button: "Close",
            });
            $scope.getEmployeesData();
        }
        );
    };


    // set particular employee details in a variable for modals
    $scope.getEmployeeDetails = function(employee) {
        $scope.employeeDetails = employee;
    };


    // get salary details of a particular employee from the database for viewSalriesModal
    $scope.getEmployeeSalaries = function() {
        $http({
            method: 'POST',
            url: 'api/getEmployeesSalaries.php',
            data: {
                id: $scope.employeeDetails.id
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeeSalariesError = "";
                $scope.employeeSalaries = resData.data;
            }
            else {
                $scope.employeeSalariesError = resData.message;
            }
        });
    };
    

    // for editing employee data, first get the data from db
    $scope.getEmployeeData = function(employeeId) {
        $http({
            method: 'POST',
            url: 'api/getEmployeesData.php',
            data: {
                id: employeeId
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeeData = resData.data[0];
                var dob = new Date($scope.employeeData.date_of_birth);
                var doj = new Date($scope.employeeData.date_of_joining);
                $scope.employeeData.date_of_birth = dob;
                $scope.employeeData.date_of_joining = doj;
            }
        });
    };
    // then save the edits
    $scope.updateEmployeeDetails = function() {
        $http({
            method: 'POST',
            url: 'api/updateEmployeeDetails.php',
            data: $scope.employeeData
        })
        .then(function success(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.dismissModal('editEmployeeDetailsModal');
                swal({
                    title: "Success",
                    text: resData.message,
                    icon: "success",
                    button: "Close",
                });
                $scope.getEmployeesData();
            }
            else {
                $scope.dismissModal('editEmployeeDetailsModal');
                swal({
                    title: "Failed",
                    text: resData.message,
                    icon: "error",
                    button: "Close",
                });
                $scope.getEmployeesData();
            }
        },
        function error(response) {
            $scope.dismissModal('editEmployeeDetailsModal');
            swal({
                title: "Failed",
                text: "Error Updating Employee Data",
                icon: "error",
                button: "Close",
            });
            $scope.getEmployeesData();
        }   
        );
    };
    

    // Delete Employee Details
    $scope.deleteEmployeeDetails = function(employeeId) {
        console.log(employeeId);
        swal({
            title: "Are you sure?",
            text: "All data of the employee will be deleted!",
            icon: "warning",
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $http({
                    method: 'POST',
                    url: 'api/deleteEmployeeDetails.php',
                    data: {
                        id: employeeId
                    }
                })
                .then(function(response) {
                    const resData = response.data;
                    if(resData.status) {
                        swal({
                            title: "Success",
                            text: resData.message,
                            icon: "success",
                            button: "Close",
                        });
                    }
                    else {
                        swal({
                            title: "Failed",
                            text: resData.message,
                            icon: "error",
                            button: "Close",
                        });
                    }
                });
            }
            $scope.getEmployeesData();
        });
    };   
});




// Controller Functions for the Page employeesData.html
app.controller('EmployeesSalariesController', function($scope, $http) {

    // DOM Functionalities
    $scope.dismissModal = function(modalId) {
        var myModal = document.getElementById(modalId);
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
    }
    $scope.resetForm = function(formId) {
        document.getElementById(formId).reset();
    }


    // get employeesSalaries table data
    $scope.employeesSalariesData = [];
    $scope.getEmployeesSalaries = function() {
        $http.get('api/getEmployeesSalaries.php')
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeesSalariesError = "";
                $scope.employeesSalariesData = resData.data;
            }
            else {
                $scope.employeesSalariesError = resData.message;
            }
        });
    };
    $scope.getEmployeesSalaries();


    // get filters options/data 
    $scope.salaryMonthFilterArr = [];
    $scope.getSalaryMonth = function() {
        $http.get('api/getSalaryMonth.php')
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.salaryMonthFilterArr = resData.data;
            }
        });
    }
    $scope.getSalaryMonth();
 

    $scope.dateOfPaymentFilterArr = [];
    $scope.getDateOfPayment = function() {
        $http({
            method: 'POST',
            url: 'api/getDateOfPayment.php',
            data: {
                salaryMonth: $scope.selectedSalaryMonth
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.dateOfPaymentFilterArr = resData.data;
            }
        });
    }
    $scope.getDateOfPayment();


    $scope.employeesList = [];
    $scope.getEmployeesList = function() {
        $http.get('api/getEmployeesList.php')
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeesList = resData.data;
            }
        });
    }
    $scope.getEmployeesList();



    // search salaries by filter
    $scope.filterSalaries = function() {
        $scope.employeesSalariesData = [];
        $http({
            method: 'POST',
            url: 'api/getEmployeesSalaries.php',
            data: {
                salaryMonth: $scope.selectedSalaryMonth,
                dateOfPayment: $scope.selectedDateOfPayment,
                employeeId: $scope.selectedEmployeeName
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeesSalariesError = "";
                $scope.employeesSalariesData = resData.data;
            }
            else {
                $scope.employeesSalariesError = resData.message;
            }
        });
    };


    // clear filters 
    $scope.clearFilters = function() {
        $scope.selectedSalaryMonth = "";
        $scope.selectedDateOfPayment = "";
        $scope.selectedEmployeeName = "";
        $scope.getEmployeesSalaries();
    };


    // add new salary dependencies
    $scope.getEmployeeData = function(employeeId, forSalaryBreakup) {
        $scope.employeeData = [];
        $http({
            method: 'POST',
            url: 'api/getEmployeesData.php',
            data: {
                id: employeeId,
                forSalariesFilter: forSalaryBreakup
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeeData = resData.data[0];
                var dob = new Date($scope.employeeData.date_of_birth);
                var doj = new Date($scope.employeeData.date_of_joining);
                $scope.employeeData.date_of_birth = dob;
                $scope.employeeData.date_of_joining = doj;
            }
        });
    };
    


    $scope.viewSalaryBreakup = function(salaryVal) {
        // $scope.getEmployeeData(salaryVal.employee_id, true);
        $scope.employeeSalaryBreakupData = [];
        $http({
            method: 'POST',
            url: 'api/getSalaryBreakup.php',
            data: {
                id: salaryVal.id
            }
        })
        .then(function(response) {
            const resData = response.data;
            if(resData.status) {
                $scope.employeeSalaryBreakupData = resData.data;
                console.log($scope.employeeSalaryBreakupData);
                // $scope.employeeSalaryData = resData.data[0];
            }
            else {
                $scope.viewSalaryBreakupError = resData.message;
            }
        });
    }


    $scope.deleteSalary = function(salaryId) {
        swal({
            title: "Are you sure?",
            text: "Do you want to delete this employee salary data?",
            icon: "warning",
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $http({
                    method: 'POST',
                    url: 'api/deleteSalary.php',
                    data: {id: salaryId}
                })
                .then(
                    function(response) {
                        let resData = response.data;
                        if(resData.status) {
                            swal({
                                title: "Success",
                                text: resData.message,
                                icon: "success",
                                button: "Close",
                            });
                        }
                        else {
                            swal({
                                title: "Error",
                                text: resData.message,
                                icon: "error",
                                button: "Close",
                            });
                        }
                    }
                );
            }
            getEmployeesSalaries();
        });
    }
});