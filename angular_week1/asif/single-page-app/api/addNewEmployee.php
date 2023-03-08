<?php

include_once 'dbconnection.php';
$response = [
    "status" => true,
    "message" => "",
    "errors" => [
        "firstNameError" => '',
        "lastNameError" => '',
        "dateOfJoiningError" => '',
        "dateOfBirthError" => '',
        "mobileNumberError" => '',
        "grossSalaryError" => ''
    ]
];

$request = (array) json_decode(file_get_contents('php://input'), true);

// check for validations
if(!array_key_exists("firstName", $request) || strlen($request["firstName"]) == 0) {
    $response["errors"]["firstNameError"] = "Please enter first name";
    $response["status"] = false;
}
else if(!preg_match("/^[A-Z]+$/i", $request["firstName"])) {
    $response["errors"]["firstNameError"] = "Invalid first name";
    $response["status"] = false;
}

if(!array_key_exists("lastName", $request) || strlen($request["lastName"]) == 0) {
    $response["errors"]["lastNameError"] = "Please enter last name";
    $response["status"] = false;
}
else if(!preg_match("/^[A-Z]+$/i", $request["lastName"])) {
    $response["errors"]["lastNameError"] = "Invalid last name";
    $response["status"] = false;
}

if(!array_key_exists("dateOfJoining", $request) || $request["dateOfJoining"] == "") {
    $response["errors"]["dateOfJoiningError"] = "Please select date of joining";
    $response["status"] = false;
}
if($request["dateOfJoining"] < '2000-01-01' || $request["dateOfJoining"] > date("y-m-d") || $request["dateOfJoining"] < $request["dateOfBirth"]) {
    $response["errors"]["dateOfJoiningError"] = "Please select valid date of joining";
    $response["status"] = false;
}

if(!array_key_exists("dateOfBirth", $request) || $request["dateOfBirth"] == "") {
    $response["errors"]["dateOfBirthError"] = "Please enter date of birth";
    $response["status"] = false;
}
else if($request["dateOfBirth"] < '1930-01-01' || $request["dateOfBirth"] > date("y-m-d") || $request["dateOfBirth"] > $request["dateOfJoining"]) {
    $response["errors"]["dateOfBirthError"] = "Please select valid date of birth";
    $response["status"] = false;
}

if(!array_key_exists("mobileNumber", $request) || strlen($request["mobileNumber"]) == 0) {
    $response["errors"]["mobileNumberError"] = "Please enter mobile number";
    $response["status"] = false;
}
else if(!preg_match("/^[0-9]+$/", $request["mobileNumber"]) || strlen($request["mobileNumber"]) != 10) {
    $response["errors"]["mobileNumberError"] = "Mobile number should be 10 digits number only!";
    $response["status"] = false;
}

if(!array_key_exists("grossSalary", $request) || strlen($request["grossSalary"]) == 0) {
    $response["errors"]["grossSalaryError"] = "Please enter gross salary";
    $response["status"] = false;
}
else if(!preg_match("/^[0-9]+$/", $request["grossSalary"]) || $request["grossSalary"] > 5000000) {
    $response["errors"]["grossSalaryError"] = "Enter correct salary amount";
    $response["status"] = false;
}

// if errors, return error messages
if($response["status"] == false) {
    $response["message"] = "Please Enter Correct Form Details!";
    echo json_encode($response);
    return;
}


// else insert the data into database
include_once 'response.php';
try {
    $query = "INSERT INTO employees(surname, firstname, lastname, date_of_joining, date_of_birth, gender, phone, working_status_id, designation_id, location_id, gross_salary) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $statement = $pdo->prepare($query);
    
    $isQueryExecuted = $statement->execute([$request['surname'], $request['firstName'], $request['lastName'], $request['dateOfJoining'], $request['dateOfBirth'], $request['gender'], $request['mobileNumber'], $request['workingStatus'], $request['designation'], $request['location'], $request['grossSalary']]);
    
    if($isQueryExecuted) {
        $response['status'] = true;
        $response['message'] = 'New Employee Added Successfully';
        echo json_encode($response);
        return;
    }

    $response['status'] = false;
    $response['message'] = 'Error Adding New Employee';

} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;
?>