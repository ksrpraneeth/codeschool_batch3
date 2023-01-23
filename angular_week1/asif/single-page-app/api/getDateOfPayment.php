<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

try {
    $query = "SELECT DISTINCT paid_on, to_char(paid_on, 'DD/MM/YYYY') as date_of_payment FROM salaries";
    
    if(array_key_exists('salaryMonth', $request) && $request['salaryMonth'] != "") {
        $query .= ' WHERE for_month = ?';
        $statement = $pdo->prepare($query);
        $statement->execute([$request['salaryMonth']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $statement = $pdo->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    if(count($result) == 0) {
        $response['status'] = false;
        $response['message'] = 'No Records Found';
        echo json_encode($response);
        return;
    }
    
    $response['status'] = true;
    $response['message'] = 'Records Found';
    $response['data'] = $result;
    
} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;

?>