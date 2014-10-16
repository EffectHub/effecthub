<?php 
$lang['page_title'] = 'EffectHub API <span>beta</span>';
$lang['introduce'] = 'The EffectHub API is available for non-commercial use. Commercial use is possible by prior arrangement. Please <a href="mailto:effecthub.com@gmail.com">contact us</a> if you wish to apply for commercial use of the API.';
$lang['overview'] = 'Overview';
$lang['overview_p1'] = 'All API access is over HTTP. All responses are returned as JSON. The API is (mostly) RESTful.';
$lang['overview_p2'] = 'Currently, no API key is required, but this will likely change so that we can better monitor usage and enforce the Terms of Use (below). The API has been stable, but will retain the beta moniker until API keys are added.';
$lang['overview_p3'] = 'API calls are limited to 60 per minute and 10,000 per day. We may change the limit in the future and/or tie it to API keys. Exceeding the limit will result in 403 "Rate Limit Exceeded" responses.';
$lang['overview_p4'] = '<a href="mailto:effecthub.com@gmail.com">Contact us</a> with comments, questions or feedback on the API.';
$lang['terms_of_use'] = 'Terms of Use';
$lang['terms_of_use_intro'] = 'The following terms and conditions govern all use of the EffectHub website API.';
$lang['terms_of_use_i1'] = 'EffectHub members own all rights to their content and it is your responsibility to make sure your use of the API does not contravene those rights.';
$lang['terms_of_use_i2'] = 'You must remove from your application within 24 hours any EffectHub item or personal information that the owner asks you to remove.';
$lang['terms_of_use_i3'] = 'Don\'t use the name EffectHub in your application, url or branding.';
$lang['terms_of_use_i4'] = 'Do not use the EffectHub API for any application that replicates or attempts to replace the essential user experience of effecthub.com';
$lang['terms_of_use_i5'] = 'If your application derives revenue from its use of the EffectHub API, directly or indirectly, it is considered a commercial application and requires our approval in advance.';
$lang['terms_of_use_i6'] = 'EffectHub reserves the right to evaluate and monitor applications to ensure that they do not harm EffectHub\'s servers or business interests.';
$lang['terms_of_use_i7'] = 'Do not abuse the API or use it excessively. If you\'re unsure whether your planned use is excessive, <a href="mailto:effecthub.com@gmail.com">ask us</a>.';
$lang['terms_of_use_i8'] = 'EffectHub may terminate your license to the EffectHub API under these terms at any time for any reason.';
$lang['terms_of_use_i9'] = 'EffectHub reserves the right to update and change these terms from time to time without notice.';

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