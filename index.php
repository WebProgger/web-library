<?php

define('LIB', '');

require_once('./system.php');

if( $_SERVER['REQUEST_URI'] == '/' ) { $page = 'index'; }

else { $page = substr($_SERVER['REQUEST_URI'], 1); if(!preg_match('/^[A-z0-9]{3,15}$/', $page)) { exit('error url'); } }

$core->def_header = $core->sp(LIB_THEME_PATH.'header.html');

switch($page) {
    case 'auth1':
    case 'register':
        $content = $core->load_def_module($page);
    break;

    default:
        $content = $core->load_module($page);
    break;  
}

$data_global = array(
    'CONTENT'       => $content,
    'TITLE'         => $core->title,
    'HEADER'        => $core->header,
    'DEF_HEADER'    => $core->def_header,
    'BLOCKS'        => '',
    'CFG'           => $core->cfg->main,
    'MENU'          => '',
    'BREADCRUMBS'   => '',
    'SEARCH'        => ''
);

if($core->check_theme_page($page)) {
    echo $core->sp(LIB_THEME_PATH.'theme_pages/'.$page.'.html', $data_global);
} else {
    echo $core->sp(LIB_THEME_PATH.'global.html', $data_global);
}


?>