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
        //$pdo = new PDO("mysql:host=localhost;dbname=dirvan2_schilderijen;port=3306", "dirvan2_admin", "hEwhBPLqGv6kbkF");
        $q = $pdo->prepare($query);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // uitvoeren
        $q->execute($params);
        //get results
        $result = $q->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null; // drop connection
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

function uploadSchilderijImg($id, $imgExtension, $old) {
    if ($old != null) {
        if (file_exists("./../content/uploads/" . $old)) {
            unlink("./../content/uploads/" . $old);
        }
        if (file_exists("./../content/uploads/small_" . $old)) {
            unlink("./../content/uploads/small_" . $old);
        }
    }

    $newpath = "./../content/uploads/" . $id . $imgExtension;
    $smallpath = "./../content/uploads/small_" . $id . $imgExtension;

    query("UPDATE schilderij SET Img = ? WHERE Schilderij_ID = ?", array($id . $imgExtension, $id));

    move_uploaded_file($_FILES["img"]["tmp_name"], $newpath);
    copy($newpath, $smallpath);

    list($width, $height) = getimagesize($smallpath);
    $newwidth = 228;
    $newheight = $height / ($width / $newwidth);
    
    $src = imagecreatefromjpeg($smallpath);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagejpeg($src, $smallpath, 30);
}
