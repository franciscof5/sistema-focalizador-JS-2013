<div class="content_nosidebar col-xs-12">
	<?php 
	#style="width: 104%;left: -2%;"
	$instance = array(
		"title" => "Ranking (top 100)",
		"count" => "100",
		"exclude_roles" => array("administrator"),#
		"include_post_types" => array("projectimer_focus"),
		"preset" => "custom",
		#"template" => "%gravatar_32% %firstname% %lastname% (%nrofposts%)",
		"template" => '<li><a href="/colegas/%username%">%gravatar_32%  %firstname% %lastname% (%nrofposts%) </a>  </li>',
		"before_list" => "<ul class='ta-preset ta-gravatar-list-count'>",
		"after_list" => "</ul>",
		"custom_id" => "",
		"archive_specific" => false); 
	the_widget("Top_Authors_Widget", $instance, "");
	$current_user = wp_get_current_user();
	#echo "<hr />";
	echo "Ranking gerado em: ".get_the_time('j \d\e F \d\e Y').", via www.pomodoros.com.br/ranking. Usuário: ".$current_user->display_name.", ".$current_user->user_email;
	?>
</div><!-- #content -->