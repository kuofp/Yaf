<?php

namespace kuofp;

class Yaf{

	public function __construct($path = ''){
		
		require_once 'include/class/box.php';
		require_once 'include/class/lang.php';
		
		// i18n
		\Box::obj('Lang')->set();
		
		require_once 'include/class/helper.php';
		
		// session
		session_start();
		
		// shared item
		$cfg = require $path; // use require instead of require_once
		\Box::obj('\Medoo\Medoo(db)', $cfg['medoo']);
		\Box::val('title', $cfg['title']);
		\Box::val('brand', $cfg['brand']);
		\Box::val('mod',   $cfg['mod']);
		\Box::val('nav',   $cfg['nav']);
		
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
