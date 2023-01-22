// Custom AngularJS Filter for Capitalizing First Letter of Word
app.filter('capitalize', function() {
    return function(input) {
      return (angular.isString(input) && input.length > 0) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : input;
    }
});

// Controller Functions for the Page employeesData.html
app.controller("getEmployeesData", function($scope, $http) {

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
        $http.get('api/getEmployeesdata.php')
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
app.controller('', []);