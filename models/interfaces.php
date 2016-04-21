<?php

defined("SCRIPT") or die;
/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 18.04.2016
 * Time: 13:38
 *
 */

/**
 * Interface base
 * Базовый интерфейс:
 * Добавление, удаление, изменение, получение записей
 */
interface base
{
    function get_name_by_id($id);

    function get_all();

    function delete($id);

    //function write($id, $name, $priority = "");

    function get_priority_by_id($id);
}