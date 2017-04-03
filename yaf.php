<?php

namespace kuofp;

class Yaf{

	public function __construct($path = ''){
		require_once 'include/class/box.php';
		require_once 'include/class/lang.php';
		
		// i18n
		\Box::obj('Lang')->set();
		
		require_once 'include/class/control.php';
		require_once 'include/class/helper.php';
		
		$core = new \Control();
		
		// shared item
		$cfg = require $path; // use require instead of require_once
		\Box::obj('db',    $cfg['medoo']);
		
		\Box::val('title', $cfg['title']);
		\Box::val('brand', $cfg['brand']);
		\Box::val('mod',   $cfg['mod']);
		\Box::val('nav',   $cfg['nav']);
		
		$core->make();
	}
}
