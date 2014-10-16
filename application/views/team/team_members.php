<?php $this->load->view('header') ?>
<div id="content" class="group">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>

<div class="full">
	<div class="profile vcard group">
		<img alt="<?php echo $team['team_name']; ?>" class="photo" src="<?php echo $team['pic_url']; ?>">
		<h1><?= $this->lang->line('team_team'); ?> <?php echo $team['team_name']; ?></h1>
	</div>
</div>

<div id="main">
		
	<div class="cates-list-info">
		<h3><?= $this->lang->line('teammember_members'); ?> (<?= $team['people_num']?>)</h3>
	</div>
		
	<div class="hotest">
	<?php foreach($members as $_user): ?>
		<div class="hot-group">
			<a href="<?= site_url('user/'.$_user['member_id'])?>" title="<?= $_user['displayName']?>"><img src="<?= $_user['pic_url']?>"/></a>
			<a class="hot-group-title" href="<?= site_url('user/'.$_user['member_id'])?>" title="<?= $_user['displayName']?>"><?= $_user['displayName']?></a>
			<?php if ($_user['position'] != 99) { ?>
			<p class="member-position" title="<?= $this->lang->line('teammember_position'.$_user['position']) ?>" name="<?= $_user['position'] ?>"><?= $this->lang->line('teammember_position'.$_user['position']) ?></p>	
			<?php } else { ?>
			<p class="member-position" title="<?= $_user['position_name'] ?>" name="<?= $_user['position'] ?>"><?= $_user['position_name'] ?></p>	
			<?php }  ?>
			
			<?php if ($this->session->userdata('id')&&($this->session->userdata('id')==$team['leader_id'])&&($_user['member_id']!=$team['leader_id'])) { ?>
			<div class="member-edit" name="<?= $_user['member_id'] ?>">
				<a href="javascript:;" class="team-edit" name="<?= $_user['displayName'] ?>"><?= $this->lang->line('teammember_edit'); ?></a>
				<a name="<?= $_user['position'] ?>" href="<?= site_url('team/delete_member/'.$_user['member_id'].'/'.$team['team_id'].'/'.$this->uri->segment(4)); ?>" class="team-delete" onclick="return confirm('<?= $_user['displayName'].$this->lang->line('teammember_delete_confirm') ?>')"><?= $this->lang->line('teammember_delete'); ?></a>
			</div>
			
			<?php } ?>
		</div>
	<?php endforeach;?>
	</div>		
	
	<div class="page" style="clear:both;">
		<?php echo $this->pagination->create_links();?>
	</div>
	
</div>


<div class="secondary">

	<p><?= $this->lang->line('teammember_leader') ?><a href="<?= site_url('user/'.$team['leader_id']); ?>" title="<?= $team['leader_name'] ?>"><?= $team['leader_name'] ?></a></p>
	<br/><br/>
	<a href="<?= site_url('team/'.$team['team_id']) ?>"><?= $this->lang->line('teamcomments_back'); ?></a>


</div>

<?php if ($this->session->userdata('id')&&($this->session->userdata('id')==$team['leader_id'])) { ?>

<script>
	$('.team-edit').live('click',function(){

		var p = $(this).parent('.member-edit').prev('.member-position').attr('name');
		
		$('.team-member-edit').css('display','block');
		$('p.edit-name').html($(this).attr('name'));
		$('.team-member-edit').attr('name',$(this).parent().attr('name'));

		if (p == 99) {
			$('input#position').val($(this).parent('.member-edit').prev('.member-position').html());
			$('.input-position').css('visibility','visible');
		}

		$("#edit-position option[value='"+ p + "']").attr('selected','selected');
		
	});
	
	$('.ok').live('click',function(){
		if (($('#edit-position').val()==99)&&($.trim($('#position').val())=='')) {
			alert('<?= $this->lang->line('teammember_input_error') ?>');
			return;
		}

		
		$.post(
			"<?= site_url('team/edit_member') ?>",
			{
				member: $('.team-member-edit').attr('name'),
				position: $('#edit-position').val(),
				position_name: $('#position').val()
			},
			function(data,status){
				if (data == 'fail') {
					location.href="<?= site_url('login'); ?>";
				} else if (data=='success'){
					location.href="<?= site_url('team/members/'.$this->session->userdata('team_id').'/'.$this->uri->segment(4)); ?>";
				} else {
					$('.team-member-edit').css('display','none');
				}
			}
		);
		
	});

	$('.cancel').live('click',function(){
		$('.input-position').css('visibility','hidden');
		$('.team-member-edit').css('display','none');
	});

	$('.edit-position').live('change',function(){
		if ($('#edit-position').val()==99) {
			$('.input-position').css('visibility','visible');	
		} else {
			$('.input-position').css('visibility','hidden');	
		}
	});
	
</script>

<div class="team-member-edit"> 
	<p class="edit-name" name=""></p>
	<div class="edit-position">
		<label class="edit-position"><?= $this->lang->line('teammember_edit_position'); ?></label>
		<select class="edit-position" id="edit-position" name="">
			<option value="0"><?= $this->lang->line('teammember_position0') ?></option>
			<option value="2"><?= $this->lang->line('teammember_position2') ?></option>
			<option value="3"><?= $this->lang->line('teammember_position3') ?></option>
			<option value="4"><?= $this->lang->line('teammember_position4') ?></option>
			<option value="5"><?= $this->lang->line('teammember_position5') ?></option>
			<option value="6"><?= $this->lang->line('teammember_position6') ?></option>
			<option value="7"><?= $this->lang->line('teammember_position7') ?></option>
			<option value="8"><?= $this->lang->line('teammember_position8') ?></option>
			<option value="99"><?= $this->lang->line('teammember_position99') ?></option>
		</select>
	</div>
	<div class="input-position">
		<label><?= $this->lang->line('teammember_input_position') ?></label>
		<input type="text" class="signin_input txt" id="position" name="position" value="">
	</div>
	<div class="position-button">
		<a class="ok" href="javascript:;"><?= $this->lang->line('teammember_ok') ?></a>
		<a class="cancel" href="javascript:;"><?= $this->lang->line('teammember_cancel') ?></a>
	</div>
</div>



<?php } ?>
</div>
<?php $this->load->view('footer') ?>
