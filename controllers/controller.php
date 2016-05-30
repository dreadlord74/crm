<?php

defined("SCRIPT") or die;

require_once MODELS;

//clear($_POST); clear($_GET);

$view = ($_GET['view'] ? $_GET['view'] : "mainTable");

$do = ($_GET['do'] ? $_GET['do'] : "nothing");

$work_type = array(
    1 => "Сайт",
    2 => "СЕО",
    3 => "Реклама",
    4 => "Доработки"
);

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

    case "summary":
        $title = "Сводная";

        require_once "summary.php";

        break;

    case "mainTable":
        require_once "mainTable.php";

        break;
}

unset($do, $mysqli);

require_once (VIEW."/index.php");