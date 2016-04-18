<?php
/**
 * Created by PhpStorm.
 * User: Данил Хандысь
 * Date: 18.04.2016
 * Time: 13:25
 */

class departament{
    public $id;
    public $name;

    private $db;

   function __construct (){
       global $mysqli;

       $this->db = $mysqli;
   }


    public function get_all(){


        $query = "SELECT * FROM departament";

        return $this->db->super_query($query, true);

    }
}