var app = angular.module("app", ["ui.router"]);
//ui-router
if(!localStorage.getItem('userToken')&& !location.href.includes("login.html"))
{
  location.assign("login.html");
}else
{
  if(localStorage.getItem('userToken')&& location.href.includes("login.html"))
  {
    location.assign("dashboard.html");
  }
}
app.config([
  "$stateProvider",
  function ($stateProvider) {
    $stateProvider
      .state("addRecipe", {
        url: "/addRecipe",
        templateUrl: "addRecipe.html",
      })
      .state("recipeList", {
        url: "/recipeList",
        templateUrl: "recipeList.html",
      })
      .state("recipeList.recipeDetails", {
        url: "/recipeDetails/:id",
        templateUrl: "recipeDetails.html",
      })
      .state("recipeList.recipeDetails.editRecipe",{
        url:"/editRecipe/:id",
        templateUrl:"editRecipe.html",
     })
  },
]);
app.controller("recipeController", function ($scope, $http,$window) {
  $scope.error = "";
  //to add new details into db
  $scope.add = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/addrecipe",
      data: {
        recipe_name: $scope.recipe_name,
        cuisine: $scope.cuisine,
        chef: $scope.chef,
        description: $scope.description,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          alert(response.data.message);
        }
      },
      function error(response) {
        $scope.error =
          response.data.errors[Object.keys(response.data.errors)[0]][0];
      }
    );
  };
  //to fetch recipe list into table
  $http({
    method: "POST",
    url: "http://127.0.0.1:8000/api/getrecipes",
  }).then(function (response) {
    $scope.recipes = response.data.data;
  });
  //delete details of that particular recipe
  $scope.confirmDelete = function (id, index) {
    if ($window.confirm("Do you want to continue?"))
    {
      $http({
        method:"POST",
        url:"http://127.0.0.1:8000/api/deleterecipe",
        data:{id},
      }).then(
        function success(response){
         if(response.data.status==true)
         {
          alert(response.data.message);
          $scope.recipes.splice(index, 1);
         }
        },
        function error()
        {
          //
        }
      )
    
  }
    else{
    $scope.result = "No";
    }
  }
  });
//fetch details of that particular recipe
app.controller("recipeDetails", function ($scope, $http, $stateParams) {



  $http({
    method: "POST",
    url: "http://127.0.0.1:8000/api/recipedetails",
    data: { id: $stateParams.id },
  }).then(
    function(response) {
      $scope.recipe_details = response.data.data;
    },
    function(response) {
      alert(response);
    }
  );
  
//update existing details for a particular recipe
$scope.recipe_details={},

$scope.saveRecipe=function()
  
  {
    $http({
      method:"POST",
      url:"http://127.0.0.1:8000/api/saveRequest/"+$stateParams.id,
      data:{id:$stateParams.id,
        recipe_details:$scope.recipe_details,

      },
    }).then(
      function success(response){
       if(response.data.status==true)
       {
        alert(response.data.message);
       }
      },
      function error()
      {
        //
      }
    )
  }
  });
  
  app.controller("AddIngredient",function($scope,$http,$stateParams)
  {
     //get ingredient list
    $scope.ingredients=[];
    $scope.addIngredient=function()
    {
      $http({
        method: "POST",
        url: "http://127.0.0.1:8000/api/getingredient",
      }).then(
        function(response) {
          $scope.ingredients = response.data.data;
          console.log(response.data);
        },
        function(response) {
          alert(response);
          console.log(response);
        }
      );
    }
    //get selected ingredient list into database
    $scope.selectIngredient=[];
    $scope.selectIngredients=function()
    {
      $http({
        method: "POST",
        url: "http://127.0.0.1:8000/api/selectedingredient",
        data:{
          ingredients:$scope.selectIngredient,
          recipe_id:$stateParams.id
        }
      }).then(
        function(response) {
          alert(response.data.message);
        },
        function(response) {
          
          console.log(response);
        }
      );
    }
  })
//register new user
app.controller("registerController",function($scope,$http,$window)
{
    $scope.register=function()
    {
        $http({
            method:'POST',
            url:'http://127.0.0.1:8000/api/registeruser',
            data:{email:$scope.email,
                //backend:frontend
                full_name:$scope.full_name,
                username:$scope.username,
                password:$scope.password,
                password_confirmation:$scope.confirmPassword
            }
        }).then(function success(response)
        {
            if(response.data.status==true){
                alert(response.data.message);
                $window.location.href='login.html';
            }
            else
            {
                $scope.error = response.data.message;
            }

        },
            function error(response){
                $scope.error = response.data.errors[Object.keys(response.data.errors)[0]][0];
            })
    }
    //login 
    $scope.login=function()
    {
        $http({
            method:'POST',
            url:'http://127.0.0.1:8000/api/loginuser',
            data:{
                username:$scope.username,
                password:$scope.password
            }
        }).then(function success(response)
        {
            if(response.data.status){
              alert(response.data.message);
              localStorage.setItem('userToken',response.data.token);
                $window.location.href='dashboard.html';
            } else {
                alert(response.data.message)
            }
        },
            function error(response){
                if(response.data.errors){
                    alert("Login Failed check data!")
                }
            })
    }
  });
  //controller for http for token on login
  app.controller("dashboardController",function($scope,$http)
  {
    $http({
      method:'POST',
      url:"http://127.0.0.1:8000/api/dashboard",
      data:{token:localStorage.getItem('userToken')},
    }).then(
      function(response) 
      {
        if(!response.data.status)
        {
          location.assign("login.html");
        }
      }
    )
    $scope.logout=function()
    {
      localStorage.clear();
      location.replace('login.html');
    }

  });
