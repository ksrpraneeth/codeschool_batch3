<?php

$dbServer = '172.105.41.146';
$dbDatabase = 'organization';
$dbPort = '5432';
$dbUsername = 'postgres';
$dbPassword = '@Himesh69';
$dsn = "pgsql:host=$dbServer;dbname=$dbDatabase;port=$dbPort;";


// make a database connection using pdo
try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch(PDOException $e) {
    die($e->getMessage());
}

?>