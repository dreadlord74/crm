<?php

/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 18.04.2016
 * Time: 15:52
 */

/**
 * Class client
 * Класс для работы с клиентами
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

    /**
     * @param $id
     * @param null $deadline_id
     * Устанавливает поля этого класса
     * Это нужно для выставления дедлайнов в основной таблице
     */
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

    /**
     * @return array
     * Получает адишники всех клиентов
     */
    public function get_ids()
    {
        return $this->db->super_query("SELECT id FROM clients");
    }

    /**
     * @param $id
     * @return array
     * Возвращает массив с одним клиентом по айди
     */
    public function get_by_id(&$id)
    {
        return $this->db->super_query("SELECT * FROM clients WHERE id=$id", false);
    }

    public function get_priority_by_id($id)
    {
        // TODO: Implement get_priority_by_id() method.
    }

    /**
     * @param $id
     * @return string
     * Получает имя клиента по его айди
     */
    public function get_name_by_id($id)
    {
        if (!$id)
            $name = "";
        else
            $name = $this->db->super_query("SELECT name FROM clients WHERE id=".$id, false);

        return $name[name];
    }

    /**
     * @return array
     * Получает всех неархивных клиентов
     */
    public function get_all()
    {
        return $this->db->super_query("SELECT * FROM clients WHERE id !=-1 AND is_archive!='1' ORDER BY priority");
    }

    /**
     * @param $search
     * @return arraY
     * Возвращает массив наденных клиентов
     */
    public function search($search){
        $result = $this->db->super_query("SELECT * FROM clients WHERE (name LIKE '%$search%' OR clients.name LIKE '$search%' OR clients.name LIKE '%$search') AND id != -1");
		
		foreach ($result as $key => $value)
			$result[$key][work_type] = work_type($value[work_type]);
		
		return $result;
    }

    /**
     * @param $id
     * @return string
     * Возвращает цвет фона
     */
    public function get_color_by_id($id){
        $color = $this->db->super_query("SELECT color FROM clients WHERE id=".$id, false);

        return $color[color];
    }

    /**
     * @param $id
     * @return string
     * Метод, возвращающий цвет текста
     */
    public function get_text_color_by_id($id){
        $color = $this->db->super_query("SELECT text_color FROM clients WHERE id=".$id, false);

        return $color[text_color];
    }

    /**
     * @param $id
     * @param $priority
     * Метод изменения приоритетов
     * Не удалять, чтобы не сломалось!
     */
    private function change_priority($id, $priority){

    }

    /**
     * @param $id
     * @return date
     * Возвращает дату заключения договора
     */
	private function get_date_by_id(&$id){
		$date = $this->db->super_query("SELECT date FROM clients WHERE id=$id", false);
		return $date[date];
	}

    /**
     * @param $id
     * @return string
     * Получает направление
     */
    public function get_way_by_id($id){
        $way = $this->db->super_query("SELECT way FROM clients WHERE id=$id", false);

        return $way[way];
    }

    /**
     * @param $id
     * @return string
     * Получает тип работы
     */
    public function get_work_type_by_id($id){
        $work_type = $this->db->super_query("SELECT work_type FROM clients WHERE id=$id", false);

        return work_type($work_type[work_type]);
    }

    /**
     * @param $id
     * @return int
     * Метод для получения номера контракта по id клиента
     */
    public function get_contract_number_by_id($id){
        $contract_number = $this->db->super_query("SELECT contract_number FROM clients WHERE id=$id", false);

        return $contract_number[contract_number];
    }

    /**
     * @param $id
     * @param $name
     * @param $way
     * @param $work_type
     * @param $color
     * @param $text_color
     * @param $date
     * @param $contract_number
     * @return int
     * Метод для изменения клиента
     */
    public function write($id, $name, $way, $work_type, $color, $text_color, $date, $contract_number)
    {
        return $this->db->query("UPDATE clients SET name='$name', way='$way', work_type='$work_type', color='$color', text_color='$text_color', date='$date', contract_number='$contract_number' WHERE id=$id")->affected();
    }


    /**
     * @param $name
     * @param $way
     * @param $work_type
     * @param $color
     * @param $text_color
     * @param $date
     * @param $contract_number
     * @return int
     * Метод для добавления клиента
     */
    public function add ($name, $way, $work_type, $color, $text_color, $date, $contract_number){

        $id = $this->db->query("INSERT INTO clients (name, `date`, way, work_type, contract_number, color, text_color) VALUES ('$name', '$date', '$way', '$work_type', '$contract_number', '$color', '$text_color')");

        if ($id){
            $this->db->query("INSERT INTO summary (client_id) VALUES ({$this->db->get_last_id()})");
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @return array
     * Метод получения архивных клиентов
     */
    public function get_archive()
    {
        return $this->db->super_query("SELECT * FROM clients WHERE is_archive='1'");
    }

    /**
     * @param $id
     * @return int
     * Метод перевода клиента в архив
     */
    public function go_to_archive(&$id)
    {
        $res = $this->db->query("UPDATE summary SET is_archive='1' WHERE client_id=$id")->affected();
        return ($res ? $this->db->query("UPDATE clietns SET is_archive='1' WHERE id=$id")->affected() : 0);
    }

    /**
     * @param $id
     * @return int
     * Метод перевода клиента из архива
     */
    public function go_from_archive(&$id){
        $res = $this->db->query("UPDATE summary SET is_archive='0' WHERE client_id=$id")->affected();
        return ($res ? $this->db->query("UPDATE clietns SET is_archive='0' WHERE id=$id")->affected() : 0);
    }

    /**
     * @param $id
     * Метод удаления клиента
     * Не реализован потомучто не нужен
     * Не удалять так как все сломается из-за интерфейса
     */
    public  function delete($id)
    {
        // TODO: Implement delete() method.
    }
}