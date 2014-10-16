//settings ajax check
$('#full_name').blur(function(){
	var l = $('#full_name').val().length;
	if ( l < 1) {
		$('#display-message').html('Your display name should be at least 1 characters');
		$('#display-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
	} else {
		$('#display-message').html('Your name displayed on Effecthub!');
		$('#display-message').css({
			'color':'#999999',
			'font-weight':'normal'
		});
	}
});

$('#user_name').blur(function(){
	var l = $('#user_name').val().length;
	if ( l < 1) {
		$('#user-message').html('Your user name should be at least 1 characters');
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
					
					$('#user-message').html('Your EffectHub URL: http://www.effecthub.com/people/<strong><span id="username">' + name + '</span></strong>');
					$('#user-message').css({
						'color':'#999999',
						'font-weight':'normal'
					});
					
				} else {
					$('#user-message').html('This name is been used. Please change another one.');
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
		$('#display-message').html('Your display name should be at least 1 characters');
		$('#display-message').css({
			'color':'#e00',
			'font-weight':'bold'
		});
		
		return;
	}
	
	var ll = $('#user_name').val().length;
	
	if (ll < 1) {
		$('#user-message').html('Your user name should be at least 1 characters');
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
					$('#save-settings-message').html('Saving information successfully!');
		    		$('#save-settings-message').css('display','inline');
				} else {
					$('#user-message').html('This name is been used. Please change another one.');
					$('#user-message').css({
						'color':'#e00',
						'font-weight':'bold'
					});
				} 
			} else {
				$('#save-settings-message').html('Fail to save your information');
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
		$('#c-password-message').html('Please input your password');
	} else {
		$('#c-password-message').html('Verifying...');
		$('#c-password-message').css('color','#666');
		
		var p = $('#current_password').val();
		
		$.get("http://www.effecthub.com/account/settings/verifypassword/" +p, function(data,status){
		        
			if (status=='success'){
				
		        var verify = data;
		        if (verify == false){
		        	$('#c-password-message').html('Your password is incorrect');
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
		$('#n-password-message').html('The new passwords you input is mismatch');
		$('#n-password-message').css('visibility','visible');
	}
	else if (np == ''){
		$('#n-password-message').html('New password should include at least 1 character');
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
					
					$('#save-password').html('Changing password successfully!');
		    		$('#save-password').css({
		    			'background':'#0a0',
		    			'display':'inline'
		    		});
					
				} else {
					$('#c-password-message').html('Your password is incorrect');
			    	$('#c-password-message').css({
			    		'visibility':'visible',
			    		'color':'#e00'
			    	});
				}
			
			} else {
				
				$('#save-password').html('Fail to save your new password');
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
			
				$('#notice-settings-message').html('Saving successfully!');
				$('#notice-settings-message').css({
					'display':'inline',
					'background':'#0a0'
		    	});
			} else {
				$('#notice-settings-message').html('Fail to save');
				$('#notice-settings-message').css({
					'display':'inline',
					'background':'#e00'
				});
			}		
		}
	);
});



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









