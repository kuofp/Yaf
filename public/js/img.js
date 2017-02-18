// require jquery/bootstrap/font-awesome
jQuery.fn.extend({
	uploadfile: function(init){
		
		var tar = this;
		var url = init.url;
		var col = init.col || 'col-sm-6';
		
		var bar = $('<div class="p" style="background-color: aquamarine; height: 3px; width: 0px; margin: 1px"></div>');
		var ctl = $('<input type="file" multiple>');
		
		$(tar).before(bar);
		$(tar).before(ctl);
		
		$(ctl).change(function(e){
			
			var upload = this;
			var data = new FormData();
			var files = $(this).get(0).files;
			
			for(var i in files){
				data.append(i, files[i]);
			}
			
			$.ajax({
				url:  url,
				type: 'POST',
				data: data,
				processData: false, // Don't process the files
				contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				success: function(re){
					
					var add = JSON.parse(re);
					var val = $(tar).val() || '[]';
					var arr = JSON.parse(val);
					for(var i in add){
						arr.push(add[i]);
					}
					
					// clear selected files, render gallery
					$(upload).val('');
					$(tar).val(JSON.stringify(arr)).trigger('preset');
				},
				error: function(){
					console.log('err: ajax file upload');
				},
				xhr: function(){
					var xhr = $.ajaxSettings.xhr() ;
					// set the onprogress event handler
					xhr.upload.onprogress = function(evt){
						$(bar).animate({width: (evt.loaded/evt.total*100) + '%'}, 100);
					} ;
					// set the onload event handler
					xhr.upload.onload = function(){
						$(bar).stop().animate({width: '0%'}, 10);
					} ;
					return xhr ;
				}
			});
			return false;
		});
		
		$(tar).on('preset', function(){
			
			var val = $(this).val() || '[]';
			var arr = JSON.parse(val);
			
			$(this).siblings('div.gallery').remove();
			
			// init
			if(!arr.length) return;
			
			var gallery = $('<div class="gallery"><style>.icon-set{ white-space: nowrap; text-overflow: ellipsis; overflow: hidden; position: absolute; bottom: 20px; width: 100%; padding: 5px; background-color: rgba(0,0,0,0.8); color: white}</style></div>');
			
			$(this).after(gallery);
			
			// bind form reset event
			$(gallery).parents('form').on('reset', function(){
				$(gallery).remove();
			});
			
			var html = '';
			for(var i in arr){
				
				arr[i]['ext'] = (arr[i]['name'].split('.')[1] || 'na').toLowerCase();
				
				var dl = '<a href="' + arr[i]['url'] + '" download="' + arr[i]['name'] + '" target="_blank"><i class="fa fa-download"></i></a>';
				var rm = ' | <a href="#" class="delete"><i class="fa fa-trash"></i></a> ';
				
				html += '<div style="position: relative; float: left; margin: 10px;"><a class="thumbnail" href="#"><table style="width: 100px; height: 100px;"><tr><td style="text-align: center"><img src="' + arr[i]['url'] + '" class="img-responsive" style="max-width: 100px; max-height: 100px; margin: 0 auto;"/></td></tr></table></a>         <div class="icon-set" title="' + arr[i]['name'] + '">' + dl + rm + arr[i]['name'] + '</div></div>';
			}
			console.log(arr);
			
			// start loading
			$(gallery).append(html);
			
			$(gallery).find('.thumbnail').each(function(i){
				
				$(this).imgEvent($(tar));
				
				$(this).find('img').on('load', function(){
					
				}).on('error', function(){
					$(this).addClass('hidden').after('<i class="fa fa-file fa-3x" style="position: relative;color: brown;"><span style="position: absolute; top: 25px; left: 6px; color: azure; font-size: 11px;">' + arr[i]['ext'] + '</span></i>');
				});
			});
		});
	},
	// delete event
	imgEvent: function(input){
		
		var tar = this;
		var img = $(tar).find('img');
		
		$(tar).siblings('.icon-set').find('.delete').click(function(){
			var url = $(img).attr('src');
			
			var arr = JSON.parse($(input).val());
			for(var i in arr){
				if(arr[i]['url'] == url){
					arr.splice(i, 1);
					break;
				}
			}
			
			$(input).val(JSON.stringify(arr));
			$(tar).parent('div').remove();
		});
		return this;
	}
});