<?php

/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 19.04.2016
 * Time: 11:18
 * Класс для работы с таблицой dates
 */
class date extends abstract_class
{
    public function get_all(){
        return $this->db->super_query("SELECT * FROM dates");
    }
}