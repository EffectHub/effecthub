// JavaScript Document

var defaultStuff = '<h3>Welcome to Awayeffect real-time HTML editor!<\/h3>\n' +
'<p>Type HTML/CSS/JS in the textarea above, and it will magically appear in the frame below.<\/p>';

var extraStuff = '<div style="position:absolute; margin:.3em; bottom:0em; right:0em;"><small>\n  Created by <a href="http://www.effecthub.com/" target="_blank">Zhuyuxiang<\/a> <\/small><\/div>';

var old_html = '';
var old_css = '';
var old_js = '';
   
   
function getStr(action)
{
	if(action=="editboxHTML")
	{
		return editboxHTML;	
	}
	else if(action=="defaultStuff")
	{
		return 	defaultStuff;
	}
	else if(action=="extraStuff")
	{
		return 	extraStuff;
	}
	else if(action=="ta_html")
	{
		return 	old_html;
	}
	else if(action=="ta_css")
	{
		return 	old_css;
	}
	else if(action=="ta_js")
	{
		return 	old_js;
	}
}  
function setStr(action,str)
{
	if(action=="editboxHTML")
	{
		editboxHTML=str;	
	}
	else if(action=="defaultStuff")
	{
		defaultStuff=str;
	}
	else if(action=="extraStuff")
	{
		extraStuff=str;
	}
	else if(action=="ta_html")
	{
		old_html=str;
	}
	else if(action=="ta_css")
	{
		old_css='<style type="text/css">'+str+'<\/style>';
	}
	else if(action=="ta_js")
	{

		old_js='<script type="text/javascript">'+str+'<\/script>';
	}
}    
         
function init()
{
  document.getElementById('ta_html').value= getStr('defaultStuff');
  update();
}

function update()
{
  var rF = window.frames['resultFrame'].document;
  var ta_css = document.getElementById('ta_css');
  var ta_js = document.getElementById('ta_js');
  var ta_html = document.getElementById('ta_html');  
 
  //判断js/css/html是否改变
  if (getStr('ta_js') != ta_js.value||getStr('ta_css') != ta_css.value||getStr('ta_html') != ta_html.value) 
  {
	setStr('ta_js', ta_js.value);
	setStr('ta_css', ta_css.value);
	setStr('ta_html', ta_html.value);
	rF.open();
    rF.write(getStr('ta_js')+getStr('ta_css')+getStr('ta_html'));
	rF.close();
  }
  window.setTimeout(update, 150);
}  
 
/*
function iFrameHeight() { 
	var ifm= document.getElementById('resultFrame');   
	var subWeb = document.frames ? document.frames['resultFrame'].document : ifm.contentDocument;   
	if(ifm != null && subWeb != null) {
	   ifm.height = subWeb.body.scrollHeight;
	}   
}  
*/ 
function ta_change(id){
	var rF = window.frames['resultFrame'].document;	
	var ta = document.getElementById(id);
	setStr(id, ta.value);
	rF.open();
    rF.write(getStr('ta_js')+getStr('ta_css')+getStr('ta_html'));
	rF.close();
}

;
/*

 rF.write('<style type="text/css">'+getStr('old_css')+'<\/style>'); 

'<script type="text/javascript">'+getStr('old_js')+'<\/script>

//判断css是否改变
  if(getStr('old_css') != ta_css.value)
  {
	  setStr('old_css', ta_css.value); 
	   //替换俩字符串中间的内容  原有css内容
	  rF.open();
	  rF.write('<style type="text/css">'+getStr('old_css')+'<\/style>');
	  rF.close();
  }

  


*/