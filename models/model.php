<?php

defined ("SCRIPT") or die ("Сюда нельзя!");
/**
 * Модель системы
 */
session_start();

require_once ("classes/data_base.php");
$mysqli = new data_base();

require_once ("classes/worker.php");
require_once ("classes/departament.php");
