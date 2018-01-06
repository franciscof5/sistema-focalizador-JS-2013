<?php
/*Template Name: Ranking*/
?>
<?php get_header() ?>

<?php #get_sidebar(); ?>

<style type="text/css">
	.top-authors-widget ul li {
		height: 34px;
		line-height: 34px;
		border: 1px solid #CCC;
		border-radius: 10px;
		margin: 0 0 5px 0;
	}
	.top-authors-widget ul li a {
		color: #666;
		font-size: 16px;
		font-weight: 600;
		overflow: hidden;
		white-space: nowrap;
		position: absolute;

	}
	.top-authors-widget ul li:nth-child(1) { border: 0;}
	/*.top-authors-widget ul li div {
		float: left;
	}*/
	.top-authors-widget ul li img {
		border-radius: 10px;
		margin-right: 10px;
	}
	.top-authors-widget ul li div:nth-child(2) {
		/*margin: -22px 0 0 80px;*/
	}
	.top-authors-widget ul li h3 {
		margin-top: 30px;
		width: 80%;
		white-space: nowrap;
		overflow: hidden;
	}

	/*.top-authors-widget ul li:nth-child(odd) {*/
	.ta-preset li:nth-child(odd) {
		background: #CCC;
	}
	.ta-preset li:nth-child(even) {
		background: #EBEBEB;
	}
	/*.top-authors-widget ul li span {
		float: right;
		font-size: 22px;
		margin: 15px;
		color: #006633;
		font-family: "Lilita One", cursive;
	}*/
	.pos {
		float: left;
		margin: 0;
		padding: 0 10px;
		font-size: 14px;
		line-height: 34px;
		font-weight: bold;
		color: #666;
		width: 50px;
		text-align: center;
	}
	/*.first {
		background: #983;
	}*/
</style>
<script type="text/javascript">

jQuery( document ).ready(function() {
	largura = 800;
	//primeiro = jQuery("li:nth-child(2)").find('span').text();
	var regExp = /\(([^)]+)\)/;
	primeiro = jQuery(".ta-preset li:nth-child(1)").text();
	//var matches = parseInt(regExp.exec());
	var matches = regExp.exec(primeiro);
	var primeiro = parseInt(matches[1]);
	//alert(primeiro);
	//jQuery( ".top-authors-widget").find( "li" ).each(function(i) {
		
	jQuery( ".ta-preset li").each(function(i) {
	//jQuery( "li" ).each(function(i) {
		/*alert( jQuery(this).find('span').text() );
		jQuery( this ).width( jQuery(this).find('span').text() );/
		*/
		//alert(i);

		jQuery(this).prepend("<span class=pos>"+(i+1)+"</span>");
		qtddpomo_parentisis = (jQuery(this).text());
		//alert(qtddpomo_parentisis);
		//var patt = /\((\d)\)/;
		
		//var qtddpomo = qtddpomo_parentisis.match(patt)[0].replace("(", "").replace(")","");
		
		
		
		var matches = regExp.exec(qtddpomo_parentisis);

		//matches[1] contains the value between the parentheses
		//console.log(matches[1]);

		qtddpomo= parseInt(matches[1]);
		//res = 25 + ((((qtddpomo/primeiro)/4)*3)*100);
		//res = 50 + ((((qtddpomo/primeiro)/2)*1)*100);
		
		res = 40 + ((((qtddpomo/primeiro)/10)*6)*100);
		//alert(res);
		jQuery( this ).width( (res) + "%" );
		//jQuery( this ).css('backgroundColor', "CCC");
		


		/*if(i>0) {
			jQuery( this ).before( '<span style="float: left;font-family: Lilita One, cursive;width: 30px;font-size: 20px;line-height: 30px;text-align: center;background: #009933;color: #FFF;border-radius: 50px;padding: 0;margin: 20px 10px;">'+i+"</span" );
		}*/
	});
	jQuery(".ta-preset li:nth-child(1)").css({
			"background":"#FFF379",
			"color": "#9B7529",
	});
	jQuery(".ta-preset li:nth-child(1) .pos").css({
		"color": "#9B7529",
		"font-size": "30px"
	});
	jQuery(".ta-preset li:nth-child(1) a").css("color", "#9B7529");


	jQuery(".ta-preset li:nth-child(2)").css({
			"background":"#98969B",
			"color": "#D0D8D7"
	});
	jQuery(".ta-preset li:nth-child(2) .pos").css({
		"color": "#D0D8D7",
		"font-size": "26px"
	});
	jQuery(".ta-preset li:nth-child(2) a").css("color", "#D0D8D7");


	jQuery(".ta-preset li:nth-child(3)").css({
			"background":"#F1AB66",
			"color": "#50352F"
	});
	jQuery(".ta-preset li:nth-child(3) .pos").css({
		"color": "#50352F",
		"font-size": "22px"
	});
	jQuery(".ta-preset li:nth-child(3) a").css("color", "#50352F");

});
</script>

<div class="content_nosidebar col-xs-12 col-sm-6" style="width: 104%;left: -2%;" >
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->
	<?php if (is_user_logged_in()) { ?>
	<?php 
	dynamic_sidebar( 'ranking' );
	get_currentuserinfo();
	#var_dump(do_shortcode('[widgets_on_pages id="authors"]')); 
	#the_widget("Top_Authors_Widget");
	#echo "<hr />";
	echo "Ranking gerado em: ".get_the_time('j \d\e F \d\e Y').", via www.pomodoros.com.br/ranking. Usuário: ".$current_user->display_name.", ".$current_user->user_email;
	?>
	<?php } else { ?>
		<h3  style="margin:50px;">Acesso restrito</h3>
		<p class="bg-danger" style="margin:50px; font-size: 14px; padding:20px;"><a href="#" class="abrir_login">Acesse sua conta</a> para ver o ranking</p>
	<?php } #<br style="clear: both;"> ?>
</div><!-- #content -->




</div><!-- #content -->
	
<?php get_footer() ?>