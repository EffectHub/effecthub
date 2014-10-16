<?php $this->load->view('header') ?>
    <script type="text/javascript">
var msg = '<?php echo $msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'invalid' : $('#emailError').css('display','inline');break;
			default : break;
		}
	}	
});
</script>     
       <div id='content' class='clearfix'>
       	   <div class='contentTitle'>
               <h5>
               Give your feedback
               </h5>
           </div>
           <div id='main' class='clearfix' style="background:#E7E7E7;">
               <div id='left' class='clearfix' style="background:#E7E7E7;">
                   
                   <div class="article">
	  
    <span class="wrap"><h3>STEP 1</h3></span>
    <div class="indent">Enter the e-mail address you used to create your EffectHub account.<br><br>
    We will locate your account information and send you an e-mail with a link to reset your password.<br><br>
    </div>
    <form id="signin_form" style="height:270px;font-size:14px" class="ims ajax" method="post" action="<?=site_url('api/feedback')?>" method="post">
						<div>
						<div><label>Name</label></div>
					    <div><input class="txt create_input" name="name" size="55"/></div>
					    
						<div><label>Email</label></div>
					    <div><input class="txt create_input" name="email" size="55"/></div>
					    
					    <div><label>Feedback</label></div>
					    <div><input class="txt create_input" name="comment" size="55"/></div>
					    
					    <input type="hidden" name="subscribe" value="true"/>
					    <input type="hidden" name="donate" value="false"/>
					    <input type="hidden" name="attend" value="false"/>
					    <input type="hidden" name="tool" value="dragonbones"/>
					    <input type="hidden" name="from" value="designpanel"/>
					        <br/>
					        <input type="submit" id="change_pwd_btn" class="btn" value="Submit">
					    </div>
					</form>

	</div>
                  
               </div>
               <div id='right' class='clearfix'>
                   <div id='main-search' class='clearfix'>
                       <div id='main-search-box' class='clearfix'>
                           <input type="text" id='particle_search_field' name="search" onblur="if (this.value == '') {this.value = 'Search...';}" onfocus="if (this.value == 'Search...') {this.value = '';}" value="Search..." x-webkit-speech="" speech="">
                       </div>
                    </div>
                   <div id='tagheader' class='clearfix'>
                       <p id='tagtitle'>
                       Explore Works
                       </p>
                   </div>
                   <div class='generalsectionone'>
                         <?php foreach($hot_item_list as $_hot_item): ?>
                        <div class="iconimg">
                                 <a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>"><img style="width:90px;height:72px" src="<?php echo $_hot_item['thumb_url']==null?$_hot_item['pic_url']:$_hot_item['thumb_url']; ?>"></a>
                        </div>
                    <?php endforeach; ?>
                    </div>
               </div>
           </div>
       </div>
<?php $this->load->view('footer') ?>