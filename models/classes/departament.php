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

        return $this->db->super_query("SELECT * FROM departaments ORDER BY priority");

    }

    public function get_cols_by_id($id){

    }

    public function add($name){
        $query = "INSERT INTO departaments (name) VALUES ('".$name."')";

        $id = $this->db->query($query)->get_last_id();

        $name = $this->get_name_by_id($id);

        $mass = array(
            "id" => $id,
            "name" => $name
        );

        return $mass;
    }

    public function write($id, $name){
        $result = $this->db->query("UPDATE departaments SET name='".$name."' WHERE id=".$id)->affected();

        if ($result)
            return 1;
        else
            return 0;
    }

    public function delete($id){
        $result = $this->db->query("DELETE FROM departaments WHERE id=".$id)->affected();

        /*if ($result)
            return 1;
        else
            return 0;*/

        return $result;
    }
}