			
			</div>
		</div> <!-- #wrapper #2D2D2D-->
		<br style="clear:both;" />
		&nbsp;
		<br />
		<?php do_action( 'bp_after_container' ) ?>

		

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer" class="row">
			<div id="footer-content" class="row">
					
					
					<!--div class="col-sm-3">
						<h3>Páginas</h3>
						<ul>
							<li><a href="<?php bloginfo('url'); ?>">Início</a></li>
							<?php if ( is_user_logged_in() ) { ?> 
								<li><a href="<?php bloginfo('url'); ?>/focar">Focar</a></li>
								<li><a href="<?php bloginfo('url'); ?>/colegas/<?php  $current_user = wp_get_current_user(); echo $current_user->display_name  ?>">Produtividade</a></li>
							<?php } ?>
							<li><a href="<?php bloginfo('url'); ?>/colegas">Amigos</a></li>
							<li><a href="<?php bloginfo('url'); ?>/mural">Mural</a></li>
							<li><a href="<?php bloginfo('url'); ?>/ranking">Ranking</a></li>
							<li><a href="<?php bloginfo('url'); ?>/calendar">Calendário</a></li>
						</ul>
						<?php //wp_list_pages("title_li=&include=8,3096,381,4814"); ?>
					</div-->
					
					<div class="col-sm-3 contem_last_pomodoros">
						<h3>Últimos pomodoros</h3>
						<?php /*#if(!is_user_logged_in()) { ?>
						<p class="bg-danger"><a href="#" class="abrir_login">Acesse sua conta</a> para ver pomodoros recentes</p>
						<?php } else {*/ ?>
							
							<?php 
							
							#$recent_posts = wp_get_recent_posts("numberposts=9&post_status=publish&post_type=projectimer_focus");
							$args = array( 'post_type' => 'projectimer_focus', 'posts_per_page' => 9, 'post_status' => 'publish' ); 
							$recent_posts = get_posts( $args );

							foreach( $recent_posts as $recent ){

								#echo '<li>'.get_avatar($recent->post_author, 24)."<a href='/colegas/".get_the_author_meta( "user_login", $recent->post_author )."'>".get_the_author_meta( 'display_name', $recent->post_author ).'</a> - <a href="' . get_permalink($recent->ID) . '" title="Look '.esc_attr($recent->post_title).'" >' . $recent->post_title.'</a> </li> '; #WITH NAME
								
								echo '<li>'.get_avatar($recent->post_author, 24).' <a href="' . get_permalink($recent->ID) . '" title="Look '.esc_attr($recent->post_title).'" >' . $recent->post_title.'</a> </li> '; #NO NAME
							}
							#set_shared_database_schema();
							if(function_exists('set_shared_database_schema'))
								set_shared_database_schema();
							 ?>
						<?php #} ?>
						
					</div>
					<!--div class="link-group">
						<h3>Telefones</h3>
						<ul>
							<li>Vendas</li>
							<li>+55 15 33333527.77777267</li>
							<li>Suporte</li>
							<li>+55 15 33333527.77777267</li>
						</ul>
					</div-->
				<div class="col-sm-3">
						<h3>Ranking Top 7</h3>
						<?php
						$instance = array(
							"title" => "",
							"count" => "7",
							"exclude_roles" => array("administrator"),#
							"include_post_types" => array("projectimer_focus"),
							"preset" => "custom",
							#"template" => "%gravatar_32% %firstname% %lastname% (%nrofposts%)",
							"template" => '<li><a href="/colegas/%username%">%gravatar_32%  %firstname% %lastname% (%nrofposts%) </a>  </li>',
							"before_list" => "<ul class='ta-preset2 ta-gravatar-list-count'>",
							"after_list" => "</ul>",
							"custom_id" => "",
							"archive_specific" => false); 
						the_widget("Top_Authors_Widget", $instance, "");
						?>
						<small>Não contabiliza pomodoros privados.</small>
						<?php
						/*global $reverter_filtro_de_categoria_pra_forcar_funcionamento;
						$reverter_filtro_de_categoria_pra_forcar_funcionamento = true;

						echo do_shortcode('[product id="4530"]');  

						//global $reverter_filtro_de_categoria_pra_forcar_funcionamento;
						$reverter_filtro_de_categoria_pra_forcar_funcionamento = false;
						//unset($reverter_filtro_de_categoria_pra_forcar_funcionamento);*/
						?>
					</div>
				<div class="col-sm-3">
						<h3>Nosso blog</h3>
						<?php 
						#global $type;
						#$type='notknow';
						#if(function_exists('force_database_aditional_tables_share'))
						#	force_database_aditional_tables_share(NULL);
						#echo do_shortcode( '[contact-form-7 id="1526" title="Contato"]' ); 
						#echo do_shortcode( '[contact-form-7 id="60" title="footer"]' ); 
						?>
					
						<?php 
						if(function_exists('set_shared_database_schema'))
							set_shared_database_schema();

						the_widget('WP_Widget_Recent_Posts', 'number=6');  
						#'before_title' => '<span class="hidden">','after_title' => '</span>',
						?>

							<?php #echo do_shortcode("[wp-rss-aggregator limit=5]");  ?>
						</div>
				<div id="footer-contact-form" class="col-sm-3">
					<h3>Fale conosco</h3>
					<?php if(!is_user_logged_in()) { ?>
						<p class="bg-danger"><a href="#" class="abrir_login">Acesse sua conta</a> para usar o formulário de contato</p>
					<?php } else { ?>
						
						<?php 
						#global $type;
						#$type='notknow';
						#if(function_exists('set_shared_database_schema'))
						#	set_shared_database_schema();
						#echo do_shortcode( ' [contact-form-7 id="4702" title="Testando SMTP"]' );
						echo do_shortcode( '[contact-form-7 id="1526" title="Contato"]' ); 
						#echo do_shortcode( '[contact-form-7 id="60" title="footer"]' ); 
						?>
					<?php } ?>
				</div>

				
				<!--div id="footer-info">
				    <p id="assinatura">Desenvolvido por F5 Sites <br /> <a href="http://www.f5sites.com">www.f5sites.com</a></p>
				    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>*/ ?>
				</div-->
				<?php do_action( 'bp_footer' ) ?>
			</div>
		
				<div  class="row">
					<div class="col-sm-6">
						<p>Developed by <a href="https://www.franciscomat.com">Francisco Mat</a>, Hosted by <a href="https://www.f5sites.com/pomodoros">F5 Sites</a>, Fork us <a href="https://github.com/franciscof5/sistema-focalizador-javascript">on GitHub</a></p>
					</div>
					<div class="col-sm-6">
						<p style="text-align: right;">Acompanhe o <a href="<?php bloginfo('url'); ?>/projeto/pomodoros-2">projeto Pomodoros</a> em tempo real</p>
					</div>
				</div>
				</div>
		
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
		font-size: 12px;
		font-weight: 600;
		overflow: hidden;
		white-space: nowrap;
		position: absolute;
		max-width: 80%;

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

	.ta-preset li a {
		max-width: 60% !important;
	}
	/*.top-authors-widget ul li:nth-child(odd) {*/
	.ta-preset li:nth-child(odd),.ta-preset2 li:nth-child(odd) {
		background: #CCC;
	}
	.ta-preset li:nth-child(even), .ta-preset2 li:nth-child(even) {
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
		padding: 0 2px;
		font-size: 14px;
		line-height: 34px;
		font-weight: bold;
		color: #666;
		width: 20px;
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
	
	//alert(primeiro);
	//jQuery( ".top-authors-widget").find( "li" ).each(function(i) {
	
	if(jQuery( ".ta-preset li").length) {
		primeiro = jQuery(".ta-preset li:nth-child(1)").text();
	//var matches = parseInt(regExp.exec());
	var matches = regExp.exec(primeiro);
	var primeiro = parseInt(matches[1]);
		jQuery( ".ta-preset li").each(function(i, b) {
			//alert(b);
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
			
			res = 80 + ((((qtddpomo/primeiro)/10)*2)*100);
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
	}
	

	///******************************GAMB****************FAST CLONE*/************

	primeiro2 = jQuery(".ta-preset2 li:nth-child(1)").text();
	//var matches = parseInt(regExp.exec());
	var matches2 = regExp.exec(primeiro2);
	var primeiro2 = parseInt(matches2[1]);
	jQuery( ".ta-preset2 li").each(function(i, b) {
		//alert(b);
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
		
		res = 80 + ((((qtddpomo/primeiro2)/10)*2)*100);
		//alert(res);
		jQuery( this ).width( (res) + "%" );
		//jQuery( this ).css('backgroundColor', "CCC");
		


		/*if(i>0) {
			jQuery( this ).before( '<span style="float: left;font-family: Lilita One, cursive;width: 30px;font-size: 20px;line-height: 30px;text-align: center;background: #009933;color: #FFF;border-radius: 50px;padding: 0;margin: 20px 10px;">'+i+"</span" );
		}*/
	});
	jQuery(".ta-preset2 li:nth-child(1)").css({
			"background":"#FFF379",
			"color": "#9B7529",
	});
	jQuery(".ta-preset2 li:nth-child(1) .pos").css({
		"color": "#9B7529",
		"font-size": "30px"
	});
	jQuery(".ta-preset2 li:nth-child(1) a").css("color", "#9B7529");


	jQuery(".ta-preset2 li:nth-child(2)").css({
			"background":"#98969B",
			"color": "#D0D8D7"
	});
	jQuery(".ta-preset2 li:nth-child(2) .pos").css({
		"color": "#D0D8D7",
		"font-size": "26px"
	});
	jQuery(".ta-preset2 li:nth-child(2) a").css("color", "#D0D8D7");


	jQuery(".ta-preset2 li:nth-child(3)").css({
			"background":"#F1AB66",
			"color": "#50352F"
	});
	jQuery(".ta-preset li:nth-child(3) .pos").css({
		"color": "#50352F",
		"font-size": "22px"
	});
	jQuery(".ta-preset2 li:nth-child(3) a").css("color", "#50352F");
			
	jQuery( ".abrir_login" ).click(function() {
		jQuery( "#loginlogbox" ).toggle("slow");
	});
	jQuery( "#settings_panel" ).click(function() {
		jQuery( "#settingsbox" ).toggle("slow");
	});
});		

</script>
<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
	
<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>
</body>
</html>