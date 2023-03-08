<?php

include_once 'dbconnection.php';
include_once 'response.php';

try {
    $query = "SELECT DISTINCT for_month, to_char(for_month, 'MONTH - YYYY') AS salary_month FROM salaries";
    
    $statement = $pdo->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

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