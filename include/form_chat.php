<?php
 
$obj = new Form(
					/*file*/
					'./?m=form_chat',
					/*db*/
					'db_shop',
					/*table*/
					't_chat',
					/*col*/
					array('id', 'user_id', 'user', 'content', 'reply', 'date'),
					/*col_ch*/
					array('代碼', '帳號', '留言名稱', '留言內容', '店家回覆', '留言時間'),
					/*empty check*/
					array(0, 0, 0, 0, 0, 0),
					/*exist(duplicate) check*/
					array(0, 0, 0, 0, 0, 0),
					/*chain(join) check (table, content, id)*/
					array('', 't_account,user,id', '', '', '', ''),
					/*route(Ajax) check (file.php) for ajax files*/
					array('', '', '', '', '', '',),
					/*show bootstrap grid class*/
					array(  'hidden',
							'col-md-2 col-sm-2 col-xs-4',
							'col-md-2 col-sm-2 col-xs-4',
							'col-md-2 col-sm-2 hidden-xs',
							'col-md-2 col-sm-2 col-xs-4',
							'col-md-2 col-sm-2 hidden-xs'
						),
					/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
					array('hidden', 'hidden', 'hidden', 'text', 'text', 'hidden'),
					/*authority check*/
					array('chat_review', 'chat_create', 'chat_modify', 'chat_delete')
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
?>