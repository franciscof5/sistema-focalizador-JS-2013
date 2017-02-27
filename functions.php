<?php

add_filter('show_admin_bar', '__return_false'); 
add_action( 'login_form_middle', 'add_lost_password_link' );
add_action( 'admin_menu', 'edit_admin_menus' ); 
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');
add_action('wp_ajax_save_progress', 'save_progress');
add_action('wp_ajax_nopriv_save_progress', 'save_progress');
add_action('wp_ajax_load_pomo', 'load_pomo');
add_action('wp_ajax_nopriv_load_pomo', 'load_pomo');
add_action('wp_ajax_update_pomo', 'update_pomo');
add_action('wp_ajax_nopriv_update_pomo', 'update_pomo');
add_action('wp_ajax_save_modelnow', 'save_modelnow');
add_action('wp_ajax_nopriv_save_modelnow', 'save_modelnow');
add_action( 'admin_menu', 'my_remove_menu_pages' );
add_action('wp_logout','go_home');
add_action('init', 'theme_scripts');

function theme_scripts() {	
	//jquery colors
	wp_enqueue_script("jquery-color", get_bloginfo("stylesheet_directory")."/assets/jquery.color-2.1.2.min.js");
	//alertify
	wp_enqueue_script("alertify-js", get_bloginfo("stylesheet_directory")."/assets/alertify.min.js");
	wp_enqueue_style('alertify-css', get_bloginfo("stylesheet_directory")."/assets/alertify.core_and_default_merged.css", __FILE__);
}
#
function reset_configurations () {
	delete_user_meta(get_current_user_id(), "pomodoroAtivo");
}

function add_lost_password_link() {
    return '<a href="/wp-login.php?action=lostpassword">Esqueci a senha!</a>';
}

function go_home(){
	wp_redirect( home_url() );
	exit();
}

function my_remove_menu_pages() {
	get_currentuserinfo();
	if(!current_user_can('administrator')) {
		remove_menu_page('link-manager.php');
		remove_menu_page('themes.php');
		remove_menu_page('index.php');
		remove_menu_page('tools.php');
		remove_menu_page('profile.php');
		remove_menu_page('upload.php');
		remove_menu_page('post.php');
		remove_menu_page('post-new.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('admin.php');
		remove_menu_page('edit-comments.php');
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'tools.php', 'wp-cumulus.php' );
		
		 remove_meta_box('linktargetdiv', 'link', 'normal');
		  remove_meta_box('linkxfndiv', 'link', 'normal');
		  remove_meta_box('linkadvanceddiv', 'link', 'normal');
		  remove_meta_box('postexcerpt', 'post', 'normal');
		  remove_meta_box('trackbacksdiv', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('postcustom', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('commentsdiv', 'post', 'normal');
		  remove_meta_box('revisionsdiv', 'post', 'normal');
		  remove_meta_box('authordiv', 'post', 'normal');
		  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
		  remove_meta_box('submitdiv', 'post', 'normal');
		  remove_meta_box('avhec_catgroupdiv', 'post', 'normal');
		  remove_meta_box('categorydiv', 'post', 'normal');
	}
}

function edit_admin_menus() {  
	global $menu;  
	$menu[5][0] = 'Pomodoros'; // Change Posts to Pomodoros
}  

function myStartSession() {
	if(!session_id()) {
		session_start();
	}
 
}

function myEndSession() {
    session_destroy ();
}


function save_progress () {
	$pomo_completed = date("Y-m-d H:i")."|".$_POST['descri'];
	$save_progress = add_user_meta(get_current_user_id(), "pomodoro_completed", $pomo_completed);
	if($save_progress) {
		echo "true";
	} else {
		echo "false";
	}
	
	$tagsinput = explode(" ", $_POST['post_tags']);
	
	$my_post = array(
		'post_title' => $_POST['post_titulo'],
		'post_content' => $_POST['post_descri'],
		'post_status' => $_POST['post_priv'],
		'post_category' => array(1, $_POST['post_cat']),
		'post_author' => $current_user->ID,
		'tags_input' => array($_POST['post_tags'])
		//'post_category' => array(0)
	);
	wp_insert_post( $my_post );
	
	die(); 
}

#
function load_pomo () {
	//checa se já existe um rascunho, caso não cria o primeiro
	$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	
	if($pomodoroAtivo=="") {
		
		//If there is no active post, look for any type of post, for the current user
		$args = array(
			'author' => get_current_user_id(),
			'posts_per_page' => 1
		);
		$any_post = get_posts($args);
		

		//$res = get_post($pomodoroAtivo);
		//var_dump($res);
		if (count($any_post)==0) {
			echo "É a sua primeira visita? Configurei uma tarefa como exemplo abaixo! $^$ Organizar ambiente$^$ projeto-organizacao$^$ Organizar mesa e gaveta, arquivar papéis do ano passado. Nessa área você pode escrever mais detalhes da tarefa. Uma curiosidade, organizar o ambiente é a tarefa número 1 de quem usa o Pomodoros.com.br pela primeira vez $^$ ".date("Y-m-d H:i:s")."$^$ $^$ $^$ ";
			//echo "É a sua primeira visita? Vou configurar um pomodoro como exemplo"
			//echo "Houve um problema ao carregar seu pomodoro ativo! É sua primeira visita? $^$ $^$ $^$ $^$ ";
			//O $^$ é o separador, para (FALA DA FOCA, TITULO, PROJETO, DESCRICAO)
			
		} else {
			foreach ($any_post as $post) {
				echo "Carreguei sua última tarefa, basta acionar o botão FOCAR! e arregaçar as mangas."."$^$ ".$post->post_title."$^$ ".$tags[0]->name."$^$ ".$post->post_content."$^$ ".$post->post_date."$^$ ".$post->post_status."$^$ ".$post->ID."$^$ ".$secs;
			}
		}
	} else {
		//O cara já tem um pomodoroAtivo, só carregar	
		//$res = get_posts($args);
		$post = get_post($pomodoroAtivo);
		$tags = wp_get_post_tags($post->ID);
		
		//if($post->post_status=="pending") {
		$post->post_date;
		//echo " i ".date("Y-m-d H:i:s");//, strtotime('+25 minutes')
		$timeFirst  = strtotime($post->post_date);
		//echo " i ";
		$timeSecond = strtotime(date("Y-m-d H:i:s"));
		
		//echo " S:";
		$secs = ($timeSecond - $timeFirst);

		/*$date = new DateTime( $post->post_date_gmt );
		$date2 = new DateTime( "2014-01-13 04:29:10" );
		echo " s2:".$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();*/
		//$secs = 1000;
		//} 
		echo "Carreguei sua última tarefa, basta acionar o botão FOCAR! e arregaçar as mangas."."$^$ ".$post->post_title."$^$ ".$tags[0]->name."$^$ ".$post->post_content."$^$ ".$post->post_date."$^$ ".$post->post_status."$^$ ".$post->ID."$^$ ".$secs;
		//}
	}

	/*} else {
		//O cara ainda não tem pomodoroAtivo
		echo "É a sua primeira visita? Configurei uma tarefa como exemplo abaixo! $^$ Organizar ambiente$^$ projeto-organizacao$^$ Organizar mesa e gaveta, arquivar papéis do ano passado. Nessa área você pode escrever mais detalhes da tarefa. Uma curiosidade, organizar o ambiente é a tarefa número 1 de quem usa o Pomodoros.com.br pela primeira vez $^$ ";
	}*/
	//echo "META[pomodoativo]:".$reqweasdasd.get_current_user_id();
}

function update_pomo () {
	//echo "update_pomo";
	$tagsinput = explode(" ", $_POST['post_tags']);
	//$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	$agora = date("Y-m-d H:i:s");
	
	if($_POST['ignora_data']) {
		echo "com o pomodoro rolando. ";
		$my_post = array(
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "pending",
			'edit_date' => true,
			//'post_date' => $agora
			'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	} else {
		echo "com o relógio parado. ";
		$my_post = array(
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "draft",
			'edit_date' => true,
			'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	}
	if($_POST["post_status"]!="") {
		$my_post["post_status"] = $_POST["post_status"];
	}
	
	$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);

	if($pomodoroAtivo=="") {
		//Não tem pomodoro ativo
		$save_progress = wp_insert_post( $my_post );
		update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		$pomodoroAtivo = $save_progress;
		echo "Salvando pela primeira vez.";
	} else {
		//Atualiza o pomodoro ativo
		$my_post["ID"] = $pomodoroAtivo;
		$save_progress = wp_update_post( $my_post );
		echo "Atualizando seu pomodoro ativo.";
		//SO USADA PARA TESTES
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
	}

	//RETORNANDO VALORES
	$post_atual_pega_data = get_post($pomodoroAtivo);
	echo "$^$ ".$post_atual_pega_data->post_status."$^$ ".$post_atual_pega_data->post_date;
	
}

function save_modelnow () {
	if(isset($_POST['post_para_deletar'])) {
		wp_delete_post($_POST['post_para_deletar']);
	} else {
		$tagsinput = explode(" ", $_POST['post_tags']);	
		$my_post = array(
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => "pending",
			'post_author' => $current_user->ID,
			'tags_input' => array($_POST['post_tags'])
		);
		$idofpost = wp_insert_post( $my_post );
		echo $idofpost;
		die();
	}
}

register_sidebar( array(
	'name' => __( 'pomodoros'),
	'id' => 'pomodoros',
	'description' => __( 'Sidebar pomodoros'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );
register_sidebar( array(
	'name' => __( 'geral'),
	'id' => 'geral',
	'description' => __( 'Sidebar geral'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

?>