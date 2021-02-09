<?php

if(!defined('LIB')) { exit('Hacking Attempt!'); }

class core {

	public $title, $header, $menu;

	public $page_title;

    public $def_header = '';

    public $db, $cfg, $user = false;

    public $cfg_mod, $cfg_block, $cfg_modal = array();

    public $captcha = array(

        0 => "---",
		1 => "ReCaptcha",
        2 => "KeyCaptcha"
        
    );

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
		define('LIB_THEME_MODAL_PATH', LIB_THEME_PATH.'modals/');
        define('LIB_BASE_URL', $base_url);
        define('LIB_THEME_URL', LIB_BASE_URL.'themes/'.$this->cfg->main['s_theme'].'/');
        define('LIB_THEME_CSS_URL', LIB_THEME_URL.'css/');
        define('LIB_THEME_JS_URL', LIB_THEME_URL.'js/');
        define('LIB_THEME_IMG_URL', LIB_THEME_URL.'img/');

        $this->title = $this->cfg->main['s_name'];

        require_once(LIB_ENGINE_PATH.'user.class.php');

		$this->user = new user($this);
		
		require_once(LIB_ENGINE_PATH.'menu.class.php');
		
		$this->menu = new menu($this);

    }

    public function random($length = 10, $safe = true) {

        $chars	= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		if(!$safe){ $chars .= '$()#@!'; }

		$string	= "";

		$len	= strlen($chars) - 1;  
		while (strlen($string) < $length){
			$string .= $chars[mt_rand(0,$len)];  
		}

		return $string;

    }

    public function check_cfg($cfg){

		$validator = array(
			'MOD_ENABLE',
			'MOD_TITLE',
			'MOD_DESC',
			'MOD_AUTHOR',
            'MOD_VERSION',
            'MOD_PAGE'
		);

		$result = true;

		foreach($validator as $key => $val){
			if(!isset($cfg[$val])) { $result = false; }
		}

        return $result;
        
    }

    public function check_cfg_block($cfg) {

		$format = array(
			'ENABLE',
			'POSITION',
			'TITLE',
			'DESC',
			'AUTHOR'
		);

		$result = true;

		foreach($format as $key => $val) {

            if(!isset($cfg[$val])) { $result = false; }
            
		}

        return $result;
        
	}

	public function check_cfg_modal($cfg){

		$validator = array(
			'ENABLE',
			'TITLE',
			'DESC',
			'AUTHOR'
		);

		$result = true;

		foreach($validator as $key => $val){
			if(!isset($cfg[$val])) { $result = false; }
		}

        return $result;
        
    }
    
    public function check_theme_page($mod) {

        if(!file_exists(LIB_CONFIG_PATH.'modules/'.$mod.'.php')){
			return false;
        }

        require(LIB_CONFIG_PATH.'modules/'.$mod.'.php');

        if($cfg['MOD_PAGE'] == false) {
            return false;
        }

        return true;

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

    public function load_def_blocks() {

		$format = array('ENABLE', 'POSITION', 'TITLE', 'DESC', 'AUTHOR');

		$configs = scandir(LIB_CONFIG_PATH.'blocks');

		if(empty($configs)){ return false; }

		$content = '';
		$blocks = array();

		foreach($configs as $key => $file) {

			$this->cfg_block = $cfg = false;

			if($file=='.' || $file=='..' || substr($file, -4)!='.php'){ continue; }

			include(LIB_CONFIG_PATH.'blocks/'.$file);

			if($cfg === false) { continue; }

			$cfg_keys = array_keys($cfg);

			$diff = array_diff($format, $cfg_keys);

			if(!empty($diff) || !$cfg['ENABLE']){ continue; }

			if(!file_exists(LIB_BLOCK_PATH.$file)){ continue; }

            include(LIB_BLOCK_PATH.$file);
            
            $this->cfg_block = $cfg;

			$classname = 'block_'.substr($file, 0, -4);

			if(!class_exists($classname)){ continue; }

			$obj = new $classname($this);

			if(!method_exists($obj, 'content')){ unset($obj); continue; }

			$blocks[$cfg['POSITION']] = $obj->content();

            unset($obj);
            
		}

		ksort($blocks);

		foreach($blocks as $key => $val) {

            $content .= $val;
            
		}

        return $content;
        
	}

	public function load_def_modals() {

		$format = array('ENABLE', 'TITLE', 'DESC', 'AUTHOR');

		$configs = scandir(LIB_CONFIG_PATH.'modals');

		if(empty($configs)) { return false; }

		$content = '';
		$modals = array();

		foreach($configs as $key => $file) {

			$this->cfg_modal = $cfg = false;

			if($file=='.' || $file=='..' || substr($file, -4)!='.php'){ continue; }

			include(LIB_CONFIG_PATH.'modals/'.$file);

			if($cfg === false) { continue; }

			$cfg_keys = array_keys($cfg);

			$diff = array_diff($format, $cfg_keys);

			if(!empty($diff) || !$cfg['ENABLE']) { continue; }

			if(!file_exists(LIB_MODAL_PATH.$file)) { continue; }

            include(LIB_MODAL_PATH.$file);
            
            $this->cfg_modal = $cfg;

			$classname = 'modal_'.substr($file, 0, -4);

			if(!class_exists($classname)){ continue; }

			$obj = new $classname($this);

			if(!method_exists($obj, 'content')){ unset($obj); continue; }

			$modals[0] = $obj->content();

            unset($obj);
            
		}

		ksort($modals);

		foreach($modals as $key => $val) {

            $content .= $val;
            
		}

        return $content;
        
	}
    
    public function sp($path, $data=array()) {

        ob_start();

        include($path);

        return ob_get_clean();

    }

    public function gen_password($string = '', $crypt = false) {

		if($crypt === false){ $crypt = $this->cfg->main['crypt']; }

		switch($crypt) {

			case 1: return md5(md5($string)); break;

            default: return md5($string); break;
            
        }
        
    }

    public function base_url(){

        $pos = strripos($_SERVER['PHP_SELF'], 'index');

        return mb_substr($_SERVER['PHP_SELF'], 0, $pos, 'UTF-8');
        
	}
    
    public function notify($title='', $text='', $type=2, $url='', $out=false) {

		$url = (!$out) ? $this->base_url().$url : $url;

		if($out || (empty($title) && empty($text))){ header("Location: ".$url); exit; }

		switch($type){
			case 2: $_SESSION['notify_type'] = 'alert-error'; break;
			case 3: $_SESSION['notify_type'] = 'alert-success'; break;
			case 4: $_SESSION['notify_type'] = 'alert-info'; break;

			default: $_SESSION['notify_type'] = ''; break;
		}

		$_SESSION['lib_notify'] = true;
		$_SESSION['notify_title'] = $title;
		$_SESSION['notify_msg'] = $text;

		header("Location: $url");

        exit;

	}

	public function is_access($id=0) {

		if($id == 1) { return true; }

		if($id == 0) { return false; }

		if(empty(@$this->user->permissions)) { return false; }

		for($i = 0; $i < count(@$this->user->permissions); $i++ ) {

			if(@$this->user->permissions[$i] === $id) { return true; }

		}

		return false;

	}

	public function upload_image($dir='',$field) {

		// path - название папки в uploads
		// field - название поля в форме

		$path = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$dir.'/';

		if(!is_uploaded_file ($_FILES[$field]['tmp_name'])) { return false; }

		$mw = 1920; // Максимальная ширина
		$mh = 1080; // Максимальная высота

		list($width, $height, $type, $attr) = getimagesize($_FILES[$field]['tmp_name']); // Получение информации об изображении

		if($width < 50 || $width > $mw) {
			$error = 1;
			$this->core->notify("Ошибка!", "По ширине картинка должна быть не меньше 50px и не больше $mw", 2);
			return false;
		} else if($height < 50 || $height > $mh) {
			$error = 1;
	    	$this->core->notify("Ошибка!", "По высоте картинка должна быть не меньше 50px и не больше $mh ", 2);
	    	return false;
		}

		if(!isset($error)) {
			do {
				$image_name = uniqid().'.png';
			} while(file_exists($path.$image_name));
			move_uploaded_file($_FILES[$field]['tmp_name'], $path.$image_name);

			return '/uploads/'.$dir.'/'.$image_name;
		}

	}

	public function upload_file($dir='',$field) {

		// path - название папки в uploads
		// field - название поля в форме

		$path = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$dir.'/';

		if(!is_uploaded_file($_FILES[$field]['tmp_name'])) { return false; }

		$file_extension = end(explode(".", $_FILES[$field]['tmp_name']));

		$file_name = uniqid().'.'.$file_extension;

		move_uploaded_file($_FILES[$field]['tmp_name'], $path.$file_name);

		return '/uploads/'.$dir.'/'.$file_name;

	}

    

}

?>