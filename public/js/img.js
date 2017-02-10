jQuery.fn.extend({
	uploadfile: function(){
		var tar = this;
		$(tar).before('<input class="form-control input-sm" type="file" multiple>');
		$(tar).prev('[type=file]').change(function(e){
			var upload = this;
			var data = new FormData();
			var files = $(this).get(0).files;
			
			for(var i in files){
				data.append(i, files[i]);
			}
			
			$.ajax({
				url:  '?m=plugin_files',
				type: 'POST',
				data: data,
				processData: false, // Don't process the files
				contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				success: function(re){
					
					var add = JSON.parse(re);
					
					var arr = JSON.parse($(tar).val());
					for(var i in add){
						arr.push(add[i]);
					}
					// clear selected files, render gallery
					$(upload).val('');
					$(tar).val(JSON.stringify(arr)).trigger('preset');
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log('err: ajax file upload');
				}
			});
			return false;
		});
		
		$(tar).on('preset', function(){
			var arr = JSON.parse($(this).val());
			$(this).siblings('div.gallery').remove();
			
			$(this).after('<div class="gallery" style="margin-top: 15px"><style>.icon-set{ white-space: nowrap; text-overflow: ellipsis; overflow: hidden; position: absolute; bottom: 25px; width: calc(100% - 30px); padding: 7px; background-color: rgba(0,0,0,0.2);}</style></div>');
			
			var html = '';
			for(var i in arr){
				var dl = '<a href="?m=plugin_files&method=download&url=' + arr[i]['url'] + '&name=' + arr[i]['name'] + '" target="_blank"><i class="fa fa-download"></i></a>';
				var rm = ' | <a href="#" class="delete"><i class="fa fa-trash"></i></a> ';
				html += '<div class="col-sm-6"><div class="icon-set" title="' + arr[i]['name'] + '">' + dl + rm + arr[i]['name'] + '</div><a href="#" class="thumbnail"><img ></a></div>';
			}
			$(this).siblings('.gallery').append(html);
			
			$(this).siblings('.gallery').find('.thumbnail').each(function(i){
				
				var tmp = this;
				var img = $(this).find('img');
				
				$(img).on('load', function(){
					$(tmp).imgResize().imgEvent($(tar));
				}).on('error', function(){
					$(this).attr('url', $(this).attr('src')).attr('src', 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=');
				}).attr('src', arr[i]['url']);
			});
			
			//resize event
			$(window).resize(function(){
				$(tar).siblings('.gallery').find('.thumbnail').each(function(){
					$(this).imgResize().imgEvent($(tar));
				});
			});
		});
	},
	imgResize: function(){
		var tar = this;
		var img = $(tar).find('img');
		$(img).attr('style', '');
		
		var w = $(tar).width();
		var img_h = $(img).height();
		var img_w = $(img).width();
		
		//debug tool
		//console.log('div w: ' + w + 'px, img_h: ' + img_h + 'px, img_w: ' + img_w);
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