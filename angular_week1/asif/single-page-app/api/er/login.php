<?php

include 'dbconnection.php';
include 'response.php';

$post = (array) json_decode(file_get_contents("php://input"));

try {
    // fetch data from database to check valid details or not
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$post['email'], md5($post['password'])]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // if not valid, return
    if(count($result) == 0) {
        $response['status'] = false;
        $response['message'] = 'Invalid Email or Password!';
        echo json_encode($response);
        return;
    }
    
    
    // if valid update status, token, last login
    // $id = $result[0]['id'];
    // $bytes = random_bytes(5);
    // $token = bin2hex($bytes);
    // $query = "UPDATE users SET status = 1, token = ?, last_login = CURRENT_TIMESTAMP WHERE id = ?";
    // $statement = $pdo->prepare($query);
    // $statement->execute([$token, $id]);

    // get data for the user to send it to frontend 
    // $query = "SELECT name, token, DATE_FORMAT(last_login, '%d-%b-%Y') as date, DATE_FORMAT(last_login, '%h:%i %p') as time FROM users WHERE id = ?";
    // $statement = $pdo->prepare($query);
    // $statement->execute([$id]);
    // $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $response['status'] = true;
    $response['message'] = 'Login Success!';
    $response['data'] = $result;
    
} catch(PDOException $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
return;

?>