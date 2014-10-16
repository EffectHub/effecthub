<?php $this->load->view('header') ?>

<Iframe id="wikiframe" name="wikiframe" src="<?php echo base_url();?>wiki/doku.php" style="width:100%;height:100%" scrolling="no" width="100%" height = "100%" frameborder="0"></iframe> 
<script>
$(function(){
	$("#wikiframe").load(function(){
		var mainheight = $(this).contents().find("body").height();
		$(this).height(mainheight);
		}); 
});
</script>
<?php $this->load->view('footer') ?>