var tips = [
	'註冊帳號以後要待管理員審核後方可使用',
	'如果權限不足將看不到功能按鈕',
	'點擊欄位可以查看內容',
	'點擊欄位標題將可以使用排序功能',
	'搜尋功能可以針對所有欄位使用'
];

$(function(){
	setInterval(function(){
		$('#random_tips').text("-" + tips[Math.floor(Math.random() * tips.length)] + "-");
	}, 10000);
});

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