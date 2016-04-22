<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=TITLE.($title ? " - ".$title : "")?></title>
    <link href="<?=VIEW?>/css/bootstrap.css" rel="stylesheet" />
    <link href="<?=VIEW?>/bootstrap.css" rel="stylesheet" />
    <link href="<?=VIEW?>/css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="<?=VIEW?>/js/jquery-2.0.0.min.js"></script>
    <script type="text/javascript" src="<?=VIEW?>/js/bootstrap.min.js"></script>

</head>

<body>
<?php

    require_once ($view.".php");

?>
<div class="row menu table-bordered">
    <?echo 'Памяти использовано: ',round(memory_get_usage()/1024/1024,2),' MB';?>
    <div class="col-md-12">
        <ul class="list-inline">
            <li><a href="/">Основная таблица</a> </li>
            <li><a href="/?view=dep">Отделы</a> </li>
            <li><a href="/?view=worker">Работники</a> </li>
            <li><a href="/?view=client">Клиенты</a> </li>
        </ul>
    </div>
</div>
</body>
</html>
