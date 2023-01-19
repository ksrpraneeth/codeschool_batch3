<?php
include('dbconnect.php');


$response = [
    'status'=>false,
    
    'data'=>null
];
$statement = $pdo->prepare("select productimg,productname,price,productid from Products");
$statement->execute();
$result = $statement->fetchall(PDO::FETCH_ASSOC);
if($result){
    $response['status']=True;
    $response['output']=$result;
    echo json_encode($response);
    return;
}