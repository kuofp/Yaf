<?php
namespace Form;

class Ad{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_ad',
			/*col*/
			array('id', 'pic', 'link', 'status_id'),
			/*col_ch*/
			array('代碼', '圖片', '連結', '狀態'),
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
			array('hidden', 'uploadfile', 'text', 'select'),
			/*authority check*/
			array(
				$_SESSION['auth']['admin_review'] ?? 0,
				$_SESSION['auth']['admin_create'] ?? 0,
				$_SESSION['auth']['admin_modify'] ?? 0,
				$_SESSION['auth']['admin_delete'] ?? 0,
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