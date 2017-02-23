<!-- @main -->
<div id="{unique_id}" style="height: 100%">
	<input id="{unique_id}_item_cnt"        type="hidden" value="">
	<input id="{unique_id}_target_id"       type="hidden" value="">
	<input id="{unique_id}_review_complete" type="hidden" value="trigger change when review table complete">
	<input id="{unique_id}_checked_list"    type="hidden" value="">
	<input id="{unique_id}_change_complete" type="hidden" value="trigger change when modal fetch data complete">
		
	<div class="panel panel-default" id="{unique_id}_panel" style="height: 100%">
		<div class="panel-body" style="height: 100%">
			<!-- toolist area -->
			<div class="btn-group toollist">
				<button type="button" class="btn btn-default main">操作</button>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu toollist"></ul>
			</div>
			
			<!-- search and advance search option which can filter more keywords -->
			<div class="btn-group">
				<input class="form-control search" type="{style_effect}" placeholder="搜尋" style="width: 160px"/>
				<input class="form-control search_adv" type="hidden" value="{query}" />
			</div>
			
			<!-- form text and info area has hidden-xs class attribute -->
			<div class="btn-group">
				<span class="hidden-xs">目前顯示</span>&nbsp;<div class="badge"><span class="item_cnt"></span></div><span class="hidden-xs"> 項結果</span>
			</div>
			
			<!-- main content area -->
			<div style="padding-right: 16px;">
				<table class="table" style="margin: 0px;">
					<thead class="form_title">
						<th class="chkall" style="width: 30px; cursor: pointer">
							<i class="fa fa-square-o"></i>
						</th>
						<!-- @th-->
						<th class="{class} order" name="{name}" style="cursor: pointer">{text}<i class="fa"></i></th>
						<!-- @th-->
					</thead>
				</table>
			</div>
			
			<div class="table_wrap sub" style="overflow-y: scroll; height: calc(100% - 70px);">
				<table class="table table-hover review" style="cursor: pointer;">
					<tbody class="last">
						<!-- @tr-->
						<tr class="newdatalist">
							<!-- @td-->
							<td class="{class}" name="{name}">{text}</td>
							<!-- @td-->
						</tr>
						<!-- @tr-->
					</tbody>
				</table>
				<p class="hidden empty_text" align="center">資料底端，沒有找到更多</p>
				<button class="btn btn-default btn-block review">顯示更多50筆+</button>
			</div>
		</div>
	</div>
</div>

<script>
	bindFormViewComplete('{unique_id}');
	bindFormAjaxOnRefresh('{unique_id}', '{url}', '{table}');

</script>
<!-- @main -->


<!-- @mail -->
<div class="modal fade" id="{unique_id}_Mail_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--div class="modal-dialog"><div class="modal-content"-->
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">寄送通知</h4>
	</div>
	<div class="modal-body">
		<form>
			<table class="table">
				<thead>
					<tr>
						<th class="col-xs-1 col-sm-1 col-md-1"></th>
						<th class="col-xs-2 col-sm-2 col-md-2"></th>
					</tr>
				</thead>
				<tr>
					<td align="center">收件者(必填)</td>
					<td><input class="form-control input-sm" name="mailto" type="text" value=""/></td>
				</tr>
				<tr>
					<td align="center">副本</td>
					<td><input class="form-control input-sm" name="mailcc" type="text" value=""/></td>
				</tr>
				<tr>
					<td align="center">標題</td>
					<td><input class="form-control input-sm" name="title" type="text" value=""/></td>
				</tr>
				<tr>
					<td align="center">內文</td>
					<td><textarea class="form-control" name="content" type="text" rows="7"></textarea></td>
				</tr>
				<tr>
					<td align="center">附檔</td>
					<td><p class="attach_label"></p><p class="attach_link"></p><input name="attach" type="hidden"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input name="mailfrom" type="hidden" value="{mailfrom}"/>
						<div name="report" style="overflow-x: auto"></div>
					</td>
				</tr>			
			</table>
		</form>
	</div>
	<div class="modal-footer">
		<div class="mail"></div>
	</div>
	<!--/div></div-->
</div>

<script>
	bindFormMailTool('{unique_id}', '{url}', '{table}', {source});
</script>
<!-- @mail -->


<!-- @create -->
<script>
	bindFormCreateTool('{unique_id}', '{url}');
</script>
<!-- @create -->

<!-- @modify -->
<script>
	bindFormModifyTool('{unique_id}', '{url}');
</script>
<!-- @modify -->

<!-- @delete -->
<script>
	bindFormDeleteTool('{unique_id}', '{url}');
</script>
<!-- @delete -->

<!-- @export -->
<script>
	bindFormExportTool('{unique_id}', '{url}', '{table}');
</script>
<!-- @export -->

<!-- @change -->
<script>
	bindInputAjaxOnChange('{unique_id}', '{url}', {type}, {col});
</script>
<!-- @change -->





<!-- @index -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{title}</title>
	
	<!-- icon-->
	<link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">

	<!-- jquery-->
	<script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
	<!-- jquery ui-->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
	<script   src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"   integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="   crossorigin="anonymous"></script>
	
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	
	<!-- Patch for Muti-Modal -->
	<link rel="stylesheet" href="css/bootstrap-modal-bs3patch.css">
	<link rel="stylesheet" href="css/bootstrap-modal.css">
	
	<!-- Patch for Muti-Menu -->
	<link rel="stylesheet" href="css/bootstrap-menu-bs3patch.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<!-- Patch for Muti-Modal -->
	<script src="js/bootstrap-modalmanager.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	
	<!-- font-awesome-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<!-- js -->
	<script src="js/script.js"></script>
	<script src="js/img.js"></script>
	<script src="js/jquery-datepicker-zh-TW.js"></script>

	<!-- css -->
	<link href="css/style.css" rel="stylesheet">

	
</head>

<body>
	<div id="header">
		{header}
	</div>
	<div id="nav">
		{nav}
	</div>
	<div id="main" class="col-sm-12 col-md-12 col-lg-12">
		{main}
	</div>
	<div id="footer">
		<!-- @footer -->
		<div style="height: 60px;" class="hidden-sm hidden-xs">&nbsp;</div>
		<div style="position: fixed;height: 60px;width: 100%;background-color: #000;bottom: 0px;margin-top:50px;padding-top:20px;padding-bottom:20px;color:#777;z-index:10;" class="hidden-sm hidden-xs">
			<p style="margin: 0 0 0 30px;">
				<small id="random_tips"></small>
			</p>
		</div>
		<!-- @footer -->
	</div>
</body>
</html>
<!-- @index -->


<!-- @login -->
<script>
$(function(){
	
	$('.ajax').submit(function(){
		
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
		
		return false;
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

<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4" style="max-width: 500px">
<div id="login_panel" class="panel panel-default"><div class="panel-body"><h1 style="font-family:Microsoft JhengHei; font-weight: bold">{title}</h1>
	<form class="ajax" method="POST" action="./?m=sys_login&method=login">
		<input type="text" name="user" class="form-control input-sm alphanumeric_check" placeholder="帳號"/>
		<br/>
		<input type="password" name="password" class="form-control input-sm" placeholder="密碼"/>
		<br/>
		<button type="submit" class="btn btn-primary login pull-right" data-loading-text="登入中...">登入<i class="fa fa-sign-in" aria-hidden="true"></i></button>
	</form>
</div><div class="panel-footer">{brand}</div></div>
</div>
<!-- @login -->


<!-- @nav -->
<style>
/*NAV*/
/*nav.navbar{
	-webkit-box-shadow: 0 3px 6px rgba(0,0,0,.175);
	box-shadow: 0 3px 6px rgba(0,0,0,.175);
}*/

#main{
	position: absolute;
	height: calc(100% - 100px);
}

@media screen and (max-width: 768px) {
	.dropdown-submenu>.dropdown-menu{
		left: 0px;
		width: 100%;
	}
}

@media screen and (min-width: 992px) {
    .nav-sidebar{
        padding: 20px 0px; width: 200px; position: fixed; top: 52px; left: 0px; z-index: 10;
    }
	
	.nav-sidebar li{
		width: 100%;
	}
	
	.nav-sidebar a{
		color: #000 !important;
		padding: 10px 15px !important;
	}

	.nav-sidebar a:hover{
		background-color: #EEE !important;
	}
	
	.nav-sidebar .active > a, .nav-sidebar .active > a:hover, .nav-sidebar .active > a:focus{
		color: #000;
		background-color: #EEE;
		border-right:thick double #ff0000;
	}
	
	#main{
		width: calc(100% - 200px);
		height: calc(100% - 150px);
		position: absolute;
		left: 200px;
	}
}
</style>


<nav class="navbar navbar-default">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#"><!--img alt="Brand" src="img/logo/logo.png" style="display: inline-block"--><span style=" font-weight: bold; font-size: 20px; font-family:Microsoft JhengHei;">{brand}</span></a>
	</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
		<ul class="nav navbar-nav nav-sidebar">
			{side}
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="hidden-md hidden-sm hidden-xs"><a href="#">{user}({mail})</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i> 設置 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				<!--li><a href="#">Action</a></li-->
					<li><a href="#" class="intro">使用說明</a></li>
					<li><a href="#" class="change_password">修改密碼</a></li>
					<li class="divider"></li>
					<li><a href="./?m=sys_login&method=logout">登出</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>


<div id="change_password_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">修改密碼({mail})</h4>
	</div>
	<form class="ajax">
	<div class="modal-body">
		<input class="form-control" name="password" type="password" placeholder="請輸入新密碼"/>
	</div>
	<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="submit" class="btn btn-primary modify">修改</button>
	</div>
	</form>
</div>


<script>

//add active class script
$('.nav-sidebar a').click(function(){
	$('.nav li').removeClass('active');
	$(this).addClass('active');
	$(this).parents('li').addClass('active');
	$('title').text('後台系統: ' + $(this).text());
});

$('.change_password').click(function(){
	$('#change_password_Modal').find('[name=password]').val('');
	$('#change_password_Modal').modal('show');
});
	
$('.ajax').submit(function(){	
	
	$.ajax({
		url: './?m=sys_login&method=change',
		type: 'POST',
		data: $(this).serialize(),
		success: function(re) {
			if(re == 'success'){
				customAlert('密碼修改成功', 1);
				$('#change_password_Modal').modal('hide');
			}else if(re == 'err_empty'){
				customAlert('密碼務必填寫');
			}else console.log(re);
		},
		error: function() {alert('ajax ERROR!!!');}
	});
	
	return false;
});

$('.intro').click(function(){ $('#main').load('./?m=sys_intro'); });

</script>
<!-- @nav -->


<!-- @intro -->
<script>
$('#main').load('./?m=sys_intro');
</script>
<!-- @intro -->

<!-- @table -->
	<!-- @print -->
		<table style="border:3px #000 solid; width:1500px; table-layout:fixed; text-align: center;" rules="all" class="pure-table">
			<tr>
				<!-- @th -->
				<th style="text-align: center">{text}</th>
				<!-- @th -->
			</tr>
			<!-- @tr -->
			<tr>
				<!-- @td -->
				<td style="white-space: normal; overflow: visible; word-wrap: break-word;" name="{name}">{text}</td>
				<!-- @td -->
			</tr>
			<!-- @tr -->
		</table>
	<!-- @print -->
	<!-- @excel -->
		<table>
			<tr>
				<!-- @th -->
				<th>{text}</th>
				<!-- @th -->
			</tr>
			<!-- @tr -->
			<tr>
				<!-- @td -->
				<td>{text}</td>
				<!-- @td -->
			</tr>
			<!-- @tr -->
		</table>
	<!-- @excel -->
<!-- @table -->

<!-- @crop-img -->
<div class="thumbnail" style="display: inline-block; margin: 0px;">
	<table style="width: 100px; height: 100px;">
		<tr>
			<td class="text-center">
				<img src="{url}" class="img-responsive {img}" style="max-width: 100px; max-height: 100px; margin: 0 auto;"/>
				<i class="fa fa-file {icon}" style="position: relative; color: brown; font-size: 45px"><span style="position: absolute; top: 25px; left: 6px; color: white; font-size: 11px;">{ext}</span></i>
			</td>
		</tr>
	</table>
</div>
<!-- @crop-img -->

<!-- @modal-detail -->
<div class="modal fade" id="{unique_id}_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<!--div class="modal-dialog"><div class="modal-content"-->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">詳細資訊</h4>
		</div>
		<div class="modal-body">
			<form>
				<table class="table">
					<tr>
						<th class="col-xs-1 col-sm-1 col-md-1">項目</th>
						<th class="col-xs-2 col-sm-2 col-md-2">內容</th>
					</tr>
				<!-- @tr -->
					<tr>
					<!-- @td -->
						<!-- @hidden -->
						<td class="hidden"></td>
						<td class="hidden">
							<input name="{name}" value="{value}"/>
						</td>
						<!-- @hidden -->
						<!-- @text -->
						<td align="center">{meta}</td>
						<td>
							<input class="form-control input-sm" name="{name}" type="text" value="{value}"/>
						</td>
						<!-- @text -->
						<!-- @password -->
						<td align="center">{meta}</td>
						<td>
							<input class="form-control input-sm" name="{name}" type="password" value="{value}"/>
						</td>
						<!-- @password -->
						<!-- @textarea -->
						<td align="center">{meta}</td>
						<td>
							<textarea class="form-control input-sm" name="{name}" type="text" rows="7">{value}</textarea>
						</td>
						<!-- @textarea -->
						<!-- @select -->
						<td align="center">{meta}</td>
						<td>
							<select class="form-control input-sm" name="{name}">
								<option value="0">請選擇</option>
							<!-- @option -->
								<option value="{value}" {selected}>{text}</option>
							<!-- @option -->
							</select>
						</td>
						<!-- @select -->
						<!-- @radiobox -->
						<td align="center">{meta}</td>
						<td>
							<!-- @option -->
							<div class="radio">
								<label><input type="radio" name="{name}" value="{value}" {checked}/>{text}</label>
							</div>
							<!-- @option -->
						</td>
						<!-- @radiobox -->
						<!-- @checkbox -->
						<td align="center">{meta}</td>
						<td>
							<!-- @option -->
							<div class="checkbox">
								<label><input type="checkbox" name="{name}" value="{value}" {checked}/>{text}</label>
							</div>
							<!-- @option -->
						</td>
						<!-- @checkbox -->
						<!-- @autocomplete -->
						<td align="center">{meta}</td>
						<td>
							<input class="form-control input-sm" type="text" value="{text}" id="{uid}_label"/>
							<input class="hidden" name="{name}" value="{value}" id="{uid}"/>
							<script>
								bindInputAutoComplete('{uid}', '{url}', '{label}', '{val}');
							</script>
						</td>
						<!-- @autocomplete -->
						<!-- @datepicker -->
						<td align="center">{meta}</td>
						<td>
							<input class="form-control input-sm" name="{name}" type="text" value="{value}" id="{uid}"/>
							<script>
								$('#{uid}').datepicker({dateFormat: 'yy-mm-dd', closeText: 'Close', changeYear: true, changeMonth: true, beforeShow: function() {setTimeout(function(){ $('.ui-datepicker').css('z-index', 1070);}, 0);}});
							</script>
						</td>
						<!-- @datepicker -->
						<!-- @uploadfile -->
						<td align="center">{meta}</td>
						<td>
							<input class="hidden" name="{name}" value="{value}" id="{uid}"/>
							<script>
								$('#{uid}').uploadfile({url: '{url}'});
							</script>
						</td>
						<!-- @uploadfile -->
					<!-- @td -->
					</tr>
				<!-- @tr -->
				</table>
			</form>
		</div>
		<div class="modal-footer">
			<div class="create"></div>
			<div class="modify"></div>
		</div>
	<!--/div></div-->
	<div class="modal-area-label"></div>
	<div class="modal-area"></div>
</div>
<!-- @modal-detail -->