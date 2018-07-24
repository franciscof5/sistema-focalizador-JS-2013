<?php get_header() ?>
<?php
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
#var_dump(dirname($uri_parts[0]));die;
if(dirname($uri_parts[0])!="/") {
	$page = explode("/", dirname($uri_parts[0]));
	$page = $page[1];
} else {
	$page = basename($uri_parts[0]);
}

?>
	<!--div id="content" class="content_default"-->

	<div class="content_nosidebar col-xs-12">
	
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page">

			

				<h2 class="pagetitle">404 Not Found</h2>

				<div class="post" id="post-<?php the_ID(); ?>">

					<div class="entry">

						<p>Nada encontrado</p>
						
					</div>

				</div>
				<div style="margin:0 auto;width: 220px;">

				<?php
				wp_login_form();

				force_database_aditional_tables_share(false);
				echo do_shortcode('[product id="5160" width="200"]');  
				revert_database_schema();
				?>
				</div>
		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ) ?>

		</div><!-- .padder -->
		
	</div><!-- #content -->
	
	<?php #locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
