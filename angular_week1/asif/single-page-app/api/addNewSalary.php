<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

$day = substr($request['paidOn'], 0, 2);
$month = substr($request['paidOn'], 3, 2);
$year = substr($request['paidOn'], 6, 4);
$paidOn = $year.'-'.$month.'-'.$day;

try {
    // check whether the salary for same month is present or not in salaries table
    $query = "SELECT id from salaries WHERE employee_id = ? AND for_month = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$request['employeeId'], $request['forMonth']]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // if present get salary id
    if(count($result) > 0) {
        $salary_id = $result[0]['id'];
    }

    // if not present insert the salary record and return the salary id
    else {
        $query = "INSERT INTO salaries(employee_id, for_month, paid_on, gross_salary, deductions, net_salary) VALUES(?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($query);
        $result = $statement->execute([$request['employeeId'], $request['forMonth'], $paidOn, $request['grossSalary'], $request['deductions'], $request['netSalary']]);
        if($result) {
            $query = "SELECT id from salaries WHERE employee_id = ? AND for_month = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$request['employeeId'], $request['forMonth']]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $salary_id = $result[0]['id'];
        }
    }

    // based on salary id, first check the salary components are already present or not
    $query = "SELECT id from salary_details WHERE salary_id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$salary_id]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // if salary components are present, return
    if(count($result) > 0) {
        $response['status'] = false;
        $response['message'] = 'Salary Already Exists!';
        echo json_encode($response);
        return;
    }

    // if not present, then insert the values
    $id = $salary_id;
    $query = 'INSERT INTO salary_details(salary_id, salary_component_id, amount) VALUES('.$id. ', 1, '.$request['basicPay'].'), ('.$id. ', 2, '.$request['da'].'), ('.$id. ', 3, '.$request['hra'].'), ('.$id. ', 4, '.$request['ca'].'), ('.$id. ', 5, '.$request['medicalAllowance'].'), ('.$id. ', 6, '.$request['bonus'].'), ('.$id. ', 7, '.$request['tds'].'), ('.$id. ', 8, '.$request['pf'].')';
    $statement = $pdo->prepare($query);
    $result = $statement->execute();
    if($result) {
        $response['status'] = true;
        $response['message'] = 'Salary Added Successfully!';
    }
    
} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;

?>