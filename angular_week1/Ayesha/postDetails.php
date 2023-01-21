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
    $ppoid = $request->ppoid;
    $pension = $request->pension;
    $dor = $request->dor;
    $startDate = $request->startDate;
    $efp = $request->efp;
    $familyPensionName = $request->familyPensionName;
    $scaleType = $request->scaleType;
    //prepare statements
    $statement = $pdo->prepare("Insert into details(ppoid,ppono,pension,dor,start_date,efp,scale_type,pension_name) values (?,?,?,?,?,?,?,?)");
    $queryResult = $statement->execute([$ppoid,$pension,$pension,$dor,$startDate,$efp,$familyPensionName,$scaleType]);
    if($queryResult){
        echo json_encode(['status'=>true, 'message'=>'User registered successfully!']);
        return;
    }
}
catch (PDOException $e) {
    echo json_encode(["status"=>false,"message"=>"not connected msg: " . $e->getMessage()]);
}