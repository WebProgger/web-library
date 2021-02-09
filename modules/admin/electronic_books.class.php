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

	private function get_languages() {

		$query = $this->db->query("SELECT `idlanguage`, `name` FROM `languages`");

		if(!$query || $this->db->num_rows($query) <= 0) { echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/none.html'); }

		ob_start();

		while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID' => $ar[0],
                'NAME' => $ar[1],
            ];

			echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/languages-item.html', $data);
			
		}

		return ob_get_clean();

	}

	private function get_genres() {

		$query = $this->db->query("SELECT `idgenre`, `name` FROM `genres`");

		if(!$query || $this->db->num_rows($query) <= 0) { echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/none.html'); }

		ob_start();

		while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID' => $ar[0],
                'NAME' => $ar[1],
            ];

			echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/genres-item.html', $data);
			
		}

		return ob_get_clean();

	}
	
	private function electronic_books() {

		if($_SERVER['REQUEST_METHOD'] != 'POST') { $this->core->notify('Hacking Attemp!'); }

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

		if(!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['author']) &&
		!empty($_POST['genre']) && !empty($_POST['year']) && !empty($_POST['language']) && !empty($_POST['pages'])
		&& !empty($_POST['publisher']) && !empty($_POST['city_print']) && !empty($_POST['count']) && !empty($_POST['uuid']) ) {

				$name = $this->db->safesql($_POST['name']);
				$desc = $this->db->safesql($_POST['description']);
				$author = $this->db->safesql($_POST['author']);
				$genre = intval($_POST['genre']);
				$year = intval($_POST['year']);
				$language = intval($_POST['language']);
				$pages = intval($_POST['pages']);
				$publisher = $this->db->safesql($_POST['publisher']);
				$city_print = $this->db->safesql($_POST['city_print']);
				$count = intval($_POST['count']);
				$electronic_src = $this->core->upload_file('electronic_books', 'electronic_src');
				$cover = $this->core->upload_image('books', 'cover');
				$uuid = $this->db->safesql($_POST['uuid']);

				$query = $this->db->query("INSERT INTO `books` (`name`, `description`, `author`, `idgenre`, `year`, `idlanguage`, `pages`, `publisher`, `city_print`, `count`, 
				`electronic_src`, `cover`, `uuid`) VALUES ('$name', '$desc', '$author', $genre, $year, $language, $pages, '$publisher', '$city_print', $count, '$electronic_src',
				'$cover', '$uuid')");

				if(!$query) { $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

				$this->core->notify('Успех!', 'Книга успешно добавлена!', 3);

		} else {

			$this->core->notify('Ошибка!', 'Все поля должны быть заполнены!', 2);

		}


		
	}

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

		if($_SERVER['REQUEST_METHOD'] === 'POST') { $this->electronic_books(); }

		$data = array(
			'GENRES' => $this->get_genres(),
			'LANGUAGES' => $this->get_languages()
		);
	
		return $this->core->sp(LIB_THEME_MOD_PATH.'admin/electronic_books/index.html', $data);
        
    }
    
}

?>