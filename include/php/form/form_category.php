<?php
namespace Form;

class Category{
	
	function __construct(){
		
		$obj = new \Form(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_category',
			/*col*/
			array('id', 'name', 'status_id'),
			/*col_ch*/
			array('代碼', '名稱', '狀態'),
			/*empty check*/
			array(0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', '', 't_status,alias,id'),
			/*route(Ajax) check (file.php) for ajax files*/
			array('', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-8 col-sm-8 col-xs-6',
				'col-md-4 col-sm-4 col-xs-6',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'text', 'select'),
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
	}
}