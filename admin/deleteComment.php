<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "false";
    exit();
}

$result = query("SELECT COUNT(*) c FROM commentaar WHERE Id = ?", [$_GET["id"]]);
if($result[0]["c"] == 1){
    query("DELETE FROM commentaar WHERE Id = ?", [$_GET["id"]]);
    echo "true";
    exit();
}
echo "false";
