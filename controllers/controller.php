<?php

defined("SCRIPT") or die;

require_once MODELS;

$mysqli = new data_base();

$view = ($_GET['view'] ? $_GET['view'] : "mainTable");

switch ($view){

    case "mainTable":

        break;
}

require_once (VIEW."/index.php");