<?php
namespace Form;

class Log{
	
	function __construct(){
		
		$obj = new \Yapa(
			// url
			_url(get_class()),
			// table
			't_log',
			// column
			array('id', 'show_id', 'content', 'cdate'),
			// label
			array('代碼', '項目', '內容', '建立時間'),
			// join (table,column,id)
			array('', 't_show,text,id', '',''),
			// class (func/hidden-create/hidden-modify/disabled/disabled-create/disabled-modify)
			array(
				'hidden',
				'hidden',
				'w120',
				'w160 hidden-create disabled',
			),
			// type (select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker/colorpicker/uploadfile/json/editor/value)
			array('hidden', 'hidden', 'textarea', 'datepicker,{"format": "Y-m-d H:i:s"}'),
			// auth
			array(
				1,
				1,
				1,
				1,
			),
			// medoo orm
			\Box::obj('db')
		);
		
		if($obj->act){
			// additional settings (review/create/modify/delete)
			switch($obj->act){
				case 'create':
					$obj->arg['data']['cdate'] = time();
					break;
				default:
					break;
			}
			
			//do the work
			echo $obj->{$obj->act}($obj->arg);
		}else{
			$obj->render();
		}
		
		exit;
	}
}