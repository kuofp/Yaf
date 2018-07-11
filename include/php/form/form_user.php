<?php
namespace Form;

class User{
	
	function __construct(){
		
		$obj = new \Yapa(
			// url
			_url(get_class()),
			// table
			't_account',
			// column
			array('id', 'account', 'password', 'auth', 'status_id'),
			// label
			array('代碼', '帳號', '密碼', '權限', '狀態'),
			// join (table,column,id)
			array('', '', '', 't_auth,alias,id', 't_status,alias,id'),
			// class (func/hidden-create/hidden-modify/disabled/disabled-create/disabled-modify)
			array(
				'hidden',
				'w200 disabled-modify',
				'hidden',
				'w200',
				'w200',
			),
			// type (select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker/colorpicker/uploadfile/json/editor/value)
			array('hidden', 'text', 'password', 'checkbox', 'select'),
			// auth
			array(
				$_SESSION['auth']['account_review'] ?? 0,
				$_SESSION['auth']['account_create'] ?? 0,
				$_SESSION['auth']['account_modify'] ?? 0,
				$_SESSION['auth']['account_delete'] ?? 0,
			),
			// medoo orm
			\Box::obj('db')
		);
		
		if($obj->act){
			// additional settings (review/create/modify/delete)
			switch($obj->act){
				case 'create':
					$obj->arg['data']['password'] = password_hash($obj->arg['data']['password'], PASSWORD_DEFAULT);
					break;
				case 'modify':
					$user = \Box::obj('db')->select('t_account', '*', ['id' => $obj->arg['data']['id']]);
					if($user[0]['password'] != $obj->arg['data']['password']){
						$obj->arg['data']['password'] = password_hash($obj->arg['data']['password'], PASSWORD_DEFAULT);
					}
					break;
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