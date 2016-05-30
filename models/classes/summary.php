<?php

defined("SCRIPT") or die("");

/**
 * Created by PhpStorm.
 * User: Хандысь Данил
 * Date: 19.05.2016
 * Time: 16:36
 */
class summary extends abstract_class
{
    public function get_all()
    {
        return $this->db->super_query("SELECT * FROM summary WHERE is_archive='0'");
    }

    public function get_ids()
    {
        return $this->db->super_query("SELECT id FROM summary WHERE is_archive='0'");
    }

    public function write_e_date(&$id, &$date)
    {
        $client_id = $this->db->super_query("SELECT client_id FROM summary WHERE id=$id", false);
        $this->db->query("DELETE FROM deadlines WHERE client_id={$client_id[client_id]}");
        $ids = $this->db->super_query("SELECT id FROM dates WHERE date='$date'", false);
        $ids = $ids[id];
        $this->db->query("INSERT INTO deadlines (client_id, date_id) VALUES ('{$client_id[client_id]}', ".$ids.")");
        return $this->db->query("UPDATE summary SET end_date='$date' WHERE id=$id")->affected();
    }

    public function write_b_date(&$id, &$date)
    {
        return $this->db->query("UPDATE summary SET begin_date='$date' WHERE id=$id")->affected();
    }

    public function write_hours(&$id, &$hours)
    {
        return $this->db->query("UPDATE summary SET hours=$hours WHERE id=$id")->affected();
    }

    public function get_info_by_id(&$id)
    {
        return $this->db->super_query("SELECT * FROM summary_info WHERE summary_id=$id");
    }

    public function calc_work_by_dates_id(&$dates_id, &$clietn_id, &$worker_id)
    {
        $res = $this->db->super_query("SELECT sum(time) as summa FROM work_table WHERE date_id IN(".implode(" ,", $dates_id).")
                                            AND client_id=$clietn_id AND worker_id=$worker_id",false);
        return $res[summa];
    }

    public function delete_info_by_worker_id(&$id)
    {
        return $this->db->query("DELETE FROM summary_info WHERE worker_id=$id")->affected();
    }

    public function write_plan_h(&$sum_id, &$worker_id, &$value)
    {
        return $this->db->query("UPDATE summary_info SET plan_hours=$value WHERE summary_id=$sum_id AND worker_id=$worker_id")->affected();
    }

    public function write_days(&$sum_id, &$worker_id, &$date, &$value, $offset = 0)
    {
        $value += $offset;

        $res = $this->db->super_query("SELECT date FROM dates WHERE date>'$date' AND is_work_day!='0' ORDER BY date LIMIT $value");

        $res = array_pop($res);

        $value -= $offset;

        $this->db->query("UPDATE summary_info SET days_count=$value, date_end='{$res[date]}' WHERE summary_id=$sum_id AND worker_id=$worker_id");

        return change_date_view($res[date]);
    }
}