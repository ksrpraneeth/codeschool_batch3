var app =angular.module('loginMod',[]);

 
app.controller("loginCtrl",function($scope,$http){

    $scope.email='';
    $scope.password='';
$scope.login=function(email,password){
  let data={email:email,password:password}
  console.log(data)
  $http.post("loginApi.php",data).then(
    function(response){
        if(response.data.status){
            
            // localStorage.setItem("userData", JSON.stringify(response.data[0]))
            swal("Login Successfully" ,"","success")
            location.replace('index.html');
        }
        else{
          swal(response.data.message,"","error")
        }

    }
  )
}

});
