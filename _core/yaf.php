<?php

namespace kuofp;

class Yaf{
	
	public function __construct($path = ''){
		
		require_once 'box.php';
		
		// i18n
		$lang = $_REQUEST['lang'] ?? $_COOKIE['lang'] ?? 'zh_TW';
		setcookie('lang', $lang, time() + (86400 * 30), '/');
		putenv('LANG=' . $lang);
		setlocale(LC_ALL, $lang . '.utf8');
		bindtextdomain('admin', './locale');
		textdomain('admin');
		
		require_once 'helper.php';
		
		// session
		session_start();
		
		// shared item
		$cfg = require $path; // use require instead of require_once
		\Box::obj('\Medoo\Medoo(db)', $cfg['medoo']);
		\Box::val('lang', ['default' => $lang, 'list' => $cfg['lang']]);
		\Box::val('mod', $cfg['mod']);
		\Box::val('nav', $cfg['nav']);
		
		$mod = \Box::val('mod');
		$act = $_REQUEST['m'] ?? 'index';
		
		switch($act){
			case 'sys_login':
			case 'sys_index':
			case 'index':
				// Write session
				break;
			default:
				// Reduce session lock
				session_write_close();
				break;
		}
		
		if(class_exists($act)){
			// new obj directly
			return new $act;
			
		}else if(class_exists($mod[$act] ?? '')){
			// new obj via module table
			return new $mod[$act];
			
		}else if(file_exists($mod[$act] ?? '')){
			// include file
			require $mod[$act];
			exit;
		}
	}
}
