<?php
session_start();
require 'functions.php';
if (!isLoggedIn()) {
    header("location: index.php");
}
require '../htmlHelpers.php';
renderHtmlStartAdmin("Categorie&euml;", '');


$uitvoerDatabase = query("SELECT * FROM Categorie WHERE Categorie_naam = ?", NULL);

?>

    <?php
    renderHtmlEndAdmin();

    /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

