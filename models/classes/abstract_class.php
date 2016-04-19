<?php

defined("SCRIPT") or die;

abstract class abstract_class{
    protected $db;

    function __construct()
    {
        global $mysqli;

        $this->db = $mysqli;
    }
}