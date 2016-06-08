<?php
include_once('./config/nav.inc.php');
$module = $_GET['m'];
$grid = $_GET['g'];
?>
<div class="container-fluid">
	<div class="row">
	<?php for($i=0; $i<count($grid); $i++):?>
		<div class="col-sm-<?=$grid[$i]?> col-md-<?=$grid[$i]?> col-lg-<?=$grid[$i]?>" onload="$(this).load('<?=$cfg_mod[$module[$i]]?>');"></div>
	<?php endfor;?>
	</div>
</div>

<script>
$(function(){
	$('div[onload]').trigger('onload');
});
</script>