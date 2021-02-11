<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class user {

    private $core, $db, $cfg;

    public $mail, $password, $token;
    public $iduser = 0;
    public $surname = '';
    public $name = '';
    public $middle_name = '';
    public $full_name = '';
    public $idrole = 0;
    public $role_name = '';
    public $is_auth = false;
    public $auth;

    public $permissions = array();


    public function __construct($core) {

        $this->core     = $core;
        $this->db       = $core->db;
        $this->cfg      = $core->cfg;

        $this->auth     = $this->load_auth();

        if(!isset($_COOKIE['lib_user'])) { return false; }

        $cookie = explode("_", $_COOKIE['lib_user']);

        if(!isset($cookie[0], $cookie[1])) { $this->set_unauth(); $this->core->notify(); }

        $c_id = intval($cookie[0]);
        $c_token = $cookie[1];

        $query = $this->db->query("SELECT `users`.`iduser`, `users`.`surname`, `users`.`name`, `users`.`middle_name`, `users`.`idrole`, `users`.`mail`, 
        `users`.`password`, `users`.`token`, `roles`.`permissions`, `roles`.`name` AS rolename
        FROM `users`, `roles` WHERE `roles`.`idrole` = `users`.`idrole` AND `users`.`iduser` = $c_id");

        if(!$query || $this->db->num_rows($query) <= 0) { $this->set_unauth(); $this->core->notify(); }

        $ar          = $this->db->fetch_assoc($query);

        $token       = $this->db->HSC($ar['token']);
        $password    = $this->db->HSC($ar['password']);

        if($c_token !== $token) { $this->set_unauth(); $this->core->notify(); }

        $this->iduser      = intval($ar['iduser']);

        $this->mail        = $this->db->HSC($ar['mail']);
        $this->password    = $this->db->HSC($ar['password']);
        $this->token       = $token;

        $this->surname     = $this->db->HSC($ar['surname']);
        $this->name        = $this->db->HSC($ar['name']);
        $this->middle_name = $this->db->HSC($ar['middle_name']);
        $this->full_name   = $this->surname . " " . $this->name . " " . $this->middle_name;

        $this->idrole      = intval($ar['idrole']);
        $this->role_name   = $this->db->HSC($ar['rolename']);

        $this->is_auth     = true;

        $permissions       = $this->db->HSC($ar['permissions']);

        $this->permissions = explode(",", $permissions);

        if(isset($_POST['logout'])) { $this->set_unauth(); $this->core->notify(); }
        
    }

    public function load_auth() {

        if(!file_exists(LIB_LIBS_PATH.'auth/'.$this->cfg->main['p_logic'].'.php')) { exit('Auth type error!'); }

        require_once(LIB_LIBS_PATH.'auth/'.$this->cfg->main['p_logic'].'.php');

        return new auth($this->core);

    }

    public function set_unauth() {
        
        if(isset($_COOKIE['lib_user'])) { setcookie("lib_user", "", time()-3600); }

        return true;

    }



}

?>