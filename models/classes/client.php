<?php

/**
 * Created by PhpStorm.
 * User: sp
 * Date: 18.04.2016
 * Time: 15:52
 */
class client extends abstract_class implements base
{
    public function get_priority_by_id($id)
    {
        // TODO: Implement get_priority_by_id() method.
    }

    public function get_name_by_id($id)
    {
        if (!$id)
            $name = "";
        else
            $name = $this->db->super_query("SELECT name FROM clients WHERE id=".$id, false);

        return $name[name];
    }

    public function get_all()
    {
        // TODO: Implement get_all() method.

        return $this->db->super_query("SELECT * FROM clients ORDER BY priority");
    }

    public function get_color_by_id($id){
        $color = $this->db->super_query("SELECT color FROM clients WHERE id=".$id, false);

        return $color[color];
    }

    private function change_priority($id, $priority){

    }

    public function write($id, $name, $priority = "")
    {
        // TODO: Implement write() method.
    }

    public function add ($name, $date, $way, $work_type, $contract_number, $color, $text_color){

        $id = $this->db->query("INSERT INTO clients (name, `date`, way, work_type, contract_number, color, text_color) VALUES ('$name', '$way')");

    }

    public  function delete($id)
    {
        // TODO: Implement delete() method.
    }
}