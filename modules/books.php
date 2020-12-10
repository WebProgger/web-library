<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

		$this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/books/header.html');

		
	}

	private function books_list() {

        $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
            `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid` 
            FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage`");

        if(!$query || $this->db->num_rows($query) <= 0) { $this->core->sp(LIB_THEME_PATH.'modules/books/book-none.html'); exit; }

        ob_start();

        while($book = $this->db->fetch_array($query)) {

            $data = [
                'ID' => $book[0],
                'NAME' => $book[1],
                'DESC' => $book[2],
                'AUTHOR' => $book[3],
                'GENRE' => $book[4],
                'YEAR' => $book[5],
                'LANGUAGE' => $book[6],
                'PAGES' => $book[7],
                'PUBLISHER' => $book[8],
                'CITY_PRINT' => $book[9],
                'COUNT' => $book[10],
                'ELECTRONIC_SRC' => $book[11],
                'COVER' => $book[12],
                'UUID' => $book[13]
            ];

            

            echo $this->core->sp(LIB_THEME_PATH.'modules/books/book-id.html', $data);

        }

        return ob_get_clean();

	}

	public function content() {

        return $this->books_list();

    }
    
}

?>