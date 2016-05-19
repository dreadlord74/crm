<?php

defined("SCRIPT") or die;

$dep = new departament();

switch ($do){
    case "add":

        echo json_encode($dep->add($_POST[name]));
        exit();

        break;

    case "view_add":

        $view = "/departament/".$do;

        break;

    case "write":

        echo $dep->write($_POST[id], $_POST[name], $_POST[color], $_POST[text_color], $_POST[prior]);

        exit();
        break;

    case "del":

        echo $dep->delete($_POST[id]);

        exit();
        break;

    default:

        $view = "departament/view";
}