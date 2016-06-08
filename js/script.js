var tips = [
	"註冊帳號以後要待管理員審核後方可使用",
	"如果權限不足將看不到功能按鈕",
	"點擊欄位可以查看內容",
	"點擊欄位標題將可以使用排序功能",
	"搜尋功能可以針對所有欄位使用"
];

$(document).ready(function(){
	setInterval("getTips()", 10000);
});

function getTips(){
	var pdata={ where:{ AND:{ valid_id: 1}}};
	$.ajax({
		url: './?m=form_bulletin',
		type: 'POST',
		data: { jdata: JSON.stringify({ pdata: pdata, method: 'getJson' }) },
		success: function(re) {
			var jdata = JSON.parse(re);
			if(jdata.length){
				var random_id = Math.floor((Math.random()*jdata.length));
				$('#random_tips').text("-[公告事項] "+jdata[random_id]['date']+": "+jdata[random_id]['content']);
			}else{
				$('#random_tips').text("-"+tips[Math.floor((Math.random()*tips.length))]+"-");
			}
		},
		error: function(){
				$('#random_tips').text("-"+tips[Math.floor((Math.random()*tips.length))]+"-");
			}
		});
	
}

function open(verb, url, data, target) {
	var form = document.createElement("form");
	form.action = url;
	form.method = verb;
	form.target = target || "_self";
	if (data) {
	for (var key in data) {
	var input = document.createElement("textarea");
	input.name = key;
	input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
	form.appendChild(input);
	}
	}
	form.style.display = 'none';
	document.body.appendChild(form);
	form.submit();
}


function customAlert(msg, arg){
	var arg = arg | 0;
	var info = ['<i class="fa fa-times-circle"></i> 錯誤', '<i class="fa fa-check-circle"></i> 成功', '<i class="fa fa-exclamation-circle"></i> 警告'];
	var type = ['danger', 'success', 'warning'];
	$('body').find('.err-msg-wrap').remove();
	$('body').append("<div class='err-msg-wrap' style='width: 100%;position: fixed;top: 0px;z-index: 1500;'><script>setTimeout(function(){ $('body').find('.err-msg-wrap').fadeOut(); }, 3000);</script><div class='alert alert-" + type[arg] + "' role='alert' style='width: 320px;position: relative;margin: auto;'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><p><strong>" + info[arg] + ": </strong>" + msg + "</p></div></div>");
}


function bindFormChkall(uid){
	var f = $('#' + uid + '_panel');
	var l = $('#' + uid + '_checked_list');
	f.find('.chkall').click(function(){
		if($(this).children().hasClass('fa-check-square-o')){
			$(this).children().removeClass('fa-check-square-o').addClass('fa-square-o');
			l.val('');
			
			f.find('.chklist').children().removeClass('fa-check-square-o').addClass('fa-square-o');
			f.find('.chklist').parent('.datalist').removeAttr('style');
		}else if($(this).children().hasClass('fa-square-o')){
			$(this).children().removeClass('fa-square-o').addClass('fa-check-square-o');
			var chkall = [];
			f.find('.chklist').parent().find('[name=\'id\']').each(function(i){ chkall[i] = $(this).text();});
			f.find('.chklist').parent().css('background-color', '#4285f4').css('color', '#fff').find('.chklist').children().removeClass('fa-square-o').addClass('fa-check-square-o');
			l.val(chkall.join());
		}
	});
}
function bindFormSort(uid){
	var f = $('#' + uid + '_panel');
	f.find('th.order').click(function(){
		var plus = '';
		var t = $(this).children();
		
		if(t.hasClass('fa-sort-alpha-asc')){
			f.find('input.search_adv').val('-order ' + $(this).attr('name') + ',DESC').trigger('change');
			plus = 'fa-sort-alpha-desc';
		}else if(t.hasClass('fa-sort-alpha-desc')){
			f.find('input.search_adv').val('').trigger('change');
			plus = '';
		}else{
			f.find('input.search_adv').val('-order ' + $(this).attr('name') + ',ASC').trigger('change');
			plus = 'fa-sort-alpha-asc';
		}
		f.find('th.order').children().removeClass('fa-sort-alpha-desc').removeClass('fa-sort-alpha-asc');
		t.addClass(plus);
	});
}

function bindFormChkall2(uid){
	var f = $('#' + uid + '_panel');
	var l = $('#' + uid + '_checked_list');
	
	
	f.find('table.review').find('.newdatalist').prepend('<td class=\'chklist\' style=\'width: 30px;\'><i class=\'fa fa-square-o\'></i></td>');
	f.find('.newdatalist').find('.chklist').click(function() {
		if($(this).children().hasClass('fa-check-square-o')){
			$(this).children().removeClass('fa-check-square-o').addClass('fa-square-o');
			$(this).parent('.datalist').removeAttr('style');
			
			var str = l.val();
			var arr = str.split(',');
			
			var val = $(this).parent().find('[name=\'id\']').text();
			var idx = jQuery.inArray( val, arr );
			
			//if found in array
			if(idx != -1){
				delete arr[idx];
				l.val($.grep(arr,function(n){ return(n) }));
			}
			
		}else{
			$(this).children().removeClass('fa-square-o').addClass('fa-check-square-o');
			$(this).parent('.datalist').css('background-color', '#4285f4').css('color', '#fff');
			
			if(l.val() == ''){
				l.val( $(this).parent().find('[name=\'id\']').text() );
			}else{
				l.val( l.val() + ',' + $(this).parent().find('[name=\'id\']').text() );
			}
		}
		//console.log('Info: checked list ' + l.val());
	});
	
	var str = l.val();
	var arr = str.split(',');
	
	//clear select and select again, filter is better than map contain values
	for(var i = 0; i < arr.length; i++){
		f.find('table.review').find('.newdatalist').find('[name=\'id\']').filter(function() {
			return $(this).text() === arr[i];
		}).parent('.newdatalist').css('background-color', '#4285f4').css('color', '#fff').find('.chklist').children().removeClass('fa-square-o').addClass('fa-check-square-o');
	}
}