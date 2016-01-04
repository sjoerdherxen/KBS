<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {// get is goed
    $result = query("SELECT Schilderij_ID, titel FROM schilderij WHERE Schilderij_ID = ?", array($_GET["id"])); // check of schilderij bestaat
    if (count($result == 1)) {
         // verwijderen
        query("DELETE FROM schilderij WHERE Schilderij_ID = ?", array($_GET["id"]));
        header("location: schilderijList.php#Schilderij " . $result[0]["titel"] . " is verwijderd!");
        exit();
    } else {
         // schilderij bestaat niet
        header("location: schilderijList.php#Schilderij " . $result[0]["titel"] . " verwijderen is mislukt!");
        exit();
    }
}
header("location: schilderijList.php");
exit();
