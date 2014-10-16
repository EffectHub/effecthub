<?php $this->load->view('header') ?>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong><?= $this->lang->line('userinvite_userlogin_slogan'); ?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('header_sign_up'); ?></a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
	</h1>
</div>
<?php  }?>

<div id="main">
<div class="group">
	<div class="full">
		<h1 class="alt"><?= $this->lang->line('userinvite_title'); ?>
                        <span class="sep"></span></h1>
	</div>
</div>
<div class="idtabs">
<div class="apps-type"> 	
<ul class="tabs">
	<li><a href="<?php echo site_url('invite/twitter');?>" <?php if($type=='twitter')echo "class='selected'"?>>Twitter</a></li>
	<li><a href="<?php echo site_url('invite/google');?>" <?php if($type=='google')echo "class='selected'"?>>Google</a></li>
	<li><a href="<?php echo site_url('invite/weibo');?>" <?php if($type=='weibo')echo "class='selected'"?>>Weibo</a></li>
	<li><a href="<?php echo site_url('invite/email');?>" <?php if($type=='email')echo "class='selected'"?>>Email</a></li>
</ul>
</div>

		
<form id="signin_form" class="gen-form" style="background:#FFF;padding:20px;border-radius: 5px;" method="post" action="<?=site_url('invite/send_invite/'.$type)?>" enctype="multipart/form-data">
		<?php if( $type =='email' ){ ?>
            <p style="color:#000"><?= $this->lang->line('userinvite_email_title'); ?></p>
			<fieldset><input type="text" class="signin_input txt" id="title" name="uid[]" placeholder="" value="">
		        <input type="text" class="signin_input txt" id="title" name="uid[]" placeholder="" value="">
		        <input type="text" class="signin_input txt" id="title" name="uid[]" placeholder="" value="">
		        <input type="text" class="signin_input txt" id="title" name="uid[]" placeholder="" value="">
		        <input type="text" class="signin_input txt" id="title" name="uid[]" placeholder="" value="">
		            </fieldset>
			<fieldset>
                <p style="color:#000"><?= $this->lang->line('userinvite_message'); ?></p>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="width:500px;height: 80px; "  placeholder=""/><?= $this->lang->line('userinvite_message_content'); ?></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('userinvite_error'); ?></span>
		            </fieldset>
					
		             <fieldset>
		             <input type="hidden" name="first" value="<?php echo $first?>"/>
		            <button type="button" class="form-sub" name="sign_in" onclick="checkgroup()"><?= $this->lang->line('userinvite_send_invitations'); ?></button>
		            </fieldset>
		<?php }else{ ?>	
			
		<?php if( count($following_list)<1){ ?>
		
			<?php if( $type =='twitter' ){ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/twitter.png">
				                <a class="accountBindItemText" href="<?=site_url('login/twitter')?>">&gt;<?= $this->lang->line('userinvite_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $type =='weibo' ){ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/sina.png">
				                <a class="accountBindItemText" href="<?=site_url('login/sina')?>">&gt;<?= $this->lang->line('userinvite_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $type =='google' ){ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/google.png">
				                <a class="accountBindItemText" href="<?=site_url('login/google')?>">&gt;<?= $this->lang->line('userinvite_connect'); ?></a>
				                </div>
				             <?php } ?>
		
		<?php }else{ ?>
		    		<p>
		
      <a href="javascript:void(0);" class="mp-pick-all form-sub"><?= $this->lang->line('userinvite_select_all'); ?>   </a>&nbsp;&nbsp;
      <a href="javascript:void(0);" class="mp-drop-all form-sub"><?= $this->lang->line('userinvite_select_none'); ?>   </a>
    </p>
		    		<div class="mp-members" style="margin-top:30px;margin-bottom:10px;border:2px solid #ddd">
    				<ul style="margin:0;padding:0">
		            <?php foreach($following_list as $_following): ?>
		            <li class="mp-member-item" title="<?php echo $_following['displayName']; ?>">
    <label for="uid<?php echo $_following['id']; ?>" style="cursor:pointer;float:none;width:100%;margin:0"><img src='<?php echo $_following['pic_url']; ?>' style='width:50px;height:50px;'></label>
    <div style="padding-top:5px">
     <?php if( $type =='twitter' ){ ?>
      <input type="checkbox" <?php echo $_following['is_in']?'disabled':''; ?> name="uid[]" value="<?php echo $_following['id']; ?>" id="uid<?php echo $_following['id']; ?>" style="display:inline"> <a href="<?php echo 'http://twitter.com/'.$_following['screen_name'];?>" target="_blank"><?php echo $_following['displayName']; ?></a>
    <?php }else if( $type =='google' ){ ?>
     <input type="checkbox" <?php echo $_following['is_in']?'disabled':''; ?> name="uid[]" value="<?php echo $_following['screen_name']; ?>" id="uid<?php echo $_following['id']; ?>" style="display:inline"> <a href="<?php echo 'mailto:'.$_following['screen_name'];?>"><?php echo $_following['displayName']; ?></a>
    <?php }else if( $type =='weibo' ){ ?>
    	<input type="checkbox" <?php echo $_following['is_in']?'disabled':''; ?> name="uid[]" value="<?php echo $_following['weibo_id']; ?>" id="uid<?php echo $_following['id']; ?>" style="display:inline"> <a href="<?php echo 'http://weibo.com/u/'.$_following['id'];?>" target="_blank"><?php echo $_following['displayName']; ?></a>
    <?php } ?>
    </div>
    <span class="text-supple"></span>
  </li>
                  <?php endforeach; ?>
		    </ul>
  </div>
		    <fieldset>
                <p style="color:#000"><?= $this->lang->line('userinvite_message'); ?></p>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="width:500px;height: 80px; "  placeholder=""/><?= $this->lang->line('userinvite_message_content'); ?> </textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('userinvite_error'); ?></span>
		            </fieldset>
					
		             <fieldset>
		             <input type="hidden" name="first" value="<?php echo $first?>"/>
		            <button type="button" class="form-sub" name="sign_in" onclick="checkgroup()"><?= $this->lang->line('userinvite_send_invitations'); ?></button>
		            </fieldset>
		            
		            <?php } ?>
		            <?php } ?>
        		</form>
</div>

</div>

<div class="secondary">
<?php if( isset($friends_list)&&count($friends_list)>1){ ?>
<h3><?= $this->lang->line('userinvite_possible_friends'); ?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($friends_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= $this->lang->line('user_followers'); ?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('user_follow'); ?></a>
 </li>
                   <?php endforeach; ?> </ul></div><br/><br/>
<?php } ?> 
<h3><?= $this->lang->line('userinvite_explore_groups'); ?><span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($hot_groups as $_group): ?>
 <li>
<a href="<?php echo site_url('group/'.$_group['id'])?>"><img src="<?php echo $_group['group_pic']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('group/'.$_group['id'])?>" class="group-title"><?php echo $_group['group_name']; ?></a>
 <br><span class="group-count"><?php echo $_group['member_num']; ?> <?= strtolower($this->lang->line('userinvite_members')); ?><br><?php echo $_group['topic_num']; ?> <?= strtolower($this->lang->line('userinvite_topics')); ?></span>
</p>
 
<a class="group-follow" href="<?php echo site_url('group/index/'.$_group['id'])?>"><?= $this->lang->line('userinvite_join'); ?></a>
 </li>
<?php endforeach; ?>
 </ul></div>


</div>
 




</div>
<?php $this->load->view('footer') ?>