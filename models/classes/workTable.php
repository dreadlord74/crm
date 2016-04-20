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
}