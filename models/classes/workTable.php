<?php

/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 19.04.2016
 * Time: 11:24
 */
class workTable extends abstract_class
{
    public function get_work_by_worker_id_date_id($w_id, $d_id){
        return $this->db->super_query("SELECT * FROM work_table WHERE date_id=".$d_id." AND worker_id=".$w_id);
    }

    public function write_desc($id, $desc){
        return $this->db->query("UPDATE work_table SET description='$desc' WHERE id=$id")->affected();
    }

    public function write_time($id, $time){
        return $this->db->query("UPDATE work_table SET time='$time' WHERE id=$id")->affected();
    }

    public function add_date($last_date){

        $time = (strtotime(date("d-m-Y")) - strtotime($last_date));

        if (FUTURE_DATES - ($time/60/60/24) < FUTURE_DATES){
            global $date;

            $date_ids = array();

            for ($i = 1; $i <= FUTURE_DATES-($time/60/60/24); $i++) {
                $date_ids[] = $date->add(date('Y-m-d', strtotime($last_date . " +" . $i . " day")));
                //echo date("d m Y", strtotime("$last_date + $i day"));
            }
            return $date_ids;
        }
    }


}