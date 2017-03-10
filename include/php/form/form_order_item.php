<?php
namespace Form;

class OrderItem{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
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
			/*show bootstrap grid class*/
			array(
				'hidden',
				'hidden',
				'hidden',
				'col-md-6 col-sm-8 col-xs-4',
				'col-md-3 col-sm-2 col-xs-4',
				'col-md-3 col-sm-2 col-xs-4',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'text', 'autocomplete', 'autocomplete', 'text', 'text'),
			/*authority check*/
			array(
				$_SESSION['auth']['order_review'] ?? 0,
				$_SESSION['auth']['order_create'] ?? 0,
				$_SESSION['auth']['order_modify'] ?? 0,
				$_SESSION['auth']['order_delete'] ?? 0,
			),
			/*medoo*/
			$di->obj('db'),
			/*phpmailer*/
			$di->obj('mail')
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
		}else{
			$obj->render();
		}
		
		unset($obj);
		exit;
	}
}