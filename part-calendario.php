
<script type="text/javascript">
	if(window.jQuery) {
		jQuery( document ).ready(function() {

			jQuery("ul.calendar li.day").find('.day-caption').mouseenter(function(){
				//jQuery(this).find('.author-ranking').show();
				//if(jQuery(this).find('.author-ranking').css('display') == 'none') {
					jQuery(this).parent().find('.author-ranking').css('display', "block");
				//}
				//console.log("mouseenter day caption");
			})
			jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
				//jQuery(this).hide();
				jQuery(this).css('display', "none");
				//console.log("saiu author ranking");
			})
			jQuery("ul.calendar li.day").mouseleave(function(){
				//jQuery(this).find('.author-ranking').show();
				jQuery(this).find('.author-ranking').css('display', "none");
			})
			jQuery(".author-ranking").each(function(i) {
				if(jQuery(this).find("ul").length) {
					//Gold
					jQuery(this).find("li:nth-child(1)").find(".aut_barra div").css('background-color', "#FFD700");
					//Silver
					jQuery(this).find("li:nth-child(2)").find(".aut_barra div").css('background-color', "#A8A8A8");
					//Bronze
					jQuery(this).find("li:nth-child(3)").find(".aut_barra div").css('background-color', "#965A38");
				}
				//jQuery.each(".aut_barra").css('background-color', "#964");
			});
			
		});
		
		
	}//if window.jQuery

</script>

	
<div class="content_nosidebar col-xs-12 col-sm-6" style="width: 104%;left: -2%;" >
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->
	<?php echo do_shortcode("[ranking-calendar]"); ?>
</div><!-- #content -->