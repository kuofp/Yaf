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
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
	
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	
	<!-- Patch for Multi-Modal -->
	<link rel="stylesheet" href="css/bootstrap-modal-bs3patch.css">
	<link rel="stylesheet" href="css/bootstrap-modal.css">
	
	<!-- Patch for Multi-Menu -->
	<link rel="stylesheet" href="css/bootstrap-menu-bs3patch.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<!-- Patch for Multi-Modal -->
	<script src="js/bootstrap-modalmanager.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	
	<!-- font-awesome-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<!-- js -->
	<script src="js/script.js"></script>
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

	// alphanumeric check
	$('.alphanumeric_check').keyup(function(){
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

<div class="col-sm-6 col-md-4 center-block" style="max-width: 400px; float: none">
	<div id="login_panel" class="panel panel-default">
		<div class="panel-body">
			<h1 style="font-family:Microsoft JhengHei; font-weight: bold">{title}</h1>
			<form class="ajax" method="POST" action="./?m=sys_login&method=login">
				<input type="text" name="account" class="form-control input-sm alphanumeric_check" placeholder="帳號"/>
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
	.navbar{
		margin-bottom: -1px;
	}
	#main{
		padding: 0px;
		height: calc(100% - 51px);
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
			<li class="hidden-md hidden-sm hidden-xs"><a href="#">{user}</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i> 設置 <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				<!--li><a href="#">Action</a></li-->
					<li><a href="#" class="intro">使用說明</a></li>
					<li><a href="#" data-toggle="modal" data-target="#change_password_Modal">修改密碼</a></li>
					<li><a href="#" data-toggle="modal" data-target="#change_lang_Modal">切換語系</a></li>
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
		<h4 class="modal-title"><i class="fa fa-key" aria-hidden="true"></i>修改密碼({user})</h4>
	</div>
	<form class="ajax">
	<div class="modal-body">
		<input class="form-control" name="password" type="password" placeholder="請輸入新密碼"/>
	</div>
	<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="submit" class="btn btn-primary modify">修改</button>
	</div>
	</form>
</div>

<div id="change_lang_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><i class="fa fa-language" aria-hidden="true"></i>切換語系</h4>
	</div>
	<form class="ajax">
	<div class="modal-body">
		<!-- @lang --><!-- @lang -->
	</div>
	<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><!--button type="submit" class="btn btn-primary modify">修改</button-->
	</div>
	</form>
</div>


<script>
$(function(){
	//add active class script
	$('.nav-sidebar a').click(function(){
		$('.nav li').removeClass('active');
		$(this).addClass('active');
		$(this).parents('li').addClass('active');
		$('title').text('後台系統: ' + $(this).text());
	});
	
	$('.ajax').submit(function(){	
		
		$.ajax({
			url: './?m=sys_login&method=change',
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
		$('#main').load('./?m=sys_intro');
	});
});
</script>
<!-- @nav -->

<!-- @lang -->
<select class="form-control input-sm" onChange="location='./?lang=' + $(this).val()">
	<!-- @option -->
	<option value="{value}" {selected}>{text}</option>
	<!-- @option -->
</select>
<!-- @lang -->

<!-- @intro -->
<script>
$('#main').load('./?m=sys_intro');
</script>
<!-- @intro -->