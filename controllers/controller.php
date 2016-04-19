<?php

defined("SCRIPT") or die;

require_once MODELS;

//разбирает массив гет и создает переменные


$view = ($_GET['view'] ? $_GET['view'] : "mainTable");

$do = ($_GET['do'] ? $_GET['do'] : "nothing");

switch ($view){

    case "dep":

        require_once "departament.php";

        break;

    case "client":

        require_once "client.php";

        break;

    case "mainTable":
        require_once "mainTable.php";


        break;
}

require_once (VIEW."/index.php");