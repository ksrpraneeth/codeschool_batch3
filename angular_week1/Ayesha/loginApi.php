<?php
session_start();
include "db.php";
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
//request data sent from front end(usernme and pw)
try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    // make a database connection
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //echo "connected";
    $username = $request->username;
$password = $request->password;
    //prepare statements
    $statement = $pdo->prepare("select * from users where username=? and password= ?");
    $statement->execute([$username,$password]);
    $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
    //check if present in database
    if (count($resultSet) == 0) {
    echo json_encode(['status'=>false, 'message'=>'Username or password incorrect!']);
        return;
    } 
    $row=$resultSet[0];
    $_SESSION["userId"] = $row["id"];
        echo json_encode(['status' => true, 'message' => 'Login successful!','data'=>[$resultSet]]);
        return;
} 
catch (PDOException $e) {
    echo json_encode(["status"=>false,"message"=>"not connected"]);
}

