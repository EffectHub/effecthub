<?php $this->load->view('header') ?>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<div class="full">
	<h1 class="alt"><?= $this->lang->line('page_title') ?></h1>
</div>

<div id="main" class="site api">
<div class="col-about col-about-full under-hero">
<p class="mod"><?= $this->lang->line('introduce') ?>
	<!-- The EffectHub API is available for non-commercial use. Commercial use is possible by prior arrangement. Please <a href="mailto:effecthub.com@gmail.com">contact us</a> if you wish to apply for commercial use of the API.-->
</p>

<h2 class="section api">
	<span class="alt"><?= $this->lang->line('overview') ?></span>
</h2>
<p>
<?= $this->lang->line('overview_p1') ?>
	<!-- All API access is over HTTP. All responses are returned as JSON. The API is (mostly) RESTful. -->
</p>

<p><?= $this->lang->line('overview_p2') ?>
	<!-- Currently, no API key is required, but this will likely change so we can better monitor usage and enforce the Terms of Use (below). The API has been stable, but will retain the beta moniker until API keys are added. -->
</p>

<p><?= $this->lang->line('overview_p3') ?>
	<!-- API calls are limited to 60 per minute and 10,000 per day. We may change the limit in the future and/or tie it to API keys. Exceeding the limit will result in 403 "Rate Limit Exceeded" responses. -->
</p>

<p class="mod"><?= $this->lang->line('overview_p4') ?>
	<!-- <a href="mailto:effecthub.com@gmail.com">Contact us</a> with comments, questions or feedback on the API. -->
</p>
	
<h2 class="section api">
	<span class="alt"><?= $this->lang->line('terms_of_use') ?></span>
</h2>

<p><?= $this->lang->line('terms_of_use_intro') ?>
<!-- The following terms and conditions govern all use of the EffectHub website API. -->
</p>

<ul>
<li><?= $this->lang->line('terms_of_use_i1') ?></li>
<li><?= $this->lang->line('terms_of_use_i2') ?></li>
<!--<li><?= $this->lang->line('terms_of_use_i3') ?></li>-->
<li><?= $this->lang->line('terms_of_use_i4') ?></li>
<li><?= $this->lang->line('terms_of_use_i5') ?></li>
<li><?= $this->lang->line('terms_of_use_i6') ?></li>
<li><?= $this->lang->line('terms_of_use_i7') ?></li>
<li><?= $this->lang->line('terms_of_use_i8') ?></li>
<li><?= $this->lang->line('terms_of_use_i9') ?></li>
<!-- 
	<li>EffectHub members own all rights to their content and it is your responsibility to make sure your use of the API does not contravene those rights.</li>
	<li>You must remove from your application within 24 hours any EffectHub item or personal information that the owner asks you to remove.</li>
	<li>Don't use the name EffectHub in your application, url or branding.</li>
	<li>Do not use the EffectHub API for any application that replicates or attempts to replace the essential user experience of effecthub.com</li>
	<li>If your application derives revenue from its use of the EffectHub API, directly or indirectly, it is considered a commercial application and requires our approval in advance.</li>
	<li>EffectHub reserves the right to evaluate and monitor applications to ensure that they do not harm EffectHub's servers or business interests.</li>
	<li>Do not abuse the API or use it excessively. If you're unsure whether your planned use is excessive, <a href="mailto:effecthub.com@gmail.com">ask us</a>.</li>
	<li>EffectHub may terminate your license to the EffectHub API under these terms at any time for any reason.</li>
	<li>EffectHub reserves the right to update and change these terms from time to time without notice.</li>
 -->
</ul>


<h2 id="get_item" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/item/load/:id</span>
</h2>
<ul>
<!-- 
<li>Description: Load item information</li>
<li>Return: details for a item specified by <span class="api-values">:id</span> </li>
<li>Note:You must add post parameter 'userid' and 'token'.If the userid is author of this item, then the download_url is available. To get the userid and token, please refer to <a href="#user_login">user login API</a>
</li>
-->
<li><?= $this->lang->line('get_item_desc') ?></li>
<li><?= $this->lang->line('get_item_return') ?></li>
<li><?= $this->lang->line('get_item_note') ?></li>
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/load/8
---
{
"id":"8",
"title":"My Bubbles v4",
"desc":"My Bubbles v4",
"author_id":"1001009",
"download_url":"http:\/\/www.effecthub.com\/uploads\/attachment\/A77F64C6-56B3-3847-083C-E6EA6B6DB5D9.zip",
"preview_url":"0",
"tags":"Bubbles",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/6FE1DDEC-E013-DD00-294A-780DFC358A6E.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/6FE1DDEC-E013-DD00-294A-780DFC358A6E_thumb.jpg",
"view_num":"280",
"fav_num":"0",
"comment_num":"0",
"type":"1",
"create_date":"2013-06-05 15:01:17",
"update_date":"2013-06-07 16:20:11",
"last_comment_date":"0000-00-00 00:00:00",
"price":"10","version":"3","watch_num":"0",
"download_num":"0","from":"particle",
"contest_id":"0","is_share":"0",
"parent_id":"0",
"platform":"1",
"tool":"1",
"extension":"zip",
"file_size":"40657",
"file_name":null,
"folder_id":"0",
"password":null,
"topic_id":"0",
"work_id":"0",
"is_private":"0",
"active":"1",
"author_name":"Chenguang Liu",
"type_link":"Particle",
"type_name":"Particle",
"type_name_cn":"\u7279\u6548",
"type_pic":null,
"author_pic":"http:\/\/tp1.sinaimg.cn\/1362706900\/180\/5623207546\/1"
}
---
if failed, the result as below.
{
"download_url":"",
"password":""
}</code></pre>
</div>
<h2 id="get_item_by_tool" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/item/loadbytool/[tool id]</span>
</h2>
<ul>
<li><?= $this->lang->line('get_item_by_tool_desc') ?></li>
<li><?= $this->lang->line('get_item_by_tool_return') ?></li>
<li><?= $this->lang->line('get_item_by_tool_parameter') ?></li>
<!--
<li>Description: Item list by tool such as dragonbones</li>
<li>Return: latest 20 items of specified tool id.
 </li>
<li>Parameter:1 is sparticle,2 is dragonbones
</li>
--> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/loadbytool/2
---
[
{
"id":"764",
"title":"skeleton",
"desc":"Project inside a skeleton model, as a result.Hope great spirit promoted a lot ~ ~",
"author_id":"1000978",
"download_url":"",
"preview_url":"0",
"tags":"The skeleton",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/AECDA866-C1D2-DE79-8702-9158B8EF91E3.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/AECDA866-C1D2-DE79-8702-9158B8EF91E3_thumb.jpg",
"view_num":"7229",
"fav_num":"90",
"comment_num":"10",
"type":"1",
"create_date":"2014-02-19 14:13:36",
"update_date":"2014-02-19 14:13:36",
"last_comment_date":"0000-00-00 00:00:00",
"price":"10",
"version":"0",
"watch_num":"12",
"download_num":"27",
"from":"particle",
"contest_id":"1",
"is_share":"0",
"parent_id":"0",
"platform":"1",
"tool":"1",
"extension":"zip",
"file_size":"1768150",
"file_name":null,
"folder_id":"0",
"password":null,
"topic_id":"0",
"work_id":"0",
"is_private":"0",
"active":"1",
"type_name":"Particle",
"type_name_cn":"\u7279\u6548",
"is_folder":0,
"author_name":"miskas",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000978_thumb.jpg",
"author_level":"10",
"author_point":"387",
"tool_name":"Sparticle",
"tool_domain":"sparticle",
"tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg",
"platform_name":"Flash",
"platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png",
"platform_key":"flash",
"extension_bg":"153",
"extension_bg_thumb":"352",
"player":null
},
{
"id":"642",
"title":"sword",
"desc":"Like xianjian wonder spread, so did this. Everyone like to vote, please thank you!",
"author_id":"1000673",
"download_url":"",
"preview_url":"0",
"tags":"sword0",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/052B80F9-8E9F-3034-5EE7-9799AF938045.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/052B80F9-8E9F-3034-5EE7-9799AF938045_thumb.jpg",
"view_num":"5120",
"fav_num":"83",
"comment_num":"14",
"type":"1",
"create_date":"2014-01-21 02:18:51",
"update_date":"2014-02-19 07:52:32",
"last_comment_date":"0000-00-00 00:00:00",
"price":"10",
"version":"4",
"watch_num":"7",
"download_num":"20",
"from":"particle",
"contest_id":"1",
"is_share":"0",
"parent_id":"0",
"platform":"1",
"tool":"1",
"extension":"zip",
"file_size":"2070899",
"file_name":null,
"folder_id":"0",
"password":null,
"topic_id":"0",
"work_id":"0",
"is_private":"0",
"active":"1",
"type_name":"Particle",
"type_name_cn":"\u7279\u6548",
"is_folder":0,
"author_name":"zhouyouwu",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000673_thumb.jpg",
"author_level":"10",
"author_point":"722",
"tool_name":"Sparticle",
"tool_domain":"sparticle",
"tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg",
"platform_name":"Flash",
"platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png",
"platform_key":"flash",
"extension_bg":"153",
"extension_bg_thumb":"352",
"player":null
}]
</code></pre>
</div>

<h2 id="get_item_by_type" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/item/loadbytype/[type id]</span>
</h2>
<ul>
<li><?= $this->lang->line('get_item_by_type_desc') ?></li>
<li><?= $this->lang->line('get_item_by_type_return') ?></li>
<li><?= $this->lang->line('get_item_by_type_parameter') ?></li>
<!-- 
<li>Description:Item list by type</li>
<li>Return: latest 20 items of specified type id.</li>
<li>Parameter:1 is particle, 2 is model, 3 is texture, 6 is animation
</li>
--> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/loadbytype/6
---
[
{"id":"764",
"title":"skeleton",
"desc":"Project inside a skeleton model, as a result.Hope great spirit promoted a lot ~ ~",
"author_id":"1000978","download_url":"","preview_url":"0","tags":"The skeleton",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/AECDA866-C1D2-DE79-8702-9158B8EF91E3.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/AECDA866-C1D2-DE79-8702-9158B8EF91E3_thumb.jpg",
"view_num":"7229","fav_num":"90","comment_num":"10","type":"1",
"create_date":"2014-02-19 14:13:36",
"update_date":"2014-02-19 14:13:36",
"last_comment_date":"0000-00-00 00:00:00",
"price":"10","version":"0","watch_num":"12","download_num":"27",
"from":"particle","contest_id":"1","is_share":"0","parent_id":"0",
"platform":"1","tool":"1","extension":"zip","file_size":"1768150",
"file_name":null,"folder_id":"0","password":null,"topic_id":"0","work_id":"0",
"is_private":"0","active":"1","type_name":"Particle","type_name_cn":"\u7279\u6548",
"is_folder":0,"author_name":"miskas",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000978_thumb.jpg",
"author_level":"10","author_point":"387","tool_name":"Sparticle",
"tool_domain":"sparticle","tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg",
"platform_name":"Flash","platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png",
"platform_key":"flash","extension_bg":"153","extension_bg_thumb":"352",
"player":null
},
{
"id":"642",
"title":"sword",
"desc":"Like xianjian wonder spread, so did this. Everyone like to vote, please thank you!",
"author_id":"1000673","download_url":"","preview_url":"0","tags":"sword0",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/052B80F9-8E9F-3034-5EE7-9799AF938045.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/052B80F9-8E9F-3034-5EE7-9799AF938045_thumb.jpg",
"view_num":"5120","fav_num":"83","comment_num":"14","type":"1","create_date":"2014-01-21 02:18:51",
"update_date":"2014-02-19 07:52:32","last_comment_date":"0000-00-00 00:00:00","price":"10","version":"4",
"watch_num":"7","download_num":"20","from":"particle","contest_id":"1","is_share":"0","parent_id":"0",
"platform":"1","tool":"1","extension":"zip","file_size":"2070899","file_name":null,"folder_id":"0",
"password":null,"topic_id":"0","work_id":"0","is_private":"0","active":"1","type_name":"Particle",
"type_name_cn":"\u7279\u6548","is_folder":0,"author_name":"zhouyouwu",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000673_thumb.jpg",
"author_level":"10","author_point":"722","tool_name":"Sparticle","tool_domain":"sparticle",
"tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg","platform_name":"Flash",
"platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png","platform_key":"flash",
"extension_bg":"153","extension_bg_thumb":"352",
"player":null
}
]</code></pre>
</div>


<h2 id="item_list_by_author" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/item/loadbyuser/[userid]</span>
</h2>
<ul>
<li><?= $this->lang->line('item_list_by_author_desc') ?></li>
<li><?= $this->lang->line('item_list_by_author_return') ?></li>
<li><?= $this->lang->line('item_list_by_author_note') ?></li>
<!-- 
<li>Description:Item list by author</li>
<li>Return: latest 20 items of specified user id</li>
<li>Note: You must add post parameter 'token'. If the token is correct and userid is author of these items, then the download_url is available.
</li>
--> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/loadbyuser/1000002
---
[
{
"id":"264",
"title":"Cool Light",
"desc":"",
"author_id":"1000009",
"download_url":"http:\/\/www.effecthub.com\/uploads\/attachment\/F50DCB9B-87C1-1468-091E-8282D57827DD.zip",
"preview_url":"0","tags":"light",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/03B05056-E2A1-2058-4046-5382ED028FD6.jpg",
"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/03B05056-E2A1-2058-4046-5382ED028FD6_thumb.jpg",
"view_num":"179","fav_num":"1","comment_num":"1","type":"1","create_date":"2013-09-18 05:28:12","update_date":"2013-09-18 05:28:12",
"last_comment_date":"0000-00-00 00:00:00","price":"10","version":"2","watch_num":"0","download_num":"2",
"from":"particle","contest_id":"0","is_share":"0","parent_id":"243","platform":"1","tool":"1","extension":"zip",
"file_size":"45494","file_name":null,"folder_id":"0","password":null,"topic_id":"0","work_id":"0","is_private":"0",
"active":"1","type_name":"Particle","type_name_cn":"\u7279\u6548","is_folder":0,"author_name":"Chenguang Liu",
"author_pic":"http:\/\/tp1.sinaimg.cn\/1362706900\/180\/5623207546\/1","author_level":"1","author_point":"612",
"tool_name":"Sparticle","tool_domain":"sparticle","tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg",
"platform_name":"Flash","platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png","platform_key":"flash",
"extension_bg":"153","extension_bg_thumb":"352","player":null
},
{
"id":"58",
"title":"Thundercloud v2",
"desc":"Thundercloud v2",
"author_id":"1000009"
,"download_url":"http:\/\/www.effecthub.com\/uploads\/attachment\/0F6AF65D-189F-6E79-36C7-557A8C1D7255.zip",
"preview_url":"0","tags":"Thundercloud",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/0F93B812-0EE1-D6CF-9F96-FFF77D879C03.jpg"
,"thumb_url":"http:\/\/www.effecthub.com\/uploads\/item\/0F93B812-0EE1-D6CF-9F96-FFF77D879C03_thumb.jpg",
"view_num":"504","fav_num":"5","comment_num":"2","type":"1","create_date":"2013-06-18 14:06:44","update_date":"2013-06-21 14:34:43",
"last_comment_date":"0000-00-00 00:00:00","price":"10","version":"1","watch_num":"2","download_num":"2",
"from":"particle","contest_id":"0","is_share":"0","parent_id":"0","platform":"1","tool":"1","extension":"zip",
"file_size":"39490","file_name":null,"folder_id":"0","password":null,"topic_id":"0","work_id":"0","is_private":"0",
"active":"1","type_name":"Particle","type_name_cn":"\u7279\u6548","is_folder":0,"author_name":"Chenguang Liu",
"author_pic":"http:\/\/tp1.sinaimg.cn\/1362706900\/180\/5623207546\/1","author_level":"1","author_point":"612",
"tool_name":"Sparticle","tool_domain":"sparticle","tool_pic":"http:\/\/www.effecthub.com\/uploads\/tool\/1_thumb.jpg",
"platform_name":"Flash","platform_pic":"http:\/\/www.effecthub.com\/images\/flash.png","platform_key":"flash",
"extension_bg":"153","extension_bg_thumb":"352","player":null
}
]
</code></pre>
</div>

<h2 id="download_item" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/item/download/[item id]</span>
</h2>
<ul>
<li><?= $this->lang->line('download_item_desc') ?></li>
<li><?= $this->lang->line('download_item_return') ?></li>
<li><?= $this->lang->line('download_item_note') ?></li>
<!-- 
<li>Description: Download item</li>
<li>Return: download URL of specified item id</li>
<li>Note: You must add post parameters 'userid' and 'token'. If the token is correct, then the download_url is available, and coins will be spent
</li>
 --> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/download/1
---
http://www.effecthub.com/disk/1000002/particle/img201005120949250.jpg
</code></pre>
</div>

<h2 id="upload_pic" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/item/upload_pic</span>
</h2>
<ul>
<li>Description: Upload item screenshot</li>
<li>Return: the static URL of uploaded screenshot</li>
<li>Note: You must post picture file data
</li>
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/upload_pic
---
http://www.effecthub.com/uploads/item/0CC6B4AA-69D4-36C2-D600-A125A3B5DD5D.jpg
</code></pre>
</div>


<h2 id="upload_item" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/item/upload_attachment</span>
</h2>
<ul>
<li><?= $this->lang->line('upload_item_desc') ?></li>
<li><?= $this->lang->line('upload_item_return') ?></li>
<li><?= $this->lang->line('upload_item_note') ?></li>
<!-- 
<li>Description: Upload item data file</li>
<li>Return: the static URL of uploaded attachments</li>
<li>Note: You must post attachment file data
</li>
--> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/upload_attachment
---
http://www.effecthub.com/uploads/attachment/0CC6B4AA-69D4-36C2-D600-A125A3B5DD5D.zip
</code></pre>
</div>

<h2 id="create_update_item" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/item/save</span>
</h2>
<ul>
<li><?= $this->lang->line('create_update_item_desc') ?></li>
<li>
<ul><?= $this->lang->line('create_update_item_create') ?></ul>
<ul><?= $this->lang->line('create_update_item_update') ?></ul>
</li>
<li><?= $this->lang->line('create_update_item_note') ?></li>
<!-- 
<li>Description: Create or Update item</li>
<li> 
<ul> <b>create:</b> Post userid, token, title, desc, tags, price, type, version, from, is_private, contest_id, parent_id, pic, attachment.(type: 1 is particle, 2 is model, 3 is texture, 6 is animation)(from: 'particle' is sparticle, 'dragonbones' is dragonbones)
 </ul>
 <ul><b>update:</b> Post id, userid, token, title, desc, tags, price, type, version, from, is_private, contest_id, parent_id, pic, attachment.(type: 1 is particle, 2 is model, 3 is texture, 6 is animation)(from: 'particle' is sparticle, 'dragonbones' is dragonbones)
</ul>
</li>
<li>Note:You can use upload_pic and upload_attachment to get pic/attachment URL first.</li>
--> 
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/item/save
---
http://localhost/effecthub/uploads/attachment/8C1DAC78-0225-E8EA-1D22-D399DB0E25D2.zip
</code></pre>
</div>





<h2 id="load_user" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/user/load/[user id]</span>
</h2>
<ul>
<li><?= $this->lang->line('load_user_desc') ?></li>
<li><?= $this->lang->line('load_user_return') ?></li>
<li><?= $this->lang->line('load_user_parameter') ?></li>
<li><?= $this->lang->line('load_user_note') ?></li>
<!-- 
<li>Description: Load user information</li>
<li>Return: the detail information of specified user id</li>
-->
</ul>

<h3 class="api">Example</h3>

<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/load/1028773
---
{
"id":"1028773",
"name":"1405046732247",
"email":"",
"countryCode":"US",
"displayName":"1405046732247",
"pic_url":null,
"follow_num":"0",
"follower_num":"0",
"source_pic_url":"",
"password":"",
"active":"1",
"point":"50",
"balance":"0",
"from":"sparticle",
"consent":"on",
"update_time":"2014-07-11 04:45:32",
"create_time":"2014-07-11 04:45:32",
"last_login_time":"2014-07-11 04:45:32",
"last_login_ip":"",
"homepage":null,
"desc":null,
"latitude":null,
"longitude":null,
"token":"",
"verified":"0",
"level":"1",
"space":"1073741824",
"language":"0",
"job_type":"1",
"email_valid":"1",
"noti_message":"on",
"noti_followme":"on",
"noti_invite":"on",
"noti_comment":"on"
}</code></pre>
</div>

<h2 id="mail_list" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/user/mail/[user id]</span>
</h2>

<ul>
<li><?= $this->lang->line('mail_list_desc') ?></li>
<li><?= $this->lang->line('mail_list_return') ?></li>
<li><?= $this->lang->line('mail_list_parameter') ?></li>
<!-- 
<li>Description: the mails of user id</li>
<li>Return: the latest 5 mail list of specified user id.</li>
<li>Parameter: You must add post parameter 'token'.If the token is correct, then the mail list is available.
</li>
-->
</ul>
<h3 class="api">Example</h3>

<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/mail/1000002
---
</code></pre>
</div>

<h2 id="notification_list" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/user/notification/[user id]</span>
</h2>

<ul>
<li><?= $this->lang->line('notification_list_desc') ?></li>
<li><?= $this->lang->line('notification_list_return') ?></li>
<li><?= $this->lang->line('notification_list_parameter') ?></li>
<!-- 
<li>Description: Notification list of user id</li>
<li>Return: the latest 5 notification list of specified user id.</li>
<li>Parameter: You must add post parameter 'token'.If the token is correct, then the notification list is available.
</li> 
-->
</ul>

<h3 class="api">Example</h3>

<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/notification/1000002
---
{
  "page": 1,
  "pages": 100,
  "per_page": 15,
  "total": 1500,
  "user": [
    {
      "id": 2,
      "name": "Rich Thornett",
      "username": "frogandcode",
      "url": "http://effecthub.com/frogandcode",
      "avatar_url": "http://effecthub.com/system/users/2/avatars/original/headitem.jpg",
      "location": "Salem, MA",
      "twitter_screen_name": "frogandcode",
      "drafted_by_user_id": 1,
      "item_count": 10,
      "draftees_count": 36,
      "followers_count": 254,
      "following_count": 309,
      "comments_count": 331,
      "comments_received_count": 40,
      "likes_count": 3041,
      "likes_received_count": 52,
      "rebounds_count": 2,
      "rebounds_received_count": 1,
      "created_at": "2009/07/07 21:51:50 -0400"
    },
    ...
  ]
}</code></pre>
</div>

<h2 id="get_news_feeds_of_follows" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/user/myfollow/[user id]</span>
</h2>
<ul>
<li><?= $this->lang->line('get_news_feeds_of_follows_desc') ?></li>
<li><?= $this->lang->line('get_news_feeds_of_follows_return') ?></li>
<li><?= $this->lang->line('get_news_feeds_of_follows_parameter') ?></li>

<!-- 
<li>Description: get news feed list of specified user id.</li>
<li>Return: the latest 5 news feed list of specified user id.</li>
<li>Parameter: You must add post parameter 'token'.If the token is correct, then the news feed list is available.
</li> 
-->
</ul>
<h3 class="api">Example</h3>

<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/myfollow/1000002
---
[
{
"id":"6297",
"user_id":"1028758",
"action":null,
"content":null,
"target_name":"Chenguang Liu",
"pic_url":"http:\/\/tp1.sinaimg.cn\/1362706900\/180\/5623207546\/1",
"target_url":null,"status_type":"1",
"content_id":"0","target_id":"1000009",
"timestamp":"2014-07-10 09:37:26",
"author_name":"labuser","author_pic":"http:\/\/www.effecthub.com\/images\/blank.jpg"
},
{
"id":"6296",
"user_id":"1000002",
"action":null,
"content":null,
"target_name":"Sparticle\u5165\u95e8\u6559\u7a0b",
"pic_url":null,"target_url":null,"status_type":"8",
"content_id":"184",
"target_id":"57",
"timestamp":"2014-07-07 00:31:36",
"author_name":"disound",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000002_thumb.jpg",
"content_content":"\u9700\u8981\u88c5\u4e2aAdobe AIR"
},
{
"id":"6295",
"user_id":"1000235",
"action":null,
"content":null,
"target_name":"Test1",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/item\/44CCC446-FA41-7459-FFE7-A391C7042AD7_thumb.jpg",
"target_url":null,
"status_type":"5",
"content_id":"1200","target_id":"11588",
"timestamp":"2014-07-05 06:18:32",
"author_name":"roens",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000235_thumb.jpg",
"content_content":"can be more superior"
},
{"id":"6294","user_id":"1028520",
"action":null,"content":null,
"target_name":"Sparticle\u5165\u95e8\u6559\u7a0b",
"pic_url":null,
"target_url":null,
"status_type":"8",
"content_id":"183",
"target_id":"57",
"timestamp":"2014-07-04 15:17:13",
"author_name":"chendalei",
"author_pic":"http:\/\/www.effecthub.com\/images\/blank.jpg",
"content_content":"\u538b\u7f29\u5305\u600e\u4e48\u5b89\u88c5\u554a \u6c42\u5927\u795e"
},
{
"id":"6293",
"user_id":"1028486",
"action":null,
"content":null,
"target_name":null,
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1028486.jpg",
"target_url":null,
"status_type":"7",
"content_id":"0",
"target_id":"1028486",
"timestamp":"2014-07-04 03:19:22",
"author_name":"6340998",
"author_pic":"http:\/\/www.effecthub.com\/uploads\/avatar\/1028486_thumb.jpg"
}
]</code></pre>
</div>

<h2 id="user_register" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/user/register</span>
</h2>
<ul>
<li><?= $this->lang->line('user_register_desc') ?></li>
<li><?= $this->lang->line('user_register_return') ?></li>
<li><?= $this->lang->line('user_register_parameter') ?></li>
<li><?= $this->lang->line('user_register_note') ?></li>
<!-- 
<li>Description:get all the information of current register user including social information, token and email</li>
<li>Return: all the information of current register user including social information, token and email</li>
<li>Parameter: Post 'email_address', 'password'.
</li> 
-->
</ul>

<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/register
---
{
"id":"1028766",
"name":"1404972465252",
"email":"1404972465252@helloworld.com",
"countryCode":"US",
"displayName":"1404972465252",
"pic_url":null,
"follow_num":"0",
"follower_num":"0",
"source_pic_url":"",
"password":"753dcad922c2b95ef45fdd7dfe02b564",
"active":"1",
"point":"50",
"balance":"0",
"from":"sparticle",
"consent":"on",
"update_time":"2014-07-10 08:07:45",
"create_time":"2014-07-10 08:07:45",
"last_login_time":"0000-00-00 00:00:00",
"last_login_ip":"",
"homepage":null,
"desc":null,
"latitude":null,
"longitude":null,
"token":null,
"verified":"0",
"level":"1",
"space":"1073741824",
"language":"0",
"job_type":"1",
"email_valid":"1",
"noti_message":"on",
"noti_followme":"on",
"noti_invite":"on",
"noti_comment":"on"
}
</code></pre>
</div>

<h2 id="user_login" class="section api">
	<span class="meta">POST</span>
	<span class="alt">/user/login</span>
</h2>

<ul>
<li><?= $this->lang->line('user_login_desc') ?></li>
<li><?= $this->lang->line('user_login_return') ?></li>
<li><?= $this->lang->line('user_login_parameter') ?></li>
<li><?= $this->lang->line('user_login_note') ?></li>
<!-- 
<li>Description: get all the information of current user including social information, token and email.</li>
<li>Return: all the information of current user including social information, token and email.</li>
<li>Parameter: Post 'username' and 'password'.</li>
<li>Note: 'username' is the user's mail address and 'password' must be embeded through MD5</li>
--> 
</ul>
<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/login
---
{
	"id":"1028758",
	"name":"labuser",
	"email":"labuser@adobe.com",
	"countryCode":"CN",
	"displayName":"labuser",
	"pic_url":"http:\/\/www.effecthub.com\/images\/blank.jpg",
	"follow_num":"0",
	"follower_num":"0",
	"source_pic_url":"",
	"password":"",
	"active":"1",
	"point":"50",
	"balance":"0",
	"from":"0",
	"consent":"0",
	"update_time":"2014-07-10 04:49:41",
	"create_time":"2014-07-10 04:49:41",
	"last_login_time":"2014-07-10 04:49:41",
	"last_login_ip":"::1",
	"homepage":null,
	"desc":null,
	"latitude":null,
	"longitude":null,
	"token":"E1545C50-08B2-88C1-9BBE-936C24F392A1",
	"verified":"0",
	"level":"1",
	"space":"1073741824",
	"language":"0",
	"job_type":"1",
	"email_valid":"1",
	"noti_message":"on",
	"noti_followme":"on",
	"noti_invite":"on",
	"noti_comment":"on"
}
</code></pre>
</div>

<h2 id="popular_user_list" class="section api">
	<span class="meta">GET</span>
	<span class="alt">/user/popular</span>
</h2>

<ul>
<li><?= $this->lang->line('popular_user_list_desc') ?></li>
<li><?= $this->lang->line('popular_user_list_return') ?></li>

<!-- 
<li>Description: the popular 10 authors list</li>
<li>Return: the popular 10 authors list</li>
--> 
</ul>
<h3 class="api">Example</h3>
<div class="code-block">
<pre><code>$ curl http://www.effecthub.com/api/user/popular
---
[
{
"id":"1000008",
"name":"ChengLiao",
"countryCode":"CN",
"displayName":"Liao Cheng",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000008_thumb.jpg",
"follow_num":"12",
"follower_num":"62",
"country_name":"China"
},
{
"id":"1000002",
"name":"disound",
"countryCode":"CN",
"displayName":"disound",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000002_thumb.jpg",
"follow_num":"35",
"follower_num":"39",
"country_name":"China"
},
{
"id":"1000057",
"name":"\u63c6\u5143\u5144",
"countryCode":"CN",
"displayName":"\u63c6\u5143\u5144",
"pic_url":"http:\/\/www.effecthub.com\/images\/blank.jpg",
"follow_num":"0",
"follower_num":"22",
"country_name":"China"
},
{
"id":"1000005",
"name":"gNikro",
"countryCode":"RU",
"displayName":"Klementiev Konstantine",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000005_thumb.jpg",
"follow_num":"4",
"follower_num":"20",
"country_name":"Russia"
},
{
"id":"1000009",
"name":"Chenguang Liu",
"countryCode":"CN",
"displayName":"Chenguang Liu",
"pic_url":"http:\/\/tp1.sinaimg.cn\/1362706900\/180\/5623207546\/1",
"follow_num":"6",
"follower_num":"19",
"country_name":"China"
},
{
"id":"1000097",
"name":"orangesuzuki",
"countryCode":"JP",
"displayName":"Katsushi Suzuki",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000097_thumb.jpg",
"follow_num":"6",
"follower_num":"15",
"country_name":"Japan"
},
{
"id":"1000185",
"name":"Paul Ollivier | FLASHMAFIA",
"countryCode":"FR",
"displayName":"Paul Ollivier",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000185_thumb.jpg",
"follow_num":"7",
"follower_num":"14",
"country_name":"France"
},
{
"id":"1000012",
"name":"nidin",
"countryCode":"IN",
"displayName":"Nidin Vinayak",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000012_thumb.jpg",
"follow_num":"4",
"follower_num":"14",
"country_name":"India"
},
{
"id":"1000110",
"name":"star",
"countryCode":"CN",
"displayName":"star",
"pic_url":"http:\/\/www.effecthub.com\/images\/blank.jpg",
"follow_num":"0",
"follower_num":"13",
"country_name":"China"
},
{
"id":"1000243",
"name":"zhonghcc",
"countryCode":"CN",
"displayName":"Chenzhi Wu",
"pic_url":"http:\/\/www.effecthub.com\/uploads\/avatar\/1000243_thumb.jpg",
"follow_num":"28",
"follower_num":"12",
"country_name":"China"
}
]</code></pre>
</div>



</div>
</div>


<div class="secondary api">
	<div class="side-nav" style="background:#FFF">
	<h3>Items</h3>
	<ul>
		<li>
			<a href="#get_item">
				<strong>GET /item/load/:id</strong>
			</a>
		</li>
		<li>
			<a href="#get_item_by_tool">
				<strong>GET /item/loadbytool/[tool id]</strong>
			</a>
		</li>
		<li>
			<a href="#get_item_by_type">
				<strong>GET /item/loadbytype/[type id]</strong>
			</a>
		</li>
		<li>
			<a href="#item_list_by_author">
				<strong>GET /item/loadbyuser/[userid]</strong>
			</a>
		</li>
		<li>
			<a href="#download_item">
				<strong>POST /item/download/[item id]</strong>
			</a>
		</li>
		<li>
			<a href="#upload_pic">
				<strong>POST /item/upload_pic</strong>
			</a>
		</li>
		<li>
			<a href="#upload_item">
				<strong>POST /item/upload_attachment</strong>
			</a>
		</li>
		<li>
			<a href="#create_update_item">
				<strong>POST /item/save</strong>
			</a>
		</li>
	</ul>
	
	<h3>Users</h3>
	<ul>
		<li>
			<a href="#load_user">
				<strong>GET /user/load/[user id]</strong>
			</a>
		</li>
		<li>
			<a href="#mail_list">
				<strong>GET /user/mail/[user id]</strong>
			</a>
		</li>
		<li>
			<a href="#notification_list">
				<strong>GET /user/notification/[user id]</strong>
			</a>
		</li>
		<li>
			<a href="#get_news_feeds_of_follows">
				<strong>GET /user/myfollow/[user id]</strong>
			</a>
		</li>
		<li>
			<a href="#user_register">
				<strong>POST /user/register</strong>
			</a>
		</li>
		<li>
			<a href="#user_login">
				<strong>POST /user/login</strong>
			</a>
		</li>
		<li>
			<a href="#popular_user_list">
				<strong>GET /user/popular</strong>
			</a>
		</li>
	</ul>
		
	</div>
</div>

</div>
<?php $this->load->view('footer') ?>