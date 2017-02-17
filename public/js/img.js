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
			
			var gallery = $('<div class="gallery" style="opacity: 0; margin-top: 30px"><style>.icon-set{ white-space: nowrap; text-overflow: ellipsis; overflow: hidden; position: absolute; bottom: 25px; width: calc(100% - 32px); margin: 1px; padding: 7px; background-color: rgba(255,255,255,0.8);}</style></div>');
			
			$(this).after(gallery);
			
			// bind form reset event
			$(gallery).parents('form').on('reset', function(){
				$(gallery).remove();
			});
			
			var html = '';
			for(var i in arr){
				var dl = '<a href="' + arr[i]['url'] + '" download="' + arr[i]['name'] + '" target="_blank"><i class="fa fa-download"></i></a>';
				var rm = ' | <a href="#" class="delete"><i class="fa fa-trash"></i></a> ';
				html += '<div class="' + col + '"><div class="icon-set" title="' + arr[i]['name'] + '">' + dl + rm + arr[i]['name'] + '</div><a href="#" class="thumbnail"><img></a></div>';
			}
			
			// start loading
			$(gallery).append(html);
			
			var job = arr.length;
			
			$(gallery).find('.thumbnail').each(function(i){
				
				var tmp = this;
				var img = $(this).find('img');
				
				$(img).on('load', function(){
					job--;
				}).on('error', function(){
					$(this).attr('url', $(this).attr('src')).attr('src', 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=');
				}).attr('src', arr[i]['url']);
			});
			
			var refreshIntervalId = setInterval(function(){
				if(job == 0){
					$(gallery).find('.thumbnail').each(function(i){
						$(this).imgResize().imgEvent($(tar));
					});
					// smooth effect
					$(gallery).css('height', '').animate({opacity: 1}, 1000);
					clearInterval(refreshIntervalId);
				}
			}, 300);
			
			// resize event
			$(window).resize(function(){
				$(gallery).find('.thumbnail').each(function(){
					$(this).imgResize().imgEvent($(tar));
				});
			});
		});
	},
	// resize and center
	imgResize: function(){
		
		var tar = this;
		var img = $(tar).find('img');
		$(img).attr('style', '');
		
		var w = $(tar).width();
		var img_h = $(img).height();
		var img_w = $(img).width();
		
		// debug tool
		// console.log('div w: ' + w + 'px, img_h: ' + img_h + 'px, img_w: ' + img_w);
		$(tar).attr('style', 'height: ' + (w+10) + 'px');
		
		if(img_h > img_w){
			var width = img_w * w / img_h;
			$(img).attr('style', 'height:' + w + 'px; width:' + width + 'px');
		}else{
			var margin_top = ((w-img_h)/2);
			if(margin_top > 0){
				$(img).attr('style', 'margin-top:' + margin_top + 'px');
			}
		}
		return this;
	},
	// delete event
	imgEvent: function(input){
		
		var tar = this;
		var img = $(tar).find('img');
		
		$(tar).siblings('.icon-set').find('.delete').click(function(){
			var url = $(img).attr('url') || $(img).attr('src');
			
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