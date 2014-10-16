<?php $this->load->view('header') ?>
<style type=text/css>

.boxCodeInner {
	max-width: 990px;
	margin: 30px auto;	
	background: #888;
}

#showFiles {
	width: 150px;
	float: left;
	height:	450px;
	position: relative;
}

.fTitle {
	margin-left: 10px;
	font-size: 15px;
	line-height: 20px;
	color: #efefef;		
	vertical-align: center;
}

.Folders {
	overflow-x: auto;
	overflow-y: auto;
	background: #dcdcdc;
	width: 150px;
	height: 400px;
	border: 3px inset #c5c5c5;
}

.code {
	width: 400px;
	float: left;
	height:	460px;
	margin-left: 15px;
	position: relative;
}

#code_container {
	width: 400px;
	height: 400px;
	background: #111;
	border: 3px inset #c5c5c5;
}

textarea {
	overflow: auto;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	width: 400px;
	height: 400px;
	background: #212121;
	color: #e2e2e2;
}

#ascode {
	Scrollbar-Arrow-Color: #ee2131;

}

.play_button {
	width: 60px;
	height: 20px;
	background: #2a2a2a;
	position: absolute;
	text-align: center;
	right: 10px;
	bottom: 5px;
	border: 2px outset #787878;
}

.play_button:hover {
	cursor: pointer;
}

.play_button p {
	line-height: 20px;
}

.codeswf {
	float: left;
	width: 400px;
	height:	450px;
}

#swf_container {
	margin-left: 6px;
	width: 400px;
	height: 406px;
	background: #181818;	
}

</style>
<script type="text/javascript" src="<?=base_url()?>player/particle/swfobject.js"></script>
<script>

		$(document).ready(function(){
			$(".play_button").click(function(){
			
				//$('#ShowProcess').fadeTo("slow").fadeIn().hstml("Compling,Please wait");
                $(".play_button").text("Compiling....");
				$.ajax({
					type:"post",
					data:{pid:<?=$src['id']?>,pcode:$("#asCode").val()},
					url:"./compile",
					datatype:"json",
					success:function(result)
					{
						var jsonObj=$.parseJSON(result);
                        
                        
                        var attributes ={
                        };
                        attributes.align="middle";
                        attributes.allowfullscreen ="true";
                        attributes.wmode="direct";
                        var flashvars=false;
                        var params={
                        };
                        
                        if (jsonObj.statue)
                        {
                            //swfobject.embedSWF(jsonObj.content, "swf", "100%", "100%", "11.2.0",flashvars,params,attributes);
                            //swfobject.createCSS("#swf", "display:block;text-align:left;");
                            $("#swf").empty();
                            var c = document.getElementById("swfcontent");
                                if (!c) {
                                    var d = document.createElement("div");
                                    d.setAttribute("id", "swfcontent");
                                    document.getElementById("swf_container").appendChild(d);
                                }
                                // create SWF
                                var att = { data:jsonObj.content, width:"100%", height:"100%" };
                                var par = { menu:"false" };
                                var id = "swfcontent";
                                swfobject.createSWF(att, par, id);
                                // rotate SWFs
                                //var s = swfs.shift();
                                //swfs.push(s);
                        }
                        else
                        {
                            $("#swf").empty();
                            swfobject.removeSWF("swfcontent");
                            $("#swf").text(trim(jsonObj.content));
                        };
                        $(".play_button").text("preview");
					},
					error:function()
					{
						alert("ajax error");
						//$('#ShowProcess').hide();
                        $(".play_button").text("preview");
					}				
				
				});
			
			});		
		});

</script>
	<div id="content">
    	<div id="content-inner">
        	
            <div class="contentTitle">
        		<h5>AS Online Editor</h5>
			</div>
        
        	<div class="boxCodeInner">
            	<div id="showFiles">
                	<p class="fTitle">Files:</p>
                    <div class="Folders">
                    						<!-- files and folders which are needed to make swf file are listed here -->
                    </div>
                
                </div>
            
  				<div class="code">
                	<p class="fTitle">Code:</p>
                	<div id="code_container">
      					<textarea id="asCode" name="as" cols="2000" >

                <?=trim($src['code']);?>   
						</textarea>			<!-- the file which is selected on the left shows its code here -->
					</div>
                    <div class="play_button"><p>Preview</p>			<!-- the play button -->
                    </div>
				</div>

				<div class="codeswf">
                	<p class="fTitle">Preview:</p>
                	<div id="swf_container">
                    	<div id="swf">
                                                    
						</div>
  					</div>
				</div>
			</div>
            
		</div>
	</div><script>
						var editor = CodeMirror.fromTextArea(document.getElementById("asCode"), {
							lineNumbers: true,
      						matchBrackets: true,
							styleActiveLine: true
    					});
						
						editor.setOption("theme", "ambiance");
  					</script>
    <?php $this->load->view('footer') ?>