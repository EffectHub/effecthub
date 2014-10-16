
	<div class="remind" id="new-earn">
		<p><span style='font-size:16px;color:#bbb;'><?= $this->lang->line('pop_everyday_login'); ?></span> +1 <?= $this->lang->line('pop_coin'); ?></p>
	</div>

	<script>
		
		$(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
			
			var remind = $('#new-earn');
			remind.css('display','block');
			remind.animate({opacity:'1'},1500);
			remind.animate({opacity:'1'},3000);
			remind.animate({opacity:'0'},1500,function(){
				$('#new-earn').css('display','none');
			});
			
		});

		$(window).resize(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
		});

	</script>






