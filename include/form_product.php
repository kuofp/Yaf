<?php

$obj = new Form(
					/*file*/
					'./?m=form_product',
					/*db*/
					'db_shop',
					/*table*/
					't_product',
					/*col*/
					array('id', 'category_id', 'product', 'pic', 'price', 'stock', 'intro', 'status_id', 'remark'),
					/*col_ch*/
					array('代碼', '分類', '名稱', '商品編號', '單價', '庫存', '介紹', '狀態', '備註'),
					/*empty check*/
					array(0, 0, 0, 0, 0, 0, 0, 0, 0),
					/*exist(duplicate) check*/
					array(0, 0, 0, 0, 0, 0, 0, 0, 0),
					/*chain(join) check (table, content, id)*/
					array('', 't_category,name,id', '', '', '', '', '', 't_type,alias,id', ''),
					/*route(Ajax) check (file.php) for ajax files*/
					array('', '', '', '', '', '', '', '', ''),
					/*show bootstrap grid class*/
					array(  'hidden',
							'col-md-2 col-sm-2 col-xs-4',
							'col-md-2 col-sm-2 col-xs-4',
							'col-md-2 col-sm-2 hidden-xs',
							'col-md-1 col-sm-1 col-xs-4',
							'hidden',
							'col-md-3 col-sm-3 hidden-xs',
							'col-md-2 col-sm-2 hidden-xs',
							'hidden'
						),
					/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
					array('hidden', 'select', 'text', 'text', 'text', 'hidden', 'textarea', 'select', 'text'),
					/*authority check*/
					array('product_review', 'product_create', 'product_modify', 'product_delete')
					);

$obj->decodeJson($_POST);

if(!empty($obj->act)){
	//additional settings
	switch($obj->act){
		default:
			break;
	}
	
	//do the work
	echo $obj->{$obj->act}($obj->arg);
	exit;
}else{
	$obj->render();
}

unset($obj);
?>