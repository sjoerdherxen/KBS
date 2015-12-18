<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("inlog", "","main");


echo "<h2>welkom: " . getUser()."</h2>";
?>

<?php

//require "schilderijList.php";

renderHtmlEndAdmin();

