<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

try {
    $query = "";
    if(array_key_exists('id', $request) && $request['id'] != "") {
        // get salary of specific employee
        $query = "SELECT to_char(for_month, 'MONTH') AS salary_month, to_char(for_month, 'YYYY') AS salary_year, to_char(paid_on, 'DD/MM/YYYY') AS paid_on, to_char(net_salary, 'FM9,99,999') AS net_salary FROM salaries WHERE employee_id = " .$request['id'];
    }
    else {
        // get salary of all employees
        $query = "SELECT s.id, s.employee_id, CONCAT(e.surname, ' ', e.firstname, ' ', e.lastname) AS employee_name, to_char(s.for_month, 'MONTH') AS salary_month, to_char(s.for_month, 'YYYY') AS salary_year, to_char(s.paid_on, 'DD/MM/YYYY') AS paid_on, to_char(e.gross_salary, 'FM9,99,999') AS gross_salary, to_char(s.deductions, 'FM9,99,999') AS deductions, to_char(s.net_salary, 'FM9,99,999') AS net_salary, to_char(s.created_at, 'DD/MM/YYYY HH12:MI AM') AS created_at FROM salaries AS s, employees AS e WHERE s.employee_id = e.id";

        // get salary of all employees with some filters
        if(array_key_exists('salaryMonth', $request) && $request['salaryMonth'] != "") {
            $query .= ' AND s.for_month = '.'"'.$request['salaryMonth'].'"';
        } if(array_key_exists('dateOfPayment', $request) && $request['dateOfPayment'] != "") {
            $query .= ' AND s.paid_on = '.'"'.$request['dateOfPayment'].'"';
        } if(array_key_exists('employeeId', $request) && $request['employeeId'] != "") {
            $query .= ' AND s.employee_id = '.'"'.$request['employeeId'].'"';
        } 
        $query .= ' ORDER BY s.id';
    }

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