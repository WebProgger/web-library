<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

		$this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/lk/header.html');

		$this->core->page_title = "Личный кабинет";

    }

	private function load_rented() {

		$query = $this->db->query("SELECT `rented_books`.`idrented`, `books`.`cover`, `books`.`name`, `rented_books`.`date_capture`, 
		`rented_books`.`date_return`, `statuses`.`name` AS 'status'
			FROM `books`, `rented_books`, `statuses`
				WHERE `books`.`idbook` = `rented_books`.`idbook` AND `rented_books`.`idstatus` = `statuses`.`idstatus` AND `rented_books`.`iduser` = ".$this->user->iduser."");

		if(!$query || $this->db->num_rows($query) < 1) { return; }

		ob_start();

		while($ar = $this->db->fetch_assoc($query)) {
			
			$book_name = $this->db->HSC($ar['name']);

			if(strlen($book_name) > 31 ) {
				$book_name = substr($book_name, 0, 28);
				$book_name = rtrim($book_name, "!,.-");
				$book_name = substr($book_name, 0, strrpos($book_name, ' '));
				$book_name = $book_name . "...";
			}

			$date_capture = date('d.m.Y', strtotime($ar['date_capture']));

			$date_return = date('d.m.Y', strtotime($ar['date_return']));

			$data = [
				'ID'	     	=> intval($ar['idrented']),
				'BOOK_COVER' 	=> $this->db->HSC($ar['cover']),
				'BOOK_NAME'	 	=> $book_name,
				'DATE_CAPTURE'	=> $date_capture,
				'DATE_RETURN'	=> $date_return,
				'STATUS'		=> $this->db->HSC($ar['status'])
			];

			echo $this->core->sp(LIB_THEME_MOD_PATH.'lk/rented-id.html', $data);

		}

		$data = [
			'RENTED' => ob_get_clean()
		];

		return $this->core->sp(LIB_THEME_MOD_PATH.'lk/rented.html', $data);

	}
    
    private function load_favorites() {

		$query = $this->db->query("SELECT `books`.`idbook`, `books`.`cover`, `books`.`name` FROM `books`, `favorites` 
			WHERE `books`.`idbook` = `favorites`.`idbook` AND `favorites`.`iduser` = ".$this->user->iduser."");

		if(!$query) { $this->core->notify('Ошибка!', 'Невозможно загрузить избранное!', 2); }

		ob_start();

		while($ar = $this->db->fetch_assoc($query)) {

			$book_name = $this->db->HSC($ar['name']);

			if(strlen($book_name) > 31 ) {
				$book_name = substr($book_name, 0, 28);
				$book_name = rtrim($book_name, "!,.-");
				$book_name = substr($book_name, 0, strrpos($book_name, ' '));
				$book_name = $book_name . "...";
			}

			$data = [
				'ID'	     => intval($ar['idbook']),
				'BOOK_COVER' => $this->db->HSC($ar['cover']),
				'BOOK_NAME'	 => $book_name
			];


			echo $this->core->sp(LIB_THEME_PATH.'modules/lk/favorite-id.html', $data);

		}

		$data = [
			'FAVORITES' => ob_get_clean()
		];

		return $this->core->sp(LIB_THEME_PATH.'modules/lk/favorites.html', $data);
		
    }

	public function content() {

		if(!$this->user->is_auth) { $this->core->notify('Ошибка!', 'Данная страница доступна только авторизированным пользователям!', 2); }

		$data = array(
			'MAIL' 		=> $this->user->mail,
			'FIO'		=> $this->user->full_name,
			'ROLE'		=> $this->user->role_name,
			'FAVORITES' => $this->load_favorites(),
			'RENTED'	=> $this->load_rented()
		);
	
		return $this->core->sp(LIB_THEME_PATH.'modules/lk/index.html', $data);

    }
    
}

?>