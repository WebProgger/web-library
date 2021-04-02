<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class submodule {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

        $this->core->header .= $this->core->sp(LIB_THEME_MOD_PATH."admin/books/header.html");
        
	}

	private function get_books() {

        $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `genres`.`name`, `languages`.`name`, `books`.`count`, `books`.`uuid` 
            FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage`");

        if(!$query || $this->db->num_rows($query) < 1) { return $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/books-none.html'); }

        ob_start();

        while($book = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $book[0],
                'NAME'          => $book[1],
                'GENRE'         => $book[2],
                'LANGUAGE'      => $book[3],
                'COUNT'         => $book[4],
                'UUID'          => $book[5]
            ];

            echo $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/books-id.html', $data);

        }

        return ob_get_clean();

    }

    private function get_list_books() {
        $data = [
            'BOOKS' => $this->get_books()
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/books-list.html', $data);
    }

    private function methodMenu($id) {
        $data = [
            'ID' => intval($id)
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/menu.html', $data);
    }

    private function methodDelete($id) {
        $id = intval($id);

        $select = $this->db->query("SELECT * FROM `books` WHERE `idbook` = $id LIMIT 1");

        if(!$select || $this->db->num_rows($select) < 1) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/books'); }

        $ar = $this->db->fetch_array($select);

        $name           = $this->db->HSC($ar[1]);
        $desc           = $this->db->HSC($ar[2]);
        $author         = $this->db->HSC($ar[3]);
        $genre          = intval($ar[4]);
        $year           = intval($ar[5]);
        $language       = intval($ar[6]);
        $pages          = intval($ar[7]);
        $publisher      = $this->db->HSC($ar[8]);
        $city_print     = $this->db->HSC($ar[9]);
        $count          = intval($ar[10]);
        $electronic_src = $this->db->HSC($ar[11]);
        $cover          = $this->db->HSC($ar[12]);
        $uuid           = $this->db->HSC($ar[13]);

        $insert = $this->db->query("INSERT INTO `books_archive` (`name`, `description`, `author`, `idgenre`, `year`, `idlanguage`, `pages`, `publisher`, `city_print`, `count`, 
            `electronic_src`, `cover`, `uuid`) VALUES ('$name', '$desc', '$author', $genre, $year, $language, $pages, '$publisher', '$city_print', $count, '$electronic_src',
				'$cover', '$uuid')");

        if(!$insert) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/books'); }

        $favorites = $this->db->query("DELETE FROM `favorites` WHERE `idbook` = $id");

        if(!$favorites) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/books'); }

        $rented = $this->db->query("DELETE FROM `rented_books` WHERE `idbook` = $id");

        if(!$rented) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/books'); }

        $delete = $this->db->query("DELETE FROM `books` WHERE `idbook` = $id");

        if(!$delete) { return $this->core->notify('Ошибка!', 'Системная ошибка!', 2, 'admin/books'); }

        return $this->core->notify('Успех!', 'Успешно удалено!', 3, 'admin/books');
    }

    private function Handler($method, $id) {
        $data = [
            'CONTENT'   => $this->get_list_books()
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
                return $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/books.html', $data);
            break;
        }
    }

	public function content() {

		if(!$this->core->is_access('2')) { $this->core->notify('Ошибка!', 'Доступ запрещен!', 2); }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($_GET['method'] && !empty($_GET['method'] && $_GET['id'] && !empty($_GET['id']))) { return $this->Handler($_GET['method'], $_GET['id']); }
        }

		$data = [
            'CONTENT'   => $this->get_list_books(),
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'admin/books/books.html', $data);
        
    }
    
}

?>