<?php

if(!defined("LIB")) { exit("Hacking Attempt!"); }

class submodule {

	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;

        $this->core->header .= $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/header.html");
        
	}

	private function get_items_array() {

		$query = $this->db->query("SELECT `idmenu`, `title`, `url`, `permissions`, `idgroup` FROM `menu_admin`");

		if(!$query || $this->db->num_rows($query)<=0) { return array(); }

		$items = array();

		while($ar = $this->db->fetch_assoc($query)) {

            $group = intval($ar['idgroup']);

			$array = array(
				"id" => $ar['idmenu'],
				"title" => $ar['title'],
                "url" => $ar['url'],
                "permissions" => $ar['permissions'],
                "group" => $ar['idgroup']
            );
            
            if(!isset($items[$group])){
				$items[$group] = array();
				array_push($items[$group], $array);
			}else{
				array_push($items[$group], $array);
			}

        }

        return $items;
        
	}

	private function item_array($items){
		ob_start();

		foreach($items as $key => $ar){

			$data = array(
				"ID" => intval($ar['id']),
				"TITLE" => $this->db->HSC($ar['title']),
                "URL" => $this->db->HSC($ar['url']),
                "PERMISSIONS" => $this->db->HSC($ar['permissions']),
                "GROUP" => $this->db->HSC($ar['group']),
			);

			echo $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-items/item-id.html", $data);
		}

		return ob_get_clean();
	}

	private function item_list($items=array()) {

		if(empty($items)) { return $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-items/item-none.html"); }

		$data = array(
			"ITEMS" => $this->item_array($items),
		);

        return $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-items/item-list.html", $data);
        
	}

	private function group_array() {

		$items = $this->get_items_array();

		$query = $this->db->query("SELECT `idgroup`, `title` FROM `menu_admin_group`");

		if(!$query || $this->db->num_rows($query)<=0){ return $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-groups/group-none.html"); }

		ob_start();
		
		while($ar = $this->db->fetch_assoc($query)) {

			$id = intval($ar['idgroup']);

			$list = (isset($items[$id])) ? $items[$id] : array();

			$data = array(
				"ID"		=> $id,
				"TITLE"		=> $this->db->HSC($ar['title']),
				"ITEMS"		=> $this->item_list($list),
			);

			echo $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-groups/group-id.html", $data);
		}

        return ob_get_clean();
        
	}

	private function group_list() {

		$data = array(
			"GROUPS" => $this->group_array()
		);

        return $this->core->sp(LIB_THEME_MOD_PATH."admin/panel_menu/menu-groups/group-list.html", $data);
        
	}

	public function content() {

        return $this->group_list();
        
    }
    
}

?>