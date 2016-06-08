<?php
 
$obj = new Form(
					/*file*/
					'./?m=form_order_item',
					/*db*/
					'db_report',
					/*table*/
					't_cart',
					/*col*/
					array('id', 'order_id', 'user_id', 'product_id', 'quantity', 'price'),
					/*col_ch*/
					array('代碼', '訂單編號', '購買人', '品項名稱', '數量', '單價'),
					/*empty check*/
					array(0, 1, 1, 1, 0, 0),
					/*exist(duplicate) check*/
					array(0, 0, 0, 0, 0, 0),
					/*chain(join) check (table, content, id)*/
					array('', '', 't_account,name,id', 't_product,product,id', '', ''),
					/*route(Ajax) check (file.php) for ajax files*/
					array('', '', './?m=form_user', './?m=form_product', '', ''),
					/*show bootstrap grid class*/
					array(  'hidden',
							'hidden',
							'hidden',
							'col-md-6 col-sm-8 col-xs-4',
							'col-md-3 col-sm-2 col-xs-4',
							'col-md-3 col-sm-2 col-xs-4'
							
						),
					/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
					array('hidden', 'text', 'autocomplete', 'autocomplete', 'text', 'text'),
					/*authority check*/
					array('order_review', 'order_create', 'order_modify', 'order_delete')
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