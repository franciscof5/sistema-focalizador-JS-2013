<?php get_header() ?>

	<div id="content" class="content_default  col-xs-12 col-sm-9">
	
		<div class="padder">
		<?php if(is_home()) { ?>
			<div id="blog-welcome">
			<h3 style="font-family: Forte;">Blog do pomodoros</h3>
			
			<p>Novidades e histórico do projeto, no ar desde 2010.</p>
			
			<?php if(is_user_logged_in()) { ?>
				<?php $current_user = wp_get_current_user(); ?>
				<?php 
				/*$recent = get_posts(array(
				    'author'=>$current_user->ID,
				    'post_type'=>'projectimer_focus',
				    'post_statys' => 'draft',
				    #'orderby'=>'date',
				    #'order'=>'desc',
				    'numberposts'=>1
				));*/
				$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),
		              //'orderby'   => 'title',
		              //'order'     => 'ASC',
		              'posts_per_page' => 1,
		            );
				$recent = get_posts($args); #new WP_Query( $args );
				#var_dump($post);die;
				if( $recent ){
				  $title = ", sua tarefa mais recente é <i>".get_the_title($recent[0]->ID)."</i>";
				}else{
				  $title = ", você ainda não começou nenhuma tarefa"; //No published posts
				} ?>
				<p>Olá <?php echo $current_user->display_name.$title; ?>, <a href="/focar">acessar aplicativo online e focar</a>.</p>
			<?php } else { ?>
				<p>Caro visitante, <a href="/register">crie sua conta grátis para acessar o aplicativo online. </a></p>
				<p>Se já possui um usuário, <a id="testes" href="#" class="abrir_login">acesse sua conta</a></p>
			<?php } ?>
			</div>
			<hr />
		<?php } ?>
		
		<?php do_action( 'bp_before_blog_home' ) ?>

		<div class="page" id="blog-latest">

			<?php if ( have_posts() ) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ) ?>

					<div class="post" id="post-<?php the_ID(); ?>">

						<div class="author-box">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
							<p><?php 
							#printf( __( 'Por %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) )
							printf( bp_core_get_userlink( $post->post_author ) ) 
							?></p>
						</div>

						<div class="post-content">
							<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<p class="date"><?php the_time("j \d\\e F \d\\e Y") ?> <em><?php #_e( 'em', 'buddypress' ) ?> <?php #the_category(', ') ?> <?php #printf( __( 'por %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></em></p>

							<div class="entry">
								<?php 
								if(!is_single())
								the_excerpt("... continuar lendo.");
								else
								the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							</div>

							<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ) ?>

				<?php endwhile; ?>

				<div class="navigation">

					<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
					<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>

				</div>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

				<?php locate_template( array( 'searchform.php' ), true ) ?>

			<?php endif; ?>
		</div>

		<?php do_action( 'bp_after_blog_home' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 's-blog.php' ), true ) ?>

<?php get_footer() ?>
