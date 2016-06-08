<?php
	$unique_id = 'analysis_' . rand();
?>


<div id='<?=$unique_id?>' class='container-fluid'>
	<div class='row table_wrap well'>
		<h3>系統資訊</h3>
		<a href='file/manual.pdf'>使用說明</a>
		<ul>
			<li>[優化] 選單分類調整</li>
			<li>[優化] 全選功能優化</li>
			<li>[新增] 點擊欄位標題排序功能</li>
		</ul>
	</div>
</div>


<script>
$(function(){

	$(window).resize(function(){
		var h = 150;
		if($(window).width()<992){
			h = 100;
		}
		$('#<?=$unique_id?>').find('div.table_wrap').css('height', $(window).height()-h);
	});
	$(window).trigger('resize');
});

</script>