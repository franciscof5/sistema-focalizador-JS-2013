			
			</div>
		</div> <!-- #wrapper #2D2D2D-->
		<div class="row">
		<div class="push"></div>
		<?php do_action( 'bp_after_container' ) ?>

		

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer">
			<div id="footer-content">
				<?php if (is_user_logged_in()) { ?><?php } ?>
				
				<div class="links">
					<div class="link-group">
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
					<!--div class="link-group">
						<h3>Blog</h3>
						<?php  ?>
					</div-->
					<div class="link-group">
						<h3>Últimos pomodoros</h3>
						<?php $recent_posts = wp_get_recent_posts("numberposts=6&post_status=publish");
						foreach( $recent_posts as $recent ){
							echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
						} ?>
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
				</div>
				<div id="footer-contact-form">
					<h3>Fale conosco</h3>
					<?php echo do_shortcode( '[contact-form-7 id="60" title="footer"]' ); ?>
				</div>
				<div style="clear:both; width:100%">
					<p style="float:left;">Desenvolvido por <a href="<?php bloginfo('url'); ?>/colegas/francisco/">Francisco Matelli</a> | F5 Sites | <a href="http://www.f5sites.com">www.f5sites.com</a></p>
					<p style="float:right;">Acompanhe o <a href="<?php bloginfo('url'); ?>/projeto/pomodoros-2">projeto Pomodoros</a> em tempo real</p>
				</div>
				<!--div id="footer-info">
				    <p id="assinatura">Desenvolvido por F5 Sites <br /> <a href="http://www.f5sites.com">www.f5sites.com</a></p>
				    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>*/ ?>
				</div-->
				<?php do_action( 'bp_footer' ) ?>
			</div>
		</div>

		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>
<a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a>
	</body>

</html>