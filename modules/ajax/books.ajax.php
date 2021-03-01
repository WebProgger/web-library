<?php

if(!defined("LIB")){ exit("Hacking Attempt!"); }

class submodule{
	private $core, $db, $cfg, $user;

	public function __construct($core){
		$this->core		= $core;
		$this->db		= $core->db;
		$this->cfg		= $core->cfg;
		$this->user		= $core->user;
	}

    private function setFavorite($id) {

        $user = $this->user->iduser;

        $query = $this->db->query("INSERT INTO `favorites` (`iduser`, `idbook`) VALUES ($user, $id)");

        if(!$query) { return array('message' => 'fail'); }

        return "OK";

    }

    private function unsetFavorite($id) {

        $user = $this->user->iduser;

        $query = $this->db->query("DELETE FROM `favorites` WHERE `iduser` = $user AND `idbook` = $id");

        if(!$query) { return; }

        return;

    }

    public function content() {

        if($_POST['method'] && $_POST['id_star'] && !empty($_POST['id_star'])) {
            switch($_POST['method']) {
                case "set":
                    return $this->setFavorite(intval($_POST['id_star']));
                break;
                case "unset":
                    return $this->unsetFavorite(intval($_POST['id_star']));
                break;

                default:
                    return "null";
                break;
            }
        }

        return;

    }

}