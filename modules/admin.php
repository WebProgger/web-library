<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class module {
	
	private $core, $db, $cfg, $user;

	public function __construct($core) {

		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;
        
	}

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify("Ошибка!", "Доступ запрещен!", 2); }

		//$do = (isset($_GET['do'])) ? $_GET['do'] : 'panel_menu';

		$do = explode("/", $_SERVER['REQUEST_URI']);
		
		$do = $do[2];

		$do = (isset($do)) ? $do : 'panel_menu';

		if(!preg_match("/^[\w\.\-]+$/i", $do)){ $this->core->notify("Ошибка!", "Страница не найдена!", 2); }

		if(!file_exists(LIB_MOD_PATH.'admin/'.$do.'.class.php')){
			$this->core->notify("Ошибка!", "Модуль не найден!", 2);
		}

		require_once(LIB_MOD_PATH.'admin/'.$do.'.class.php');

		if(!class_exists('submodule')){
			$this->core->notify("Ошибка!", "Модуль не найден!", 2);
		}
		
		$submodule = new submodule($this->core);

        return $submodule->content();
        
    }
    
}

?>