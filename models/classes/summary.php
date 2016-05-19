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
}