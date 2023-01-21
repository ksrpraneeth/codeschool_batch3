<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.js"></script>
    <script src="./index.js"></script>
    <style>
        body {
            margin-top: 200px;
        }

        body input {
            width: 50px;
        }
    </style>
</head>

<body ng-app="user">
    <div class="container d-flex gap-lg-5  gap-2  rounded-2 mt-5 align-items-center">
        <div class="registerForm col-6" ng-controller="RegisterController">
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Full Name</span>
                <input type="text" class="form-control rounded-1" ng-model="fullNameInput"
                    placeholder="Enter Full Name..." required>
            </div>
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Email</span>
                <input type="mail" class="form-control rounded-1" ng-model="emailInput" placeholder="Enter Email..."
                    required>
            </div>
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Phone Number</span>
                <input type="text" class="form-control rounded-1" ng-model="phoneNumberInput"
                    placeholder="Enter Phone Number..." required>
            </div>
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Date of Birth</span>
                <input type="date" class="form-control rounded-1" ng-model="dobInput"
                    placeholder="Enter Date of Birth..." required>
            </div>
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Password</span>
                <input type="password" class="form-control rounded-1" ng-model="passwordInput"
                    placeholder="Enter Password..." required>
            </div>
            <div class="d-flex gap-3 mt-3">
                <span class="col-3">Confirm Password</span>
                <input type="password" class="form-control rounded-1" ng-model="confirmPasswordInput"
                    placeholder="Enter Confirm Password..." required>
            </div>
            <button class="btn btn-danger mt-4" ng-click="register()">Register</button>
        </div>
        <div class="login ms-lg-4">
            <p>Already Registered?</p>
            <a class="btn btn-primary mb-4" href="./login.html">Login
            </a>
        </div>
    </div>
</body>

</html>