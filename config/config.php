<?php

return [
	'lang' => [
		'zh_TW' => '繁體中文',
		'zh_CN' => '简体中文',
		'en_US' => 'English',
	],
	
	'medoo' => [
		'database_type' => 'mysql',
		'database_name' => 'test',
		'server'        => 'localhost',
		'username'      => 'root',
		'password'      => 'Ab12345',
		'charset'       => 'utf8',
	],
	
	// module table
	'mod' => [
		'index'         => 'Sys\Index',
		'sys_index'     => 'Sys\Index',
		'sys_intro'     => 'intro.html',
		'sys_login'     => 'Sys\Login',
		'form_user'     => 'Form\User',
		'form_log'      => 'Form\Log',
		'form_show'     => 'Form\Show',
	],
	
	// nav table
	'nav' => [
		
		array('帳號管理', 'form_user', $_SESSION['auth']['account_review'] ?? 0),
		
		array('<i class="fa fa-repeat"></i> All type', 'form_show', 1),
		
		array(array('階層', '', 1),
			array('階層2', '', 1),
			array(array('階層2', '', 1),
				array('階層3', '', 1),
				array('階層3', '', 1),
			),
		),
	],
];