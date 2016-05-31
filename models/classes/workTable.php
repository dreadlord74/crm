<?php

/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 19.04.2016
 * Time: 11:24
 */

/**
 * Class workTable
 * Класс для работы с основной таблицей
 */
class workTable extends abstract_class
{
    /**
     * @param $w_id
     * @param $d_id
     * @return array
     * Возвращает работу для работника за конкретную дату
     */
    public function get_work_by_worker_id_date_id($w_id, $d_id){
        return $this->db->super_query("SELECT * FROM work_table WHERE date_id=".$d_id." AND worker_id=".$w_id);
    }

    /**
     * @param $id
     * @param $desc
     * @return int
     * Изменяет описание работы
     */
    public function write_desc($id, $desc){
        return $this->db->query("UPDATE work_table SET description='$desc' WHERE id=$id")->affected();
    }

    /**
     * @param $id
     * @param $time
     * @return int
     * Изменяет время работы
     */
    public function write_time($id, $time){
        return $this->db->query("UPDATE work_table SET time=$time WHERE id=$id")->affected();
    }

    /**
     * @param $last_date
     * @return array
     * Вроде не используется
     */
    public function add_date($last_date){

        $time = (strtotime(date("d-m-Y")) - strtotime($last_date));

        if (FUTURE_DATES - ($time/60/60/24) < FUTURE_DATES){
            global $date;

            $date_ids = array();

            for ($i = 1; $i <= FUTURE_DATES-($time/60/60/24); $i++) {
                $date_ids[] = $date->add(date('Y-m-d', strtotime($last_date . " +" . $i . " day")));
                //echo date("d m Y", strtotime("$last_date + $i day"));
            }
            return $date_ids;
        }
    }

    /**
     * @param $date_id
     * @param $dep_id
     * @param $client_id
     * @param $worker_id
     * @param string $time
     * @param string $desc
     * @return array
     * Добавляе работу
     */
    public function add_work($date_id, $dep_id, $client_id, $worker_id, $time = "", $desc=""){
        $time = ($time ? $time : 0);
		
		$id = $this->db->query("INSERT INTO work_table (date_id, dep_id, client_id, worker_id, time, description) VALUES ('$date_id', '$dep_id', '$client_id', '$worker_id', '$time', '$desc')")->get_last_id();
        $result = $this->db->super_query("SELECT work_table.id as wid, clients.text_color, clients.color, clients.contract_number, clients.way, clients.work_type, clients.name, clients.id as cid
										FROM work_table
											RIGHT JOIN clients ON work_table.client_id = clients.id
												WHERE work_table.id=$id");
		foreach ($result as $key => $value)
			$result[$key][work_type] = work_type($value[work_type]);
		
		return $result;
    }

    /**
     * @param $id
     * @param $client_id
     * @return array|int
     * Изменяет работу
     */
    public function write_work($id, $client_id){
        $res = $this->db->query("UPDATE work_table SET client_id='$client_id' WHERE id=$id")->affected();
        return ($res ? $this->db->super_query("SELECT * FROM work_table WHERE id=$id") : 0);
    }

    /**
     * @param $id
     * @param $date_id
     * @param $dep_id
     * @param $worker_id
     * @param $text
     * @return int|string
     * Изменяет текст работу (Не путать с описанием, которое выводится в textarea)
     */
    public function change_text($id, $date_id, $dep_id, $worker_id, $text){
        if ($id != "undefined")
            return $this->db->query("UPDATE work_table SET text='$text' WHERE id=$id")->affected();
        else
            return $this->db->query("INSERT INTO work_table (date_id, dep_id, client_id, worker_id, text) VALUES ('$date_id', '$dep_id', -1, '$worker_id', '$text')")->get_last_id();
    }

    /**
     * @param $id
     * @return int
     * Удаляет
     */
    public function delete($id){
        return $this->db->query("DELETE FROM work_table WHERE id=$id")->affected();
    }

    /**
     * @param $id
     * @return int
     * Удаляет по айди работника
     */
    public function delete_by_worker_id(&$id)
    {
        return $this->db->query("DELETE FROM work_table WHERE worker_id=$id")->affected();
    }
}