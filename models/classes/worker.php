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

    public $cols;

    private $dep_id;

    private $dep;

    private function dep_ini(){
        $this->dep = new departament();

        return $this->dep;
    }

    public function get_priority_by_id($id)
    {
        $priority = $this->db->super_query("SELECT priority FROM workers WHERE id=".$id, false);

        return $priority[priority];
    }

    public function get_dep_id_by_id($id){
        $res = $this->db->super_query("SELECT departament FROM workers WHERE id=".$id, false);

        return $res[departament];
    }

    public function get_name_by_id($id)
    {
        // TODO: Implement get_name_by_id() method.

        $name = $this->db->super_query("SELECT name FROM workers WHERE id=".$id, false);

        return $name[name];
    }

    public function add_column($id){
        $this->dep_ini()->change_cols_by_id($this->get_dep_id_by_id($id));
        return $this->db->query("UPDATE workers SET cols=cols+2 WHERE id=$id")->affected();
    }

    public function get_cols_by_id($id){
        $cols = $this->db->super_query("SELECT cols FROM workers WHERE id=".$id, false);

        return $cols[cols];
    }

    public function get_worker_by_date_id($id){
        return $this->db->super_query("SELECT * FROM work_table WHERE date_id=".$id);
    }

    public function get_all()
    {
        return $this->db->super_query("SELECT * FROM workers ORDER BY priority");
    }

    public function get_by_dep_id($id){
        return $this->db->super_query("SELECT * FROM workers WHERE departament=".$id." ORDER BY priority");
    }

    public function write($id, $name, $priority = "")
    {
        if ($priority != $this->get_priority_by_id($id))
            $this->change_priority($id, $priority);

        $result = $this->db->query("UPDATE workers SET name='".$name."', priority=".$priority." WHERE id=".$id)->affected();

        if ($result)
            return 1;
        else
            return 0;
    }

    /**
     * @param $id
     * @param $priority
     * Изменяет приоритет объектов
     */
    private function change_priority($id, $priority){

        //$res = $this->db->super_query("SELECT id FROM departaments WHERE priority=".$priority, false);

        $change = $this->db->super_query("SELECT id FROM workers WHERE priority >= ".$priority." AND id !=".$id." ORDER BY priority");

        $query = "UPDATE workers SET priority=priority+1 WHERE id IN (";

        if ($change){
            foreach ($change as $ch)
                $query .= $ch[id].',';

            $query = substr($query, 0, -1);

            $query .= ")";

            $this->db->query($query);
        }
    }

    public function add($name, $dep_id){
       $this->db->query("INSERT INTO workers (name, departament) VALUES ('".$name."', ".$dep_id.")")->get_last_id();

       $this->dep_ini()->change_cols_by_id($dep_id);

    }

    public function delete($id)
    {
        global $summary; global $main;

        $summary->delete_info_by_worker_id($id);
        $main->delete_by_worker_id($id);

        $this->cols = $this->get_cols_by_id($id);
        $this->dep_id = $this->get_dep_id_by_id($id);

        if ($this->db->query("DELETE FROM workers WHERE id=".$id)->affected()){
            echo $this->cols." ".$this->dep;
            $this->dep_ini()->change_cols_by_id($this->dep_id, "-", $this->cols);
        }
    }
}