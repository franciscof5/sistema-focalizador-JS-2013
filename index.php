<?php 
$page = basename($_SERVER["REQUEST_URI"]);

$newactivation = array_key_exists("jmm-join-site", $_GET);

if($page==basename(get_bloginfo("url")) and !$newactivation) {
	#if ( is_user_logged_in() )
	wp_redirect(get_bloginfo('url')."/focar");
	#else
	#wp_redirect(get_bloginfo('url')."/focar");
}

/*function get_user_subscription($user_id, $domain) {
	$user_id = (!isset($user_id)) ? get_current_user_id() : $user_id;
	$sql = "SELECT * FROM f5sites_posts WHERE post_type='subscription' AND post_author=".$user_id;
	global $wpdb;
	 echo "<pre>"; print_r($wpdb); echo "</pre>";
	
	$results = $wpdb->get_results( $sql, OBJECT );
	var_dump($results);
	die;
				
}*/
//get_user_subscription(2, $_SERVER['REQUEST_URI']);
get_header(); ?>

<!--div id="loading-message"><p>.</p><p class="dots">..</p></div-->
<!--div class="container-fluid" style="clear:both;"-->
<!--div id="content" class="content_default  col-xs-12 col-sm-9"-->
	<!--div class="row"-->
		<?php

		$pages = array("focar", "calendario", "ranking", "planejador", "produtividade", "inicio", "1tv", "csv", "1invite");
		
		#var_dump($pages);die;
		if(in_array($page, $pages)) {
			wp_enqueue_script("projectimer-js");
			locate_template( array( "t-".$page.".php" ), true );
			#wp_enqueue_script("/css/"$page.".css");
			#get_template_part( $page );
		} else {
			locate_template( array( "t-inicio.php" ), true );
			#get_template_part("default.php");
		}

		?>
		
	<!--/div-->
	<?php get_footer() ?>
<!--/div><!-- #content -->


