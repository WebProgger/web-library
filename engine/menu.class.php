<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class menu {

	private $core, $db, $user, $cfg;

	public function __construct($core) {

		$this->core		= $core;
		$this->db		= $core->db;
		$this->user		= $core->user;
		$this->cfg		= $core->cfg;

	}

	private function get_url() {

		$protocol = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) ? 'https://' : 'http://';

		return $protocol.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

	}

	private function menu_profile() {

		$authfile = (!$this->user->is_auth) ? "unauth" : "auth";

        echo $this->core->sp(LIB_THEME_PATH."menu/$authfile.html");

	}

	private function generate_menu($array) {

		$this->request_url = $this->get_url();

		ob_start();

		foreach ($array as $key=>$ar){

			$data = array(
				"TITLE"		=> $ar['title'],
				"URL"		=> $this->db->HSC($ar['url']),
			);
			
			echo $this->core->sp(LIB_THEME_PATH."menu/menu-id.html", $data);
			
		}

		$this->menu_profile();

		return ob_get_clean();

	}

	private function menu_array() {
		

		$query = $this->db->query("SELECT `idmenu`, `title`, `url`, `permissions` FROM `menu`");

		if(!$query || $this->db->num_rows($query)<=0){ return; }

		$array = array();

		while($ar = $this->db->fetch_assoc($query)){

			if(!$this->core->is_access($ar['permissions'])){ continue; }
			
			$array[$ar['id']] = array(
				"id" => $ar['id'],
				"title" => $ar['title'],
				"url" => $ar['url'],
				"permissions" => $ar['permissions']
			);

		}

		return $this->generate_menu($array);

	}

	public function _list(){

		return $this->menu_array();

	}

	

}

?>