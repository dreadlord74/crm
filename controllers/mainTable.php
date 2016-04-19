<?php

defined("SCRIPT") or die;

$dep = new departament();

$worker = new Worker();

$client = new client();

$main_table = $mysqli->super_query("SELECT * FROM work_table");