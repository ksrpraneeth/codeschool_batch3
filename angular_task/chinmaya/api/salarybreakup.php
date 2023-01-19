<?php

include "dbconnection.php";
try {
    $post = json_decode(file_get_contents('php://input'),true);
    
    $empid=$post['empid'];
    


    $statement1=$pdo->prepare("select concat(e.surename,' ',e.firstname,' ',e.lastname),s.month,s.year,w.status_description,l.district,d.description from employees as e,salaries as s,working_status as w,location as l,designation as d where e.working_status_id=w.id and s.employee_id=e.id and e.location_id=l.id and e.designation_id =d.id and e.id=? and s.id=? and s.month=? and s.year=?");
    $statement1->execute([$empid,$post['salid'],$post['month'],$post['yr']]);
    $employeedetails=$statement1->fetchAll(PDO::FETCH_ASSOC);
    
    
  

    $statement2=$pdo->prepare("select sd.amount,sc.description from salary_details as sd ,salary_component as sc where sc.id=sd.salary_component_id and sd.employee_id=? and sc.type='earnings' and salary_id=?");
    $statement2->execute([$empid,$post['salid']]);
    $earning=$statement2->fetchAll(PDO::FETCH_ASSOC);
    
    
    $statement3=$pdo->prepare("select sd.amount,sc.description from salary_details as sd ,salary_component as sc where sc.id=sd.salary_component_id and sd.employee_id=? and sc.type='deduction' and salary_id=?");
    $statement3->execute([$empid,$post['salid']]);
    $deduction=$statement3->fetchAll(PDO::FETCH_ASSOC);
  
  


    if(count($employeedetails)==0){
        $response=["status"=>false,"message"=>"Data is not found"];
        echo json_encode($response);
        return;
    }
    // $response=["status"=>true,"output"=>$employeedetails,"earning"=>$earning,"deduction"=>$deduction];
    $response=["status"=>true,"message"=>"","Data"=>["output"=>$employeedetails,"earning"=>$earning,"deduction"=>$deduction]];
    
    echo json_encode($response);
    


} 


catch (PDOException $e) {
    $response=["status"=>false,"message"=>"data is not found"];
    echo json_encode($response);
    return;


}

