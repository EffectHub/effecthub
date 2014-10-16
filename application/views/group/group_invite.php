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
		<strong>EffectHub is connecting the world's gaming designers and developers.</strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
	</h1>
</div>
<?php  }?>

<div id="main">
<ul class="tabs">
		<li class="groups <?php echo $feature=='groups'?'active':'' ?>">
		<a class="selected" href="<?=site_url('group/invite/'.$group['id'])?>">		<span class="meta"><?= $this->lang->line('groupinvite_title') ?></span>
		<span class="count"></span></a></li>
		<li class="groups <?php echo $feature=='groups'?'active':'' ?>">
		<a class="selected" href="<?=site_url('group/inviteFollow/'.$group['id'])?>">		<span class="meta"><?= $this->lang->line('groupinvite_following_title') ?></span>
		<span class="count"></span></a></li>
		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group/'.$group['id'])?>"><?= $this->lang->line('groupcreate_back'); ?></a>
</ul>
<form id="signin_form" class="gen-form" style="background:#FFF;padding:20px;border-radius: 5px;" method="post" action="<?=site_url('group/send_invite')?>" enctype="multipart/form-data">
		    		<p>
      <a href="javascript:void(0);" class="mp-pick-all form-sub"><?= $this->lang->line('groupinvite_select_all') ?>   </a>&nbsp;&nbsp;
      <a href="javascript:void(0);" class="mp-drop-all form-sub"><?= $this->lang->line('groupinvite_select_none') ?>   </a>
    </p>
		    		<div class="mp-members" style="background:#efefef;margin-top:30px;margin-bottom:10px;border:2px solid #ddd">
    				<ul style="margin:0;padding:0">
		            <?php foreach($following_list as $_following): ?>
		            <li class="mp-member-item" title="<?php echo $_following['displayName']; ?>">
    <label for="uid<?php echo $_following['id']; ?>" style="cursor:pointer;float:none;width:100px;margin:0"><img src='<?php echo $_following['pic_url']; ?>' style='width:50px;height:50px;'></label>
    <div style="padding-top:5px">
      <input type="checkbox" name="uid[]" value="<?php echo $_following['id']; ?>" id="uid<?php echo $_following['id']; ?>" style="display:inline"> <a href="<?php echo site_url('user/'.$_following['id'])?>" target="_blank"><?php echo $_following['displayName']; ?></a>
    </div>
    <span class="text-supple"></span>
  </li>
                  <?php endforeach; ?>
		    </ul>
  </div>
		    <fieldset>
                <p style="color:#000"><?= $this->lang->line('groupinvite_message') ?></p>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="width:500px;height: 80px; "  placeholder=""/><?= $this->lang->line('groupinvite_message_content') ?><?php echo $group['group_name']; ?> </textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error') ?></span>
		            </fieldset>
					
		             <fieldset>
		             <input type="hidden" name="group" value="<?php echo $group['id']?>"/>
		            <button type="button" class="form-sub" name="sign_in" onclick="checkgroup()"><?= $this->lang->line('groupinvite_send_invitation') ?></button>
		            </fieldset>
        		</form>
</div>


<div class="secondary">
 
<h3><?= $this->lang->line('groupinvite_explore_groups') ?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($hot_groups as $_group): ?>
 <li>
<a href="<?php echo site_url('group/'.$_group['id'])?>"><img src="<?php echo $_group['group_pic']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('group/'.$_group['id'])?>" class="group-title"><?php echo $_group['group_name']; ?></a>
 <br><span class="group-count"><?php echo $_group['member_num']; ?> <?= $this->lang->line('groupexplore_members') ?><br><?php echo $_group['topic_num']; ?> <?= $this->lang->line('groupexplore_topics') ?></span>
</p>
 
<a class="group-follow" href="<?php echo site_url('group/index/'.$_group['id'])?>"><?= $this->lang->line('groupinvite_join') ?></a>
 </li>
<?php endforeach; ?>
 </ul></div>
 
</div>



</div>
<?php $this->load->view('footer') ?>