<?php
function isLoggedIn(){
    return isset($_SESSION['inlog']) && $_SESSION['inlog'] != "";
}

function getUser(){
    return $_SESSION['inlog'];
}

