<?php
namespace Form;

class Product{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
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
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
				'col-md-1 col-sm-1 col-xs-4',
				'hidden',
				'col-md-3 col-sm-3 hidden-xs',
				'col-md-2 col-sm-2 hidden-xs',
				'hidden',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'select', 'text', 'text', 'text', 'hidden', 'textarea', 'select', 'text'),
			/*authority check*/
			array(
				$_SESSION['auth']['product_review'] ?? 0,
				$_SESSION['auth']['product_create'] ?? 0,
				$_SESSION['auth']['product_modify'] ?? 0,
				$_SESSION['auth']['product_delete'] ?? 0,
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
			exit;
		}else{
			$obj->render();
		}
		
		unset($obj);
	}
}