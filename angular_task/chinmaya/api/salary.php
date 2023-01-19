<?php
include "dbconnection.php";
$post = json_decode(file_get_contents('php://input'),true);
try{
    $statement=$pdo->prepare("select id from users where token=?");
    $statement->execute([$post['usertoken']]);
    $id=$statement->fetchAll(PDO::FETCH_ASSOC);




    $statement=$pdo->prepare("select concat(e.surename,' ',e.firstname,' ',e.lastname),s.id,s.month,s.year,to_char(s.paid_on,'DD-MM-YYYY')as paid_on,to_char(s.gross,'fm999G999D99')as gross,to_char(s.deduction,'fm999G999D99')as deduction,to_char(s.net,'fm999G999D99')as net,s.employee_id from employees as e,salaries as s where e.id=s.employee_id and e.created_by=?");


     $statement->execute([$id[0]['id']]);
     $result=$statement->fetchAll(PDO::FETCH_ASSOC);





if(count($result)==0){
    $response=["status"=>false,"message"=>"Data not found"];
    echo json_encode($response);
    return;
}



$response=["status"=>true,
"message"=>"",
"Data"=>$result];
echo  json_encode($response);
}



catch (PDOException $e) {
    $response=["status"=>false,"output"=>"Can not login"];
    echo json_encode($response);
    return;
}