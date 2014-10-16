var currentItem = 0;
var currentItemType = -1;
var currentItemName = '';
var currentItemPrivate = -1;
var currentPosition = -1;
var previousPosition = -1;
var previousItem = 0;
$(document).ready(function () {
	$(".selectionArbitrate").click(function(){
			$(".files-header").toggleClass("on");
			$(".file-item").toggleClass("on");
			$(".icon-item").toggleClass("on");
		if($("#fileActionHeader").css("display")=="none"){
			$("#sortColsHeader").hide();$("#fileActionHeader").show();
		}else{
			$("#sortColsHeader").show();$("#fileActionHeader").hide();
		}
	});
	$(".icon-item").click(function(){

		if(currentType=='all'){
			$("#sortColsHeader").show();$("#fileActionHeader").hide();
			return;
		}
		var folder = $(this).attr("folder");
		currentItemType = folder;
		currentItemName = $(this).attr("title");
		previousPosition = currentPosition;
		previousItem = currentItem;
		currentItem = $(this).attr("data");
		if(currentItem==previousItem)currentItem=0;
		currentPosition = $(this).attr("_position");
		if(currentPosition==previousPosition)currentPosition=-1;
		currentItemPrivate = $(this).attr("private");
		//if(folder==0){
			$(this).toggleClass("on");
			$("#infiniteListView .file-item:eq("+$(this).attr("_position")+")").toggleClass("on");
			if(previousPosition!=-1){
				$("#infiniteListView .file-item:eq("+previousPosition+")").toggleClass("on");
				$("#infiniteGridView .icon-item:eq("+previousPosition+")").toggleClass("on");
			}
			if(currentPosition!=-1){
				//$("#infiniteListView .icon-item:eq("+currentPosition+")").toggleClass("on");
			}else{
				$("#infiniteListView .file-item:eq("+previousPosition+")").toggleClass("on");
				$("#infiniteGridView .icon-item:eq("+previousPosition+")").toggleClass("on");
			}
			if(currentItem!=0){
				$("#sortColsHeader").hide();$("#fileActionHeader").show();
			}else{
				$("#sortColsHeader").show();$("#fileActionHeader").hide();
				$("#file_action_word").text("");
				$("#createFolder").hide();
			}
		//}
		if(currentItemPrivate==1){
			if(!$("#barCmdCancelShare").hasClass("none"))$("#barCmdCancelShare").addClass("none");
			if($("#barCmdShareAll").hasClass("none"))$("#barCmdShareAll").removeClass("none");
		}
		if(currentItemPrivate==0){
			if($("#barCmdCancelShare").hasClass("none"))$("#barCmdCancelShare").removeClass("none");
			if(!$("#barCmdShareAll").hasClass("none"))$("#barCmdShareAll").addClass("none");
		}
	});
	$(".file-item").click(function(){

		if(currentType=='all'){
			$("#sortColsHeader").show();$("#fileActionHeader").hide();
			return;
		}
		var folder = $(this).attr("folder");
		currentItemType = folder;
		currentItemName = $(this).attr("title");
		previousPosition = currentPosition;
		previousItem = currentItem;
		currentItem = $(this).attr("data");
		if(currentItem==previousItem)currentItem=0;
		currentPosition = $(this).attr("_position");
		if(currentPosition==previousPosition)currentPosition=-1;
		currentItemPrivate = $(this).attr("private");
		
		//if(folder==0){
			$(this).toggleClass("on");
			$("#infiniteGridView .icon-item:eq("+$(this).attr("_position")+")").toggleClass("on");
			if(previousPosition!=-1){
				$("#infiniteListView .file-item:eq("+previousPosition+")").toggleClass("on");
				$("#infiniteGridView .icon-item:eq("+previousPosition+")").toggleClass("on");
			}
			if(currentPosition!=-1){
				//$("#infiniteListView .icon-item:eq("+currentPosition+")").toggleClass("on");
			}else{
				$("#infiniteListView .file-item:eq("+previousPosition+")").toggleClass("on");
				$("#infiniteGridView .icon-item:eq("+previousPosition+")").toggleClass("on");
			}
			if(currentItem!=0){
				$("#sortColsHeader").hide();$("#fileActionHeader").show();
			}else{
				$("#sortColsHeader").show();$("#fileActionHeader").hide();
				$("#file_action_word").text("");
				$("#createFolder").hide();
			}
		//}
		if(currentItemPrivate==1){
			if(!$("#barCmdCancelShare").hasClass("none"))$("#barCmdCancelShare").addClass("none");
			if($("#barCmdShareAll").hasClass("none"))$("#barCmdShareAll").removeClass("none");
		}
		if(currentItemPrivate==0){
			if($("#barCmdCancelShare").hasClass("none"))$("#barCmdCancelShare").removeClass("none");
			if(!$("#barCmdShareAll").hasClass("none"))$("#barCmdShareAll").addClass("none");
		}
	});
	$(".file-item").mouseover(function(){
		$(this).toggleClass("hover");
	});
	$(".file-item").mouseout(function(){
		$(this).toggleClass("hover");
	});
	$(".icon-item").mouseover(function(){
		$(this).toggleClass("hover");
	});
	$(".icon-item").mouseout(function(){
		$(this).toggleClass("hover");
	});
	$("#barCmdViewSmall").click(function(){
		$("#barCmdViewList").removeClass("select");
		if(!$("#barCmdViewSmall").hasClass("select"))$("#barCmdViewSmall").addClass("select");
		if($("#sortColsHeader").css("display")!="none"){
			$("#sortColsHeader").hide();$("#fileThumbHeader").show();
		}
		if($("#infiniteGridView").css("display")=="none"){
			$("#infiniteGridView").show();$("#infiniteListView").hide();
		}
	});
	$("#barCmdViewList").click(function(){
		$("#barCmdViewSmall").removeClass("select");
		if(!$("#barCmdViewList").hasClass("select"))$("#barCmdViewList").addClass("select");
		if($("#sortColsHeader").css("display")=="none"){
			$("#sortColsHeader").show();$("#fileThumbHeader").hide();
		}
		if($("#fileThumbHeader").css("display")=="block"){
			$("#fileThumbHeader").hide();
		}
		if($("#infiniteListView").css("display")=="none"){
			$("#infiniteListView").show();$("#infiniteGridView").hide();
		}
	});
	$("#barCmdNewFolder").click(function(){
		$("#createFolder").show();
	});
	$(".ic-chname-failure").click(function(){
		$("#createFolder").hide();
	});
	$(".ic-chname-ok").click(function(){
		if($('#folderGeneratorHandler').attr("value")=='')return;
		var folderURL = '';
		if(currentItem!=0)folderURL = "http://www.effecthub.com/folder/editFolder/"+currentItem;
		else folderURL = "http://www.effecthub.com/folder/createFolder/"+currentType;
		$.ajax({  
           type:"GET" 
           ,url:folderURL
           ,data:{folder_name:$('#folderGeneratorHandler').attr("value"),folder_id:currentFolder}                              
           ,contentType:'text/html;charset=utf-8'//编码格式   
           ,success:function(data){
        	   //alert(data);
        	   if(data==1){
        		   if(currentItem!=0)$(".toast-msg").text("Edit folder successfully.");
        		   else $(".toast-msg").text("Create folder successfully.");
	        	   $(".toast-dialog").show();
	        	   if(currentFolder==0)window.location.href = "http://www.effecthub.com/disk/"+currentType;
	        	   else window.location.href = "http://www.effecthub.com/folder/"+currentFolder;
	        	   setTimeout(hidetoast,3000);
        	   }else{
        		   if(currentItem!=0)$(".toast-msg").text("Edit folder failed.");
        		   else $(".toast-msg").text("Create folder failed.");
            	   $(".toast-dialog").show();
            	   setTimeout(hidetoast,3000);
        	   }
           }//请求成功后  
           ,error:function(data){  
        	   //alert(data);
        	   $(".toast-msg").text("Create folder failed.");
        	   $(".toast-dialog").show();
        	   setTimeout(hidetoast,3000);
           }//请求错误  
        }); 
		$("#createFolder").hide();
	});
	$("#barCmdDownload").click(function(){
		if($("#fileActionHeader").hasClass("on")){
			window.location.href = 'http://www.effecthub.com/folder/download/'+currentFolder;
		}else{
			if(currentItemType==0)
			window.location.href = 'http://www.effecthub.com/item/download/'+currentItem;
			if(currentItemType==1)
			window.location.href = 'http://www.effecthub.com/folder/download/'+currentItem;
		}
	});
	$("#barCmdSave").click(function(){
		var divId=$(".move-dialog");
		divId.css({
			position:'absolute', 
			left: ($(window).width() - divId.outerWidth())/2, 
			top: ($(window).height() - divId.outerHeight())/2 + $(document).scrollTop() 
			}); 
		divId.show();
	});
	$("#barCmdEdit").click(function(){
		if(currentItemType==0)
		window.location.href = 'http://www.effecthub.com/item/edit/'+currentItem;
		if(currentItemType==1){
			$("#createFolder").show();
			$('#folderGeneratorHandler').attr("value",currentItemName);
		}
	});
	$("#barCmdDelete").click(function(){
		var divId=$(".alert-dialog");
		divId.css({
			position:'absolute', 
			left: ($(window).width() - divId.outerWidth())/2, 
			top: ($(window).height() - divId.outerHeight())/2 + $(document).scrollTop() 
			}); 
		divId.show();
	});
	$("#barCmdShareAll").click(function(){
		var divId=$(".share-dialog");
		divId.css({
			position:'absolute', 
			left: ($(window).width() - divId.outerWidth())/2, 
			top: ($(window).height() - divId.outerHeight())/2 + $(document).scrollTop() 
			}); 
		divId.show();

		if(currentItemType==0)
		$(".public-link").attr("value",'http://www.effecthub.com/item/'+currentItem);
		if(currentItemType==1)
		$(".public-link").attr("value",'http://www.effecthub.com/folder/'+currentItem);
	});
	$(".dlg-cnr-r").click(function(){
		$(".alert-dialog").hide();
		$(".share-dialog").hide();
		$(".move-dialog").hide();
	});
	$(".abtn").click(function(){
		$(".alert-dialog").hide();
		$(".share-dialog").hide();
		$(".move-dialog").hide();
	});
	$(".cancel").click(function(){
		$(".alert-dialog").hide();
		$(".share-dialog").hide();
		$(".move-dialog").hide();
	});
	$("#barCmdCancelShare").click(function(){
		var shareURL = '';
		if(currentItemType==0)shareURL = "http://www.effecthub.com/disk/unshareFile/"+currentItem;
		if(currentItemType==1)shareURL = "http://www.effecthub.com/folder/unshareFolder/"+currentItem;
		$.ajax({  
           type:"GET" 
           ,url:shareURL 
           ,data:{password:$('#link-password').attr("value")}                              
           ,contentType:'text/html;charset=utf-8'//编码格式   
           ,success:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Cancel share file successfully. Coins -10.");
        	   if(currentItemType==1)$(".toast-msg").text("Cancel share folder successfully.");
        	   $(".toast-dialog").show();
        	   window.location.href = "http://www.effecthub.com/disk/"+currentType;
        	   setTimeout(hidetoast,3000);
           }//请求成功后  
           ,error:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Cancel share file failed.");
        	   if(currentItemType==1)$(".toast-msg").text("Cancel share folder failed.");
        	   $(".toast-dialog").show();
        	   setTimeout(hidetoast,3000);
           }//请求错误  
        }); 
	});
	$(".sbtn").click(function(){
		var shareURL = '';
		var teamlist = '';
		$("input[name='teamid']:checked").each(function(i, o){
			teamlist = teamlist + $(o).val() + ',';
		});
		if(currentItemType==0)shareURL = "http://www.effecthub.com/disk/shareFile/"+currentItem;
		if(currentItemType==1)shareURL = "http://www.effecthub.com/folder/shareFolder/"+currentItem;
		$.ajax({  
           type:"GET" 
           ,url:shareURL
           ,data:{password:$('#link-password').attr("value"),team:teamlist}                              
           ,contentType:'text/html;charset=utf-8'//编码格式   
           ,success:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Share file successfully. Coins +10.");
        	   if(currentItemType==1)$(".toast-msg").text("Share folder successfully.");
        	   $(".toast-dialog").show();
        	   window.location.href = "http://www.effecthub.com/disk/"+currentType;
        	   setTimeout(hidetoast,3000);
           }//请求成功后  
           ,error:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Share file failed.");
        	   if(currentItemType==1)$(".toast-msg").text("Share folder failed.");
        	   $(".toast-dialog").show();
        	   setTimeout(hidetoast,3000);
           }//请求错误  
        }); 
		$(".alert-dialog").hide();
		$(".share-dialog").hide();
	});
	$(".okay").click(function(){
		var deleteURL = '';
		if(currentItemType==0)deleteURL = "http://www.effecthub.com/disk/deleteFile/"+currentItem;
		if(currentItemType==1)deleteURL = "http://www.effecthub.com/folder/deleteFolder/"+currentItem;
		$.ajax({  
           type:"GET" 
           ,url:deleteURL
           ,data:{}                              
           ,contentType:'text/html;charset=utf-8'//编码格式   
           ,success:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Delete file successfully.");
        	   if(currentItemType==1)$(".toast-msg").text("Delete folder successfully.");
        	   $(".toast-dialog").show();
        	   /*$("[data='"+currentItem+"']").remove();
        	   currentItem = 0;
        	   currentPosition = -1;
        	   previousPosition = -1;
        	   $("#sortColsHeader").show();$("#fileActionHeader").hide();*/
        	   window.location.href = "http://www.effecthub.com/disk/"+currentType;
        	   setTimeout(hidetoast,3000);
           }//请求成功后  
           ,error:function(data){  
        	   if(currentItemType==0)$(".toast-msg").text("Delete file failed.");
        	   if(currentItemType==1)$(".toast-msg").text("Delete folder failed.");
        	   $(".toast-dialog").show();
        	   setTimeout(hidetoast,3000);
           }//请求错误  
        }); 
		var divId=$(".alert-dialog");
		divId.hide();
	});
	$("#barDropdownTriggerMore").mouseover(function(){
		if($(".pull-down-menu").css("display")=="none"){
			$(".pull-down-menu").show();
		}else{
			$(".pull-down-menu").hide();
		}
	});
	$(".pull-down-menu").mouseout(function(){
		if($(".pull-down-menu").css("display")=="none"){
			$(".pull-down-menu").show();
		}else{
			$(".pull-down-menu").hide();
		}
	});
	$(".b-ig-ln").click(function(){
		$(this).parent.addClass("on");
	});
	

   $('#watchFolder').click(function(){  
   	 var folderID = $(this).attr('name');
   	 if($('#watch').val() == 0){
   	 	 $.ajax({  
             type:"GET" 
             ,url:"http://www.effecthub.com/folder/watch/"+folderID  
             ,data:{id:1}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
               $('#watchFolder').html(data);      
             }//请求成功后  
             ,error:function(data){  
                $('#watchFolder').html('failed to watch it.')  
             }//请求错误  
          });  	
   	}else{
   		$.ajax({  
             type:"GET" 
             ,url:"http://www.effecthub.com/folder/unwatch/"+folderID  
             ,data:{id:1}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
               $('#watchFolder').html(data);      
             }//请求成功后  
             ,error:function(data){  
            	 alert(data);
                $('#watchFolder').html('failed to unwatch it.')  
             }//请求错误  
          });  
   	}
   	 			
 });
  
   $('#likeFolder').click(function(){  
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
   
   $(".treeview-node").mouseover(function(){
	    if(!$(this).hasClass("treeview-node-hover"))$(this).addClass("treeview-node-hover");
   });
   $(".treeview-node").mouseout(function(){
	    if($(this).hasClass("treeview-node-hover"))$(this).removeClass("treeview-node-hover");
  });
   $(".treeview-node").click(function(){
	    $(".treeview-node").removeClass("treeview-node-hover");
	    $(".treeview-node").removeClass("treeview-node-on");
	    if(!$(this).hasClass("treeview-node-on"))$(this).addClass("treeview-node-on");
	});
   $(".treeview-node").click(function(){
	    if(!$(this).hasClass("_minus")){
	    	$(this).addClass("_minus");
	    	$(this).find(".plus").addClass("minus");
	    	$(this).siblings("ul").removeClass("treeview-collapse");
	    }else{
	    	$(this).removeClass("_minus");
	    	$(this).find(".plus").removeClass("minus");
	    	$(this).siblings("ul").addClass("treeview-collapse");
	    }
	});
});

function hidetoast() 
{ 
	$(".toast-dialog").hide();
}