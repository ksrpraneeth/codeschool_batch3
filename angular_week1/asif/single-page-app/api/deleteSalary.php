<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

if(!array_key_exists('id', $request)) {
    $response['status'] = false;
    $response['message'] = 'Invalid Request';
    echo json_encode($response);
    return;
}

try {
    // $query = "DELETE FROM salaries USING salary_details WHERE salary_details.salary_id = salaries.id AND salaries.id = ?";
    $query = "DELETE FROM salaries
    WHERE id IN (SELECT id FROM salaries 
                 WHERE salaries.id = ?
                 AND id IN (SELECT id FROM salary_details WHERE salary_details.salary_id = ?))";
    $statement = $pdo->prepare($query);
    $isQueryExecuted = $statement->execute([$request['id'], $request['id']]);
    
    if($isQueryExecuted > 0) {
        $response['status'] = true;
        $response['message'] = 'Salary Details Deleted';
        echo json_encode($response);
        return;
    }

    $response['status'] = false;
    $response['message'] = 'Error Deleting Salary Details!';    

} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;
?>