<?php
/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 18.04.2016
 * Time: 13:25
 */

class departament extends abstract_class implements base{
    public $id;
    public $name;

    public function get_name_by_id($id)
    {
        // TODO: Implement get_name_by_id() method.

        $name = $this->db->super_query("SELECT name FROM departaments WHERE id=".$id, false);

        return $name[name];
    }

    public function get_all(){


        $query = "SELECT * FROM departments";

        return $this->db->super_query($query);

    }

    public function add($name){
        $query = "INSERT INTO departament ('name') VALUES ".$name;

        $this->db->query($query);
        return $this;
    }
}