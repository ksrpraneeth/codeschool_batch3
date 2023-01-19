<?php
include('dbconnect.php');
//print_r($_POST);
$POST=json_decode(file_get_contents('php://input'),true);


$response = [
    'status'=>false,
    'message'=>'',
    'data'=>null
];

if(!array_key_exists('email',$POST)){
    $response['status']=false;
    $response['message']="Please enter EMAIL";
    echo json_encode($response);
    return;
}

if(strlen($POST['email'])==0){
    $response['status']=false;
    $response['message']="Please enter EMAIL";
    echo json_encode($response);
    return;
}

if(strlen($POST['password'])==0){
    $response['status']=false;
    $response['message']="Please enter PASSWORD";
    echo json_encode($response);
    return;
}

if(!array_key_exists('password',$POST)){
    $response['status']=false;
    $response['message']="Please enter PASSWORD";
    echo json_encode($response);
    return;
}
$statement = $pdo->prepare("Select * from users where email =? and password=?");
$statement->execute([$POST['email'],md5($POST['password'])]);

$resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
// print_r($resultSet);
// die();


if(count($resultSet)==0){
    $response['status']=false;
    $response['message']="Email or Password is wrong";
    echo json_encode($response);
    return;
}


// $bytes = random_bytes(5);
// $token=  bin2hex($bytes);
// $statement = $pdo->prepare("UPDATE users set token =? where id = ?");
// $statement->execute([$token,$resultSet['id']]);
// session_start();
// $_SESSION['userdetails']=$resultSet;
$response['status'] = true;
$response['message'] = "Login successful";
$response['data'] =$resultSet;
echo json_encode($response);
return;