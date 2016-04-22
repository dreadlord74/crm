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
        return $this->db->super_query("SELECT * FROM clients ORDER BY priority");
    }

    public function search($search){
        return $this->db->super_query("SELECT * FROM clients WHERE name LIKE '%$search%' OR clients.name LIKE '$search%' OR clients.name LIKE '%$search'");
    }

    public function get_color_by_id($id){
        $color = $this->db->super_query("SELECT color FROM clients WHERE id=".$id, false);

        return $color[color];
    }

    public function get_text_color_by_id($id){
        $color = $this->db->super_query("SELECT text_color FROM clients WHERE id=".$id, false);

        return $color[text_color];
    }

    private function change_priority($id, $priority){

    }

    public function get_way_by_id($id){
        $way = $this->db->super_query("SELECT way FROM clients WHERE id=$id", false);

        return $way[way];
    }

    public function get_work_type_by_id($id){
        $work_type = $this->db->super_query("SELECT work_type FROM clients WHERE id=$id", false);

        return $work_type[work_type];
    }

    public function get_contract_number_by_id($id){
        $contract_number = $this->db->super_query("SELECT contract_number FROM clients WHERE id=$id", false);

        return $contract_number[contract_number];
    }

    public function write($id, $name, $way, $work_type, $color, $text_color, $date, $contract_number)
    {
        return $this->db->query("UPDATE clients SET name='$name', way='$way', work_type='$work_type', color='$color', text_color='$text_color', date='$date', contract_number='$contract_number' WHERE id=$id")->affected();
    }

    public function add ($name, $way, $work_type, $color, $text_color, $date, $contract_number){

        $id = $this->db->query("INSERT INTO clients (name, `date`, way, work_type, contract_number, color, text_color) VALUES ('$name', '$date', '$way', '$work_type', '$contract_number', '$color', '$text_color')");

        if ($id){
            return 1;
        }else{
            return 0;
        }
    }

    public  function delete($id)
    {
        // TODO: Implement delete() method.
    }
}