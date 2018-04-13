<?php 
get_header(); 

//$page = strtok(basename($_SERVER["REQUEST_URI"]),'?');
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
#var_dump(dirname($uri_parts[0]));die;
if(dirname($uri_parts[0])!="/") {
	$page = explode("/", dirname($uri_parts[0]));
	$page = $page[1];
} else {
	$page = basename($uri_parts[0]);
}
#var_dump($uri_parts);die;
#$urlParts = explode("/", $_SERVER['REQUEST_URI']);
#$rpage = explode("/", $page);
#if(isset($rpage[0]))
#$page = $rpage[0];
#echo $page;die;
$pages = array("focar", "calendar", "ranking", "produtividade", "inicio", "stats", "csv", "metas", "premios", "game", "1invite", "ticket", "product");
#var_dump($uri_parts);die;
if(!in_array($page, $pages)) {
	echo do_shortcode('[rev_slider alias="pomo1"]');
	if($locale=="pt_BR" || $locale=="pt")
		$page = "inicio";
	else
		$page = "home";
	?>
	<style type="text/css">
		.navbar {margin-bottom: 0px;}
	</style>
	<?php
} else {
	if (!is_user_logged_in()) {
		$page = "closed";
	} else {
		if($page=="focar") {
			wp_enqueue_script("sound-js");
			wp_enqueue_script("pomodoros-js");
			#wp_enqueue_script("projectimer-pomodoros-shared-parts-js");
			wp_enqueue_script("rangeslider-js");
		}
	}
}

#echo "INDEX";die;
locate_template( "part-".$page.".php", true );


get_footer();