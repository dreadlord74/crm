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
	/**
	 * @return array
	 * Возвращает массив всех дат
	 */
    public function get_all(){
        return $this->db->super_query("SELECT * FROM dates");
    }

	/**
	 * @param $date
	 * @return int
	 * Добавляет дату
	 */
    public function add($date){
        $is_work = ((get_day_of_week($date) == "вс" || get_day_of_week($date) == "сб") ? "0" : "1");

        return $this->db->query("INSERT INTO dates (date, is_work_day) VALUES ('$date', '$is_work')")->get_last_id();
    }

	/**
	 * @param $ids
	 * @return array
	 * Возвращает массив дат
	 */
    public function get_by_ids($ids){
         if (count($ids) != 0) {
             return $this->db->super_query("SELECT * FROM dates WHERE id IN (" . implode(", ", $ids) . ")");
         }
    }

	/**
	 * @param $offset
	 * @param int $limit
	 * @return array
	 * Возвращает массив дат по заданным параметрам
	 */
    public function limit_get($offset, $limit = 100){
        return $this->db->super_query("SELECT * FROM dates LIMIT $offset,$limit");
    }

	/**
	 * @return array
	 * Возвращает массив дат по интервалу, заданному в конфиге
	 */
	public function first_get(){
		return $this->db->super_query("SELECT * FROM dates WHERE date > DATE_SUB(CURDATE(), INTERVAL ".LAST_MONTHS." MONTH) AND date < DATE_ADD(CURDATE(), INTERVAL ".NEXT_MONTHS." MONTH)");
	}

	/**
	 * @param $last_id
	 * @return string
	 * Возвращает массив дат по заданному смещению
	 */
	public function get_next_dates(&$last_id)
	{
		return json_encode($this->db->super_query("SELECT * FROM dates WHERE id > $last_id LIMIT 100"));
	}

	/**
	 * @param $id
	 * @return bool|client
	 * Проверяет есть ли дедлайн в текущей дате и, если он есть,
	 * возвращает объект клиента
	 */
	public function get_deadline_by_date_id(&$id){
		$result = $this->db->super_query("SELECT id, client_id FROM deadlines WHERE date_id=$id", false);
		
		if (count($result) > 0){
			global $client;
			
			$client->set_vars($result[client_id], $result[id]);
			
			return $client;
		}else
			return false;
	}

	/**
	 * @param $client_id
	 * @param $date_id
	 * @return array
	 * Устанавливает дедлайн
	 */
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

	/**
	 * @param $id
	 * @return int
	 * Удаляет дедлайн
	 */
	public function delete_deadline(&$id){
		return $this->db->query("DELETE FROM deadlines WHERE id=$id")->affected();
	}

	/**
	 * @param $id
	 * @param int $value
	 * @return int
	 * Делает день рабочим/нерабочим
	 */
	public function change_work_day(&$id, &$value = 1)
	{
		return $this->db->query("UPDATE dates SET is_work_day='$value' WHERE id=$id")->affected();
	}
}