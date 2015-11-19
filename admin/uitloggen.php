<?php
session_start();
include 'functions.php';

$_SESSION["inlog"] = "";
header("location: index.php");

?>