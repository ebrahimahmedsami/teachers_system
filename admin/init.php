<?php

include 'connect.php';

//Routes

$tpl = "includes/templates/"; //templates directory
$css = "layout/css/"; //css directory
$js = "layout/js/"; //css directory
$func = "includes/functions/"; //functions directory
//important files

include $func . "functions.php";
include "includes/languages/english.php";
include $tpl . "header.php";
if (!isset($nonavbar)) { include $tpl . "navbar.php"; }
