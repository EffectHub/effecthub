// JavaScript Document
var state="t2b";
function layout_l2r(){
	var edi=document.getElementById("editor");
	state="l2r";
	edi.style.height=document.getElementById("inner").style.height;		
	edi.style.width=50+'%';
	if('cssFloat' in edi.style)
	{	
		edi.style.cssFloat="right";
	}	
	else if('styleFloat' in edi.style){
		edi.style.styleFloat="right";
	}
	else{
		 window.location.href="htmlEditor.html";
		 return;	
	}
	document.getElementById("html-box").style.height=100+'%';
	document.getElementById("html-box").style.width=100+'%';
	var ifr=document.getElementById("div_Iframe");
	ifr.style.height=100+'%';
	ifr.style.width=49+'%';
	if('cssFloat' in ifr.style)
		ifr.style.cssFloat="right";
	else if('styleFloat' in ifr.style){		
		ifr.style.styleFloat="right";
	}
	document.getElementById("codeswf").style.width=100+'%';
	document.getElementById("codeswf").style.height=100+'%';
}

function layout_t2b (){
	state="t2b";
	var edi=document.getElementById("editor");
	edi.style.height=50+'%';		
	edi.style.width=100+'%';
	
	document.getElementById("html-box").style.width=34+'%';
	document.getElementById("html-box").style.height=100+'%';
	document.getElementById("css-box").style.width=33+'%';
	document.getElementById("css-box").style.height=100+'%';
	document.getElementById("js-box").style.width=33+'%';
	document.getElementById("js-box").style.height=100+'%';
	
	var ifr=document.getElementById("div_Iframe");
	ifr.style.height=49+'%';
	ifr.style.width=100+'%';
	document.getElementById("resultFrame").style.width=100+'%';
	document.getElementById("resultFrame").style.height=100+'%';
}
function layout_r2l(){
	state="r2l";
	var edi=document.getElementById("editor");
	edi.style.height=document.getElementById("inner").style.height;		
	edi.style.width=44+'%';
	if('cssFloat' in edi.style)
	{
		edi.style.cssFloat="right";
	}	
	else if('styleFloat' in edi.style){
		edi.style.styleFloat="right";
	}
	else{
		 window.location.href="htmlEditor.html";
		 return;	
	}
	document.getElementById("html-box").style.height=33+'%';
	document.getElementById("css-box").style.height=33+'%';
	document.getElementById("js-box").style.height=33+'%';
	document.getElementById("html-box").style.width=100+'%';	
	document.getElementById("css-box").style.width=100+'%';
	document.getElementById("js-box").style.width=100+'%';
	
	
	var ifr=document.getElementById("div_Iframe");
	ifr.style.height=100+'%';
	ifr.style.width=55+'%';
	if('cssFloat' in ifr.style)
		ifr.style.cssFloat="right";
	else if('styleFloat' in ifr.style){	
		ifr.style.styleFloat="right";
	}
	document.getElementById("resultFrame").style.width=100+'%';
	document.getElementById("resultFrame").style.height=100+'%';
}

function fenge1(){
	
	if(state=="t2b")
	{
		document.getElementById("editor").style.height=30+'%';
		document.getElementById("div_Iframe").style.height=70+'%';
	}
	else if(state=="l2r")
	{
		document.getElementById("editor").style.width=30+'%';
		document.getElementById("div_Iframe").style.width=70+'%';
	}
	else if(state=="r2l")
	{
		document.getElementById("editor").style.width=70+'%';
		document.getElementById("div_Iframe").style.width=30+'%';
	}
}
function fenge2(){
	if(state=="t2b")
	{
		document.getElementById("editor").style.height=70+'%';
		document.getElementById("div_Iframe").style.height=30+'%';
	}
	else if(state=="l2r")
	{
		document.getElementById("editor").style.width=70+'%';
		document.getElementById("div_Iframe").style.width=30+'%';
	}
	else if(state=="r2l")
	{
		document.getElementById("editor").style.width=30+'%';
		document.getElementById("div_Iframe").style.width=70+'%';
	}
}
;
/*

function css_line(e)
{
	var keynum
	var keychar
	var numcheck

	if(window.event) // IE
	{
		keynum = e.keyCode
	}
	else if(e.which) // Netscape/Firefox/Opera
  	{
  		keynum = e.which
  	}

	if(keynum==13)
	{
		
		line_css++;
		document.getElementById('css-line').value+='\r\n'+line_css.toString();
		
		
		var re=/\n\r/g;
		var k=document.getElementById('ta_css').value.match(re);
		alert(k.length+1);
	}
}



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
 
function getStr(action)
{
	if(action=="code")
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
	if(action=="code")
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


/*
function iFrameHeight() { 
	var ifm= document.getElementById('resultFrame');   
	var subWeb = document.frames ? document.frames['resultFrame'].document : ifm.contentDocument;   
	if(ifm != null && subWeb != null) {
	   ifm.height = subWeb.body.scrollHeight;
	}   
}  


function keyUp(id,val){
	var str=val; 
	str=str.replace(/\r/gi,"");
	str=str.split("\n");
	n=str.length;
	line(n,id);
	ta_change(id,val);
}
function line(n,id){
	var lineob=document.getElementById('js-li');
	if(id=="ta_js")
		lineobj=document.getElementById('js-li');
	else if(id=="ta_css")
		lineobj=document.getElementById('css-li');
	else if(id=="code")
		lineobj=document.getElementById('html-li');
	for(var i=1;i<=n;i++){
	   if(document.all){
		num+=i+"\r\n";
	   }else{
		num+=i+"\n";
	   }
	}
	lineobj.value=num;
	num="";
}
function ta_change(id,val){
	var rF = window.frames['resultFrame'].document;	
	var ta = document.getElementById(id);
	if(getStr(id)!=val)
	{
		setStr(id, val);
		rF.open();
		rF.write(getStr('ta_js')+getStr('ta_css')+getStr('code'));
		rF.close();
	}	
}
*/ 

