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
    $query = "SELECT sc.description, sc.type, to_char(sd.amount, 'FM9,99,999') AS amount, to_char(s.for_month, 'MONTH') AS salary_month, to_char(s.for_month, 'YYYY') AS salary_year, to_char(s.paid_on, 'DD/MM/YYYY') as paid_on, to_char(s.gross_salary, 'FM9,99,999') AS gross_salary, to_char(s.deductions, 'FM9,99,999') AS deductions, to_char(s.net_salary, 'FM9,99,999') AS net_salary FROM salary_details AS sd, salary_components AS sc, salaries AS s WHERE sd.salary_id = s.id AND sd.salary_component_id = sc.id AND s.id = ?"; 
    
    $statement = $pdo->prepare($query);
    $statement->execute([$request['id']]);
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