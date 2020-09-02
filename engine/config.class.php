<?php

if(!defined('LIB')) { exit('Hacking Attempt!'); }

class config {

    public $db, $main = array();

    public function __construct() {

        require_once(LIB_CONFIG_PATH.'main.php');
        require_once(LIB_CONFIG_PATH.'db.php');

        $this->main     = $main;
        $this->db       = $db;

    }
}

?>