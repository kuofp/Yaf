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
			f.find('.chklist').parent().find('[name=id]').each(function(i){ chkall[i] = $(this).text();});
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
	
	
	f.find('table.review').find('.newdatalist').prepend('<td class="chklist" style="width: 30px;"><i class="fa fa-square-o"></i></td>');
	f.find('.newdatalist').find('.chklist').click(function() {
		if($(this).children().hasClass('fa-check-square-o')){
			$(this).children().removeClass('fa-check-square-o').addClass('fa-square-o');
			$(this).parent('.datalist').removeAttr('style');
			
			var str = l.val();
			var arr = str.split(',');
			
			var val = $(this).parent().find('[name=id]').text();
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
				l.val( $(this).parent().find('[name=id]').text() );
			}else{
				l.val( l.val() + ',' + $(this).parent().find('[name=id]').text() );
			}
		}
		//console.log('Info: checked list ' + l.val());
	});
	
	var str = l.val();
	var arr = str.split(',');
	
	//clear select and select again, filter is better than map contain values
	for(var i = 0; i < arr.length; i++){
		f.find('table.review').find('.newdatalist').find('[name=id]').filter(function() {
			return $(this).text() === arr[i];
		}).parent('.newdatalist').css('background-color', '#4285f4').css('color', '#fff').find('.chklist').children().removeClass('fa-square-o').addClass('fa-check-square-o');
	}
}


function bindFormViewComplete(uid){
	var f = $('#' + uid + '_panel');
	var c = $('#' + uid + '_item_cnt');
	var r = $('#' + uid + '_review_complete');
	var t = $('#' + uid + '_target_id');
	var m = $('#' + uid + '_Modal');
	
	f.find('input.search').on('input', function (){ f.find('table.review').trigger('refresh',{type: 'review'}); });
	f.find('input.search_adv').on('keyup keydown change', function (){ f.find('table.review').trigger('refresh',{type: 'review'}); });
	c.change(function(){ f.find('.item_cnt').text($(this).val()); });
	bindFormSort( uid );
	bindFormChkall( uid );
	f.find('button.review').click(function(){ $(this).addClass('buttonLoading').button('loading'); f.find('table.review').trigger('refresh',{type: 'append', max: 50});});


	r.change(function(){
		
		
		//set newdatalist js events
		f.find('table.review').find('.newdatalist').children().not('.chklist').click(function(){
			t.val( $(this).parent().find(' [name=id] ').text());
			t.trigger('change');
			m.find('.modal-footer').children('div').hide();
			m.find('.modal-footer').find('div.modify').show();
			m.modal('show');
		});
		
		
		bindFormChkall2( uid );
		
		
		$('.buttonLoading').button('reset');
		f.find('table.review').find('.newdatalist').addClass('datalist').removeClass('newdatalist');
		//f.find('table.review').find('.last').sortable();
		
		
		//item count
		c.val( f.find('table.review').find('.datalist').length ).trigger('change');
		console.log('Info: total ' + c.val() + ' items');
	});
}


function bindFormAjaxOnRefresh(uid, url, table){
	var f = $('#' + uid + '_panel');
	var c = $('#' + uid + '_item_cnt');
	var r = $('#' + uid + '_review_complete');
	
	f.find('table.review').on('refresh', function (e,obj){
		var str_id = (typeof obj.id === 'undefined') ? '' : obj.id;
		var arr_id = str_id.split(',');
		for(var i = 0; i < arr_id.length; i++){
			var int_id = parseInt(arr_id[i]);
			var pdata={data:{},where:{ AND: {}}};
			var arr_like={};
			var arr_or={};
			var max_ = (typeof obj.max === 'undefined') ? 50 : obj.max;
			var rule_ = (typeof obj.rule === 'undefined') ? {'id': 'DESC'} : obj.rule;
			var keyword = f.find('input.search').val();
			var keyword_adv = f.find('input.search_adv').val();
	
			switch(obj.type){
				case 'review':
					c.val(0);
				case 'append':
					pdata['where']['ORDER'] = rule_;
					pdata['where']['LIMIT'] = [c.val(), max_];
					pdata['where']['SEARCH'] = keyword;
					pdata['where']['SEARCH_ADV'] = keyword_adv;
					break;
				case 'create':
				case 'modify':
				case 'delete':
					pdata['where']['AND'][table + '.id'] = int_id;
					pdata['where']['SEARCH'] = keyword;
					pdata['where']['SEARCH_ADV'] = keyword_adv;
					break;
				default:
					break;
			}
		
		
			$.ajax({
				url: url,
				idx: i,
				type: 'POST',
				data: {jdata: JSON.stringify({ pdata: pdata, method: 'review' })},
				success: function(re) {
					var int_id = parseInt(arr_id[this.idx]);
					
					var jdata = JSON.parse(re);
					//console.log('Info: refresh err ' + jdata['err'].join(', '));
					
					//debug for search_adv 
					//console.log(jdata['err']);
					
					switch(obj.type){
						
						case 'review':
							c.val(0);
						case 'append':
							
							if(c.val() == 0){
								f.find('table.review').find('.datalist').remove();
							}
							if(jdata['cnt'] > 0){
								f.find('table.review').find('.last').append(jdata['data']);
							}
							if(jdata['cnt'] == max_){
								f.find('button.review').show();
								f.find('p.empty_text').addClass('hidden');
							}else{
								f.find('button.review').hide();
								f.find('p.empty_text').removeClass('hidden');
							}
							break;
						case 'create':
							f.find('table.review').find('.last').prepend(jdata['data']);
							break;
						case 'modify':
							f.find('table.review').find('[name=id]').filter(function() {
								return $(this).text() == int_id;
							}).parent('.datalist').replaceWith(jdata['data']);
							break;
						case 'delete':
							f.find('table.review').find('[name=id]').filter(function() {
								return $(this).text() == int_id;
							}).parent('.datalist').remove();
							break;
						default:
							break;
					}
					
					
					r.trigger('change');
				},
				error: function() {
					alert('ajax ERROR!!!');
				}
			});
		}
	}).trigger('refresh',{type: 'review'});
}

function bindFormAjaxByMethod(uid, url, method){
	var f = $('#' + uid + '_panel');
	var m = $('#' + uid + '_Modal');
	
	m.find('button.' + method).click(function(){
		var btn = $(this).addClass('buttonLoading').button('loading');
		var pdata={data:{},where:{AND:{}}};
		pdata['data'] = m.find('form:first').serialize();
		
		$.ajax({
			url: url,
			type: 'POST',
			data: { jdata: JSON.stringify({ pdata: pdata, method: method }) },
			success: function(re) {
				var jdata = JSON.parse(re);
				if(jdata['err'] == 'success'){
					f.find('table.review').trigger('refresh',{type: method, id: jdata['id']});
					m.modal('hide');
				}else if(jdata['err'] == 'err_empty'){
					customAlert('請檢查必填欄位');
				}else if(jdata['err'] == 'err_exist'){
					customAlert('請檢查重複值');
				}else console.log(re);
				$('.buttonLoading').button('reset');
			},
			error: function() {alert('ajax ERROR!!!');}
		});
	});
}

function bindFormCreateTool(uid, url){
	var f = $('#' + uid + '_panel');
	var m = $('#' + uid + '_Modal');
	
	f.find('div.toollist').find('button.main').text('新增').addClass('create');
	m.find('.modal-footer').find('div.create').append('<button class="btn btn-default create">新增</button>');
	f.find('div.toollist').find('button.create').click(function(){
		m.find('form')[0].reset();
		m.find('.modal-footer').children('div').hide();
		m.find('.modal-footer').find('div.create').show();
		m.modal('show');
	});
	
	bindFormAjaxByMethod(uid, url, 'create');
}


function bindFormModifyTool(uid, url){
	var m = $('#' + uid + '_Modal');
	
	m.find('.modal-footer').find('div.modify').append('<button class="btn btn-default modify">儲存</button>');
	bindFormAjaxByMethod(uid, url, 'modify');
}


function bindFormDeleteTool(uid, url){
	var f = $('#' + uid + '_panel');
	var m = $('#' + uid + '_Modal');
	var t = $('#' + uid + '_target_id');
	
	m.find('.modal-footer').find('div.modify').append('<button class="btn btn-danger delete"><i class="fa fa-trash-o fa-lg"></i> 刪除</button>');
	m.find('button.delete').click(function(){
		if(confirm('確定要刪除?')){
			var btn = $(this).addClass('buttonLoading').button('loading');
			var pdata={data:{},where:{ AND:{}}};
			
			pdata['where']['AND']['id'] = t.val();
			$.ajax({
				url: url,
				type: 'POST',
				data: { jdata: JSON.stringify({ pdata: pdata, method: 'delete' }) },
				success: function(re) {
					var jdata = JSON.parse(re);
					if(jdata['err'] == 'success'){
						f.find('table.review').trigger('refresh',{type:'delete', id: jdata['id']});
						m.modal('hide');
					}else if(jdata['err'] == 'err_delete'){
						customAlert('刪除失敗');
						$('.buttonLoading').button('reset');
						m.modal('hide');
					}
					else console.log(re);}
			});
		}
	});
}

function bindFormMailTool(uid, url, table, source){
	var mm = $('#' + uid + '_Mail_Modal');
	
	mm.find('[name=mailto]').autocomplete({source: source});
	mm.find('[name=mailcc]').autocomplete({source: source});
	
	var f = $('#' + uid + '_panel');
	var l = $('#' + uid + '_checked_list');
	
	f.find('ul.toollist').append('<li><a href="#" class="mail">從郵件寄送</a></li>');
	f.find('ul.toollist').find('a.mail').click(function(){
		mm.find('form')[0].reset();
		mm.find('[name=title]').val('【通知】資料報表通知: ' + $.datepicker.formatDate('yy-mm-dd', new Date()));
		mm.find('[name=report]').empty().css('padding', 0);
		
		
		mm.modal('show');
		
		var str = l.val();
		var arr = str.split(',');
		var pdata={data:{},where:{ }};
		pdata['where'][table + '.id'] = arr;
		pdata['where']['ORDER'] = {[table + '.id']: arr}; //last choose at last
		
		$.ajax({
			url: url + '&style=print',
			type: 'POST',
			data: { jdata: JSON.stringify({ pdata: pdata, method: 'review' }) },
			success: function(re) {
				var jdata = JSON.parse(re);
				
				if(jdata.cnt == 0){
					mm.find('[name=report]').append('<p>未勾選資料表項目</p>');
				}else{
					mm.find('[name=report]').css('padding', '50px 0').append(jdata.data);
				}
			}
		});
	});
	
	mm.find('div.mail').append('<button class="btn btn-primary mail">寄送</button>');
	
	
	mm.find('button.mail').click(function(){
		$(this).addClass('buttonLoading').button('loading');
		var pdata = {
			data: {
				from: mm.find('[name=mailfrom]').val(),
				mailto: mm.find('[name=mailto]').val(),
				mailcc: mm.find('[name=mailcc]').val(),
				title: mm.find('[name=title]').val(),
				content: mm.find('[name=content]').val(),
				report: mm.find('[name=report]').html(),
				attach: mm.find('[name=attach]').val(),
				attach_name: mm.find('.attach_label').text()
			}
		};
		
		$.ajax({
			url: url,
			type: 'POST',
			data: { jdata: JSON.stringify({ pdata: pdata, method: 'mailto' }) },
			success: function(re) {
				if(re == 'success'){
					customAlert('寄送成功!', 1);
					mm.modal('hide');
				}
				else if(re == 'err_mailer') customAlert('請檢查收件者等欄位');
				
				$('.buttonLoading').button('reset');
			}
		});
	});
}

function bindFormExportTool(uid, url, table){
	var f = $('#' + uid + '_panel');
	var l = $('#' + uid + '_checked_list');
	
	f.find('ul.toollist').append('<li><a href="#" class="print">列印表格</a></li>');
	f.find('ul.toollist').append('<li><a href="#" class="excel">匯出至Excel表格</a></li>');
	
	f.find('ul.toollist').find('a.print').click(function(){
		
		var str = l.val();
		var arr = str.split(',');
		var pdata={data:{},where:{ OR:{}}};
		pdata['where'][table + '.id'] = arr;
		pdata['where']['ORDER'] = {[table + '.id']: arr}; //last choose at last
		$.ajax({
			url: url + '&style=print',
			type: 'POST',
			data: { jdata: JSON.stringify({ pdata: pdata, method: 'review' }) },
			success: function(re) {
				var jdata = JSON.parse(re);
				
				$('.genPrint').remove();
				$('body').after('<div class="genPrint">' + $('title').text() + '<br>' + jdata.data + '</div>');
				window.print();
				
				
			}
		});
	});
	f.find('ul.toollist').find('a.excel').click(function(){
		var str = l.val();
		var arr = str.split(',');
		var pdata={data:{},where:{ OR:{}}};
		pdata['where'][table + '.id'] = arr;
		pdata['where']['ORDER'] = {[table + '.id']: arr}; //last choose at last
		$.ajax({
			url: url + '&style=print',
			type: 'POST',
			data: { jdata: JSON.stringify({ pdata: pdata, method: 'review' }) },
			success: function(re) {
				var jdata = JSON.parse(re);
				
				open('POST', './?m=plugin_excel&method=print', {data: jdata.data}, '_blank');
			}
		});
	});
}