<?php
defined ("SCRIPT") or die ("Сюда нельзя!");
//домен
define("PATH", "http://localhost/crm/");
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

//Название
define("TITLE","ЦРМ");

//Токен для доступа к аккуанту
error_reporting ( E_ALL ^ E_NOTICE);