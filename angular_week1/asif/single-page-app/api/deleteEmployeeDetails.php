<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

try {
    // check whether employee id is present in other tables 
    $query = "SELECT employee_id FROM salaries where employee_id = ?";

    $statement = $pdo->prepare($query);
    $statement->execute([$request['id']]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($result) > 0) {
        $response['status'] = false;
        $response['message'] = 'Error Deleting Employee Data, Try Again Later!';
        echo json_encode($response);
        return;
    }

    // if not present delete employee
    $query = "DELETE FROM employees where id = ?";
    
    $statement = $pdo->prepare($query);
    $isQueryExecuted = $statement->execute([$request['id']]);

    if($isQueryExecuted) {
        $response['status'] = true;
        $response['message'] = 'Employee Data Deleted Successfully!';
        echo json_encode($response);
        return;
    }
    
    $response['status'] = false;
    $response['message'] = 'Error Deleting Employee Data, Try Again Later!';
    
} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;

?>