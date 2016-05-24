<?php

/**
 * Created by PhpStorm.
 * User: sp
 * Date: 18.04.2016
 * Time: 15:52
 */
class client extends abstract_class implements base
{
	public $id;
	public $work_type;
	public $name;
	public $way;
	public $text_color;
	public $date;
	public $color;
	public $contract_number;
	public $deadline_id = NULL;
	
	public function set_vars(&$id, $deadline_id = NULL){
		$this->id = $id;
		$this->name = $this->get_name_by_id($id);
		$this->color = $this->get_color_by_id($id);
		$this->contract_number = $this->get_contract_number_by_id($id);
		$this->date = $this->get_date_by_id($id);
		$this->text_color = $this->get_text_color_by_id($id);
		$this->work_type = work_type($this->get_work_type_by_id($id));
		$this->way = $this->get_way_by_id($id);
		
		if ($deadline_id)
			$this->deadline_id = $deadline_id;		
	}

    public function get_ids()
    {
        return $this->db->super_query("SELECT id FROM clients");
    }

    public function get_by_id(&$id)
    {
        return $this->db->super_query("SELECT * FROM clients WHERE id=$id", false);
    }

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
        return $this->db->super_query("SELECT * FROM clients WHERE id !=-1 ORDER BY priority");
    }

    public function search($search){
        $result = $this->db->super_query("SELECT * FROM clients WHERE (name LIKE '%$search%' OR clients.name LIKE '$search%' OR clients.name LIKE '%$search') AND id != -1");
		
		foreach ($result as $key => $value)
			$result[$key][work_type] = work_type($value[work_type]);
		
		return $result;
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
	
	private function get_date_by_id(&$id){
		$date = $this->db->super_query("SELECT date FROM clients WHERE id=$id", false);
		return $date[date];
	}

    public function get_way_by_id($id){
        $way = $this->db->super_query("SELECT way FROM clients WHERE id=$id", false);

        return $way[way];
    }

    public function get_work_type_by_id($id){
        $work_type = $this->db->super_query("SELECT work_type FROM clients WHERE id=$id", false);

        return work_type($work_type[work_type]);
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
            $this->db->query("INSERT INTO summary (client_id) VALUES ({$this->db->get_last_id()})");
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