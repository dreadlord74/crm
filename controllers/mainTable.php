<?php

defined("SCRIPT") or die;

$dep = new departament();

$worker = new Worker();

$client = new client();

$date = new date();

$main = new workTable();

$main_table = $mysqli->super_query("SELECT * FROM work_table");