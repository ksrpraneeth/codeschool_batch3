var app =angular.module('loginMod',[]);

 
app.controller("loginCtrl",function($scope,$http){

    $scope.email='';
    $scope.password='';
$scope.login=function(email,password){
  let data={email:email,password:password}
  console.log(data)
  $http.post("api/login",data).then(
    function(response){
        if(response.data.status){
            
            localStorage.setItem("userData", JSON.stringify(response.data.output))
            swal("Login Successfully" ,"","success")
            location.replace('/');
        }
        else{
          swal(response.data.message,"","error")
        }

    }
  )
}

});
