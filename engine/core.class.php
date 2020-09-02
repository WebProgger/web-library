<?php

if(!defined('LIB')) { exit('Hacking Attempt!'); }

class core {

    public $title, $header;

    public $def_header = '';

    public $db, $cfg, $user = false;

    public $lng, $lng_mod, $lng_block, $cfg_mod, $cfg_block = array();

    public function __construct() {

        require(LIB_ENGINE_PATH.'config.class.php');

        $this->cfg = new config();

        require(LIB_ENGINE_PATH.'db/mysqli.class.php');

        $this->db = new db($this->cfg->db['host'], $this->cfg->db['user'], $this->cfg->db['pass'], $this->cfg->db['base'], $this->cfg->db['port'], $this);

        $base_url = $this->cfg->main['s_root'];

        define('LIB_THEME_PATH', LIB_ROOT.'themes/'.$this->cfg->main['s_theme'].'/');
        define('LIB_THEME_CSS_PATH', LIB_THEME_PATH.'css/');
        define('LIB_THEME_JS_PATH', LIB_THEME_PATH.'js/');
        define('LIB_THEME_IMG_PATH', LIB_THEME_PATH.'img/');
        define('LIB_THEME_MOD_PATH', LIB_THEME_PATH.'modules/');
        define('LIB_THEME_BLOCK_PATH', LIB_THEME_PATH.'blocks/');
        define('LIB_BASE_URL', $base_url);
        define('LIB_THEME_URL', LIB_BASE_URL.'themes/'.$this->cfg->main['s_theme'].'/');
        define('LIB_THEME_CSS_URL', LIB_THEME_URL.'css/');
        define('LIB_THEME_JS_URL', LIB_THEME_URL.'js/');
        define('LIB_THEME_IMG_URL', LIB_THEME_URL.'img/');

        $this->title = $this->cfg->main['s_name'];

    }

    public function check_cfg($cfg){

		$validator = array(
			'MOD_ENABLE',
			'MOD_TITLE',
			'MOD_DESC',
			'MOD_AUTHOR',
			'MOD_VERSION',
		);

		$result = true;

		foreach($validator as $key => $val){
			if(!isset($cfg[$val])){ $result = false; }
		}

        return $result;
        
	}

    public function load_module($mod){

        if($mod == 'index') {
            return;
        }

		if(!preg_match("/^\w+$/i", $mod) || !file_exists(LIB_MOD_PATH.$mod.".php")){
			return $this->sp(LIB_THEME_PATH."default_sp/404.html");
		}
		
		if(!file_exists(LIB_CONFIG_PATH.'modules/'.$mod.'.php')){
			return $this->sp(LIB_THEME_PATH."default_sp/mod_disable.html");
		}

		require_once(LIB_CONFIG_PATH.'modules/'.$mod.'.php');

		if(!isset($cfg) || !$this->check_cfg($cfg) || !$cfg['MOD_ENABLE']){
			return $this->sp(LIB_THEME_PATH."default_sp/mod_disable.html");
		}

		include_once(LIB_MOD_PATH.$mod.".php");

		if(!class_exists("module")){ return false; }

		//$this->lng_m = $this->load_language($mod);

		$this->cfg_mod = $cfg;

		$module = new module($this);
		
		if(!method_exists($module, "content")){ return false; }

        return $module->content();
        
    }
    
    public function load_def_module($mod){
		
		include_once(LIB_MOD_PATH.$mod.".php");

		require_once(LIB_CONFIG_PATH.'modules/'.$mod.'.php');

		//require(MCR_LANG_PATH.$this->cfg->main['s_lang'].'/'.$mode.'.php');

		if(!$cfg['MOD_ENABLE']){ return $this->sp(LIB_THEME_PATH."default_sp/mod_disable.html"); }

		//$this->lng_m = $lng;

		//$this->cfg_m = $cfg;

		$module = new module($this);

        return $module->content();
        
    }
    
    public function sp($path, $data=array()) {

        ob_start();

        include($path);

        return ob_get_clean();

    }

}

?>