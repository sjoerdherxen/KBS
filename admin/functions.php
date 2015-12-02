<?php

function isLoggedIn() {
    return isset($_SESSION['inlog']) && $_SESSION['inlog'] != "";
}

function getUser() {
    return $_SESSION['inlog'];
}

function query($query, $params) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $q->fetchAll();
    } catch (PDOException $e) {
        return null;
    }
}

function insert($query, $params) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}

function in_query_result($data, $search, $column) {
    foreach ($data as $item) {
        if ($item[$column] == $search) {
            return true;
        }
    }
    return false;
}
