var tips = [
	"註冊帳號以後要待管理員審核後方可使用",
	"如果權限不足將看不到功能按鈕",
	"點擊欄位可以查看內容",
	"點擊欄位標題將可以使用排序功能",
	"搜尋功能可以針對所有欄位使用"
];

$(document).ready(function(){
	setInterval(function(){
		$('#random_tips').text("-"+tips[Math.floor((Math.random()*tips.length))]+"-");
	}, 10000);
});

function customAlert(msg, arg){
	var arg = arg | 0;
	var info = ['<i class="fa fa-times-circle"></i> 錯誤', '<i class="fa fa-check-circle"></i> 成功', '<i class="fa fa-exclamation-circle"></i> 警告'];
	var type = ['danger', 'success', 'warning'];
	$('body').find('.err-msg-wrap').remove();
	$('body').append("<div class='err-msg-wrap' style='width: 100%;position: fixed;top: 0px;z-index: 1500;'><script>setTimeout(function(){ $('body').find('.err-msg-wrap').fadeOut(); }, 3000);</script><div class='alert alert-" + type[arg] + "' role='alert' style='width: 320px;position: relative;margin: auto;'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><p><strong>" + info[arg] + ": </strong>" + msg + "</p></div></div>");
}