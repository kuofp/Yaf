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
		
		array('<i class="fa fa-users"></i> 帳號管理', 'form_user', 'account_review'),
		
		array(array('<i class="fa fa-folder-open-o"></i> 商品設置', '', 'product_review'),
			array('<i class="fa fa-folder-open-o"></i> 商品類別', 'form_category', ''),
			array('<i class="fa fa-newspaper-o"></i> 商品總覽', 'form_product', ''),
			/*array(array('<i class="fa fa-folder-open-o"></i> 商品設置', '', ''),
					array('<i class="fa fa-folder-open-o"></i> 商品類別', '', ''),
					array('<i class="fa fa-newspaper-o"></i> 商品總覽', 'form_product', ''),
			),*/
		),
	],
];