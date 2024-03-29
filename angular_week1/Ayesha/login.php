<?php
session_start();
if(isset($_SESSION["userId"])){
    header("Location: user.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

   <!-- Boostrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous"
        />
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"
        ></script>
        <!-- Jquery -->
        <script
            src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous"
        ></script>
        <!--Angular-->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="./index.js"></script>
</head>
<body ng-app="app">
<!--form-->
<div class="row mt-5 justify-content-center">
   <div class="col-md-4 mt-4" ng-controller="menuController">
        <div class="form-group" >
        <label class="fw-bold">Username</label>
            <input type="text" class="form-control" ng-model="username" id="username" placeholder="Username">
        </div>
        <div class="form-group mt-5">
            <label class="fw-bold">Password</label>
            <input type="password" class="form-control" ng-model="password" id="password" placeholder="Password">
        </div>
        <input type="submit" class="btn btn-primary btn-block btn-lg mt-4" value="Login" ng-click="login()">              
    </form>			
</div>
        </div>
    </div>
</body>
</html>