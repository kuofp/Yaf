<?php
 
$obj = new Form(
					/*file*/
					'./?m=form_order',
					/*db*/
					'db_report',
					/*table*/
					't_order',
					/*col*/
					array('id', 'order_status_id', 'user_id', 'name', 'mobile', 'address', 'date', 'remark'),
					/*col_ch*/
					array('訂單編號', '訂單狀態', '購買人', '收件人', '收件人手機', '收件人地址', '訂單日期', '備註'),
					/*empty check*/
					array(0, 1, 1, 1, 1, 1, 0, 0),
					/*exist(duplicate) check*/
					array(0, 0, 0, 0, 0, 0, 0, 0),
					/*chain(join) check (table, content, id)*/
					array('', 't_order_status,alias,id', 't_account,name,id', '', '', '', '', ''),
					/*route(Ajax) check (file.php) for ajax files*/
					array('', '', './?m=form_user', '', '', '', '', ''),
					/*show bootstrap grid class*/
					array(  'col-md-1 col-sm-1 col-xs-4',
							'col-md-1 col-sm-1 col-xs-4',
							'col-md-1 col-sm-1 col-xs-4',
							'col-md-1 col-sm-1 hidden-xs',
							'col-md-2 col-sm-2 hidden-xs',
							'col-md-3 col-sm-1 hidden-xs',
							'col-md-2 col-sm-1 hidden-xs',
							'col-md-1 col-sm-1 hidden-xs'
						),
					/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
					array('hidden', 'select', 'autocomplete', 'text', 'text', 'text', 'hidden', 'textarea'),
					/*authority check*/
					array('order_review', 'order_create', 'order_modify', 'order_delete')
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
	exit;
}else{
	
	
	$obj->render();
	
	echo "<script>
		
		$('#" . $obj->unique_id . "_review_complete').one('change' ,function(){
			//$('#" . $obj->unique_id . "_Modal').addClass('container');
			
			
			
			//$('#" . $obj->unique_id . "_panel').find('thead.form_title').find('th[name=\'supplier_id\']').after('<th class=\'col-md-2 col-sm-2 hidden-xs\'>品項/案名</th><th class=\'col-md-1 col-sm-1 hidden-xs\'>進貨(含稅)</th><th class=\'col-md-1 col-sm-1 hidden-xs\'>進貨(未稅)</th>');
			$('#" . $obj->unique_id . "_target_id').change(function(){
				
				$('#" . $obj->unique_id . "_Modal').find('.modal-area').children().remove();
				$('#" . $obj->unique_id . "_Modal').find('.modal-area-label').text('品項列表(可直接增修)');
				var pdata = { data: { 0: 'user_id'}, where: { id: $('#" . $obj->unique_id  . "_target_id').val() }};
				$.ajax({
					url: '" . $obj->file . "',
					type: 'POST',
					data: { jdata: JSON.stringify({ pdata: pdata, method: 'getJson' }) },
					success: function(re) {
						var jdata = JSON.parse(re);
						$('#" . $obj->unique_id . "_Modal').find('.modal-area').load('./?m=form_order_item&style=sub&preset=order_id=' + $('#" . $obj->unique_id  . "_target_id').val() + ',user_id=' + jdata[0]['user_id'] + '&query=-period%20order_id,' + $('#" . $obj->unique_id  . "_target_id').val() + ',' + $('#" . $obj->unique_id  . "_target_id').val());
					}
				});
				
			});
			$('#" . $obj->unique_id . "_panel').find('div.toollist').find('button.create').click(function(){
				$('#" . $obj->unique_id . "_Modal').find('.modal-area-label').text('請先新增訂單，才能建立品項');
				$('#" . $obj->unique_id . "_Modal').find('.modal-area').children().remove();
			});

			
			
			
		});
		
	</script>";
}



unset($obj);
?>