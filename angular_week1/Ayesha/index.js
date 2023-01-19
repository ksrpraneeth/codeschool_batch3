 // Hide sidebar
 $("#sidebarToggler").click(() => {
    $("#sidebar").toggleClass("hide");
});
 //angular module
 var app=angular.module("app",[])
 app.controller("menuController",function($scope,$http,$window)
 {
    $scope.menus=[
        {
            name: "Home",
            state: "homeState"
        },
        {
            name: "PPO Acceptance",
            state: "ppoState"
        },
        {
            name: "Print grat./Comm.Bills",
            state: "printState"
        },
        {
            name: "Generate Grat./Comm.Bills",
            state: "generateState"
        },
        {
            name: "Pension Master",
            state: "pensionState"
        },
        {
            name: "Close Pay Bank",
            state: "closeState"
        },
        {
            name: "Arrear Bills",
            state: "arrearState"
        },
        {
            name: "SP to FP Conversion",
            state: "spState"
        },
        {
            name: "PPO Search",
            state: "ppoSearchState"
        },
        {
            name: "Pension Check",
            state: "pensionCheckState"
        },
        {
            name: "Income Tax",
            state: "incomeState"
        },
        {
            name: "Accept Tranfer",
            state: "acceptState"
        },
        {
            name: "Transfer",
            state: "transferState"
        },
        {
            name: "Approve bank details",
            state: "approveState"
        },
        {
            name: "Annual Verification Certificate",
            state: "verifyState"
        },
        {
            name: "Pension Reports",
            state: "reportState"
        },
        {
            name: "Fore Close Recovery",
            state: "foreState"
        },
        {
            name: "Pen Bills scrollround",
            state: "penState"
        },
        {
            name: "Open Pay Bank",
            state: "openState"
        },
        {
            name: "PRC",
            state: "prcState"
        },

    ];
    //login controller
    $scope.login=function (){
        
        $http({
            method:'POST',
            url:'loginApi.php',
            data:{username:$scope.username,password:$scope.password}
        }).then(function success(response) {
            if(response.data.status==true){
        alert(response.data.message);
         $window.location.href = 'user.php';
          }
          else
          {
            alert(response.data.message);
          }
        }, function error(response) {
           
          });
        }
    $scope.profilename="Ayesha Fatima";
    $http({
        method:'POST',
        url:'index.php',
       
    }).then(function success(response) {
        console.log(response.data);
     $scope.data=response.data; 
    }, function error(response) {
       
      });
      
      $scope.saveEdit=function()
      {
         $scope.ppoidError = "";
         $scope.ppoNumError = "";
         $scope.pensionError = "";
         $scope.dorError = "";
         $scope.startDateError = "";
         $scope.efpError = "";
         $scope.scaleError = "";
         $scope.nameError = "";
        if(!$scope.data.ppoid){
            $scope.ppoidError="PPO ID cannot be empty!";
            return;
        } 
        if(!$scope.data.pension){
            $scope.ppoNumError="PPO Number cannot be empty!";
            return;
        }
        if(!$scope.data.pension){
            $scope.pensionError="Pension Category cannot be empty!";
            return;
        }
        if(!$scope.data.dor){
            $scope.dorError="Date of Recruitment cannot be empty!";
            return;
        }
        if(!$scope.data.startDate){
            $scope.startDateError="Start Date cannot be empty!";
            return;
        }
        if(!$scope.data.efp){
            $scope.efpError="EFP cannot be empty!";
            return;
        }
        if(!$scope.data.scaleType){
            $scope.scaleError="Scale Type cannot be empty!";
            return;
        }
        if(!$scope.data.familyPensionName){
            $scope.nameError="Name cannot be empty!";
            return;
        }
        $http({
            method:'POST',
            url:'postDetails.php',
            data:{ppoid:$scope.data.ppoid,
                pension:$scope.data.pension,
                dor:$scope.data.dor,
                startDate:$scope.data.startDate,
                efp:$scope.data.efp,
                scaleType:$scope.data.scaleType,
                familyPensionName:$scope.data.familyPensionName
            }
        }).then(function success(response) {
            if(response.data.status==true){
               
            $scope.formEdit = false;
            }
        }, function error(response) {
            
          });
      }
      $scope.logout=function()
      {
        $window.location.href = 'logout.php';
      }

 })
