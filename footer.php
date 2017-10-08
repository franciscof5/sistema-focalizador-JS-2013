			
			</div>
		</div> <!-- #wrapper #2D2D2D-->
		<br style="clear:both;" />
		&nbsp;
		<br />
		<?php do_action( 'bp_after_container' ) ?>

		

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer" class="row">
			<div id="footer-content" class="row">

				
					<div class="col-sm-3">
						<h3>Nossos blog</h3>
						
						<?php the_widget('WP_Widget_Recent_Posts', 'number=10');  
						#'before_title' => '<span class="hidden">','after_title' => '</span>',
						?>

							<?php #echo do_shortcode("[wp-rss-aggregator limit=5]");  ?>
						</div>
					<div class="col-sm-3">
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
					</div>
					
					<div class="col-sm-3 contem_last_pomodoros">
						<h3>Últimos pomodoros</h3>
						<?php if(!is_user_logged_in()) { ?>
						<p class="bg-danger"><a href="#" class="abrir_login">Acesse sua conta</a> para ver pomodoros recentes</p>
						<?php } else { ?>
							
							<?php 
							
							#$recent_posts = wp_get_recent_posts("numberposts=9&post_status=publish&post_type=projectimer_focus");
							$args = array( 'post_type' => 'projectimer_focus', 'posts_per_page' => 3, 'post_status' => 'publish' ); 
							$recent_posts = get_posts( $args );

							foreach( $recent_posts as $recent ){

								#echo '<li>'.get_avatar($recent->post_author, 24)."<a href='/colegas/".get_the_author_meta( "user_login", $recent->post_author )."'>".get_the_author_meta( 'display_name', $recent->post_author ).'</a> - <a href="' . get_permalink($recent->ID) . '" title="Look '.esc_attr($recent->post_title).'" >' . $recent->post_title.'</a> </li> '; #WITH NAME
								
								echo '<li>'.get_avatar($recent->post_author, 24).' : <a href="' . get_permalink($recent->ID) . '" title="Look '.esc_attr($recent->post_title).'" >' . $recent->post_title.'</a> </li> '; #NO NAME
							} ?>
						<?php } ?>
						
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
				
				<div id="footer-contact-form" class="col-sm-3">
					<h3>Fale conosco</h3>
					<?php if(!is_user_logged_in()) { ?>
						<p class="bg-danger"><a href="#" class="abrir_login">Acesse sua conta</a> para usar o formulário de contato</p>
					<?php } else { ?>
						
						<?php echo do_shortcode( '[contact-form-7 id="60" title="footer"]' ); ?>
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
		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>
		<script type="text/javascript">
			jQuery( ".abrir_login" ).click(function() {
				jQuery( "#loginlogbox" ).toggle("slow");
			});
			jQuery( "#settings_panel" ).click(function() {
				jQuery( "#settingsbox" ).toggle("slow");
			});
			
		</script>
<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
	</body>

</html>