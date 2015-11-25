<?php
function isLoggedIn(){
    return isset($_SESSION['inlog']) && $_SESSION['inlog'] != "";
}

function getUser(){
    return $_SESSION['inlog'];
}

function query($query, $params){
    $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
    $q = $pdo->prepare($query);
    //foreach ($params as $index => $value){
    //    $q->bindParam($index, $value);
    //}
    $q->execute($params);
    return $q->fetchAll();
}