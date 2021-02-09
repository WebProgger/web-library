<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;
		
    }
    

	public function content() {

		$page_ar = explode('/', $_SERVER['REQUEST_URI']);

		$page = $page_ar[1];

		if($page == '' || $page == 'index') { $page = 'main_page'; }

		switch($page) {
			case "main_page":
				$this->core->page_title = "Главная";
			break;

			default:
				$this->core->page_title = "Страница";
			break;
		}
		
		return $this->core->sp(LIB_THEME_PATH.'modules/pages/'.$page.'.html');

    }
    
}

?>