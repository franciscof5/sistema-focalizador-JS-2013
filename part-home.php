	<?php echo do_shortcode('[rev_slider alias="pomo1"]'); ?>
	<style type="text/css">
		.navbar {margin-bottom: -10px;}
	</style>
	
	<?php
	#force_database_aditional_tables_share(false);
	#echo do_shortcode('[product id="5160"]');  
	#echo do_shortcode('[products ids="4530,5160" ]');
	#echo do_shortcode('[products]');
	#echo do_shortcode('[products ids="5160,4530" columns="4"]');
	#
	#echo do_shortcode('[product_category limit="4" columns="4" orderby="popularity" product_cat="www.pomodoros.com.br"]');  
	#revert_database_schema();#4530#5160
	?>
	<div id="content" class="content_default col col-xs-12 ">
		<div class="row">

			<div class="padder col-md-9">
			<?php if(is_home()) { ?>
				<div id="blog-welcomeDISABLED">
				<!--h3 class="forte"><script>document.write(txt_blog_header)</script></h3>
				<p><script>document.write(txt_blog_desc)</script></p-->
				<?php show_lang_options(false); ?>
				<?php if(is_user_logged_in()) { ?>
					<?php $current_user = wp_get_current_user(); ?>
					<?php 
					$args = array(
			              'post_type' => 'projectimer_focus',
			              'post_status' => 'draft',
			              'author'   => get_current_user_id(),

			              'posts_per_page' => 1,
			            );
					$recent = get_posts($args);
					if( $recent ){
					  $title = ", you most recent task is <i>".get_the_title($recent[0]->ID)."</i>";
					}else{
					  $title = ", you did not started a task yet"; //No published posts
					} ?>
					
					<?php 
					$msg_saudacao = "Hello ".$current_user->display_name." ".$title.", <a href=/focar>go to online app and start focus</a>";

					
					?>
				<?php } else {
					$msg_saudacao = "Dear visitor, <a href=/register>create your free user</a> and start focus right now";
					$msg_saudacao2 = "If you already have an account, <a id=testes href=# class=abrir_login>login</a>";
				} 
				
				echo "<script type='text/javascript'>alertify.log('".$msg_saudacao."');</script>";
				if(isset($msg_saudacao2))
				echo "<script type='text/javascript'>alertify.log('".$msg_saudacao2."');</script>";
				/*
				?>
				<script type="text/javascript">
					artyom = new Artyom();
					//
				    artyom.fatality();// use this to stop any of
				    //
				    //alert(data_from_php.php_locale);
				    //if(data_from_php.php_locale=="pt_BR")
				    artyom_lang = <?php global $locale; echo $locale; ?>;
				    //else
				    	//artyom_lang = "en-US";
				    //
				    setTimeout(function(){// if you use artyom.fatality , wait 250 ms to initialize again.
				         artyom.initialize({
				            lang:artyom_lang,// A lot of languages are supported. Read the docs !
				            continuous:true,// Artyom will listen forever
				            listen:true, // Start recognizing
				            debug:true, // Show everything in the console
				            speed:1, // talk normally
				            //name: "pomodoro",
				        }).then(function(){
				            console.log("Ready to work !");
				        });
					});
					artyom.say('<?php echo $msg_saudacao; ?>');
				</script>*/
				?>
				</div>
				<!--hr /-->
			<?php } ?>
			
			<?php do_action( 'bp_before_blog_home' ) ?>

			<div class="page" id="blog-latest">

				<?php 
				if(function_exists('set_shared_database_schema')) {
				       			set_shared_database_schema();
				       		}

				if ( have_posts() ) : ?>

					<?php while (have_posts()) : the_post(); ?>
						<?php if(has_tag("english")){ ?>
						<?php do_action( 'bp_before_blog_post' ) ?>

						<div class="post" id="post-<?php the_ID(); ?>">

								<div class="contem-thumb">
								<center>
							    <a style="margin:0 auto;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							       <?php 

							       if ( has_post_thumbnail() ) {
							       		
										the_post_thumbnail( array(500,200) );
									}

							       ?>
							    </a>
							    </center>
							    </div>
							<?php #endif;  ?>
							<div class="author-box">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), '60' ); ?>
							</div>

							<div class="post-content">
								<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

								<p class="date"><?php the_time("Y-m-d") ?></p>

								<div class="entry">
									<?php 
									if(!is_single())
									the_excerpt("... keep reading.");
									else
									the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								</div>

								<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
							</div>

						</div>

						<?php do_action( 'bp_after_blog_post' ) ?>
						<?php } ?>
					<?php endwhile; ?>

					<?php 
					#plugin: f5sites-shared-posts-tables-and-uploads-folder
					if(function_exists("print_blog_nav_links") && !is_home()) print_blog_nav_links($post); ?>

				<?php else : ?>

					<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
					<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

					<?php locate_template( array( 'searchform.php' ), true ) ?>

				<?php endif; ?>
			</div>

			<?php do_action( 'bp_after_blog_home' ); ?>

		</div><!-- .padder -->

			<div class="col-md-3">
				<h3 class="forte">Buy to support our free services</h3>
				<?php echo do_shortcode('[product id="5160"]'); ?>
				<?php #echo do_shortcode('[product id="5432"]'); ?>
				<?php #echo do_shortcode('[product id="5434"]'); ?>
				<?php #echo do_shortcode('[product id="5157"]'); ?>
				
			</div>
		</div>
	</div><!-- #content -->

	<?php #locate_template( array( 's-blog.php' ), true ) ?>
