<?php

define('LIB', '');

require_once('./system.php');

if( $_SERVER['REQUEST_URI'] == '/' ) { $page = 'index'; }

else {

    $page_arr = explode("/", $_SERVER['REQUEST_URI']);

    $page = $page_arr[1];

    $page_arr = explode("?", $page);

    $page = $page_arr[0];

    if(!preg_match('/^[A-z0-9]{3,15}$/', $page)) { exit('error url'); } 

    }

$core->def_header = $core->sp(LIB_THEME_PATH.'header.html');

switch($page) {
    case 'index':
        $content = $core->load_def_module('pages');
    break;
    case 'auth':
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
    'BLOCKS'        => $core->load_def_blocks(),
    'MODALS'        => $core->load_def_modals(),
    'HEADER'        => $core->header,
    'DEF_HEADER'    => $core->def_header,
    'CFG'           => $core->cfg->main,
    'MENU'          => $core->menu->_list(),
    'BREADCRUMBS'   => '',
    'SEARCH'        => ''
);

if($core->check_theme_page($page)) {
    echo $core->sp(LIB_THEME_PATH.'theme_pages/'.$page.'.html', $data_global);
} else {
    echo $core->sp(LIB_THEME_PATH.'global.html', $data_global);
}


?>