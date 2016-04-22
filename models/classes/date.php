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

    public function add($date){
        $is_work = ((get_day_of_week($date) == "вс" || get_day_of_week($date) == "сб") ? "0" : "1");

        return $this->db->query("INSERT INTO dates (date, is_work_day) VALUES ('$date', '$is_work')")->get_last_id();
    }

    public function get_by_ids($ids){
         if (count($ids) != 0) {
             return $this->db->super_query("SELECT * FROM dates WHERE id IN (" . implode(", ", $ids) . ")");
         }
    }
}