<?php

class db {

    public $obj = false;

    public $result = false;

    private $cfg;

    public function __construct($host='127.0.0.1', $user='root', $pass='', $base='base', $port=3306, $core=array()) {

        $this->cfg = $core->cfg;

        $connect = $this->connect($host, $user, $pass, $base);

        if(!$connect) { return; }

    }

    public function connect($host='127.0.0.1', $user='root', $pass='', $base='base', $port=3306) {

        $this->obj = @new mysqli($host, $user, $pass, $base, $port);

        if(mb_strlen($this->obj->connect_error, 'UTF-8')>0){ return false; }

		if($this->obj->connect_errno){ return false; }

		if(!$this->obj->set_charset("utf8")){ return false; }

    }

    public function query($string) {

        $this->result = @$this->obj->query($string);

        return $this->result;

    }

    public function num_rows($query=false) {

        return $this->result->num_rows;

    }

    public function fetch_array($query=false) {

        return $this->result->fetch_array();

    }

    public function fetch_assoc($query=false) {

        return $this->result->fetch_assoc();

    }

    public function safesql($string) {

        return $this->obj->real_escape_string($string);

    }

    public function HSC($string='') {

        return htmlspecialchars($string);
        
	}

    public function error() {

        if(!is_null(mysqli_connect_error())) { return mysqli_connect_error(); }

        if(!empty($this->obj->error)) { return $this->obj_error; }

        return;

    }

}

?>