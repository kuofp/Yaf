<?php
namespace Form;

class Ad{
	
	function __construct(){
		
		$obj = new \Form(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_ad',
			/*col*/
			array('id', 'pic', 'link', 'status_id'),
			/*col_ch*/
			array('代碼', '圖片路徑', '連結', '狀態'),
			/*empty check*/
			array(0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', '', '', 't_status,alias,id'),
			/*route(Ajax) check (file.php) for ajax files*/
			array('', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-8 col-sm-8 col-xs-4',
				'col-md-2 col-sm-2 col-xs-4',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'text', 'text', 'select'),
			/*authority check*/
			array('admin_review', 'admin_create', 'admin_modify', 'admin_delete')
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