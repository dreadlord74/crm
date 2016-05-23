<?php

/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 19.04.2016
 * Time: 11:18
 * Класс для работы с таблицой dates
 */
class date extends abstract_class
{
    public function get_all(){
        return $this->db->super_query("SELECT * FROM dates");
    }

    public function add($date){
        $is_work = ((get_day_of_week($date) == "вс" || get_day_of_week($date) == "сб") ? "0" : "1");

        return $this->db->query("INSERT INTO dates (date, is_work_day) VALUES ('$date', '$is_work')")->get_last_id();
    }

    public function get_by_ids($ids){
         if (count($ids) != 0) {
             return $this->db->super_query("SELECT * FROM dates WHERE id IN (" . implode(", ", $ids) . ")");
         }
    }

    public function limit_get($offset, $limit = 100){
        return $this->db->super_query("SELECT * FROM dates LIMIT $offset,$limit");
    }

	public function first_get(){
		return $this->db->super_query("SELECT * FROM dates WHERE date > DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND date < DATE_ADD(CURDATE(), INTERVAL 4 MONTH)");
	}
	
	public function get_deadline_by_date_id(&$id){
		$result = $this->db->super_query("SELECT id, client_id FROM deadlines WHERE date_id=$id", false);
		//echo $result[client_id];
		
		
		
		if (count($result) > 0){
			global $client;
			
			$client->set_vars($result[client_id], $result[id]);
			
			return $client;
		}else
			return false;
	}
	
	public function add_deadline(&$client_id, &$date_id){
		$id = $this->db->query("INSERT INTO deadlines (client_id, date_id) VALUES ('$client_id', '$date_id')")->get_last_id();
		
		global $client;
		
		$client->set_vars($client_id);
		
		return array(
			"cid" => $client->id,
			"did" => $id,
			"name" => $client->name,
			"color" => $client->color,
			"text_color" => $client->text_color,
			"way" => $client->way
		);
	}
	
	public function delete_deadline(&$id){
		return $this->db->query("DELETE FROM deadlines WHERE id=$id")->affected();
	}
}