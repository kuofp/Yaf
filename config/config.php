<?php
	$cfg_title = 'project name';
	$cfg_brand = 'corporation';

	$cfg_db_medoo = array(
		'database_type' => 'mysql',
		'database_name' => 'test',
		'server'        => 'localhost',
		'username'      => 'root',
		'password'      => 'Ab12345',
		'charset'       => 'utf8',
	);
	
	$cfg_mail_PHPMailer = array(
		'isSMTP'     => true,
		'Host'       => 'smtp.gmail.com',
		'SMTPAuth'   => true,
		'Username'   => 'test@gmail.com',
		'Password'   => '',
		'SMTPSecure' => 'ssl',
		'Port'       => 465,
		'isHTML'     => true,
		'CharSet'    => 'utf-8',
		'FromName'   => $cfg_brand,
	);
	
	// module table
	$cfg_mod = array(
		'index'            => 'Sys\Index',
		'sys_index'        => 'Sys\Index',
		'sys_intro'        => 'intro.html',
		'sys_login'        => 'Sys\Login',
		'form_bulletin'    => 'Form\Bulletin',
		'form_ad'          => 'Form\Ad',
		'form_user'        => 'Form\User',
		'form_category'    => 'Form\Category',
		'form_product'     => 'Form\Product',
		'form_chat'        => 'Form\Chat',
		'form_order'       => 'Form\Order',
		'form_order_item'  => 'Form\OrderItem',
		'form_banner'      => 'Form\Banner',
	);
	
	// nav table
	$cfg_nav = array(
		array(array('<i class="fa fa-television"></i> 前台設置', '', 'admin_review'),
			array('<i class="fa fa-television"></i> 輪播區塊', 'form_banner', ''),
			array('<i class="fa fa-bullhorn"></i> 廣告區塊', 'form_ad', ''),
		),
		
		array('<i class="fa fa-users"></i> 帳號管理', 'form_user', 'account_review'),
		
		array(array('<i class="fa fa-folder-open-o"></i> 商品設置', '', 'product_review'),
			array('<i class="fa fa-folder-open-o"></i> 商品類別', 'form_category', ''),
			array('<i class="fa fa-newspaper-o"></i> 商品總覽', 'form_product', ''),
			/*array(array('<i class="fa fa-folder-open-o"></i> 商品設置', '', ''),
					array('<i class="fa fa-folder-open-o"></i> 商品類別', '', ''),
					array('<i class="fa fa-newspaper-o"></i> 商品總覽', 'form_product', ''),
			),*/
		),
		array('<i class="fa fa-commenting"></i> 留言問答', 'form_chat', 'chat_review'),
		array('<i class="fa fa-shopping-cart"></i> 訂單管理', 'form_order', 'order_review'),
	);