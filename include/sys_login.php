<?php
header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
$obj = new Auth();

if(method_exists($obj, $obj->act)){
	$obj->{$obj->act}();
	exit;
}

?>


<script>
$(function(){
	
	$('.ajax').submit(function(e){
		e.preventDefault();
		var btn = $(this).find('[type=submit]').button('loading');
		
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: $(this).serialize(),
			success: function(re) {
				if(re == 'success'){
					location.reload();
				}else{
					if(re == 'err_fail') customAlert('帳號或密碼錯誤');
					else if(re == 'err_empty') customAlert('所有欄位必填');
					else customAlert(re);
					btn.button('reset');
				}
			},
			error: function() {
				alert('Register ajax ERROR!!!');
			}
		});
	});

	// alphanumeric check
	$( '.alphanumeric_check' ).keyup(function(){
		$(this).val($(this).val().replace(/[^\w]/g,''));
	});
	
});
</script>

<style>
@media screen and (min-width: 768px) {
    #login_panel{
		margin-top: 200px;
	}
}
body{
	background-color: #000;
}
</style>

<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
<div id="login_panel" class="panel panel-default"><div class="panel-body"><h1><?=$cfg_title?></h1>
	<form class="ajax" method="POST" action="./?m=sys_login&method=login">
		<input type="text" name="user" class="form-control alphanumeric_check" placeholder="帳號"/>
		<br/>
		<input type="password" name="password" class="form-control" placeholder="密碼"/>
		<br/>
		<button type="submit" class="btn btn-primary btn-lg btn-block login" data-loading-text="登入中...">登入</button>
	</form>
</div><div class="panel-footer"><?=$cfg_brand?></div></div>
</div>