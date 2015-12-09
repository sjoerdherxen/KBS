<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function printspace($aantal) {
    for ($i = 0; $i < $aantal; $i++) {
        print(" ");
    }
}

function printteken($aantal, $teken) {
    for ($i = 0; $i < $aantal; $i++) {
        print($teken);
    }
}

function query($query, $params) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=databasekps01;port=3307", "root", "usbw");
        $q = $pdo->prepare($query);
        $q->execute($params);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function checkCaptcha($captchaInput) {


    $clientIp = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $postfields = array(
        "secret" => "6LdBuRITAAAAADrYsJ3kWF89lQixPx0MntyZYVX0",
        "response" => $captchaInput,
        "remoteip" => $clientIp
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = json_decode(curl_exec($ch));

    return $response->success == true;
}
