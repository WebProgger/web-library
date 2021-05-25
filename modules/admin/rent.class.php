<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class submodule {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

        $this->core->header .= $this->core->sp(LIB_THEME_MOD_PATH."admin/rent/header.html");
        
	}

	private function get_items() {

        $query = $this->db->query("SELECT `rented_books`.`idrented`, `users`.`surname`, `users`.`name`, `users`.`middle_name`, `books`.`name`,
            `rented_books`.`date_capture`, `rented_books`.`date_return`, `statuses`.`name` FROM `rented_books`, `users`, `books`, `statuses` 
                WHERE `rented_books`.`iduser` = `users`.`iduser` AND `rented_books`.`idbook` = `books`.`idbook` AND `rented_books`.`idstatus` = `statuses`.`idstatus`");

        if(!$query || $this->db->num_rows($query) < 1) { return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/items-none.html'); }

        ob_start();

        while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $ar[0],
                'FIO'           => $ar[1] . ' ' . $ar[2] . ' ' . $ar[3],
                'BOOK'          => $ar[4],
                'DATE_CAPTURE'  => date("d.m.Y", strtotime($ar[5])),
                'DATE_RETURN'   => date("d.m.Y", strtotime($ar[6])),
                'STATUS'        => $ar[7]
            ];

            echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/item-id.html', $data);

        }

        return ob_get_clean();

    }

    private function get_list_items() {
        $data = [
            'ITEMS' => $this->get_items()
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/items-list.html', $data);
    }

    private function methodMenu($id) {
        $data = [
            'ID' => intval($id)
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/menu.html', $data);
    }

    private function getIdStatus($id) {
        $id = intval($id);

        $query = $this->db->query("SELECT `rented_books`.`idstatus` FROM `rented_books` WHERE `rented_books`.`idrented` = $id LIMIT 1");

        if(!$query) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/rent'); }

        $ar = $this->db->fetch_array($query);

        return $ar[0];
    }

    private function getStatus($id) {
        $id = intval($id);

        $query = $this->db->query("SELECT `rented_books`.`idstatus`, `statuses`.`name` FROM `rented_books`, `statuses` 
            WHERE `rented_books`.`idstatus` = `statuses`.`idstatus` AND `rented_books`.`idrented` = $id LIMIT 1");

        if(!$query) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/rent'); }

        $ar = $this->db->fetch_array($query);

        $data = [
            'ID'    => $ar[0],
            'NAME'  => $ar[1]
        ];
        
        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/status-id.html', $data);
    }

    private function getStatuses($id) {

        $query = $this->db->query("SELECT `statuses`.`idstatus`, `statuses`.`name` FROM `statuses` WHERE `statuses`.`idstatus` != $id");

        if(!$query) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/rent'); }

        ob_start();

        while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID'    => $ar[0],
                'NAME'  => $ar[1]
            ];

            echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/status-id.html', $data);

        }

        return ob_get_clean();

    }

    private function methodEditView($id) {
       
        $data = [
            'ID'       => $id,
            'STATUSES' => $this->getStatuses($this->getIdStatus($id)),
            'STATUS'   => $this->getStatus($id),
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/status-list.html', $data);
        
    }

    private function methodEdit($idrented, $idstatus) {

        $query = $this->db->query("UPDATE `rented_books` SET `idstatus` = $idstatus WHERE `idrented` = $idrented");

        if(!$query) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/rent'); }

        return $this->core->notify('Успех!', 'Изменение успешно применены!', 3, 'admin/rent');

    }

    private function methodDelete($id) {
        $id = intval($id);

        $delete = $this->db->query("DELETE FROM `rented_books` WHERE `idrented` = $id");

        if(!$delete) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/rent'); }

        return $this->core->notify('Успех!', 'Успешно удалено!', 3, 'admin/rent');
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
                return $this->methodEditView($id);
            break;
            case 'delete':
                return $this->methodDelete($id);
            break;

            default:
                return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/items.html', $data);
            break;
        }
    }

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($_GET['method'] && !empty($_GET['method'] && $_GET['id'] && !empty($_GET['id']))) { return $this->Handler($_GET['method'], $_GET['id']); }
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->methodEdit($_POST['id'], $_POST['status']);
        }

		$data = [
            'CONTENT'   => $this->get_list_items(),
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/rent/items.html', $data);
        
    }
    
}

?>