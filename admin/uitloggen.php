<?php
session_start();
include 'functions.php';

$_SESSION["inlog"] = "";
session_destroy();
header("location: index.php");

?>