<?php

defined("SCRIPT") or die;

$worker = new worker();

$dep = new departament();

switch ($do){

    case "add":

        if ($_POST[submit]){
            $worker->add($_POST['mname'], $_POST[dep]);
            unset($_POST[submit]);
        }

        $view = "worker/view";

        break;

    case "del":

        echo $worker->delete($_POST[id]);

        exit();
        break;

    case "write":

        echo $worker->write($_POST[id], $_POST[name], $_POST[prior]);

        exit();
        break;

    default:

        $view = "worker/view";

        break;
}