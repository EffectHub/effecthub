$(function(){
	
	var length = $('.tools option').length;
	var tool = new Array();
	

	for (var i = 0 ; i < length ; i ++){
		tool[i] = new Array();
		tool[i][0] = $(".tools option:eq(" + i + ")").attr('name');
		tool[i][1] = $('.tools').get(0).options[i].value;
		tool[i][2] = $('.tools').get(0).options[i].text;
	}
	
	


	var idx = $('.category').get(0).selectedIndex;
	var type = $(".category option:eq(" + idx +")").attr('name');
	var itemtool = $("#itemtool").attr('name');
	$('.tools').empty();
	
	$(".tools").append("<option value='0'>None</option>");
	
	for (i = 0 ; i < length ; i ++){
		if (tool[i][0] == type) {
			if(tool[i][1]==itemtool)
				$(".tools").append("<option selected=\"selected\" value='" + tool[i][1] +"'>" + tool[i][2] + "</option>");
			else
				$(".tools").append("<option value='" + tool[i][1] +"'>" + tool[i][2] + "</option>");
		}
	}
	
	$('.category').change(function(){
		
		var idx = $('.category').get(0).selectedIndex;
		var type = $(".category option:eq(" + idx +")").attr('name');
		$('.tools').empty();
		
		$(".tools").append("<option value='0'>None</option>");
		for (i = 0 ; i < length ; i ++){
			if (tool[i][0] == type) {
				if(tool[i][1]==itemtool)
					$(".tools").append("<option selected=\"selected\" value='" + tool[i][1] +"'>" + tool[i][2] + "</option>");
				else
					$(".tools").append("<option value='" + tool[i][1] +"'>" + tool[i][2] + "</option>");
			}
		}
		
		
	});
	
	
	

	
});


