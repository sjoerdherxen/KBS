<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {// get is goed
    $result = query("SELECT Schilderij_ID, titel FROM schilderij WHERE Schilderij_ID = ?", array($_GET["id"])); // check of schilderij bestaat
    $result1 = query("SELECT Id FROM commentaar WHERE Schilderijen_ID = ?", array($_GET["id"])); // check of schilderij commentaar heeft
    if (count($result == 1)) {
        // verwijderen
        if (count($result1 != 0)) {
            $to = query("SELECT email FROM schilder limit 0,1", NULL);
            $to = $to[0]['email'];
            $subject = "Al het commentaar van schilderij " . query("SELECT Titel FROM schilderij WHERE id=?", $_GET["id"]);
            $message = query("SELECT * FROM commentaar WHERE Schilderij_ID = ?", $_GET["id"]);
            $header = "From:commentaar-backup@hofvanellen.nl \r\n";
            $mailcheck = mail($to, $subject, $message, $header); // al het gegeven commentaar op het desbetreffende schilderij mailen
            if ($mailcheck) {
                query("DELETE FROM commentaar WHERE Schilderij_ID = ?", array($_GET["id"])); // het commentaar op het schilderij verwijderen
            }
        }
        query("DELETE FROM schilderij WHERE Schilderij_ID = ?", array($_GET["id"])); // het schilderij verwijderen
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
