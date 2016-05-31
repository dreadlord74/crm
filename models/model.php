<?php

defined ("SCRIPT") or die ("Сюда нельзя!");
/**
 * Модель системы
 */
//session_start();

require_once ("function.php");
require_once ("interfaces.php");

/**
 * Функция автозагрузки классов - не работает в текущей версии пхп
 * @param $class - имя класса
 */
function __autoload($class){
    require_once "classes/".$class.".php";
}

require_once ("classes/data_base.php");
$mysqli = new data_base();


require_once ("classes/abstract_class.php");
require_once ("classes/workTable.php");
require_once ("classes/worker.php");
require_once ("classes/client.php");
require_once ("classes/date.php");
require_once ("classes/departament.php");