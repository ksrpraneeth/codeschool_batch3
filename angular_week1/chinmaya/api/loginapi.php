<?php

include "dbconnection.php";


$post = json_decode(file_get_contents('php://input'),true);


    

    
$status=true;
$email=$post['Email'];
$password=$post['Password'];

if($email=='' || $password==''){
    $status=false;
}
if(!$status){
    $result=["status"=>false,"message"=>"Please fill the required fields."];
    echo json_encode($result);
    return;
}


#email verification

if(strlen($email)>65){
$status=false;
}
else if(preg_match('/[A-Z]/',$email)){
$status=false;
}
else if(preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/',$email)){
$status=false;
}
#password verification


if(!$status){
$result=["status"=>false,"message"=>"Invalid login credential"];
    echo json_encode($result);
    return;
}
if(strlen($password)<8 ||strlen($password)>20 ){
$status=false;
}
else if(!preg_match('/[A-Z]/',$password)){
$status=false;
} 
else if(!preg_match('/[\'^£$%&*()}@{#~?><>,|=_+¬-]/',$password)){
$status=false;
}
if(!$status){
$response=["status"=>false,"message"=>"Invalid Password"];
echo json_encode($response);
return;
}




try {
$statement=$pdo->prepare("select * from users where email=? and password=?");
$statement->execute([$email,md5($password)]);
$result=$statement->fetchAll(PDO::FETCH_ASSOC);



if(count($result)==0 || $result[0]['status']==0){
    $response=["status"=>false,"message"=>"Invalid login credential"];
    echo json_encode($response);
    return;  
}

$bytes = random_bytes(5);
$token=  bin2hex($bytes);
$statement2=$pdo->prepare("update users set token=? where id=?");
$statement2->execute([$token,$result[0]['id']]);



// $statement1=$pdo->prepare("select name from users where email=? and password=?");
// $statement1->execute([$email,md5($password)]);
// $result1=$statement1->fetchAll(PDO::FETCH_ASSOC);




$response=["status"=>true,"message"=>"login sucessfully","Data"=>[$token, $result[0]['name'], $result[0]['phonenumber']]];
echo json_encode($response);
}

catch (PDOException $e) {
    $response=["status"=>false,"message"=>"Can not login"];
    echo json_encode($response);
    return;


}

