<?php/
*Template Name: Ranking*/
?>
<?php get_header() ?>

<?php get_sidebar(); ?>

<style type="text/css">
	#authors ul li {
		height: 68px;
		border: 1px solid #CCC;
		border-radius: 10px;
		margin: 0 0 5px 0;
	}
	#authors ul li:nth-child(1) { border: 0;}
	/*#authors ul li div {
		float: left;
	}*/
	#authors ul li img {
		border-radius: 10px;
	}
	#authors ul li div:nth-child(2) {
		margin: -22px 0 0 80px;
	}
	#authors ul li h3 {
		margin-top: 30px;
		width: 80%;
		white-space: nowrap;
		overflow: hidden;
	}

	#authors ul li:nth-child(even) {
		background: #EEE;
	}
	#authors ul li span {
		float: right;
		font-size: 22px;
		margin: 15px;
		color: #006633;
		font-family: "Lilita One", cursive;
	}
</style>
<script type="text/javascript">

jQuery( document ).ready(function() {
	largura = 800;
	primeiro = jQuery("li:nth-child(2)").find('span').text();
	jQuery( "li" ).each(function(i) {
		/*alert( jQuery(this).find('span').text() );
		jQuery( this ).width( jQuery(this).find('span').text() );/
		*/
		qtddpomo = parseInt(jQuery(this).find('span').text());
		//res = 25 + ((((qtddpomo/primeiro)/4)*3)*100);
		//res = 50 + ((((qtddpomo/primeiro)/2)*1)*100);
		res = 40 + ((((qtddpomo/primeiro)/10)*6)*100);
		jQuery( this ).width( (res) + "%" );
		jQuery( this ).css('backgroundColor', "CCC");
		/*if(i>0) {
			jQuery( this ).before( '<span style="float: left;font-family: Lilita One, cursive;width: 30px;font-size: 20px;line-height: 30px;text-align: center;background: #009933;color: #FFF;border-radius: 50px;padding: 0;margin: 20px 10px;">'+i+"</span" );
		}*/
	});
});
</script>

<div id="content">

    <div class="padder">
<?php
#echo do_shortcode('[widgets_on_pages id="authors"]');
?>
<h3>Ranking under maintence</h3>
<p>Check out top 25 on sidebar</p>
</div>
</div><!-- #content -->
	
<?php get_footer() ?>