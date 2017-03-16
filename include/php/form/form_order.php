<?php
namespace Form;

class Order{
	
	function __construct(){
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*table*/
			't_order',
			/*col*/
			array('id', 'order_status_id', 'user_id', 'name', 'mobile', 'address', 'date', 'remark', 'module'),
			/*col_ch*/
			array('訂單編號', '訂單狀態', '購買人', '收件人', '收件人手機', '收件人地址', '訂單日期', '備註', '其他列表'),
			/*empty check*/
			array(0, 1, 1, 1, 1, 1, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0, 0, 0, 0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', 't_order_status,alias,id', 't_account,name,id', '', '', '', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'col-md-1 col-sm-1 col-xs-4',
				'col-md-1 col-sm-1 col-xs-4',
				'col-md-1 col-sm-1 col-xs-4',
				'col-md-1 col-sm-1 hidden-xs',
				'col-md-2 col-sm-2 hidden-xs',
				'col-md-3 col-sm-1 hidden-xs',
				'col-md-2 col-sm-1 hidden-xs',
				'col-md-1 col-sm-1 hidden-xs',
				'hidden',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'select', 'autocomplete', 'text', 'text', 'text', 'hidden', 'textarea', 'module'),
			/*authority check*/
			array(
				$_SESSION['auth']['order_review'] ?? 0,
				$_SESSION['auth']['order_create'] ?? 0,
				$_SESSION['auth']['order_modify'] ?? 0,
				$_SESSION['auth']['order_delete'] ?? 0,
			),
			/*medoo*/
			\Box::obj('db'),
			/*phpmailer*/
			\Box::obj('mail'),
			/*config*/
			array(
				'module' => array(
					array(
						'url' => _url('form_order_item'),
						'tag' => '品項列表',
						'sql' => array('order_id' => 'id', 'user_id'=>'user_id')
					),
					array(
						'url' => _url('form_user'),
						'tag' => '列表',
						'sql' => array()
					)
				)
			)
		);
		
		$obj->decodeJson($_POST);
		
		if(!empty($obj->act)){
			//additional settings
			switch($obj->act){
				case 'create':
					$obj->arg['data']['date'] = date('Y-m-d H:i:s');
					break;
				default:
					break;
			}
			
			//do the work
			echo $obj->{$obj->act}($obj->arg);
		}else{
			$obj->render();
		}
		
		unset($obj);
		exit;
	}
}