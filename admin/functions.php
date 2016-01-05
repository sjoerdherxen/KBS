<?php
date_default_timezone_set("Europe/Amsterdam");

function isLoggedIn() {
    return isset($_SESSION['inlog']) && $_SESSION['inlog'] != "";
}

function getUser() {
    return $_SESSION['inlog'];
}

// query op db uitvoeren
function query($query, $params) {
    try {
        // connectie maken
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        // query opbouwe;dbname=d
        $q = $pdo->prepare($query);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // uitvoeren
        $q->execute($params);
        //get results
        $result =  $q->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;// drop connection
        return $result;
    } catch (PDOException $e) {
        return null;
    }
}

function insert($query, $params) { // check query function returns id of inserted record
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        //$pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}
/*
// query op db uitvoeren
function query($query, $params) {
    try {
        // connectie maken
        $pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        // query opbouwe
        $q = $pdo->prepare($query);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // uitvoeren
        $q->execute($params);
        //get results
        $result =  $q->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;// drop connection
        return $result;
    } catch (PDOException $e) {
        return null;
    }
}

function insert($query, $params) { // check query function returns id of inserted record
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}
*/
function in_query_result($data, $search, $column) { 
// check of waarde in query result staat
//wordt gebruikt in schilderij edit/add
    foreach ($data as $item) {
        if ($item[$column] == $search) {
            return true;
        }
    }
    return false;
}
