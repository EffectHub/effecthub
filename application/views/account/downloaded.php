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
		<h1 class="alt"><?= $this->lang->line('recharge_title'); ?><span class="sep">
		</span></h1>
		 <p><?= $this->lang->line('recharge_slogan'); ?></p>
	</div>
</div>



<div id="main">

<div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li><a href="<?=site_url('account/payment')?>" ><?= $this->lang->line('recharge_nav'); ?></a></li>
	<li><a href="<?=site_url('account/payment/withdraw')?>"><?= $this->lang->line('withdraw_nav'); ?></a></li>
	<li><a href="<?=site_url('account/payment/downloaded')?>" class="selected"><?= $this->lang->line('download_nav'); ?></a></li>
</ul>
</div>

<div class="session-form alt" id="social" style="color:#000">
<h3><?= $this->lang->line('download_record'); ?></h3>
<div style="padding:10px">
<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th style="width:50%;max-width:400px"><?= $this->lang->line('download_item_name'); ?></th>
	      <th><?= $this->lang->line('download_item_price'); ?></th>
	      <th><?= $this->lang->line('download_time'); ?></th>
	      <th><?= $this->lang->line('download_again'); ?></th>
	  </tr>
	  <?php foreach($download_list as $_download): ?>
	  <tr>
	      <td style="width:50%;max-width:300px;overflow:hidden"><a target="_blank" href="<?php echo site_url('item/'.$_download['item_id'])?>">
	      <img width="100px" src="<?php echo $_download['item_pic'] ?>"/><br/>
	      <?php echo $_download['item_name'] ?></a></td>						
	      <td><?php echo $_download['price_type']!=null?$_download['price_type']:$this->lang->line('download_coin') ?> <?php echo $_download['price']!=null?$_download['price']:'0' ?> </td>
	      <td><?php echo $_download['timestamp'] ?></td>				
	      <td>
	      <a target="_blank" href="<?php echo $_download['download_url'] ?>"><?= $this->lang->line('download_again'); ?></a>
	      </td>			
	  </tr>
	  <?php endforeach; ?>
	</tbody></table>
	</p></div>
	
<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>
<br/>
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
	$('#submit_recharge').click(function(){
		var valid = true;
		if($('#recharge_name').attr('value')==''){
			$('#namemsg').css('display','inline');
			valid = false;
		}else{
			$('#namemsg').css('display','none');
		}
		if($('#recharge_email').attr('value')==''){
			$('#emailmsg').css('display','inline');
			valid = false;
		}else{
			$('#emailmsg').css('display','none');
		}
		if($('#recharge_amount').attr('value')==''){
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
