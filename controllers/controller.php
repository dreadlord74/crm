<?php

defined("SCRIPT") or die;

require_once MODELS;

//разбирает массив гет и создает переменные


$view = ($_GET['view'] ? $_GET['view'] : "mainTable");

$do = ($_GET['do'] ? $_GET['do'] : "nothing");

switch ($view){

    case "dep":
        echo 123;
        require_once CONTROLLERS."departament.php";

        break;

    case "mainTable":

        break;

    default:
        $view = "mainTable";
}

require_once (VIEW."/index.php");