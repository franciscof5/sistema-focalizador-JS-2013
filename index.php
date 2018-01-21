<?php 
get_header(); 


//$page = strtok(basename($_SERVER["REQUEST_URI"]),'?');
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$page = basename($uri_parts[0]);
$pages = array("focar", "calendario", "ranking", "produtividade", "inicio", "stats", "csv", "metas", "premios", "1invite");

if(!in_array($page, $pages)) {
	$page = "inicio";
} else {
	if (!is_user_logged_in()) {
		$page = "closed";
	} /*else {
		if($page=="focar") {
			wp_enqueue_script("sound-js");
			wp_enqueue_script("pomodoros-js");
		}
	}*/
}

#echo "INDEX";die;
locate_template( "part-".$page.".php", true );


get_footer();