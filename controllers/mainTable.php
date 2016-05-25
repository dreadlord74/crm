<?php

defined("SCRIPT") or die;

$dep = new departament();

$worker = new Worker();

$client = new client();

$date = new date();

$main = new workTable();

switch ($do){

    case "get_next_dates":

        echo $date->get_next_dates($_POST[last_date]);

        exit();
        break;

    case "write_desc":

        echo $main->write_desc($_POST[id], $_POST[description]);

        exit();
        break;

    case "write_work":

        echo $main->write_work($_POST[id], $_POST[client_id]);

        exit();
        break;

    case "write_time":
        echo $main->write_time($_POST[id], $_POST[time]);

        exit();
        break;

    case "add_work":

        echo json_encode($main->add_work($_POST[date_id], $_POST[dep_id], $_POST[client_id], $_POST[worker_id]));

        exit();
        break;

    case "change_text":

        echo $main->change_text($_POST[id], $_POST[date_id], $_POST[dep_id], $_POST[worker_id], $_POST[text]);

        exit();
        break;

    case "delete":

        echo $main->delete($_POST[id]);

        exit();
        break;
	
	case "add_deadline":
	
		echo json_encode($date->add_deadline($_POST[client_id], $_POST[date_id]));
	
		exit();
		break;
		
	case "delete_deadline":
		
		echo $date->delete_deadline($_POST[id]);
		
		exit(); 
		break;

    default:
	
		$main_table = $mysqli->super_query("SELECT * FROM work_table");

        break;
}