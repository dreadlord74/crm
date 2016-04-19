<?php
/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 18.04.2016
 * Time: 12:33
 */

defined("SCRIPT") or die;

class worker extends abstract_class implements base {
    public $id;
    public $color;

    private $dep_id;

    private $post_id;

    public function get_name_by_id($id)
    {
        // TODO: Implement get_name_by_id() method.

        $name = $this->db->super_query("SELECT name FROM workers WHERE id=".$id, false);

        return $name[name];
    }

    public function get_all()
    {
        // TODO: Implement get_all() method.

        return $this->db->super_query("SELECT * FROM workers");
    }

    public function get_by_dep_id($id){
        return $this->db->super_query("SELECT * FROM workers WHERE departament=".$id);
    }
}