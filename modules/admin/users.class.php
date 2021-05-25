<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class submodule {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

        $this->core->header .= $this->core->sp(LIB_THEME_MOD_PATH."admin/users/header.html");
        
	}

	private function get_items() {

        $query = $this->db->query("SELECT `users`.`iduser`, `users`.`surname`, `users`.`name`, `users`.`middle_name`, `roles`.`name`, `users`.`mail` 
            FROM `users`, `roles` WHERE `users`.`idrole` = `roles`.`idrole`");

        if(!$query || $this->db->num_rows($query) < 1) { return $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/users-none.html'); }

        ob_start();

        while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $ar[0],
                'SURNAME'       => $ar[1],
                'NAME'          => $ar[2],
                'MIDDLE_NAME'   => $ar[3],
                'ROLE'          => $ar[4],
                'MAIL'          => $ar[5]
            ];

            echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/users-id.html', $data);

        }

        return ob_get_clean();

    }

    private function get_list_items() {
        $data = [
            'USERS' => $this->get_items()
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/users-list.html', $data);
    }

    private function methodMenu($id) {
        $data = [
            'ID' => intval($id)
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/menu.html', $data);
    }

    private function methodDelete($id) {
        $id = intval($id);

        $delete = $this->db->query("DELETE FROM `users` WHERE `iduser` = $id");

        if(!$delete) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/users'); }

        return $this->core->notify('Успех!', 'Успешно удалено!', 3, 'admin/users');
    }

    private function Handler($method, $id) {
        $data = [
            'CONTENT'   => $this->get_list_items()
        ];

        switch($method) {
            case 'menu':
                return $this->methodMenu($id);
            break;
            case 'edit':

            break;
            case 'delete':
                return $this->methodDelete($id);
            break;

            default:
                return $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/users.html', $data);
            break;
        }
    }

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($_GET['method'] && !empty($_GET['method'] && $_GET['id'] && !empty($_GET['id']))) { return $this->Handler($_GET['method'], $_GET['id']); }
        }

		$data = [
            'CONTENT'   => $this->get_list_items(),
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/users/users.html', $data);
        
    }
    
}

?>