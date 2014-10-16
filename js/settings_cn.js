//settings ajax check
$('#full_name').blur(function(){
	var l = $('#full_name').val().length;
	if ( l < 1) {
		$('#display-message').html('用户名至少包含一个字符');
		$('#display-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
	} else {
		$('#display-message').html('你在Effecthub上使用的名字');
		$('#display-message').css({
			'color':'#999999',
			'font-weight':'normal'
		});
	}
});

$('#user_name').blur(function(){
	var l = $('#user_name').val().length;
	if ( l < 1) {
		$('#user-message').html('账号名至少包含一个字符');
		$('#user-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
	} else {
		var name = $('#user_name').val();
		
		$.get("http://www.effecthub.com/account/settings/verifyuser/" + name, function(data,status){
			if (status=='success'){
				var verify = data;
				if (verify == true){
					
					$('#user-message').html('你的effecthub网址: http://www.effecthub.com/people/<strong><span id="username">' + name + '</span></strong>');
					$('#user-message').css({
						'color':'#999999',
						'font-weight':'normal'
					});
					
				} else {
					$('#user-message').html('该账号名已被使用，请重新填写');
					$('#user-message').css({
						'color':'#e00',
						'font-weight':'bold'
					});
				}
			}

		});
		

	}
});

$('#save_settings').click(function(){

	$('#save-settings-message').css('display','none');
	
	var l = $('#full_name').val().length;
	
	if (l < 1) {
		$('#display-message').html('用户名至少包含一个字符');
		$('#display-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
		
		return;
	}
	
	var ll = $('#user_name').val().length;
	
	if (ll < 1) {
		$('#user-message').html('账号名至少包含一个字符');
		$('#user-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
		
		return;
	}
	
	$.post(
		"http://www.effecthub.com/account/settings/savesettings",
		{
			displayname:$('#full_name').val(),
			username:$('#user_name').val(),
			country:$('#country').val(),
			userurl:$('#user_url').val(),
			description:$('#user_bio').val()
		},
		function(data,status){
			if (status == 'success'){
				if (data == true){
					$('#save-settings-message').html('保存个人信息成功！');
		    		$('#save-settings-message').css('display','inline');
				} else {
					$('#user-message').html('该账号名已被使用，请重新填写');
					$('#user-message').css({
						'color':'#e00',
						'font-weight':'bold'
					});
				} 
			} else {
				$('#save-settings-message').html('保存信息失败，请稍后再试');
	    		$('#save-settings-message').css({
	    			'display':'inline',
	    			'background':'#e00'
	    		});
			}
			
		}
	
	);
		
});

$('#current_password').blur(function(){
	
	$('#c-password-message').css('visibility','visible');
	
	if ($('#current_password').val() == ''){
		$('#c-password-message').css('color','#e00');
		$('#c-password-message').html('请输入当前密码');
	} else {
		$('#c-password-message').html('正在验证...');
		$('#c-password-message').css('color','#666');
		
		var p = $('#current_password').val();
		
		$.get("http://www.effecthub.com/account/settings/verifypassword/" +p, function(data,status){
		        
			if (status=='success'){
				
		        var verify = data;
		        if (verify == false){
		        	$('#c-password-message').html('你输入的密码不正确');
			    	$('#c-password-message').css('color','#e00');
			    } else {
			    	$('#c-password-message').css('visibility','hidden');
			    	
			    }
	        }
			
		});	

	}
	
});

$('#change_password').click(function(){
	
	$('#save-password').css('display','none');
	
	var np = $('#new_password').val();
	var cp = $('#confirm_password').val();
	
	if (np != cp) {
		$('#n-password-message').html('你两次输入的新密码不匹配');
		$('#n-password-message').css('visibility','visible');
	}
	else if (np == ''){
		$('#n-password-message').html('你设置的新密码须至少包含一个字符');
		$('#n-password-message').css('visibility','visible');
	}
	else {
		$('#n-password-message').css('visibility','hidden');
		
		var pswd = np;
		var old_pswd = $('#current_password').val();
		
		$.get("http://www.effecthub.com/account/settings/savepassword/" + pswd + "/" + old_pswd,function(data,status){
			
			if (status=='success'){
				
				var verify = data;
				if (verify == true) {
					
					$('#save-password').html('密码设置成功！');
		    		$('#save-password').css({
		    			'background':'#0a0',
		    			'display':'inline'
		    		});
					
				} else {
					$('#c-password-message').html('你输入的密码不正确');
			    	$('#c-password-message').css({
			    		'visibility':'visible',
			    		'color':'#e00'
			    	});
				}
			
			} else {
				
				$('#save-password').html('设置密码失败，请稍后重试');
	    		$('#save-password').css({
	    			'background':'#e00',
	    			'display':'inline'
	    		});
			}
		
		});
	}
});

$('#notice_setting').click(function(){
	
	$.post(
		"http://www.effecthub.com/account/settings/subscribe",
		{
			consent:$('#consent').is(':checked') == true?'on':0,
			message:$('#notimessage').is(':checked') == true?'on':0,
			followme:$('#followme').is(':checked') == true?'on':0,
			invite:$('#invite').is(':checked') == true?'on':0,
			comment:$('#comment').is(':checked') == true?'on':0
		},
		function(data,status){
			if (status == 'success'){
			
				$('#notice-settings-message').html('保存成功！');
				$('#notice-settings-message').css({
					'display':'inline',
					'background':'#0a0'
		    	});
			} else {
				$('#notice-settings-message').html('保存失败，请稍后再试');
				$('#notice-settings-message').css({
					'display':'inline',
					'background':'#e00'
				});
			}		
		}
	);
});



