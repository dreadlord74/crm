<?php

defined("SCRIPT") or die;

require_once MODELS;

$view = ($_GET['view'] ? $_GET['view'] : "mainTable");

$do = ($_GET['do'] ? $_GET['do'] : "nothing");

switch ($view){

    case "dep":

        $title = "Отделы";

        require_once "departament.php";

        break;

    case "client":
        $title = "Клиенты";

        require_once "client.php";

        break;

    case "worker":

        $title = "Работники";

        require_once "worker.php";

        break;

    case "mainTable":
        require_once "mainTable.php";


        break;
}

require_once (VIEW."/index.php");