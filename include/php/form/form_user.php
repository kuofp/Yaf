<?php
namespace Form;

class User{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_account',
			/*col*/
			array('id', 'account_id', 'user', 'password', 'gender_id', 'birth', 'code_id', 'mail', 'mobile', 'address', 'job_id', 'income_id', 'title_id', 'auth', 'valid_id'),
			/*col_ch*/
			array('代碼', '階層', '帳號', '密碼', '性別', '生日', '生辰', '信箱', '手機', '地址', '職業', '收入', '職稱', '權限', '狀態'),
			/*empty check*/
			array(0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', 't_account,user,id', '', '', 't_gender,alias,id', '', 't_code,alias,id', '', '', '', 't_job,alias,id', 't_income,alias,id', 't_title,alias,id', 't_auth,alias,id', 't_valid,alias,id'),
			/*route(Ajax) check (file.php) for ajax files*/
			array('', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'hidden',
				'col-md-3 col-sm-3 col-xs-8',
				'hidden',
				'hidden',
				'hidden',
				'hidden',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
				'col-md-4 col-sm-4 hidden-xs',
				'hidden',
				'hidden',
				'hidden',
				'hidden',
				'col-md-1 col-sm-1 hidden-xs',
			),
			/*select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker */
			array('hidden', 'select', 'text', 'password', 'select', 'datepicker', 'select', 'text', 'text', 'text', 'select', 'select', 'select', 'checkbox', 'select'),
			/*authority check*/
			array(
				$_SESSION['auth']['account_review'] ?? 0,
				$_SESSION['auth']['account_create'] ?? 0,
				$_SESSION['auth']['account_modify'] ?? 0,
				$_SESSION['auth']['account_delete'] ?? 0,
			),
			/*medoo*/
			$di->obj('db'),
			/*phpmailer*/
			$di->obj('mail'),
			/*config*/
			array(
				'perpage' => 0
			)
		);
		
		$arr = $obj->decodeJson($_POST);

		if(!empty($obj->act)){
			//additional settings
			switch($obj->act){
				case 'create':
					$obj->arg['data']['password'] = md5($obj->arg['data']['password']);
					break;
				case 'modify':
					$user = $obj->getData(array('where' => array($obj->getTable() . '.id' => $obj->arg['data']['id'])));
					if($user['data'][0]['password'] != $obj->arg['data']['password']){
						$obj->arg['data']['password'] = md5($obj->arg['data']['password']);
					}
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