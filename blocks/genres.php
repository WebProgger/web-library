<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class block_genres {

	private $core, $db;

	public function __construct($core) {

		$this->core = $core;
		$this->db = $core->db;

		$this->core->header .= $this->core->sp(LIB_THEME_BLOCK_PATH."genres/header.html");
        
	}

	private function genres_items() {

		$query = $this->db->query("SELECT `idgenre`, `name` FROM `genres`");

		if(!$query || $this->db->num_rows($query) <= 0) { return $this->core->sp(LIB_THEME_BLOCK_PATH."genres/genre-none.html"); }

		ob_start();

		while($ar = $this->db->fetch_array($query)) {

            $data = [
                'ID' => $ar[0],
                'NAME' => $ar[1]
            ];

			echo $this->core->sp(LIB_THEME_BLOCK_PATH.'genres/genre-id.html', $data);
			
		}

		return ob_get_clean();

	}

	private function genres_list() {

		$data = [
			'ITEMS' => $this->genres_items(),
		];

		return $this->core->sp(LIB_THEME_BLOCK_PATH.'genres/genre.html', $data);

	}

	public function content() {

        return $this->genres_list();
        
    }
    
}

?>