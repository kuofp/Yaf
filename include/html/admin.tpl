<!-- @index -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{title}</title>
	
	<!-- icon-->
	<link rel="shortcut icon" href="/img/logo/favicon.ico" type="image/x-icon">
	
	<!-- jquery-->
	<script src="//code.jquery.com/jquery-3.1.0.min.js"></script>
	
	<!-- jquery ui-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
	<script src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
	
	<!-- bootstrap -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- font-awesome-->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- summernote -->
	<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.min.js"></script>
</head>

<body>
	<div id="header">
		{header}
	</div>
	<div id="nav">
		{nav}
	</div>
	<div id="main" class="col-xs-12" style="max-width: 1280px">
		{main}
	</div>
	<div id="footer">
	</div>
</body>
<script>

function customAlert(arr){
	var code = arr.code || 0;
	var text = arr.text || '';
	var info = ['<i class="fa fa-check-circle"></i> 成功', '<i class="fa fa-times-circle"></i> 錯誤', '<i class="fa fa-exclamation-circle"></i> 警告'];
	var type = ['success', 'danger', 'warning'];
	
	if(text){
		var alert = $('<div style="height: 1px; width: 100%; position: fixed; top: 0px; z-index: 1500;"><div class="alert alert-' + type[code] + '" style="width: 320px; position: relative; margin: auto;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p><strong>' + info[code] + ': </strong>' + text + '</p></div></div>');
		setTimeout(function(){
			$(alert).fadeOut(function(){
				$(this).remove();
			});
		}, 3000);
		$('body').append(alert);
	}
}

jQuery.fn.extend({
	loadTab: function(){
		var url = arguments[0] || '';
		var obj = arguments[1] || '';
		var txt = arguments[2] || '';
		
		var tar = this;
		var tpl = '<style>.btn-tab-del{position: absolute; top: -5px; right: 0px; cursor: pointer; padding: 2px; font-size: 20px} .btn-tab-del:hover{ color: red; }</style><ul class="nav nav-tabs"></ul><div class="tab-content" style="height: 100%"></div>';
		
		var id = 'tab' + (new Date().getTime()) + Math.round(Math.random() * 1000);
		
		var tab = $('<li class="active"><a data-toggle="tab" href="#' + id + '" style="padding: 0 15px 0 6px">' + txt + '</a></li>');
		var col = $('<div id="' + id + '" class="tab-pane fade in active" style="height: 100%"></div>');
		var btn = $('<span class="btn-tab-del" aria-hidden="true">&times</span>');
		
		if($(tar).children('.nav-tabs').length){
			$(tar).children('.nav-tabs').children('li').removeClass('active');
			$(tar).children('.tab-content').children('div').removeClass('active in');
		}else{
			$(tar).empty().append(tpl);
		}
		
		$(btn).click(function(){
			var del = $(this).closest('li').find('a').attr('href');
			
			if($(this).closest('.nav-tabs').find('li').length > 1){
				$(del).remove();
				$(this).closest('li').remove();
				
				if(!$(tar).children('.nav-tabs').children('li.active').length){
					$(tar).children('.nav-tabs').children('li').last().find('a').tab('show');
				}
			}else{
				$(tar).empty()
			}
		});
		
		$(tab).find('a').append(btn);
		$(tar).children('.nav-tabs').append(tab);
		$(tar).children('.tab-content').append(col);
		$('#' + id).load(url, obj);
	}
});
</script>
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
			success: function(re){
				var jdata = JSON.parse(re);
				if(jdata['code']){
					// fail
				}else{
					location.reload();
				}
				customAlert(jdata);
				btn.button('reset');
			},
			error: function(){
				alert('Register ajax ERROR!!!');
			}
		});
		
		return false;
	});
});
</script>

<style>
@media screen and (min-width: 768px){
	#login_panel{
		margin-top: 200px;
	}
}
body{
	background-color: #000;
}
</style>

<div class="col-sm-6 col-md-4 center-block" style="max-width: 400px; float: none">
	<div id="login_panel" class="panel panel-default">
		<div class="panel-body">
			<h1 style="font-family:Microsoft JhengHei; font-weight: bold">{title}</h1>
			<form class="ajax" method="POST" action="?m=sys_login&method=login">
				<input type="text" name="account" class="form-control input-sm" placeholder="帳號"/>
				<br/>
				<input type="password" name="password" class="form-control input-sm" placeholder="密碼"/>
				<br/>
				<button type="submit" class="btn btn-primary login pull-right" data-loading-text="登入中...">登入<i class="fa fa-sign-in" aria-hidden="true"></i></button>
			</form>
		</div>
		<div class="panel-footer">{brand}
			<div class="pull-right" style="margin-top: -5px;"><!-- @lang --><!-- @lang --></div>
		</div>
	</div>
</div>
<!-- @login -->

<!-- @nav -->
<style>
/*NAV*/
nav.navbar{
	-webkit-box-shadow: 0 3px 6px rgba(0,0,0,.175);
	box-shadow: 0 3px 6px rgba(0,0,0,.175);
}

.nav-sidebar{
	height: calc(100% - 80px);
	overflow-y: scroll;
	overflow-x: hidden;
}

.nav-sidebar .active > a,
.nav-sidebar .active > a:hover,
.nav-sidebar .active > a:focus,
.nav-sidebar a:hover{
	color: #000;
	background-color: #EEE !important;
}

.nav-sidebar a{
	color: #000 !important;
	padding: 10px 15px !important;
}

.nav-sidebar li{
	width: 100%;
}

.dropdown-submenu .dropdown-menu{
	position: relative;
	width: 100%;
	box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,.175);
	border: 1px solid #cecece;
	background-color: #FFF;
	padding-left: 10px;
}

#main{
	position: absolute;
	height: calc(100% - 100px);
}

@media screen and (max-width: 768px){
	.navbar{
		margin-bottom: -1px;
		height: 52px;
	}
	
	.navbar-collapse{
		width: 170px;
		background-color: #f8f8f8;
		z-index: 200;
		position: relative;
		float: right;
		-webkit-box-shadow: 0 3px 6px rgba(0,0,0,.175);
		box-shadow: 0 3px 6px rgba(0,0,0,.175);
	}
	
	#main{
		padding: 0px;
		height: calc(100% - 75px);
	}
}

@media screen and (min-width: 768px){
	.nav-sidebar{
		padding: 20px 0px; width: 200px; position: fixed; top: 52px; left: 0px; z-index: 10;
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
			<!-- @submenu -->
			<li class="dropdown-submenu">
				<a href="#">{name}</a>
				<ul class="dropdown-menu">
					<!-- @submenu-li -->
					<li><a href="#" onclick="$('#main').loadTab('', {m: '{link}'}, $(this).text());">{name}</a></li>
					<!-- @submenu-li -->
				</ul>
			</li>
			<!-- @submenu -->
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="hidden-md hidden-sm hidden-xs"><a href="#">{user}</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i> 設置 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				<!--li><a href="#">Action</a></li-->
					<li><a href="#" class="intro">使用說明</a></li>
					<li><a href="#" data-toggle="modal" data-target="#change_password_Modal">修改密碼</a></li>
					<li><a href="#" data-toggle="modal" data-target="#change_lang_Modal">切換語系</a></li>
					<li class="divider"></li>
					<li><a href="?m=sys_login&method=logout">登出</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

<div id="change_password_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div class="modal-dialog"><div class="modal-content">
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><i class="fa fa-key" aria-hidden="true"></i>修改密碼({user})</h4>
	</div>
	<form class="ajax">
	<div class="modal-body">
		<input class="form-control" name="password" type="password" placeholder="請輸入新密碼"/>
	</div>
	<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="submit" class="btn btn-primary modify">修改</button>
	</div>
	</form>
</div></div>
</div>

<div id="change_lang_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div class="modal-dialog"><div class="modal-content">
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><i class="fa fa-language" aria-hidden="true"></i>切換語系</h4>
	</div>
	<form class="ajax">
	<div class="modal-body">
		<!-- @lang --><!-- @lang -->
	</div>
	<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	</div>
	</form>
</div></div>
</div>

<script>
$(function(){
	//add active class script
	$('.nav-sidebar a').click(function(){
		$('.nav-sidebar li').removeClass('active');
		$(this).addClass('active');
		$(this).parents('li').addClass('active');
		$('title').text('後台系統: ' + $(this).text());
	});
	
	$('.dropdown-submenu').children('a').click(function(){
		$(this).next('.dropdown-menu').slideToggle();
	});
	
	$('.ajax').submit(function(){	
		
		$.ajax({
			url: '?m=sys_login&method=change',
			type: 'POST',
			data: $(this).serialize(),
			success: function(re){
				var jdata = JSON.parse(re);
				if(jdata['code']){
					// fail
				}else{
					$('#change_password_Modal').modal('hide');
				}
				customAlert(jdata);
			},
			error: function(){
				alert('ajax ERROR!!!');
			}
		});
		
		return false;
	});
	
	$('.intro').click(function(){
		$('#main').load('?m=sys_intro');
	});
});
</script>
<!-- @nav -->

<!-- @lang -->
<select class="form-control input-sm" onChange="location='?lang=' + $(this).val()">
	<!-- @option -->
	<option value="{value}" {selected}>{text}</option>
	<!-- @option -->
</select>
<!-- @lang -->

<!-- @intro -->
<script>
$('#main').load('?m=sys_intro');
</script>
<!-- @intro -->