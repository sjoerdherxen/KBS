<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $result = query("SELECT schilderij_id FROM schilderij WHERE schilderij_id = ?", array($_GET["id"]));
    if (count($result == 1)) {
        query("DELETE FROM schilderij WHERE schilderij_id = ?", array($_GET["id"]));
        header("location: schilderijList.php");
        exit();
    } else {
        header("location: schilderijList.php");
        exit();
    }
}
header("location: schilderijList.php");
exit();


// todo: add message for success/fail