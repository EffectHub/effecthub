$(document).ready(function () {
	/*$("#catagory").hover(function() {
		if (!$(".catagorypanel").is(":animated")) {
			$(".catagorypanel").slideDown("fast")
		}
	});	
	$("#featured").hover(function() {
		if (!$(".featurepanel").is(":animated")) {
			$(".featurepanel").slideDown("fast")
		}
	});
	$("#usershow").hover(function() {
		if (!$(".userpanel").is(":animated")) {
			$(".userpanel").slideDown("fast")
		}
	});*/
	
	var animate = true;
    var height = 0;
    height = $('.catagorypanel').height()+4+4+8;
    
	$('.catagorypanel' +', ' + '#catagory').hover(function(r){
         var item = $(this);
         var left = item.position().left;
         $('.catagorypanel').css('left', left+'px');
         $('.catagorypanel').clearQueue().animate({height:height+'px'}, 200);
         $('#catagory').addClass('active')
         
         animate = false;
         setTimeout(function(){animate = true;},1);
         $('.catagorypanel').css('display', 'block');
     }, function(r) {
         setTimeout(function(){
             if (animate) {
            	 $('.catagorypanel').animate({height:'0px'}, 200);
            	 $('#catagory').removeClass('active');
             }
         }, 0);
     });
	
	 var height1 = 0;
     height1 = $('.featurepanel').height()+4+4+8;
	 $('.featurepanel' +', ' + '#featured').hover(function(r){
        var item = $(this);
        var left = item.position().left;
        $('.featurepanel').css('left', left+'px');
        $('.featurepanel').clearQueue().animate({height:height1+'px'}, 200);
        $('#featured').addClass('active')
        
        animate = false;
        setTimeout(function(){animate = true;},1);
        $('.featurepanel').css('display', 'block');
     }, function(r) {
        setTimeout(function(){
            if (animate) {
           	 $('.featurepanel').animate({height:'0px'}, 200);
           	 $('#featured').removeClass('active');
            }
        }, 0);
     });
	
	 var height2 = 0;
     height2 = $('.userpanel').height()+4+4+8;
	 $('.userpanel' +', ' + '#usershow').hover(function(r){
        var item = $(this);
        var left = item.position().left;
        $('.userpanel').css('left', left+'px');
        $('.userpanel').clearQueue().animate({height:height2+'px'}, 200);
        $('#usershow').addClass('active')
        
        animate = false;
        setTimeout(function(){animate = true;},1);
        $('.userpanel').css('display', 'block');
     }, function(r) {
        setTimeout(function(){
            if (animate) {
           	 $('.userpanel').animate({height:'0px'}, 200);
           	 $('#usershow').removeClass('active');
            }
        }, 0);
     });
	 
	 var clickNum =0;
     $('.seemore').click(function(){  
     	 var itemID = $(this).attr('id');
     	 clickNum++;
     	 $.ajax({  
            type:"GET" 
           ,url:"http://www.effecthub.com/item/seemore/"+itemID  
           ,data:{id:clickNum}                                
           ,contentType:'text/html;charset=utf-8'//编码格式  
           ,beforeSend:function(data){  
              $('.seemore').html('loading...');  
            }//发送请求前  
           ,success:function(data){  
             $('.seemore').before(data);      
            }//请求成功后  
           ,error:function(data){  
             $('.seemore').html('failed to load data.')  
           }//请求错误  
          ,complete:function(data){  
             $('.seemore').html('<a style="cursor:pointer">See More ↓</a>');  
           }//请求完成  
       });  				
   });
   
   $('#watchOrunwatch').click(function(){  
   	 var itemID = $(this).attr('name');
   	 if($(this).html() == "Watch"){
   	 	 $.ajax({  
             type:"GET" 
             ,url:"http://www.effecthub.com/item/watch/"+itemID  
             ,data:{id:1}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
               $('#watchOrunwatch').html(data);      
             }//请求成功后  
             ,error:function(data){  
                $('#watchOrunwatch').html('failed to watch it.')  
             }//请求错误  
          });  	
   	}else{
   		$.ajax({  
             type:"GET" 
             ,url:"http://www.effecthub.com/item/unwatch/"+itemID  
             ,data:{id:1}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
               $('#watchOrunwatch').html(data);      
             }//请求成功后  
             ,error:function(data){  
                $('#watchOrunwatch').html('failed to watch it.')  
             }//请求错误  
          });  
   	}
   	 			
 });
  
   $('#likeOrdislike').click(function(){  
     	 var itemID = $(this).attr('name');
     	 if($(this).html() == "Like It!"){
     	 	 $.ajax({  
               type:"GET" 
               ,url:"http://www.effecthub.com/item/like/"+itemID  
               ,data:{id:1}                                
               ,contentType:'text/html;charset=utf-8'//编码格式   
               ,success:function(data){  
                 $('#likeOrdislike').html(data);      
               }//请求成功后  
               ,error:function(data){  
                  $('#likeOrdislike').html('failed to like it.')  
               }//请求错误  
            });  	
     	}else{
     		$.ajax({  
               type:"GET" 
               ,url:"http://www.effecthub.com/item/unlike/"+itemID  
               ,data:{id:1}                                
               ,contentType:'text/html;charset=utf-8'//编码格式   
               ,success:function(data){  
                 $('#likeOrdislike').html(data);      
               }//请求成功后  
               ,error:function(data){  
                  $('#likeOrdislike').html('failed to unlike it.')  
               }//请求错误  
            });  
     	}
     	 			
   });
   
   var clickNum1 =0;
   $('.seemore-particle').click(function(){  
   	 var userID = $(this).attr('id');
   	 clickNum1++;
   	 $.ajax({  
          type:"GET" 
         ,url:"http://www.effecthub.com/user/seemore/"+userID  
         ,data:{id:clickNum1}                                
         ,contentType:'text/html;charset=utf-8'//编码格式  
         ,beforeSend:function(data){  
            $('.seemore-particle').html('loading...');  
          }//发送请求前  
         ,success:function(data){  
           $('.seemore-particle').before(data);      
          }//请求成功后  
         ,error:function(data){  
           $('.seemore-particle').html('failed to load data.')  
         }//请求错误  
        ,complete:function(data){  
           $('.seemore-particle').html('<a style="cursor:pointer">See More ↓</a>');  
         }//请求完成  
     });  				
  });
   
   //the ajax way of post comment
   $('#postcomment').click(function(){ 
	   var itemID = $(this).attr('name');
	   var commentcontent = $('#contentarea').attr("value");
	   $.ajax({  
           type:"GET" 
           ,url:"http://www.effecthub.com/item/savecomment"  
           ,data:{item_id:itemID,content:commentcontent}                              
           ,contentType:'text/html;charset=utf-8'//编码格式   
           ,success:function(data){  
             $('.commentregion').append(data);      
           }//请求成功后  
           ,error:function(data){  
              $('.commentregion').append('failed to publish your comment.')   
           }//请求错误  
        }); 
   });
   
   var scrollNum =0;
   //首页上的鼠标滚动加载数据
   $(window).bind("scroll",function(){
	   var url = window.location.href; 
	   if(url=="http://localhost/game/" || url.indexOf("home") != -1)
	   {
		 if(parseInt($('#waiticon').attr('name')) >9){
	     // 然后判断窗口的滚动条是否接近页面底部，这里的20可以自定义
	      if( $(document).scrollTop() + $(window).height() > $(document).height() - 20 ){
		    scrollNum++;
		    $.ajax({  
		          type:"GET" 
		         ,url:"http://www.effecthub.com/home/seemore"                                
		         ,data:{id:scrollNum}
		         ,contentType:'text/html;charset=utf-8'//编码格式  
		         ,beforeSend:function(data){  
		             $('#waiticon').html('<img src="http://localhost/game/img/progressBig.gif">');  
		         }//发送请求前
		         ,success:function(data){  
		             $('#left').append(data);   
		             $('#waiticon').html(' ');
		         }//请求成功后  
		   }); 
	      }
	    }
	 }
   });

   
});
$(document).click(function() {
	if (!$(".catagorypanel").is(":animated")) {
		$(".catagorypanel").slideUp("fast");
	}
	if (!$(".featurepanel").is(":animated")) {
		$(".featurepanel").slideUp("fast");
	}
	if (!$(".userpanel").is(":animated")) {
		$(".userpanel").slideUp("fast");
	}
});
