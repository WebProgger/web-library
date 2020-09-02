<?php

class user {

    private $core, $db, $cfg;

    public $email, $login, $password;


    public function __construct($core) {

        $this->core     = $core;
        $this->db       = $db;
        $this->cfg      = $cfg;

    }
}

?>