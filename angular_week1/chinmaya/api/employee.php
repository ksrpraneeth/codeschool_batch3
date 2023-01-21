<?php
include "dbconnection.php";
$post = json_decode(file_get_contents('php://input'),true);

try{

    $statement=$pdo->prepare("select id from users where token=?");
    $statement->execute([$post['usertoken']]);
    $id=$statement->fetchAll(PDO::FETCH_ASSOC);

    

   

// if(array_key_exists('workingstatus', $_POST) && $_POST['workingstatus'] != "") {
//     $query .= ' AND e.working_status_id = '.$_POST['workingstatus'].'';
// }

// if(array_key_exists('location', $_POST) && $_POST['location'] != "") {
//     $query .= ' AND e.location_id = '.$_POST['location'].'';
// }

// if(array_key_exists('designation', $_POST) && $_POST['designation'] != "") {
//     $query .= ' AND e.designation_id = '.$_POST['designation'].'';
// }


$statement=$pdo->prepare("select e.id,concat(e.surename,' ',e.firstname,' ',e.lastname),to_char(e.date_of_joining,'DD-MM-YYYY')as doj,to_char(e.dob,'DD-MM-YYYY')as dob,e.gender,w.status_description,d.description,l.district,e.gross as gross from employees as e,working_status as w,location as l,designation as d
where e.working_status_id=w.id and e.location_id=l.id and e.designation_id=d.id and e.created_by=? order by id desc");
$statement->execute([$id[0]['id']]);
$result=$statement->fetchAll(PDO::FETCH_ASSOC);

if(count($result)==0){
    $response=["status"=>false,"message"=>"Data not found"];
    echo json_encode($response);
    return;
}

$response=["status"=>true, "message"=>"", "Data"=>$result];
echo  json_encode($response);

} catch(PDOException $e){
    $response=["status"=>false,"message"=>$e->getMessage()];
    echo json_encode($response);
}