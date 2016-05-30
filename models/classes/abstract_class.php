<?php

defined("SCRIPT") or die;

/**
 * Class abstract_class
 * Пока не знаю зачем он абстрактный
 */
abstract class abstract_class{
    protected $db;


    /**
     * abstract_class constructor.
     * Вносит объект БД в класс
     */
    function __construct()
    {
        global $mysqli;

        $this->db = $mysqli;
    }

    /**
     * @param $id
     * @param $priority
     * Изменяет приоритет объекта
     */
    private function change_priority($id, $priority){}
}