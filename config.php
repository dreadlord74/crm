<?php
defined ("SCRIPT") or die ("Сюда нельзя!");
//домен
define("PATH", "http://192.168.1.45/");
//модель
define("MODELS", "models/model.php");
//классы
define("CLASSES", "models/classes/");
//контроллер
define("CONTROLLER", "controllers/controller.php");

//контроллеры
define("CONTROLLERS", "controllers/");
//виды
define("VIEW", "views/default");
//сервер
define("HOST", "127.0.0.1");
//пользователь
define("USER", "root");
//пароль
define("PASS", "890888");
//имя бд
define("DB", "crm");

//сколько дат будет выводиться после текущей
define("FUTURE_DATES", 230);

//Название
define("TITLE","ЦРМ");

//Токен для доступа к аккуанту
error_reporting ( E_ALL ^ E_NOTICE);