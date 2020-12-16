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
    
    private function books_search() {

        $par = '';
        $val = '';
        $count = 0;

        if(!empty($_GET['name'])) { $par = 'name'; $val = $_GET['name']; }
        if(!empty($_GET['author'])) { $par = 'author'; $val = $_GET['author']; }
        if(!empty($_GET['genre'])) { $par = 'genre'; $val = $_GET['genre']; }
        if(!empty($_GET['year'])) { $par = 'year'; $val = $_GET['year']; }
        if(!empty($_GET['language'])) { $par = 'language'; $val = $_GET['language']; }
        if(!empty($_GET['pages'])) { $par = 'pages'; $val = $_GET['pages']; }

        if(!empty($_GET['genre'])) {

            $query_genres = $this->db->query("SELECT `idgenre` FROM `genres` WHERE `name` = '$val'");

            if($query_genres && $this->db->num_rows($query_genres) > 0) { while($ar = $this->db->fetch_array($query_genres)) { $par = 'idgenre'; $val = $ar[0]; } }

        }

        if(!empty($_GET['language'])) {

            $query_language = $this->db->query("SELECT `idlanguage` FROM `languages` WHERE `name` = '$val'");

            if($query_language && $this->db->num_rows($query_language) > 0) { while($ar = $this->db->fetch_array($query_language)) { $par = 'idlanguage'; $val = $ar[0]; } }

        }

        $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
            `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid`
            FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage` AND `books`.`$par` = '$val'");

        if(!$query || $this->db->num_rows($query) <= 0) { return $this->core->sp(LIB_THEME_PATH.'modules/books/book-none.html'); }

        ob_start();

        $count = $this->db->num_rows($query);

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

        $data = [
            'BOOKS' => ob_get_clean(),
            'COUNT' => $count
        ];

        return $this->core->sp(LIB_THEME_PATH.'modules/books/book-search.html', $data);
        
    }

	private function books_list() {

        $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
            `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid` 
            FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage`");

        if(!$query || $this->db->num_rows($query) <= 0) { return $this->core->sp(LIB_THEME_PATH.'modules/books/book-none.html'); }

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

        if(count($_GET) > 0) { return $this->books_search(); }

        else { return $this->books_list(); }

        

    }
    
}

?>