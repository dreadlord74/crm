<?php

defined("SCRIPT") or die;

$summary = new summary();

switch ($do){

    case "write_e_date":
        echo $summary->write_e_date($_POST[id], $_POST[end_date]);

        exit();
        break;

    case "write_b_date":
        echo $summary->write_b_date($_POST[id], $_POST[begin_date]);

        exit();
        break;

    case "write_hours":
        echo $summary->write_hours($_POST[id], $_POST[hours]);

        exit();
        break;

    default:
        $client = new client();
        $date = new date();
        $dep = new departament();
        $worker = new worker();
        $workTable = new workTable();

        $view = "summary/view";

        break;
}