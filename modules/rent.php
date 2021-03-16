<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

		$this->core->page_title = "Аренда книг";

        $this->core->header = $this->core->sp(LIB_THEME_MOD_PATH.'rent/header.html');
		
    }

	private function getRent($id) {

		if(!$this->user->is_auth) { return $this->core->notify('Ошибка!', 'Доступно только авторизированным пользователям!', 2); }

		$query = $this->db->query("SELECT `rented_books`.`idrented`, `books`.`name`, `books`.`uuid`, `rented_books`.`date_capture`, 
		`rented_books`.`date_return`, `statuses`.`name` AS 'status'
			FROM `books`, `rented_books`, `statuses`
				WHERE `books`.`idbook` = `rented_books`.`idbook` AND `rented_books`.`idstatus` = `statuses`.`idstatus` AND `rented_books`.`idrented` = $id LIMIT 1");

		if(!$query || $this->db->num_rows($query) < 1) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

		$ar		= $this->db->fetch_assoc($query);

		$data = [
			'ID'			=> intval($ar['idrented']),
			'NAME'			=> $this->db->HSC($ar['name']),
			'UUID'			=> $this->db->HSC($ar['uuid']),
			'DATE_CAPTURE'	=> date('d.m.Y', strtotime($ar['date_capture'])),
			'DATE_RETURN'	=> date('d.m.Y', strtotime($ar['date_return'])),
			'STATUS'		=> $this->db->HSC($ar['status'])
		];

		return $this->core->sp(LIB_THEME_MOD_PATH.'rent/rented.html', $data);

	}

	private function getBook($id) {

		$query = $this->db->query("SELECT `idbook`, `name` FROM `books` WHERE `idbook` = $id LIMIT 1");

		if(!$query || $this->db->num_rows($query) < 1) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

		$ar		= $this->db->fetch_assoc($query);

		$data = [
			'ID'	=> intval($ar['idbook']),
			'NAME'	=> $this->db->HSC($ar['name'])
		];

		return $this->core->sp(LIB_THEME_MOD_PATH.'rent/index.html', $data);

	}

	private function inputRent() {

		if(!$_POST['id'] || !$_POST['date_capture'] || !$_POST['date_return'] || 
			empty($_POST['id']) || empty($_POST['date_capture']) || empty($_POST['date_return'])) { return $this->core->notify('Ошибка!', 'Одно из полей не заполнено!', 2); }

		$id 			= intval($_POST['id']);
		$date_capture 	= $_POST['date_capture'];
		$date_return 	= $_POST['date_return'];
		$iduser			= $this->user->iduser;

		$check = $this->db->query("SELECT `count` FROM `books` WHERE `idbook` = $id LIMIT 1");

		if(!$check || $this->db->num_rows($check) < 1) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

		$ar		= $this->db->fetch_assoc($query);
		$count 	= intval($ar['count']);

		if($count < 1) { return $this->core->notify('Ошибка!', 'Данного печатного издания нету в наличии!', 2); }

		$count -= 1;

		$update = $this->db->query("UPDATE `books` SET `count` = $count WHERE `idbook` = $id");

		if(!$update) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

		$insert = $this->db->query("INSERT INTO `rented_books` (`iduser`, `idbook`, `date_capture`, `date_return`) VALUES ($iduser, $id, '".$date_capture."', '".$date_return."')");

		if(!$insert) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

		return "Книга успешно арендована";
		
	}
    

	public function content() {

		if(!$this->user->is_auth) { return $this->core->notify('Ошибка!', 'Доступно только авторизированным пользователям!', 2); }

		if($_SERVER['REQUEST_METHOD'] === 'POST') { return $this->inputRent(); }

		if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['id']) {

			return $this->getBook(intval($_GET['id']));

		}

		if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['idrented']) {

			return $this->getRent(intval($_GET['idrented']));

		}

		return $this->core->notify('Ошибка!', 'Доступ запрещен!', 2);

	}
    
}

?>