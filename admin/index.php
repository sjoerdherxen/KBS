<?php

session_start();
require 'functions.php';
require '../htmlHelpers.php';
renderHtmlStart("inlog", '<link href="../content/admin.css" type="text/css" rel="stylesheet">');

if (isLoggedIn()) {
    header("location: main.php");
} else {
    include 'inlog.php';
}

renderHtmlEnd();
?>
