<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("inlog", "");


echo "welkom: " . getUser();
?>


<?php

//require "schilderijList.php";

renderHtmlEndAdmin();

