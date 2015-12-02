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
function printteken($aantal,$teken) {
    for ($i = 0; $i < $aantal; $i++) {
        print($teken);
    }
}