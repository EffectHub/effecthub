String.prototype.trim = function() 
 {
  return this.replace(/(^\s*)|(\s*$)/g, ""); 
 }
$.fn.selectRange = function(start, end) {
    return this.each(function() {
        if(this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if(this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};
$(document).ready(function () {

	   $('.close').click(function(r){
		   $('.notice-alert').css('display', 'none');
	   });
	   
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
    
    $(".mp-pick-all").click(function() {
    	var uids = document.getElementsByName("uid[]");
    	for(i = 0;i < uids.length;i++){
    		uids[i].checked=true;
    	}
    });
    $(".mp-drop-all").click(function() {
    	var uids = document.getElementsByName("uid[]");
    	for(i = 0;i < uids.length;i++){
    		uids[i].checked=false;
    	}
    });
    /*
    $(".reply_link").live('click',function() {
		var a = $("#cu-" + this.rel).text().trim();
		if ($("#contentarea").length) {
			$("#parentid").attr('value', this.rel);
			$("#contentarea").val("@" + a + " " + $("#contentarea").val()).focus();
			var b = $("#contentarea").val().length;
			$("#contentarea").selectRange(b, b);
			return False;
		} else {
			location.href = location.href.split("?")[0] + "?page=-1#last";
			return False;
		}
	});
	*/
	$('.catagorypanel' +', ' + '#catagory').hover(function(r){
         var item = $(this);
         var left = item.position().left;
         $('.catagorypanel').css('left', left+'px');
         $('.catagorypanel').clearQueue().animate({height:height+'px'}, 200);
         $('#catagory').addClass('active');
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
	 
	 /*var height3 = 0;
     height3 = $('.noticepanel').height()+4+4;
	 $('.noticepanel' +', ' + '#noticeshow').hover(function(r){
		 $.ajax({  
	           type:"GET" 
	           ,url:"http://localhost/game/index.php/item/savecomment"  
	           ,data:{item_id:1}                            
	           ,contentType:'text/html;charset=utf-8'//编码格式   
	           ,success:function(data){  
	             $('.commentregion').before(data);      
	           }//请求成功后  
	           ,error:function(data){  
	              $('.commentregion').append('failed to show notice.')   
	           }//请求错误  
	    }); 
		
		var item = $(this);
        var left = item.position().left-30;
        $('.noticepanel').css('left', left+'px');
        $('.noticepanel').clearQueue().animate({height:height3+'px'}, 200);
        $('#noticeshow').addClass('active')
        
        animate = false;
        setTimeout(function(){animate = true;},1);
        $('.noticepanel').css('display', 'block');
     }, function(r) {
        setTimeout(function(){
            if (animate) {
           	 $('.noticepanel').animate({height:'0px'}, 200);
           	 $('#noticeshow').removeClass('active');
            }
        }, 0);
     }); */
	 $('#seeall').click(function(){
		 $('#noticeshow').css('display', 'none');
		 $('#noticeshow').removeAttr("title");
		 $('.num').removeClass('num');
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
             //$('.seemore').before(data); 
             $('.commentregion').append(data);
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
   	 if($('#watch').val() == 0){
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
     	 if($('#like').val() == 0){
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
	   var content = $('#contentarea').attr("value");
	   if (content=="") return;
	   $.post(

           "http://www.effecthub.com/item/savecomment",
           {
        	   item_id:itemID,
        	   content:content,
        	   parent_id:0
           },
           function(data,status){  
        	   location.href="http:///www.effecthub.com/item/"+itemID;
           }
        ); 
   });
   
  
   $('#c-submit').click(function(){
		var title = $('#c-text').val();
		if ((title != null)&&(title != '')) {
			$.post(
				"http://www.effecthub.com/collection/quick_create",
				{
					title: title
				},
				function(data,status){
					$('#c-remind').css('display','none');
					$('.c-create').after(data);
					$('#c-text').val('');
				}
			);
		} else {
			$('#c-remind').css('display','block');
		}
		
	});
    
   
   
   var scrollNum =0;
   //首页上的鼠标滚动加载数据
   $(window).bind("scroll",function(){
	   var url = window.location.href; 
	   if(url=="http://www.effecthub.com/" || url.indexOf("home") != -1)
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
		             $('#waiticon').html('<img src="http://www.effecthub.com/img/progressBig.gif">');  
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

   $('.mailcontent li').hover(function(r){
	   $(this).find('.operate_link').css('display', 'block');
   }, function(r) {
	   $(this).find('.operate_link').css('display', 'none');
   });
   /*
   $('.mailcontent li').click(function(){ 
	   var mailID = $(this).attr('id');
	   window.location.href="http://localhost/game/index.php/user/readmail/"+mailID;
   });*/

   
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


function checkupload()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if($('#url').attr('value')==''){
		$('#screenshotError').css('visibility','visible');
		valid = false;
	}else{
		$('#screenshotError').css('visibility','hidden');
	}
	if($('#attach').attr('value')==''){
		$('#attachError').css('visibility','visible');
		valid = false;
	}else{
		$('#attachError').css('visibility','hidden');
	}
	if(valid)$('#signin_form').submit();
}

function checkshare()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	/*
	if($('#url').attr('value')==''){
		$('#screenshotError').css('visibility','visible');
		valid = false;
	}else{
		$('#screenshotError').css('visibility','hidden');
	}*/
	if($('#preview').attr('value')==''){
		$('#previewError').css('visibility','visible');
		valid = false;
	}else{
		$('#previewError').css('visibility','hidden');
	}
	
	if(valid)$('#signin_form').submit();
}

function checkedit()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if(valid)$('#signin_form').submit();
}

function changemailkind(v)
{
	var userID = $('.mailstyle').attr('name');
	if(v=='all'){
		window.location.href="http://www.effecthub.com/user/checkmail/"+userID;
		$("#mailcatagory").val('all');
	}else if(v=='unread'){
		window.location.href="http://www.effecthub.com/user/findunreadmail/"+userID;
		$("#mailcatagory").val('unread');
	}else if(v=='read'){
		window.location.href="http://www.effecthub.com/user/findreadmail/"+userID;
		$("#mailcatagory").val('read');
	}
	
}
function checktask()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if($('#price').attr('value')==''){
		$('#priceError').css('visibility','visible');
		valid = false;
	}else{
		if($('#coin').attr("checked")=="checked"){
			if(parseInt($('#price').attr('value'))>parseInt($('#totalCoin').text())){
				$('#priceEnoughError').css('visibility','visible');
				valid = false;
			}else{
				$('#priceEnoughError').css('visibility','hidden');
				$('#priceError').css('visibility','hidden');
			}
		}
		if($('#cash').attr("checked")=="checked"){
			if(parseInt($('#price').attr('value'))>parseInt($('#totalCash').text())){
				$('#priceEnoughError').css('visibility','visible');
				valid = false;
			}else{
				$('#priceEnoughError').css('visibility','hidden');
				$('#priceError').css('visibility','hidden');
			}
		}
	}
	if(valid)$('#signin_form').submit();
}
function checkbid()
{
	var valid = true;
	if($('#desc').attr('value')==''){
		$('#descError').css('visibility','visible');
		valid = false;
	}else{
		$('#descError').css('visibility','hidden');
	}
	if($('#attach').attr('value')==''){
		$('#attachError').css('visibility','visible');
		valid = false;
	}else{
		$('#attachError').css('visibility','hidden');
	}
	if(valid)$('#signin_form').submit();
}
function checktopic()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	/*if($('#desc').attr('value')==''){
		$('#descError').css('display','inline');
		valid = false;
	}else{
		$('#descError').css('display','none');
	}*/
	if(valid)$('#signin_form').submit();
}
function checkgroup()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if($('#desc').attr('value')==''){
		$('#descError').css('visibility','visible');
		valid = false;
	}else{
		$('#descError').css('visibility','hidden');
	}
	/*if($('#url').attr('value')==''){
		$('#iconError').css('display','inline');
		valid = false;
	}else{
		$('#iconError').css('display','none');
	}*/
	if(valid)$('#signin_form').submit();
}
function checktool()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if($('#domain').attr('value')==''){
		$('#domainError').css('visibility','visible');
		valid = false;
	}else{
		$('#domainError').css('visibility','hidden');
	}
	if($('#desc').attr('value')==''){
		$('#descError').css('visibility','visible');
		valid = false;
	}else{
		$('#descError').css('visibility','hidden');
	}
	if(valid)$('#signin_form').submit();
}
function checklink()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	if($('#url').attr('value')==''){
		$('#urlError').css('visibility','visible');
		valid = false;
	}else{
		$('#urlError').css('visibility','hidden');
	}
	if(valid)$('#signin_form').submit();
}
function checkcollection()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	/*if($('#url').attr('value')==''){
			$('#iconError').css('display','inline');
			valid = false;
		}else{
			$('#iconError').css('display','none');
		}*/
	if(valid)$('#signin_form').submit();

}
function checkteam()
{
	var valid = true;
	if($('#title').attr('value')==''){
		$('#titleError').css('visibility','visible');
		valid = false;
	}else{
		$('#titleError').css('visibility','hidden');
	}
	/*if($('#url').attr('value')==''){
			$('#iconError').css('display','inline');
			valid = false;
		}else{
			$('#iconError').css('display','none');
		}*/
	if(valid) $('#signin_form').submit();

}


//check sign up	
function checksignup()
{
	var valid = true;
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if($('#email_address').attr('value')==''||(!reg.test($('#email_address').attr('value')))){
		$('#emailError').css('visibility','visible');
		valid = false;
	}else{
		$('#emailError').css('visibility','hidden');
	}
	
	/*var l = $('#register_password').val().length;
	if(l < 6){
		$('#passwordError').css('visibility','visible');
		valid = false;
	}else{
		$('#passwordError').css('visibility','hidden');
	}*/
	if($('#password').attr('value')==''){
		$('#passwordError').css('visibility','visible');
		valid = false;
	}else{
		$('#passwordError').css('visibility','hidden');
	}
	if(valid) $('#signin_form').submit();
}

//login check
$('#email').blur(function(){
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if($('#email').attr('value')==''||(!reg.test($('#email').attr('value')))){
		$('#emailError').css('visibility','visible');
	}else{
		$('#emailError').css('visibility','hidden');
	}
});

$('#password').blur(function(){
	if($('#password').attr('value')==''){
		$('#passwordError').css('visibility','visible');
	}else{
		$('#passwordError').css('visibility','hidden');
	}
});
	
function checklogin()
{
	var valid = true;
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if($('#email').attr('value')==''||(!reg.test($('#email').attr('value')))){
		$('#emailError').css('visibility','visible');
		valid = false;
	}else{
		$('#emailError').css('visibility','hidden');
	}
	if($('#password').attr('value')==''){
		$('#passwordError').css('visibility','visible');
		valid = false;
	}else{
		$('#passwordError').css('visibility','hidden');
	}
	if(valid) $('#signin_form').submit();
}

function teaminvite(){
	
	var chosen = new Array();
	
	$("input[type='checkbox']").each(function(){
		if ($(this).attr('checked')) {
			chosen.push($(this).val());
		}
	});
	
	if (chosen.length == 0) {
		return alert('You should choose at leat one user!');
	} else {
		
		var arr = '';
		for (var i = 0; i<chosen.length;i++) {
			arr += chosen[i];
			if (i < (chosen.length-1)) {
				arr += ',';
			}
		}
		
		$.post(
			"http://www.efecthub.com/team/invite",
			{
				arr: arr,
				new_team: $('#newteam').val()
			},
			function(data,status){
				$('#signin_form').submit();
			}
		);
		
	}
	
}

$(".team-pick-all").live('click',function(){
	
	$("input[type='checkbox']").attr('checked','true');
});
$(".team-drop-all").live('click',function(){
	
	$("input[type='checkbox']").removeAttr('checked');
});







