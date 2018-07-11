<?php
namespace Form;

class Show{
	
	function __construct(){
		
		$obj = new \Yapa(
			// url
			_url(get_class()),
			// table
			't_show',
			// column
			array('id', 'select', 'radiobox', 'checkbox', 'text', 'password', 'textarea', 'autocomplete', 'datepicker', 'colorpicker', 'uploadfile', 'json', 'editor'),
			// label
			array('代碼', '下拉選單(select)', '單選框(radiobox)', '複選框(checkbox)', '文字(text)', '密碼(password)', '文字區塊(textarea)', '單選自動完成(autocomplete)', '日期(datepicker)', '選色器(colorpicker)', '檔案上傳(uploadfile)', '自訂多欄(json)', '網頁編輯器(editor)'),
			// join (table,column,id)
			array('', 't_auth,alias,id,{"id[<]": 10}', 't_auth,alias,id', 't_auth,alias,id,{"ORDER": {"id": "DESC"}}', '', '', '', 't_auth,alias,id', '', '', '', '', ''),
			// class (func/hidden-create/hidden-modify)
			array(
				'hidden',
				'w220 disabled-create',
				'w220 disabled-modify',
				'w220 disabled',
				'w220 disabled-create disabled-modify',
				'w220 disabled disabled-create disabled-modify',
				'w220',
				'w220 disabled-create',
				'w220',
				'w220',
				'w220',
				'w220',
				'w220',
			),
			// type (select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker/colorpicker/uploadfile/json/editor/value)
			array('hidden', 'select', 'radiobox', 'checkbox', 'text', 'password', 'textarea', 'autocomplete,{"max": 3}', 'datepicker,{"format": "Y年m月d日 H時i分s秒"}', 'colorpicker', 'uploadfile,{"max": 5}', 'json', 'editor'),
			// auth
			array(
				1,
				1,
				1,
				1,
			),
			// medoo orm
			\Box::obj('db'),
			// config
			array(
				'perpage' => 5,
				'preset' => array(
					'select' => '7',
					'radiobox' => '11',
					'checkbox' => '1,2,3',
					'text' => '預設文字',
					'password' => '777',
					'textarea' => '預設內容',
					'autocomplete' => '10',
					'datepicker' => strtotime('now'),
					'colorpicker' => '#ff0000',
					'json' => array('col1,欄位1' => '1', 'col2,欄位2' => '2', 'col3,欄位3' => '3', 'col4,欄位4' => '4', 'col5,欄位5' => '5'),
					'editor' => '預設內容',
				),
				'module' => array(
					array(
						'url' => _url('form_log'),
						'tag' => '子列表',
						'sql' => ['show_id' => 'id'],
					),
					array(
						'url' => _url('sys_intro'),
						'tag' => '靜態頁面',
						'sql' => [],
					),
				)
			)
		);
		
		if($obj->act){
			// additional settings (review/create/modify/delete)
			switch($obj->act){
				default:
					break;
			}
			
			// do the work
			echo $obj->{$obj->act}($obj->arg);
			
		}else{
			$obj->render();
		}
		
		exit;
	}
}