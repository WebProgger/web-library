<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg/*, $user, $lng*/;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
//		$this->user		= $core->user;
//		$this->lng		= $core->lng_m;

		/*
		$bc = array(
			$this->lng['mod_name'] => ADMIN_URL
		);

		$this->core->bc = $this->core->gen_bc($bc);

		*/

		$this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/auth/header.html');

		
	}

	public function content() {

		$data = array(
			'1' => 1
		);

        return $this->core->sp(LIB_THEME_PATH.'modules/auth/auth.html', $data);
        
    }
    
}

?>