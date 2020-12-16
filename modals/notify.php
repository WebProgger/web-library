<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class modal_notify {

	private $core, $db;

	public function __construct($core) {

		$this->core = $core;
		$this->db = $core->db;
        
	}

	public function content() {

		$this->core->header .= $this->core->sp(LIB_THEME_MODAL_PATH."notify/header.html");

		if(!isset($_SESSION['lib_notify'])){ return; }

		$new_data = array(
			"TYPE" => $this->db->HSC(@$_SESSION['notify_type']),
			"TITLE" => $this->db->HSC(@$_SESSION['notify_title']),
			"MESSAGE" => $this->db->HSC(@$_SESSION['notify_msg'])
		);

		$result = $this->core->sp(LIB_THEME_MODAL_PATH."notify/alert.html", $new_data);
	
		unset($_SESSION['lib_notify']);
		unset($_SESSION['notify_type']);
		unset($_SESSION['notify_title']);
		unset($_SESSION['notify_msg']);

        return $result;
        
    }
    
}

?>