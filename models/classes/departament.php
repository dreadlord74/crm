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

    public function get_by_id(&$id)
    {
        return $this->db->super_query("SELECT * FROM departaments WHERE id=$id", false);
    }

    public function get_all(){

        return $this->db->super_query("SELECT * FROM departaments ORDER BY priority");

    }

    public function get_cols_by_id($id){

    }

    public function get_priority_by_id($id){

        $priority = $this->db->super_query("SELECT priority FROM departaments WHERE id=".$id, false);

        return $priority[priority];
    }

    public function add($name){
        $query = "INSERT INTO departaments (name) VALUES ('".$name."')";

        $id = $this->db->query($query)->get_last_id();

        return array(
                "id" => $id,
                "name" => $this->get_name_by_id($id),
                "priority" => $this->get_priority_by_id($id)
               );
    }

    public function write($id, $name, $color, $text_color, $priority = ""){
        if ($priority != $this->get_priority_by_id($id))
            $this->change_priority($id, $priority);

        $result = $this->db->query("UPDATE departaments SET name='".$name."', priority=".$priority.", color='$color', text_color='$text_color' WHERE id=".$id)->affected();

        if ($result)
            return 1;
        else
            return 0;
    }

    public function delete($id){
        $result = $this->db->query("DELETE FROM departaments WHERE id=".$id)->affected();

        if ($result)
            return 1;
        else
            return 0;
    }

    private function change_priority($id, $priority){

        //$res = $this->db->super_query("SELECT id FROM departaments WHERE priority=".$priority, false);

        $change = $this->db->super_query("SELECT id FROM departaments WHERE priority >= ".$priority." AND id !=".$id." ORDER BY priority");

        $query = "UPDATE departaments SET priority=priority+1 WHERE id IN (";

        if ($change){
            foreach ($change as $ch)
                $query .= $ch[id].',';

            $query = substr($query, 0, -1);

            $query .= ")";

            $this->db->query($query);
        }
    }

    public function change_cols_by_id($id, $znak = "+", $count = 2){
        switch ($znak){
            case "+":
                $this->db->query("UPDATE departaments SET cols=cols+".$count." WHERE id=".$id);

                break;

            case "-":
                $this->db->query("UPDATE departaments SET cols=cols-".$count." WHERE id=".$id);
                 echo "-";
                break;
        }
    }
}