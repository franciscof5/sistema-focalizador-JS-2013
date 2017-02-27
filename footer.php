		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ) ?>

		<div class="clear"></div>

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer">
			<?php if (is_user_logged_in()) { ?>
				<div id="footer-contact-form">
				    <?php /*echo do_shortcode( '[contact-form-7 id="60" title="footer"]' );*/ ?>
				</div>
			<?php } ?>
			<div id="footer-info">
			    <p id="assinatura">
			    Developed by <a href="http://www.franciscomat.com">Francisco Mat</a> 
			    <br /> 
			    Hosted by <a href="http://www.f5sites.com">F5 Sites</a>
			    <br />
			    Maitaned by <a href="http://www.grupof.com">GrupoF</a>
			    <br />
			    Visit our <a href="http://www.grupof.com/pomodoros.com.br">Blog</a>
			    </p>
			    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>*/ ?>
			</div>
		<?php do_action( 'bp_footer' ) ?>
		</div>

		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>

	</body>

</html>