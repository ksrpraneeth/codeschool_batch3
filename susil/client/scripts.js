var ifmsApp = angular.module('ifmsMod', ['ui.router']);
ifmsApp.config(['$urlRouterProvider', '$stateProvider', function ($urlRouterProvider, $stateProvider) {

    $urlRouterProvider.otherwise('/addAgency');
    $stateProvider
     
        .state('billEntry', {
            url: '/billEntry',
            templateUrl: 'billEntry.html'
        })
        


}]);
ifmsApp.controller("billEntryController", function ($scope, $http,$state) {
    $scope.employeeDetailHide=false
    $scope.searchEmpCode= function(empCode) {
        
        let Data = { empCode: $scope.empCode}
        console.log(Data);
    
        //  $scope.bankDetails = [];
        $http.post('http://127.0.0.1:8000/api/employeeDetails',Data)
            .then(function (response) {
                if (response.data.status) {
                    $scope.employeeDetails = response.data.data;
                    console.log($scope.employeeDetails)
                    swal(response.data.message, "", "success")
                    $scope.employeeDetailHide=true
                }

                else{
                    swal(response.data.message, "", "error")
                    $scope.employeeDetailHide=false
            }
                
            }, function (error) {
                //   console.error('Error sending data:', error);
                
            });
    }
    $scope.optionArr=[];
    $scope.earningDeductionArr=[];

    $scope.earnings= function() {
        $http.post('http://127.0.0.1:8000/api/earningType')
        .then(function (response) {
            if (response.data.status) {
                $scope.earningType= response.data.data;
              
                // swal(response.data.message, "", "success")
                $scope.optionArr=$scope.earningType;
                
                // $scope.earningDeductionArr=$scope.employeeBillList;
                // console.log( $scope.earningDeductionArr);
            }

            else{
                // swal(response.data.message, "", "error")
        }
            
        }, function (error) {
            //   console.error('Error sending data:', error);
            
        });
    
    }
    $scope.deductions= function() {
        $http.post('http://127.0.0.1:8000/api/deductionType')
        .then(function (response) {
            if (response.data.status){
                $scope.deductionType = response.data.data;
                $scope.optionArr=$scope.deductionType;
                // swal(response.data.message, "", "success")
                // $scope.earningDeductionArr=$scope.employeeBillList;
            }

            else{
                // swal(response.data.message, "", "error")
        }
            
        }, function (error) {
            //   console.error('Error sending data:', error);
            
        });
        // $scope.combineArr=$scope.earningType.concat($scope.deductionType);
        // console.log(combineArr);
    
    }
    $scope.employeeBillList = [];
    $scope.totalGross=0;
    $scope.totalDeduction=0;
    $scope.addAmount=function(amount,edType,startdate,enddate){
        
    
        if (!amount) {
            swal("", "Please enter the amount .", "error")
        }
        else if (amount <0) {
            swal("", "Please enter the amount correctly.", "error")
        }
        else if (!edType) {
            swal("", "Please enter the add type.", "error")
        }
        else if (!startdate) {
            swal("", "Please enter the start date.", "error")
        }
        else if (!enddate) {
            swal("", "Please enter the end date.", "error")
        }
        else{

            $scope.totalGross=$scope.totalGross+amount;
            $scope.totalDeduction=$scope.totalDeduction+amount;

           let billData={amount:amount,edType:edType,startdate:startdate,enddate:enddate,totalGross:$scope.totalGross,totalDeduction:$scope.totalDeduction}
           $scope.employeeBillList.push(billData)
           console.log($scope.employeeBillList)
           
          
        }
        
       
    }
    

});