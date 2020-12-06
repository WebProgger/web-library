<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class submodule {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

        $this->core->header .= $this->core->sp(LIB_THEME_MOD_PATH."admin/electronic_books/header.html");
        
	}

	
	private function electronic_books() {

		if($_SERVER['REQUEST_METHOD'] != 'POST') { $this->core->notify('Hacking Attemp!'); }

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

		if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['author']) && 
			isset($_POST['genre']) && isset($_POST['count']) && isset($_POST['uuid']) ) { 

				$name = $this->db->safesql($_POST['name']);
				$desc = $this->db->safesql($_POST['description']);
				$author = $this->db->safesql($_POST['author']);
				$genre = intval($_POST['genre']);
				$count = intval($_POST['count']);
				$uuid = $this->db->safesql($_POST['uuid']);

				//src

				$query = $this->db->query("INSERT INTO `books` (`name`, `description`, `author`, `idgenre`, `count`, `uuid`) VALUES ('$name', '$desc', '$author', $genre, $count, '$uuid')");

				if(!$query) { $this->core->notify('Ошибка!', 'Системная ошибка! '."INSERT INTO `books` (`name`, `description`, `author`, `idgenre`, `count`, `uuid`) VALUES ('$name', '$desc', '$author', $genre, $count, '$uuid')", 2); }

				$this->core->notify('Успех!', 'Книга успешно добавлена!', 3);

		} else {

			$this->core->notify('Ошибка!', 'Все поля должны быть заполнены!', 2);

		}


		
	}

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

		if($_SERVER['REQUEST_METHOD'] === 'POST') { $this->electronic_books(); }

		$data = array(
			'1' => 1
		);
	
		return $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/index.html', $data);
        
    }
    
}

?>