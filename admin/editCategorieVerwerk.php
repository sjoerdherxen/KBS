<?php

session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}

