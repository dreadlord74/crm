<?php

defined("SCRIPT") or die;

$dep = new departament();

switch ($do){
    case "add":

        $dep->add($_POST[name]);
        exit();

        break;

    case "view_add":

        $view = "/departament/".$do;

        break;

    default:

        $view = "departament/view";
}