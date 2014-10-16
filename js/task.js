//var url_root = "http://localhost/effecthub/index.php";
var url_root = "http://www.effecthub.com";
$(document).ready(function () {
	/**
	 * show all the comments to the special answer
	 */
	$('#answer-comments').live('click',function()
	{
		var root_comment_id = $(this).parent().parent().parent().attr('comment_id');
//		alert(comment_id);
		
		var reply_box_id = '#reply-box'+root_comment_id;
		var reply_box =  $(reply_box_id);
//		alert(reply_box.attr('name'));
		
		if(reply_box.is(':empty'))		
		{
			//Currently, the content is empty, so we just need fill the content			
			$.ajax({  
		           type:"GET"	           
		   		   ,data:{}
		           ,url:url_root + "/task/find_replies/" + root_comment_id
		           ,success:function(data){	        	   
//		        	   alert(data);
		        	   var obj = JSON.parse(data);
		        	   var root_comment_id = obj[0].root_comment_id;
		        	   var root_author_id =  obj[0].root_author_id;
		        	   
		        	   var reply_box_id = '#reply-box'+root_comment_id;
		        	   var reply_box =  $(reply_box_id);
		        	   
		        	   var reply_box_innerhtml = '<div id="answer-reply-area" root_comment_id="'+root_comment_id+'" root_author_id="'+root_author_id+'">'
		        		   						+'<textarea rows="1" name="reply-content" class="reply-content"></textarea>'
		        		   						+'<a style="cursor:pointer;" class="answer-reply-button form-sub" name="' + root_comment_id + '">'+lang_reply+'</a>'
		        		   						+'</div>';

					
		        	   //
		        	   //start parser all the reply items
		        	   //
		        	   for(var index = 1; index < obj.length; index++)
	        		   {
		        		   var replyItem = obj[index];
		        		   var singleReply = '';
		        		   var replyparentHtml = '';
		        		   if(replyItem.parent_user)
		        		   {
		        			   replyparentHtml = '&nbsp;'+lang_reply_call+'&nbsp;'
		        			   					+ '<a href="' + url_root + '/user/' + replyItem.parent_user.id + '">'
				        			   			+             replyItem.parent_user.name
				        			   			+ '</a>'			       
		        		   }
		        		   
		        		   var singleReply = '<div class="single-reply" reply_id="'	+ replyItem.id + '" style="border-bottom:2px solid #ddd;">'
							   				+ '<div class="reply-user" author_id='+replyItem.author_id+'>'
							   				+     '<a class="reply-img" href="' + url_root + '/user/' +replyItem.author_id + '">'
							   				+         '<img src="' + replyItem.author_pic + '"/>'
							   				+     '</a>'
					   			   			+	  '<div class="reply-username">'
					   			   			+	      '<a href="' + url_root + '/user/' + replyItem.author_id + '">'
					   			   			+             replyItem.author_name
					   			   			+	      '</a>'
					   			   			+ 			replyparentHtml
					   			   			+     '</div>'
							   				+ '</div>'
							   				+ '<div class="r-content">'// r means reply, used to diff from comment
							   				+     '<p>' + replyItem.comment_content + '</p>'
							   				+     '<p style="color:#aaa;font-size:12px">' 
							   				+ 			replyItem.update_date
							   				+ '   <a  class="reply-link" parent_comment_id="'+replyItem.id+'" parent_author_id="'+replyItem.author_id+'">'+lang_reply_call+'</a>'
							   				+     '</p>'							   				
	        		   						+ 	'<textarea class="reply-r-content" style="overflow: hidden;display: none;" rows="1"></textarea>'	        		   						
							   				+ '</div>'							   				
							   				+ '</div>';
//		        		   alert(singleReply);
		        		   reply_box_innerhtml = reply_box_innerhtml + singleReply; 
		        		   
	        		   }
//		        	   alert(reply_box.attr('name'));
		        	   reply_box.html(reply_box_innerhtml);
		        	   reply_box.css('display','block');
		        	}	           
		           ,error:function(data){
		        	   alert('error:' + data);
		        	   }
		  
		           });
		}
		else
		{
			if( reply_box.css('display')=='block'){
				// the content is not empty, just show the block
				reply_box.css('display','none');

			}
			else
			{		
//				alert('none');			
				reply_box.css('display','block');
			}
		}
		
		
		
	});
	$('.answer-reply-button').live('click',function(){		
		//step1: save data into database
		if(!user_id)
		{
			alert('please log on first');
			return;
		}
		
		var content = $(this).prev('.reply-content').val();
		var parent = $(this).parent().attr('root_comment_id');
		var root_comment_id = $(this).parent().attr('root_comment_id');		
		var task = $('#main').attr('task_id');
		var parent_author_id = $(this).parent().attr('root_author_id');
		var root_author_id = $(this).parent().attr('root_author_id');

		if (content==null||content==''){
			alert('content:' +blank);
    		return;
    	}		
		else
		{
			//alert('content:' +content);
		}
		

		$(this).html(task_commenting);
		$.ajax({  
            type:"POST" 
            ,url:url_root + '/task/savereply'  
            ,data:{
				desc: content,
				parent: parent,
				task: task,				
				parent_author_id:parent_author_id,
				root_comment_id: root_comment_id,
				root_author_id: root_author_id				
			}              
            ,success:function(data){  
//              alert('success' + data);
              var obj = JSON.parse(data);
              var appendHtml = '<div class="single-reply" reply_id="'	+ obj.comment_id + '" style="border-bottom:2px solid #ddd;">'
				 				+ '<div class="reply-user" author_id='+obj.author_id+'>'
				   				+     '<a class="reply-img" href="' + url_root + '/user/' +obj.author_id + '">'
				   				+         '<img src="' + obj.author_pic + '"/>'
				   				+     '</a>'
					   			+	  '<div class="reply-username">'
					   			+	      '<a href="' + url_root + '/user/' + obj.author_id + '">'
					   			+             obj.author_name
					   			+	      '</a>'					   			
					   			+     '</div>'
				   				+ '</div>'
				   				+ '<div class="r-content">'// r means reply, used to diff from comment
				   				+     '<p>' + obj.comment_content + '</p>'
				   				+     '<p style="color:#aaa;font-size:12px">' 
				   				+ 			obj.update_date				   				
				   				+ 		'   <a  class="reply-link" parent_comment_id="'+obj.comment_id+'" parent_author_id="'+obj.author_id+'">'+lang_reply_call+'</a>'
				   				+     '</p>'							   				
		   						+ 	'<textarea style="overflow: hidden;display: none" rows="1" class="reply-r-content"></textarea>'		   						
				   				+ '</div>'
				   				+'</div>';
              var reply_box_id = '#reply-box'+root_comment_id;
       	   	  var reply_box =  $(reply_box_id);
       	   	  $(reply_box_id+' #answer-reply-area').after(appendHtml);
//       	   	  alert($(reply_box_id+' #answer-reply-area .answer-reply-button').html());
       	   	  $(reply_box_id+' #answer-reply-area .reply-content').val('');
       	      $(reply_box_id+' #answer-reply-area .answer-reply-button').html(lang_reply);
            }//请求成功后  
            ,error:function(data){
            	alert('error' + data);
            }//请求错误  
         }); 

		
	});	 
	$('.single-reply').live('mouseenter',function(){
		var obj = $(this).find('.reply-link');
		obj.css('display','inline');				
	});
	$('.single-reply').live('mouseleave',function(){
		//alert('mouse leave');		 
		var obj = $(this).find('.reply-link');
		obj.css('display','none');	
	});
	$('.reply-link').live('click',function(){
		//alert('mouse leave');		 
		//step1: save data into database
		if(!user_id)
		{
			alert('please log on first');
			return;
		}
		//
 		// if the parent id is equal to the author_id
 		// it is the one replying himself
 		//	
//		alert($(this).parent().parent().prev().attr('author_id'));
//		alert(user_id);
 		if($(this).parent().parent().prev().attr('author_id') == user_id )
 		{
 			alert("you cannot reply yourself");
 			return;
 		}
		var obj = $(this).parent().next();
		if(obj.css('display') == 'block')
		{
			obj.css('display','none');
		}
		else
		{
			obj.css('display','block');
		}
	});
	$('.reply-r-content').live('keypress',function(e){
		var p = e.which;
	     if(p==13){
	    	 //
	    	 // if the value of the textarea is empty or null
	    	 // just hide the text area	
	    	 //
	    	 if($(this).val() == null || $.trim($(this).val()) == '')
    		 {
    		 	$(this).css('display','none');
    		 	return;
    		 }
	    	 
	    	 var content = $(this).val();	    	 
	 		var parent = $(this).parent().parent().attr('reply_id');
	 		var root_comment_id = $(this).parent().parent().parent().parent().attr('comment_id');		
	 		var task = $('#main').attr('task_id');
	 		var parent_author_id = $(this).parent().prev().attr('author_id');
	 		var root_author_id = $(this).parent().parent().prev().attr('root_author_id');
	 		
	 		$(this).val('');
	 			
	    	 
//	         alert('enter was pressed:' 
//	        		+' content:' +content
//	        		+' parent:' + parent
//	        		+' root_comment_id:' + root_comment_id
//	        		+' task:' + task
//	        		+' parent_author_id:' + parent_author_id
//	        		+' root_author_id:' + root_author_id);
	         $.ajax({  
	             type:"POST" 
	             ,url:url_root + '/task/savereply'  
	             ,data:{
	 				desc: content,
	 				parent: parent,
	 				task: task,				
	 				parent_author_id:parent_author_id,
	 				root_comment_id: root_comment_id,
	 				root_author_id: root_author_id				
	 			}              
	             ,success:function(data){  
//	               alert('success' + data);
	               var obj = JSON.parse(data);
	               var root_comment_id = obj.root_comment_id;
	               var appendHtml = '<div class="single-reply" reply_id="'	+ obj.comment_id + '" style="border-bottom:2px solid #ddd;">'
	 				 				+ '<div class="reply-user" author_id='+obj.author_id+'>'
	 				   				+     '<a class="reply-img" href="' + url_root + '/user/' +obj.author_id + '">'
	 				   				+         '<img src="' + obj.author_pic + '"/>'
	 				   				+     '</a>'
	 					   			+	  '<div class="reply-username">'
	 					   			+	      '<a href="' + url_root + '/user/' + obj.author_id + '">'
	 					   			+             obj.author_name
	 					   			+	      '</a>'
		 					   		+         '&nbsp;'+lang_reply_call+'&nbsp;'
				   					+         '<a href="' + url_root + '/user/' + obj.parent_author_id + '">'
	        			   			+             obj.parent_author_name
	        			   			+         '</a>'
	 					   			+     '</div>'
	 				   				+ '</div>'
	 				   				+ '<div class="r-content">'// r means reply, used to diff from comment
	 				   				+     '<p>' + obj.comment_content + '</p>'
	 				   				+     '<p style="color:#aaa;font-size:12px">' 
	 				   				+ 			obj.update_date				   				
	 				   				+ 		'   <a  class="reply-link" parent_comment_id="'+obj.comment_id+'" parent_author_id="'+obj.author_id+'">'+lang_reply_call+'</a>'
	 				   				+     '</p>'							   				
	 		   						+ 	'<textarea style="overflow: hidden;display: none" rows="1" class="reply-r-content"></textarea>'		   						
	 				   				+ '</div>'
	 				   				+'</div>';
	               var reply_box_id = '#reply-box'+root_comment_id;
	        	   	  var reply_box =  $(reply_box_id);
	        	   	  $(reply_box_id+' #answer-reply-area').after(appendHtml);
//	        	   	  alert($(reply_box_id+' #answer-reply-area .answer-reply-button').html());
//	        	   	  $(reply_box_id+' #answer-reply-area .reply-content').val('');
	        	      $(reply_box_id+' #answer-reply-area .answer-reply-button').html(lang_reply);
	             }//请求成功后  
	             ,error:function(data){
	             	alert('error' + data);
	             }//请求错误  
	          }); 
	         
	     }
	});
	$('.up-img').live('click',function(){
		if(!user_id)
		{
			alert('please log on first');
			return;
		}
		
		var current_level = $(this).parent().attr('useful-level');
		var current_count = parseInt($(this).parent().find('.useful-count').html());
		var comment_id = $(this).parent().parent().parent().attr('comment_id');
		
		if(current_level == 1)
		{
			// user has marked
			current_level = 0;
			current_count = current_count - 1;
//			$(this).css('background-color','transparent');
			$(this).attr('src',base_url+'images/task/up-original.png');
		}	
		else 
		{
			
			if(current_level == -1)
			{
				//level changed from useless (-1) to useful (1), different value is 2
				current_count = current_count + 2;				
			}
			else
			{
				current_count = current_count + 1;				
			}	
			current_level = 1;			
//			$(this).css('background-color','green');
//			$(this).parent().find('.down-img').css('background-color','transparent');
			$(this).attr('src',base_url+'images/task/up-clicked.png');
			$(this).parent().find('.down-img').attr('src',base_url+'images/task/down-original.png');

		}
		$(this).parent().attr('useful-level',current_level);
		$(this).parent().find('.useful-count').html(current_count);
		updateUsefulLevel(comment_id,current_count,current_level);		
	});
	$('.down-img').live('click',function(){
		if(!user_id)
		{
			alert('please log on first');
			return;
		}
		
		var current_level = $(this).parent().attr('useful-level');
		var current_count = parseInt($(this).parent().find('.useful-count').html());
		var comment_id = $(this).parent().parent().parent().attr('comment_id');		
		if(current_level == -1)
		{
			// user has marked
			current_level = 0;
			current_count = current_count + 1;			
			//$(this).css('background-color','transparent');
			$(this).attr('src',base_url+'images/task/down-original.png');
		}	
		else 
		{			
			if(current_level == 1)
			{				
				//level changed from useful (1) to useless (-1), different value is 2 
				current_count = current_count - 2;
			}
			else
			{
				current_count = current_count - 1;
			}
			current_level = -1;	
//			$(this).css('background-color','red');
//			$(this).parent().find('.up-img').css('background-color','transparent');
			$(this).attr('src',base_url+'images/task/down-clicked.png');
			$(this).parent().find('.up-img').attr('src',base_url+'images/task/up-original.png');
		}		
		$(this).parent().attr('useful-level',current_level);
		$(this).parent().find('.useful-count').html(current_count);
		updateUsefulLevel(comment_id,current_count,current_level);
	});
	$('.up-img').live('mouseenter',function(){
		$(this).css('background-color','white');
	});
	$('.up-img').live('mouseleave',function(){
		$(this).css('background-color','transparent');
	});
	$('.down-img').live('mouseenter',function(){
		$(this).css('background-color','white');
	});
	$('.down-img').live('mouseleave',function(){
		$(this).css('background-color','transparent');
	});	
});
//-------------------------------------------------------------------
// Help functions
//-------------------------------------------------------------------
function updateUsefulLevel(comment_id,count,level)
{
//	alert('start update back end. id:' + comment_id + ' count:'+ count + 'level:' + level);
	$.ajax({  
        type:"POST" 
        ,url:url_root + '/task/update_useful_record'  
        ,data:{
        	comment_id: comment_id,
			useful_count: count,
			useful_level: level				
		}              
        ,success:function(data){  
          //alert('success' + data);
        }//请求成功后  
        ,error:function(data){
        	//alert('error' + data);
        }//请求错误  
     }); 
}
