<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class auth {

	private $core, $db, $user, $cfg;

	public function __construct($core) {

		$this->core		= $core;
		$this->db		= $core->db;
		$this->user		= $core->user;
        $this->cfg		= $core->cfg;
        
    }

	public function createToken(){

        return $this->core->random(32);
        
	}

	public function createHash($password){

        return $this->core->gen_password($password);
        
	}

	public function authentificate($post_password, $password){

		$post_password = $this->createHash($post_password);

        return ($post_password===$password) ? true : false;
        
    }
    
}

?>