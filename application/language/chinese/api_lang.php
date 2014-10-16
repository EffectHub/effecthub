<?php 
$lang['page_title'] = 'EffectHub 接口 <span>beta版本</span>';
$lang['introduce'] = 'EffectHub接口已经对非商业用途开放. 商业用途首先要接受前提协议. 如果您想要将该接口用于商业目的，请<a href="mailto:effecthub.com@gmail.com">联系我们</a>';
$lang['overview'] = '概述';
$lang['overview_p1'] = '所有的接口都是通过HTTP协议通信. 所有的返回值都是JSON格式. 所有API都尽可能遵从 RESTful协议.';
$lang['overview_p2'] = '目前不需要接口关键字,但是我们未来会调整添加接口关键字，用以加强我们对用户的行为的检测并强化使用条款（见下文）';
$lang['overview_p3'] = '接口调用限制：每分钟不多于60次，每天不多于1万次. 未来我们会调整该限制并与相应的接口关键字相绑定. 一旦超过限制会返回 错误:403 "Rate Limit Exceeded" ';
$lang['overview_p4'] = '有任何疑问或者建议意见请<a href="mailto:effecthub.com@gmail.com">联系我们</a>.';
$lang['terms_of_use'] = '使用条款';
$lang['terms_of_use_intro'] = '以下条款及条件适用于所有 EffectHub网页版接口.';
$lang['terms_of_use_i1'] = 'EffectHub会员对其内容拥有所有权利，这是你的责任，以确保您使用的API并不违反这些权利。';
$lang['terms_of_use_i2'] = '当作品作者要求移除您应用程序中任何EffectHub项目或个人信息中，您务必要在24小时内删除。';
$lang['terms_of_use_i3'] = '不要使用名称EffectHub在你的应用程序，URL或品牌。';
$lang['terms_of_use_i4'] = '不要使用EffectHub的接口，复制或试图取代effecthub.com的基本用户体验的任何应用程序';
$lang['terms_of_use_i5'] = '如果您的应用程序直接或间接地使用EffectHub的接口取得收入，及被认为是一个商业应用程序，请事先获得我们的批准。';
$lang['terms_of_use_i6'] = 'EffectHub保留评估和监控应用程序，以确保它们不会伤害EffectHub的服务器或商业利益的权利。';
$lang['terms_of_use_i7'] = '不要滥用API或使用过度。如果您不确定你的计划用途是否超过条款限制, 请致电<a href="mailto:effecthub.com@gmail.com">我们</a>.';
$lang['terms_of_use_i8'] = 'EffectHub可以在任何时间以任何理由在这些条款框架下终止您调用EffectHub接口的许可。';
$lang['terms_of_use_i9'] = 'EffectHub保留更新和更改这些条款时，恕不另行通知。';

$lang['get_item_desc'] = 'Description: Load item information';
$lang['get_item_return'] = 'Return: details for a item specified by <span class="api-values">:id</span> ';
$lang['get_item_parameter'] = '';
$lang['get_item_note'] = 'Note:You must add post parameter \'userid\' and \'token\'.If the userid is author of this item, then the download_url is available. To get the userid and token, please refer to <a href="#user_login">user login API</a>';


$lang['get_item_by_tool_desc'] = 'Description: Item list by tool such as dragonbones';
$lang['get_item_by_tool_return'] = 'Return: latest 20 items of specified tool id.';
$lang['get_item_by_tool_parameter'] = 'Parameter: tool id, 1 is sparticle, 2 is dragonbones, 3 is sea3d, etc.';
$lang['get_item_by_tool_note'] = '';

$lang['get_item_by_type_desc'] = 'Description:Item list by type';
$lang['get_item_by_type_return'] = 'Return: latest 20 items of specified type id.';
$lang['get_item_by_type_parameter'] = 'Parameter:1 is particle, 2 is model, 3 is texture, 6 is animation, etc.';
$lang['get_item_by_type_note'] = '';


$lang['item_list_by_author_desc'] = 'Description:Item list by author';
$lang['item_list_by_author_return'] = 'Return: latest 20 items of specified user id';
$lang['item_list_by_author_parameter'] = '';
$lang['item_list_by_author_note'] = 'Note: You could add get parameter \'tool\' to get item by specified tool and specified author. You could add post parameter \'token\'. If the token is correct and userid is author of these items, then the download_url is available.';



$lang['download_item_desc'] = 'Description: Download item';
$lang['download_item_return'] = 'Return: download URL of specified item id';
$lang['download_item_parameter'] = '';
$lang['download_item_note'] = 'Note: You must add post parameters \'userid\' and \'token\'. If the token is correct, then the download_url is available, and coins will be spent';

$lang['upload_item_desc'] = 'Description: Upload item data file';
$lang['upload_item_return'] = 'Return: the static URL of uploaded attachments';
$lang['upload_item_parameter'] = '';
$lang['upload_item_note'] = 'Note: You must post attachment file data';

$lang['create_update_item_desc'] = 'Description: Create or Update item';
$lang['create_update_item_create'] = '<b>create:</b> Post userid, token, title, desc, tags, price, price_type, type, tool, version, from, is_private, parent_id, pic, attachment.(type: 1 is particle, 2 is model, 3 is texture, 6 is animation)(from: \'particle\' is sparticle, \'dragonbones\' is dragonbones)';
$lang['create_update_item_update'] = '<b>update:</b> Post id, userid, token, title, desc, tags, price, price_type, type, tool, version, from, is_private, parent_id, pic, attachment.(type: 1 is particle, 2 is model, 3 is texture, 6 is animation)(from: \'particle\' is sparticle, \'dragonbones\' is dragonbones)';
$lang['create_update_item_note'] = 'Note:You can use upload_pic and upload_attachment to get pic/attachment URL first.';

$lang['load_user_desc'] = 'Description: Load user information';
$lang['load_user_return'] = 'Return: the detail information of specified user id';
$lang['load_user_parameter'] = '';
$lang['load_user_note'] = '';

$lang['mail_list_desc'] = 'Description: the mails of user id';
$lang['mail_list_return'] = 'Return: the latest 5 mail list of specified user id.';
$lang['mail_list_parameter'] = 'Parameter: You must add post parameter \'token\'.If the token is correct, then the mail list is available.';
$lang['mail_list_note'] = '';

$lang['notification_list_desc'] = 'Description: Notification list of user id';
$lang['notification_list_return'] = 'Return: the latest 5 notification list of specified user id.';
$lang['notification_list_parameter'] = 'Parameter: You must add post parameter \'token\'.If the token is correct, then the notification list is available.';
$lang['notification_list_note'] = '';

$lang['get_news_feeds_of_follows_desc'] = 'Description: get news feed list of specified user id.';
$lang['get_news_feeds_of_follows_return'] = 'Return: the latest 5 news feed list of specified user id.';
$lang['get_news_feeds_of_follows_parameter'] = 'Parameter: You must add post parameter \'token\'.If the token is correct, then the news feed list is available.';
$lang['get_news_feeds_of_follows_note'] = '';

$lang['user_register_desc'] = 'Description:get all the information of current register user including social information, token and email';
$lang['user_register_return'] = 'Return: all the information of current register user including social information, token and email';
$lang['user_register_parameter'] = 'Parameter: Post \'email_address\', \'password\'.';
$lang['user_register_note'] = '';

$lang['user_login_desc'] = 'Description: get all the information of current user including social information, token and email.';
$lang['user_login_return'] = 'Return: all the information of current user including social information, token and email.';
$lang['user_login_parameter'] = 'Parameter: Post \'username\' and \'password\'.';
$lang['user_login_note'] = 'Note: \'username\' is the user\'s mail address and \'password\' must be embeded through MD5';

$lang['popular_user_list_desc'] = 'Description: the popular 10 authors list';
$lang['popular_user_list_return'] = 'Return: the popular 10 authors list';
$lang['popular_user_list_parameter'] = '';
$lang['popular_user_list_note'] = '';