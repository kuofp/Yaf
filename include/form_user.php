<?php
 
$obj = new Form(
					/*file*/
					'./?m=form_user',
					/*db*/
					'db_shop',
					/*table*/
					't_account',
					/*col*/
					array('id', 'user', 'password', 'name', 'gender_id', 'birth', 'code_id', 'mail', 'mobile', 'address', 'job_id', 'income_id', 'title_id', 'auth', 'valid_id'),
					/*col_ch*/
					array('代碼', '帳號', '密碼', '姓名', '性別', '生日', '生辰', '信箱', '手機', '地址', '職業', '收入', '職稱', '權限', '狀態'),
					/*empty check*/
					array(0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
					/*exist(duplicate) check*/
					array(0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
					/*chain(join) check (table, content, id)*/
					array('', '', '', '', 't_gender,alias,id', '', 't_code,alias,id', '', '', '', 't_job,alias,id', 't_income,alias,id', 't_title,alias,id', 't_auth,alias,id', 't_valid,alias,id'),
					/*route(Ajax) check (file.php) for ajax files*/
					array('', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
					/*show bootstrap grid class*/
					array(  'hidden',
							'col-md-1 col-sm-1 col-xs-4',
							'hidden',
							'col-md-2 col-sm-2 col-xs-4',
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
							'col-md-1 col-sm-1 hidden-xs'
						),
					/*select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker */
					array('hidden', 'text', 'password', 'text', 'select', 'datepicker', 'select', 'text', 'text', 'text', 'select', 'select', 'select', 'checkbox', 'select'),
					/*authority check*/
					array('account_review', 'account_create', 'account_modify', 'account_delete')
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
?>