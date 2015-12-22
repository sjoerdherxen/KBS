<?php
session_start();
include 'functions.php';

// uitloggen sessie verbreken
$_SESSION["inlog"] = "";
session_destroy();
header("location: index.php");

?>