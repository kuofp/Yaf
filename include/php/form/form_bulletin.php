<?php
namespace Form;

class Bulletin{
	
	function __construct(){
		
		$obj = new \Form(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_report',
			/*table*/
			't_bulletin',
			/*col*/
			array('id', 'date', 'title', 'content', 'user_id', 'valid_id'),
			/*col_ch*/
			array('代碼', '日期', '標題', '內容', '發佈人', '狀態'),
			/*empty check*/
			array(0, 0, 0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', '', '', '', 't_account,name,id', 't_valid,alias,id'),
			/*route(Ajax) check (file.php) for ajax files*/
			array('', '', '', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-3 col-sm-3 col-xs-4',
				'col-md-3 col-sm-3 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'datepicker', 'text', 'textarea', 'hidden', 'select'),
			/*authority check*/
			array('bulletin_review', 'bulletin_create', 'bulletin_modify', 'bulletin_delete')
		);
		
		$obj->decodeJson($_POST);
		
		if(!empty($obj->act)){
			//additional settings
			switch($obj->act){
				case 'create':
					$obj->arg['data']['user_id'] = $_SESSION['user_id'];
					break;
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