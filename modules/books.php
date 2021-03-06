<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class module {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
        $this->user		= $core->user;

        $this->core->page_title = "Книги";

        $this->core->header = $this->core->sp(LIB_THEME_PATH.'modules/books/header.html');
        
    }

    private function getRead($idbook) {

        $query = $this->db->query("SELECT `electronic_src` FROM `books` WHERE `idbook` = $idbook");

        if(!$query || $this->db->num_rows($query) < 1) { return; }

        $ar     = $this->db->fetch_assoc($query);
        $url    = $this->db->HSC($ar['electronic_src']);

        if($url === '') {
            return;
        }

        $data = [
            'URL' => $url
        ];

        return $this->core->sp(LIB_THEME_MOD_PATH.'books/read.html', $data);

    }

    private function getRent($idbook) {

        if(!$this->user->is_auth) { return; }

        $query = $this->db->query("SELECT `idbook`, `count`, `uuid` FROM `books` WHERE `idbook` = $idbook LIMIT 1");

        if(!$query || $this->db->num_rows($query) < 1) { return; }

        $ar     = $this->db->fetch_assoc($query);

        $id     = intval($ar['idbook']);
        $count  = intval($ar['count']);
        $uuid   = $this->db->HSC($ar['uuid']);

        if($count < 1) { return; }

        $data = [
            'ID'    => $id,
            'UUID'  => $uuid
        ];

        return $this->core->sp(LIB_THEME_PATH.'modules/books/rent.html', $data);

    }

    private function getFavorite($idbook, $iduser) {

        $nFound = [
            'ID'    => $idbook,
            'CLASS' => 'fa-star-o'
        ];

        $Found = [
            'ID'    => $idbook,
            'CLASS' => 'fa-star'
        ];

        if(!$this->user->is_auth) { return false; }
        
        $check = $this->db->query("SELECT `idfavorite` FROM `favorites` WHERE `idbook` = $idbook AND `iduser` = $iduser");

        if(!$check || $this->db->num_rows($check) < 1) { return $this->core->sp(LIB_THEME_PATH.'modules/books/favorite.html', $nFound); }

        return $this->core->sp(LIB_THEME_PATH.'modules/books/favorite.html', $Found);
    }

    private function getBook($id) {

        $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
            `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid` 
            FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage` AND `books`.`idbook` = $id LIMIT 1");

        if(!$query || $this->db->num_rows($query) <= 0) { return $this->core->sp(LIB_THEME_PATH.'modules/books/book-none.html'); }

        $array = array();

        $i = 0;

        while($book = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $book[0],
                'NAME'          => $book[1],
                'DESC'          => $book[2],
                'AUTHOR'        => $book[3],
                'GENRE'         => $book[4],
                'YEAR'          => $book[5],
                'LANGUAGE'      => $book[6],
                'PAGES'         => $book[7],
                'PUBLISHER'     => $book[8],
                'CITY_PRINT'    => $book[9],
                'COUNT'         => $book[10],
                'ELECTRONIC_SRC'=> $book[11],
                'COVER'         => $book[12],
                'UUID'          => $book[13],
                'FAVORITE'      => '',
                'RENT'          => '',
                'READ'          => ''
            ];

            $array[$i] = $data;

            $i += 1;

            $this->core->page_title = $data['NAME'];

        }

        ob_start();

        for($i = 0; $i < count($array); $i++) {

            $array[$i]['FAVORITE'] = $this->getFavorite(intval($array[$i]['ID']), $this->user->iduser);
            $array[$i]['RENT'] = $this->getRent(intval($array[$i]['ID']));
            $array[$i]['READ'] = $this->getRead(intval($array[$i]['ID']));

            $data = $array[$i];

            echo $this->core->sp(LIB_THEME_PATH.'modules/books/book-page.html', $data);

        }

        return ob_get_clean();

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
        if(!empty($_GET['idgenre'])) { $par = 'idgenre'; $val = $_GET['idgenre']; }
        if(!empty($_GET['search'])) {
            $string = iconv("UTF-8", "windows-1251", $_GET['search']);
            $val = "%";
            foreach(str_split($string) as $el) {
                $val = $val . iconv("windows-1251","UTF-8", $el) . "%";
            }
        }

        

        if(!empty($_GET['genre'])) {

            $query_genres = $this->db->query("SELECT `idgenre` FROM `genres` WHERE `name` = '$val'");

            if($query_genres && $this->db->num_rows($query_genres) > 0) { while($ar = $this->db->fetch_array($query_genres)) { $par = 'idgenre'; $val = $ar[0]; } }

        }

        if(!empty($_GET['language'])) {

            $query_language = $this->db->query("SELECT `idlanguage` FROM `languages` WHERE `name` = '$val'");

            if($query_language && $this->db->num_rows($query_language) > 0) { while($ar = $this->db->fetch_array($query_language)) { $par = 'idlanguage'; $val = $ar[0]; } }

        }

        if(!empty($_GET['idgenre'])) {

            $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
                `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid`
                FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage` AND `genres`.`$par` = '$val'");

        } else if(!empty($_GET['search'])) {

            $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
                `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid`
                FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage` AND 
                (`books`.`name` LIKE '$val' OR `books`.`author` LIKE '$val')");

        } else {

            $query = $this->db->query("SELECT `books`.`idbook`, `books`.`name`, `books`.`description`, `books`.`author`, `genres`.`name`, `books`.`year`,
                `languages`.`name`, `books`.`pages`, `books`.`publisher`, `books`.`city_print`, `books`.`count`, `books`.`electronic_src`, `books`.`cover`, `books`.`uuid`
                FROM `books`, `genres`, `languages` WHERE `books`.`idgenre` = `genres`.`idgenre` AND `books`.`idlanguage` = `languages`.`idlanguage` AND `books`.`$par` = '$val'");

        }

        if(!$query || $this->db->num_rows($query) <= 0) { return $this->core->sp(LIB_THEME_PATH.'modules/books/book-none.html'); }

        $count = $this->db->num_rows($query);

        $array = array();

        $i = 0;

        while($book = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $book[0],
                'NAME'          => $book[1],
                'DESC'          => $book[2],
                'AUTHOR'        => $book[3],
                'GENRE'         => $book[4],
                'YEAR'          => $book[5],
                'LANGUAGE'      => $book[6],
                'PAGES'         => $book[7],
                'PUBLISHER'     => $book[8],
                'CITY_PRINT'    => $book[9],
                'COUNT'         => $book[10],
                'ELECTRONIC_SRC'=> $book[11],
                'COVER'         => $book[12],
                'UUID'          => $book[13],
                'FAVORITE'      => '',
                'RENT'          => '',
                'READ'          => ''
            ];

            $array[$i] = $data;

            $i += 1;

        }

        ob_start();

        for($i = 0; $i < count($array); $i++) {

            $array[$i]['FAVORITE'] = $this->getFavorite(intval($array[$i]['ID']), $this->user->iduser);
            $array[$i]['RENT'] = $this->getRent(intval($array[$i]['ID']));
            $array[$i]['READ'] = $this->getRead(intval($array[$i]['ID']));

            $data = $array[$i];

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

        $array = array();

        $i = 0;

        while($book = $this->db->fetch_array($query)) {

            $data = [
                'ID'            => $book[0],
                'NAME'          => $book[1],
                'DESC'          => $book[2],
                'AUTHOR'        => $book[3],
                'GENRE'         => $book[4],
                'YEAR'          => $book[5],
                'LANGUAGE'      => $book[6],
                'PAGES'         => $book[7],
                'PUBLISHER'     => $book[8],
                'CITY_PRINT'    => $book[9],
                'COUNT'         => $book[10],
                'ELECTRONIC_SRC'=> $book[11],
                'COVER'         => $book[12],
                'UUID'          => $book[13],
                'FAVORITE'      => '',
                'RENT'          => '',
                'READ'          => ''
            ];

            $array[$i] = $data;

            $i += 1;

        }

        ob_start();

        for($i = 0; $i < count($array); $i++) {

            $array[$i]['FAVORITE'] = $this->getFavorite(intval($array[$i]['ID']), $this->user->iduser);
            $array[$i]['RENT'] = $this->getRent(intval($array[$i]['ID']));
            $array[$i]['READ'] = $this->getRead(intval($array[$i]['ID']));

            $data = $array[$i];

            echo $this->core->sp(LIB_THEME_PATH.'modules/books/book-id.html', $data);

        }

        return ob_get_clean();

	}

	public function content() {

        if($_GET['id'] && !empty($_GET['id'])) { return $this->getBook(intval($_GET['id'])); }

        if(count($_GET) > 0) { return $this->books_search(); }

        else { return $this->books_list(); }   

    }
    
}

?>