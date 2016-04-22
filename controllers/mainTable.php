<?php

defined("SCRIPT") or die;

$dep = new departament();

$worker = new Worker();

$client = new client();

$date = new date();

$main = new workTable();

$main_table = $mysqli->super_query("SELECT * FROM work_table");

switch ($do){

    case "write_desc":

        echo $main->write_desc($_POST[id], $_POST[description]);

        exit();
        break;

    case "write_time":
        echo $main->write_time($_POST[id], $_POST[time]);

        exit();
        break;

    case "add_work":

        echo $main->add_work($_POST[date_id], $_POST[dep_id], $_POST[client_id], $_POST[worker_id]);

        exit();
        break;

    default:

        break;
}