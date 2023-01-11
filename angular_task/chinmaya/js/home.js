if (!('token' in localStorage)) {
    window.location.replace('index.html');
}

var homemodule = angular.module('homeModule', ['ui.router']);


//custom filter

homemodule.filter('numbertoword', function () {
    return function (number) {
        number = number.toString();
        let b = number.length;
        if (b <= 10) {
            console.log('you can implement the code')
            number = '000000000' + number

            let last3 = number.substr(-3, 3)
            let thousand = number.substr(-5, 2)
            let lakh = number.substr(-7, 2)
            let core = number.substr(-10, 3)
            let str = '';
            if (Number(number) != 0) {
                if (Number(core) != 0) {
                    str = str + ConvertHundreedToword(core) + ' ' + 'core' + ' '
                }
                if (Number(lakh) != 0) {
                    str = str + ConversionTenthToword(lakh) + ' ' + 'lakh' + ' '
                }
                if (Number(thousand) != 0) {
                    str = str + ConversionTenthToword(thousand) + ' ' + 'thousand' + ' '
                }
                str = str + ConvertHundreedToword(last3) + ' ' + 'only'
                str = str.toUpperCase()
                return str;
            }
            else {
                return 'zero';
            }

            function ConvertHundreedToword(parameter1) {
                let One = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thrteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Sevente', 'Eighteen', 'Ninteen']

                let Ten = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninty']
                let hundred = '';
                let tenth = 0;
                //checaking for the hundrred place
                if (Number(parameter1[0]) != 0) {
                    hundred = hundred + One[Number(parameter1[0])] + ' ' + 'hundred' + ' ';
                }

                //cheacking for the tenth place
                if (Number(parameter1[1]) == 1) {
                    tenth = tenth + Number(parameter1[1]) + (parameter1[2]);
                    hundred = hundred + One[tenth];
                }
                else if (Number(parameter1[1]) == 0) {
                    hundred = hundred + One[Number(parameter1[2])];
                }
                else {
                    hundred = hundred + Ten[Number(parameter1[1])] + One[Number(parameter1[2])];
                }
                return hundred;

            }
            //function hundreed ends here

            //function to convert two digit number
            function ConversionTenthToword(Parameter1) {
                let One = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thrteen', 'fourteen', 'fifteen', 'sixteen', 'sevente', 'eighteen', 'ninteen']

                let Ten = ['', '', 'twenty', 'thirty', 'fourty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninty']
                let TenToword = '';
                if (Number(Parameter1[0]) > 1) {
                    TenToword = TenToword + Ten[Number(Parameter1[0])] + One[Number(Parameter1[1])]
                }
                else if (Number(Parameter1[2]) == 0) {
                    TenToword = TenToword + 'ten'
                }
                else {
                    TenToword = TenToword + One[Number(Parameter1[0] + Parameter1[1])]
                }
                return TenToword;
            }
        }
        else {
            return 'limit exceed'
        }
    }

})





//router

homemodule.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {


    $stateProvider
        .state('employee', {
            url: '/employee',
            templateUrl: 'employee.html'
        })

    $stateProvider
        .state('homepage', {
            url: '/homepage',
            templateUrl: 'homepage.html'
        })

    $stateProvider
        .state('salary', {
            url: '/salary',
            templateUrl: 'salary.html'
        })



    $urlRouterProvider.otherwise('/homepage')


}])


//controller section

homemodule.controller('headerController', function ($scope) {
    let date = new Date();
    const monthName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

    $scope.fulldate = date.getDate() + '-' + monthName[date.getMonth()] + '-' + date.getFullYear();
    $scope.time = date.toLocaleTimeString();
    $scope.username = localStorage.getItem('username');

    //navbar show and hide using angular
    // $scope.navbar='col-3';
    // $scope.sidesection='col-9';
    // $scope.hidevalue=false;

    // $scope.tooglenavbar=function(){

    //     $scope.hidevalue=false; 
    // }

    $scope.logout = function () {
        localStorage.clear();
        location.replace('index.html')
    }
})

//employee controller
homemodule.controller('employeeController', function ($scope, $http) {
    $scope.emp = []
    //all employee details
    var data = { usertoken: localStorage.getItem('token') }
    console.log(data)
    $http.post("api/employee.php", data).then(
        function (response) {
            console.log(response.data)
            if (response.data.status) {
                $scope.emp = response.data.Data
            }
            else {
                swal(response.data.message, "", "error");
            }

        },
        function (error) {
            swal('Error', JSON.stringify(error), "error");
        }
    );

    //employee indvisual detail view
    $scope.employeename = '';
    $scope.monthsalary2 = [];
    $scope.monthlysalary = function (id) {
        var formdata = { employeeid: id };
       

        $http.post("api/monthlysalary.php", formdata).then(
            function (response) {
                if (response.data.status) {
                    $scope.monthlysalary2 = response.data.Data.salarydetails;
                    $scope.employeename = response.data.Data.employee_name[0].concat;
                }
                else {
                    $scope.employeename = '';
                    $scope.monthsalary2 = []
                    swal(response.data.message, "", "error");
                   
                }
            }, function (error) {
                swal('Error', JSON.stringify(error), "error");
            }
        )
    }

//employee delete function
    $scope.deleteemployee=function(employeeid){
        var formdata={empid:employeeid}

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Employee Data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $http.post("api/deleteemployeeapi.php", formdata).then(
                    function (response) {
                        if (response.data.status) {
                            swal("Employee has been deleted!", {
                                icon: "success",
                              });
                        }
                        else {
                           
                            swal('can not delet the salary', "", "error");
                           
                        }
                    }, function (error) {
                        swal('Error', JSON.stringify(error), "error");
                    }
                )
            } else {
              swal("Employe data is safe!");
            }
          });
    }


    //employee add function
 $scope.empposition=[];
 $scope.empstatus=[];
 $scope.emplocation=[]
    $scope.addemployeebutton=function(){
        $http.post("api/addemployeeapi.php").then(
            function (response) {
                if (response.data.status) {
                   $scope.empposition=response.data.Data[0];
                   $scope.empstatus=response.data.Data[1]
                   $scope.emplocation=response.data.Data[2]
                }
                else {
                    
                    swal(response.data.message, "", "error");
                   
                }
            }, function (error) {
                swal('Error', JSON.stringify(error), "error");
            }
        )
    }
//new employee save function

$scope.empsurname=''
$scope.empfirstname=''
$scope.emplastname=''
$scope.empdoj=''
$scope.empdob=''
$scope.empworkingstatus=0
$scope.empdesignation=0
$scope.emplocation=0
$scope.gender=''
$scope.empgross=0

$scope.savenewemployee=function(surname,firstname,lastname,doj,dob,workingstatus,designation,location,gross){
    console.log(surname,firstname,lastname,doj,dob,workingstatus,designation,location,gross)
}

})



//salary controller

homemodule.controller('salaryController', function ($scope, $http) {
    $scope.salary = [];
    var data = { usertoken: localStorage.getItem('token') }
    console.log(data)
    $http.post("api/salary.php", data).then(
        function (response) {
            console.log(response.data)
            if (response.data.status) {
                $scope.salary = response.data.Data
            }
            else {
                swal(response.data.message, "", "error");
            }

        },
        function (error) {
            swal('Error', JSON.stringify(error), "error");
        }
    );


//salary view
$scope.salarypageemployee=[]
$scope.earningdetail=[]
$scope.deduction=[]

    $scope.viewsalary=function(salaryid,employeeid,year,month){
        var formdata={salid:salaryid,empid:employeeid,yr:year,month:month}
        console.log(formdata)
        $http.post("api/salarybreakup.php", formdata).then(
            function (response) {
                console.log(response.data)
                if (response.data.status) {
                   $scope.salarypageemployee=response.data.Data.output
                   $scope.earningdetail=response.data.Data.earning
                   $scope.deduction=response.data.Data.deduction
                }
                else {
                    swal(response.data.message, "", "error");
                }
    
            },
            function (error) {
                swal('Error', JSON.stringify(error), "error");
            }
        );
    }


})





