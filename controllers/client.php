<?php

defined("SCRIPT") or die;

$client = new client();

switch ($do){
    case "add":
        if ($_POST[submit]){
            $summary = new summary();

            $client->add($_POST[name], $_POST[way], $_POST[work_type], $_POST[color], $_POST[text_color], $_POST[date], $_POST[contract_number]);
            unset($_POST[submit]);
        }

        $view = "client/view";
        break;

    case "write":

        echo $client->write($_POST[id], $_POST[name], $_POST[way], $_POST[work_type], $_POST[color], $_POST[text_color], $_POST[date], $_POST[contract_number]);

        exit();
        break;

    case "get_clients":

        echo json_encode($client->search($_POST[search]));

        exit();
        break;

    default:
        $view = "client/view";

        break;
}