<?php
/*Template Name: Calendar*/
?>
<?php get_header() ?>
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
		
		/*jQuery("ul.calendar li.day").find('.day-header').mouseover(function(){
			jQuery(this).next().css('display', "block");
		})
		jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
			jQuery(this).css('display', "none");
		})
		jQuery("ul.calendar li.day").find('.author-ranking').focusout(function(){
			jQuery(this).css('display', "none");
		})
		jQuery("ul.calendar li.day").find('.day-header').mouseleave(function(){
			jQuery(this).find('.author-ranking').css('display', "none");
		})

		jQuery("ul.calendar li.day").find('.day-footer').mouseenter(function(){
			jQuery(this).parent().find('.author-ranking').css('display', "none");
		})
		*/
		/*todo: paiting the 3 firts bars colors to GOLD SILVER and BRONZE*/
		/*jQuery("ul.calendar li.day .author-ranking ul").each(function(i) {
			/*jQuery("li").each(function(i) { });*/
			/*console.log("ul:".i);
			jQuery("li").each(function(i) {
				console.log("li:".i);
			});*/
		//});
		/* For the effect of hide and show the ranking when mouses passes over day header */
		
		/*console.log("MAIOR GAMBIARRA PARA ESCONDER MESES");
		/*jQuery(".calendar-container").each(function(i) {
			console.log(";"+i);
			if(i>0) {
				jQuery(this).css("display", "none");
				jQuery(this).next().css("display", "none");
			}
		})jQuery('#tipo_calendario').change(function() {
		if($(this).val()==0) {
			window.location 
		} else {
			window.location += "?post_author="+$(this).val();
		}
	});
	*/
	}//if window.jQuery

</script>
<?php
#var_dump(get_bloginfo("stylesheet_directory")."/css/calendar.css");
#var_dump(wp_enqueue_style( "$page-css", get_template_directory_uri() . '/css/calendar.css' ));
#var_dump(wp_enqueue_style("$page-css", get_bloginfo("stylesheet_directory")."/css/$page.css", __FILE__));die;
?>
<div class="content_nosidebar" style="width: 104%;left: -2%;">
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->
	<?php
	echo do_shortcode("[ranking-calendar]");
	//echo do_shortcode("{events_calendar}");
	?>
</div><!-- #content -->

<?php get_footer() ?>