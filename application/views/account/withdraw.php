<?php $this->load->view('header') ?>
<div id="content" class="group">
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<style type="text/css">
table.dataintable {
margin-top: 10px;
border-collapse: collapse;
border: 1px solid #aaa;
width: 100%;
}
table.browsersupport th {
padding: 3px;
height: 15px;
vertical-align: middle;
text-align: center;
background-color: #efefef;
border: 1px solid #c3c3c3;
}
table.dataintable td {
vertical-align: text-top;
padding: 5px 15px 5px 5px;
background-color: #fff;
border: 1px solid #aaa;
}
table.browsersupport {
margin-top: 15px;
border-collapse: collapse;
width: 100%;
}
table{
	color:#333;
}
</style>
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div class="group">
	<div class="full">
		<h1 class="alt"><?= $this->lang->line('recharge_title'); ?><span class="sep"></span></h1>
		<p><?= $this->lang->line('recharge_slogan'); ?></p>
	</div>
</div>



<div id="main">

<div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li><a href="<?=site_url('account/payment')?>"><?= $this->lang->line('recharge_nav'); ?></a></li>
	<li><a href="<?=site_url('account/payment/withdraw')?>" class="selected"><?= $this->lang->line('withdraw_nav'); ?></a></li>
	<li><a href="<?=site_url('account/payment/downloaded')?>"><?= $this->lang->line('download_nav'); ?></a></li>
</ul>
</div>

<div class="session-form alt" id="social" style="color:#000">
<h3><?= $this->lang->line('withdraw_step1'); ?></h3>
<div style="padding:10px">
<p class="callout">
<?= $this->lang->line('withdraw_account_condition'); ?>  <br/><br/>
<?= $this->lang->line('withdraw_account_handing'); ?>  <br/><br/>
<?= $this->lang->line('withdraw_account_current'); ?> 
<?php echo $user['balance']==0&&$user['balance_usd']==0?'0':'' ?>
<?php echo $user['balance']>0?'￥'.round($user['balance'],2):'' ?> 
<?php echo $user['balance_usd']>0?'$'.round($user['balance_usd'],2):'' ?> 
</p>
</div>
<br/>
<h3><?= $this->lang->line('withdraw_step2'); ?></h3>

<div style="padding:10px">
<p class="callout"><?= $this->lang->line('withdraw_account_notice'); ?></p>
<form accept-charset="UTF-8" action="<?=site_url('account/payment/withdrawRequest')?>" class="gen-form with-messages" id="signin_form" method="post">	
<div class="form-field">
<fieldset class="user_name"><label for="recharge_name" style="width:110px"><?= $this->lang->line('recharge_account_name'); ?></label><input id="withdraw_name" name="withdraw_name" value="" size="30" type="text"></fieldset>
<p class="message" id="namemsg" style="display:none;font-size:12px;border-radius:3px;width:57%;padding:5px;color:#e00;font-weight:bold;"><?= $this->lang->line('recharge_error'); ?></p>
</div>

<fieldset id="set_password">
			<div class="form-field">
				<label for="recharge_email" style="width:110px"><?= $this->lang->line('recharge_account_email'); ?></label>
				<input autocapitalize="off" autocorrect="off" id="withdraw_email" label="Username" value="" name="withdraw_email" size="30" type="text">
			</div>
			<p class="message" id="emailmsg" style="display:none;font-size:12px;border-radius:3px;width:57%;padding:5px;color:#e00;font-weight:bold;"><?= $this->lang->line('recharge_error'); ?></p>
			<div class="form-field">
				<fieldset class="user_email"><label for="recharge_amount" style="width:110px"><?= $this->lang->line('withdraw_account_money'); ?></label><input id="withdraw_amount" label="Email" name="withdraw_amount" size="30" type="text" value=""></fieldset>	
				<p class="message" id="amountmsg" style="display:none;font-size:12px;border-radius:3px;width:57%;padding:5px;color:#e00;font-weight:bold;"><?= $this->lang->line('recharge_error'); ?></p>		
			</div>
</fieldset>
			<div class="form-btns" style="margin-bottom:20px;">
				<a href="javascript:" id="submit_withdraw" class="form-sub" name="commit"><?= $this->lang->line('withdraw_account_btn'); ?></a>
			</div>
			
</form>
</div>

<h3><?= $this->lang->line('withdraw_record'); ?></h3>
<div style="padding:10px">
<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th><?= $this->lang->line('recharge_account_name'); ?></th>
	      <th><?= $this->lang->line('recharge_account_email'); ?></th>
	      <th><?= $this->lang->line('withdraw_account_money'); ?></th>
	      <th><?= $this->lang->line('recharge_account_time'); ?></th>
	      <th><?= $this->lang->line('recharge_account_status'); ?></th>
	  </tr>
	  <?php foreach($withdraw_list as $_withdraw): ?>
	  <tr>
	      <td><?php echo $_withdraw['withdraw_name'] ?></td>						
	      <td><?php echo $_withdraw['withdraw_email'] ?></td>
	      <td><?php echo $_withdraw['withdraw_amount'] ?></td>
	      <td><?php echo $_withdraw['withdraw_time'] ?></td>				
	      <td>
	      <?php 
	      if($_withdraw['status']=='1')echo $this->lang->line('recharge_status1');
	       if($_withdraw['status']=='2')echo $this->lang->line('recharge_status2');
	        if($_withdraw['status']=='3')echo $this->lang->line('recharge_status3');
	      	?></td>			
	  </tr>
	  <?php endforeach; ?>
	</tbody></table>
	</p></div>
	</div>


</div>

</div>

<div class="secondary">
	<h3><?= $this->lang->line('recharge_exchange_coin'); ?></h3>

	<div id="avatar-preview" class="group">
		<form accept-charset="UTF-8" action="<?=site_url('account/payment/coin')?>" class="gen-form" enctype="multipart/form-data" id="avatar-form" method="post">
			<fieldset id="upload">
				<input type="text" style="background:rgba(255,255,255,1)" value="" name="coincount" id="coincount"> <?= $this->lang->line('recharge_coins'); ?> 
						<br/>
						<input type="hidden" name="userid" value="<?php echo $this->session->userdata('id') ?>" />
				<p class="info">
				<?php echo $user['balance']!=0||$user['balance_usd']!=0?''.$this->lang->line('withdraw_account_current'):'' ?>
		 <?php echo $user['balance']>0?'￥'.round($user['balance'],2):'' ?><?php echo $user['balance_usd']>0?' $'.round($user['balance_usd'],2):'' ?>
		 <?php echo $user['balance']!=0||$user['balance_usd']!=0?'':'' ?>
		 <br/>
				
				<?= $this->lang->line('recharge_canbuy'); ?> <img src="<?= base_url('images/icon-coin.png') ?>" height="15px" width="15px" />&nbsp&nbsp<?php echo ($user['balance']*10+$user['balance_usd']*6*10)>1?($user['balance']*10+$user['balance_usd']*6*10):'0'; ?>
				
				</p>
			</fieldset>

			<div id="add-btn">
				<input class="form-sub" name="commit" type="submit" value="<?= $this->lang->line('recharge_exchange_btn'); ?>">
			</div>
</form>	</div>
<?php if ($lang==2){  ?>
	<h3>充值客服</h3>
	<a target=blank 
href="tencent://message/?uin=176051557&Site=qq&Menu=yes"><img border="0" 
src="http://wpa.qq.com/pa?p=1:176051557:1" alt="充值客服" /></a>		
<?php } ?>
</div>


</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>
<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	$('#submit_withdraw').click(function(){
		var valid = true;
		if($('#withdraw_name').attr('value')==''){
			$('#namemsg').css('display','inline');
			valid = false;
		}else{
			$('#namemsg').css('display','none');
		}
		if($('#withdraw_email').attr('value')==''){
			$('#emailmsg').css('display','inline');
			valid = false;
		}else{
			$('#emailmsg').css('display','none');
		}
		if($('#withdraw_amount').attr('value')==''){
			$('#amountmsg').css('display','inline');
			valid = false;
		}else{
			$('#amountmsg').css('display','none');
		}
		if(valid)$('#signin_form').submit();
	});
});
</script>

<?php $first = get_cookie('first_login');
	if (isset($first)&&($first!= null)&&($first == 1)) {

		$this->load->view('first_login');
	
 		$cookie = array(
			'name'   => 'first_login',
			'value'  => 0,
			'expire' => '5',
		);

		set_cookie($cookie);
	
	 }?>


<?php $this->load->view('footer') ?>
