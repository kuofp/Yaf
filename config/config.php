<?php

return [
	
	'title' => _('project name'),
	
	'brand' => _('corporation'),
	
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
		'index'            => 'Sys\Index',
		'sys_index'        => 'Sys\Index',
		'sys_intro'        => 'intro.html',
		'sys_login'        => 'Sys\Login',
		'form_bulletin'    => 'Form\Bulletin',
		'form_user'        => 'Form\User',
		'form_category'    => 'Form\Category',
		'form_product'     => 'Form\Product',
	],
	
	// nav table
	'nav' => [
		
		array('帳號管理', 'form_user', $_SESSION['auth']['account_review'] ?? 0),
		
		array(array('商品設置', '', $_SESSION['auth']['product_review'] ?? 0),
			array('商品類別', 'form_category', 1),
			array('商品總覽', 'form_product', 1),
			/*array(array('商品設置', '', 1),
				array('商品類別', '', 1),
				array('商品總覽', 'form_product', 1),
			),*/
		),
	],
];