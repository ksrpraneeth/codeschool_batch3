<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

try {
    $query = "UPDATE employees SET surname = ?, firstname = ?, lastname = ?, date_of_joining = ?, date_of_birth = ?, gender = ?, phone = ?, working_status_id = ?, designation_id = ?, location_id = ?, gross_salary = ? WHERE id = ?";

    $statement = $pdo->prepare($query);
    
    $result = $statement->execute([$request['surname'], $request['firstname'], $request['lastname'], $request['date_of_joining'], $request['date_of_birth'], $request['gender'], $request['phone'], $request['working_status_id'], $request['designation_id'], $request['location_id'], $request['gross_salary'], $request['id']]);
    
    if($result) {
        $response['status'] = true;
        $response['message'] = 'Employee Data Updated Successfully';
        echo json_encode($response);
        return;
    }

    $response['status'] = false;
    $response['message'] = 'Failed to Update Employee Data';

} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;
?>