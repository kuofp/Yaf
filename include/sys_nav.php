<?php if(!isset($_SESSION['user_id'])){ header("Refresh: 0;URL= index.php"); exit;} ?>
<style>
/*NAV*/
/*nav.navbar{
	-webkit-box-shadow: 0 3px 6px rgba(0,0,0,.175);
	box-shadow: 0 3px 6px rgba(0,0,0,.175);
}*/

@media screen and (max-width: 768px) {
	.dropdown-submenu>.dropdown-menu{
		left: 0px;
		width: 100%;
	}
}

@media screen and (min-width: 992px) {
    .nav-sidebar{
        padding: 20px 0px; width: 200px; position: fixed; top: 52px; left: 0px; z-index: 100;
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
		<a class="navbar-brand" href="#"><!--img alt="Brand" src="img/logo/logo.png" style="display: inline-block"--><span style=" font-weight: bold; font-size: 20px; font-family:Microsoft JhengHei;"><?=$cfg_brand?></span></a>
	</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
		<ul class="nav navbar-nav nav-sidebar">
		<?php getSubMenu($cfg_nav);?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="hidden-md hidden-sm hidden-xs"><a href="#"><?php echo $_SESSION['user_name'] . "(" . $_SESSION['user_mail'] . ")"; ?></a></li>
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
		<h4 class="modal-title">修改密碼(<?php echo $_SESSION['user_mail']; ?>)</h4>
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
	$('#change_password_Modal').find('[name=\'password\']').val('');
	$('#change_password_Modal').modal('show');
});
	
$('.ajax').submit(function(e){	
	e.preventDefault();
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
});

$('.intro').click(function(){ $('#main').load('./?m=sys_intro'); });

</script>