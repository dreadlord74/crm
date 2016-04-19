<?php

/**
 * Created by PhpStorm.
 * User: sp
 * Date: 18.04.2016
 * Time: 15:52
 */
class client extends abstract_class implements base
{
    public function get_name_by_id($id)
    {
        // TODO: Implement get_name_by_id() method.
        $name = $this->db->super_query("SELECT name FROM clients WHERE id=".$id, false);

        return $name[name];
    }

    public function get_all()
    {
        // TODO: Implement get_all() method.

        return $this->db->super_query("SELECT * FROM clients ORDER BY priority");
    }
}