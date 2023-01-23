<?php

include_once 'dbconnection.php';
include_once 'response.php';

$request = (array) json_decode(file_get_contents('php://input'), true);

try {
    $query = "";
    if(array_key_exists('id', $request) && $request['id'] != "") {
        // get specific employee details
        $query = "SELECT id, surname, firstname, lastname, date_of_joining, date_of_birth, phone, gross_salary, gender, working_status_id, designation_id, location_id FROM employees WHERE id = " .$request['id'];
    }

    else {
        // get all employees data
        $query = "SELECT e.id, CONCAT(e.surname, ' ', e.firstname, ' ', e.lastname) AS name,  to_char(e.date_of_joining, 'DD/MM/YYYY') AS date_of_joining, to_char(e.date_of_birth, 'DD/MM/YYYY') AS date_of_birth, e.gender, e.phone, w.description AS working_status, d.description AS designation, l.district AS location, to_char(e.gross_salary, 'FM9,99,999') AS gross_salary, to_char(e.created_at, 'DD/MM/YYYY HH12:MI AM') AS created_at FROM employees AS e, working_status AS w, designations AS d, locations AS l WHERE e.working_status_id = w.id AND e.designation_id = d.id AND e.location_id = l.id AND e.id > 0";
    

        // for filters based on the provided keys
        if(array_key_exists('workingStatusId', $request) && $request['workingStatusId'] != "") {
            $query .= ' AND working_status_id = '.$request['workingStatusId'].'';
        } if(array_key_exists('designationId', $request) && $request['designationId'] != "") {
            $query .= ' AND designation_id = '.$request['designationId'].'';
        } if(array_key_exists('locationId', $request) && $request['locationId'] != "") {
            $query .= ' AND location_id = '.$request['locationId'].'';
        } 
        $query .= ' ORDER BY e.id ';
    }


    // for salary filter by employee name on employeeSalaries.php
    if(array_key_exists('forSalariesFilter', $request) && $request['forSalariesFilter'] == true) {
        $query = "SELECT CONCAT(e.surname, ' ', e.firstname, ' ', e.lastname) AS name, to_char(e.date_of_joining, 'DD/MM/YYYY') AS date_of_joining, w.description AS working_status, d.description AS designation FROM employees AS e, working_status AS w, designations AS d WHERE e.working_status_id = w.id AND e.designation_id = d.id";
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