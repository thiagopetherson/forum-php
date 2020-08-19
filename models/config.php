<?php

$param = "mysql:dbname=forum;dbhost=localhost";
$dbUser = "root";
$dbPass = "";

try{
    $pdo = new PDO($param, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("PDO Fail to connect DB" . $e->getMessage());
}


?>