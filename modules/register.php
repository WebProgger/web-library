<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

		$this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/register/header.html');

		
	}

	private function register() {

		if($_SERVER['REQUEST_METHOD'] != 'POST') { $this->core->notify('Hacking Attemp!'); }

		if($this->user->is_auth) { $this->core->notify('Ошибка!', 'Вы уже авторизированы!', 2); }

		$mail = $this->db->safesql($_POST['mail']);

		$query = $this->db->query("SELECT `iduser` FROM `users` WHERE `mail` = '$mail' LIMIT 1");

        if(!$query || $this->db->num_rows($query) > 0) { $this->core->notify('Ошибка!', 'Данная почта уже используется!', 2); }
        
        $fio = $this->db->safesql($_POST['fio']);
        $mail = $this->db->safesql($_POST['mail']);
        $pass = $this->db->safesql($_POST['password']);

        $fio_arr = explode(" ", $fio);

        $surname = $fio_arr[0];
        $name = $fio_arr[1];
        $middle_name = $fio_arr[2];

        $password = $this->core->gen_password($pass);

        $token = $this->db->safesql($this->user->auth->createToken());

        $insert = $this->db->query("INSERT INTO `users` (`surname`, `name`, `middle_name`, `idrole`, `mail`, `password`, `token`) 
            VALUES ('$surname', '$name', '$middle_name', 2, '$mail', '$password', '$token')");

        if(!$insert) { $this->core->notify('Ошибка!', 'Системная ошибка!', 2); }

        $id = $this->db->insert_id();

        $create_cookie = $id."_".$token;

        $safetime = time()+3600;

		setcookie("lib_user", $create_cookie, $safetime, '/');

		$this->core->notify("Успех!", "Вы успешно зарегистрировались!", 3);

	}

	public function content() {

		if($this->user->is_auth) { $this->core->notify('Ошибка!', 'Вы уже авторизированы!', 2); }

		if($_SERVER['REQUEST_METHOD'] === 'POST') { $this->register(); }

		$data = array(
			'1' => 1
		);
	
		return $this->core->sp(LIB_THEME_PATH.'modules/register/register.html', $data);

    }
    
}

?>