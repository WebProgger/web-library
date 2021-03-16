<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

		$this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/auth/header.html');

	}

	private function auth() {

		if($_SERVER['REQUEST_METHOD'] != 'POST') { $this->core->notify('Hacking Attemp!'); }

		if($this->user->is_auth) { $this->core->notify('Ошибка!', 'Вы уже авторизированы!', 2); }

		$mail = $this->db->safesql($_POST['mail']);

		$query = $this->db->query("SELECT `iduser`, `password`, `token` FROM `users` WHERE `mail` = '$mail' LIMIT 1");

		if(!$query || $this->db->num_rows($query) <= 0) { $this->core->notify('Ошибка!', 'Данный пользователь не найден!', 2); }

		$ar = $this->db->fetch_assoc($query);

		$iduser = intval($ar['iduser']);

		$password = $this->db->HSC($ar['password']);

		if(!$this->user->auth->authentificate(@$_POST['password'], $password)) { $this->core->notify("Ошибка!", "Неверный пароль!", 2); }

		$new_token = $this->db->safesql($this->user->auth->createToken());

		$update = $this->db->query("UPDATE `users` SET `token` = '$new_token' WHERE `iduser` = $iduser LIMIT 1");

		if(!$update) { $this->core->notify("Ошибка!", "Системная ошибка!", 2); }

		$create_cookie = $iduser."_".$new_token;

		$safetime = time()+3600*24*7;

		setcookie("lib_user", $create_cookie, $safetime, '/');

		$this->core->notify("Успех!", "Вы успешно авторизировались!", 3);

	}

	public function content() {

		if($this->user->is_auth) { $this->core->notify('Ошибка!', 'Вы уже авторизированы!', 2); }

		if($_SERVER['REQUEST_METHOD'] === 'POST') { $this->auth(); }

		$data = array(
			'1' => 1
		);
	
		return $this->core->sp(LIB_THEME_PATH.'modules/auth/auth.html', $data);

    }
    
}

?>