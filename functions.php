<?php
//
function get_author_post_tags_wpa78489($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $posts = get_posts(array(
        'author' => $author_id,
        'posts_per_page' => -1,
        'fields' => 'ids'
        )
    );

    $ts = array();

    //loop over the post and count the tags
    foreach ((array)$posts as $p_id) {
        $tags = wp_get_post_terms( $p_id, $taxonomy);
        foreach ((array)$tags as $tag) {
            if (isset($tags[$tag->term_id])){ //if its already set just increment the count
                $ts[$tag->term_id]['count'] = $ts[$tag->term_id]['count']  + 1;
            }else{ //set the term name start the count
                $ts[$tag->term_id] = array('count' => 1, 'name' => $tag->name, 'slug' => $tag->slug);
            }
        }
    }

    //so now $ts holds a list of arrays which each hold the name and the count of posts 
    //that author have in that term/tag, so we just need to display it
    $url = get_author_posts_url($author_id);
    #echo '<ul>';
    foreach ($ts as $term_id => $term_args) {
        echo '<span class="count">'.$term_args['count'].'</span> <a href="'.add_query_arg('tag',$term_args['slug'],$url).'">'.$term_args['name'].'</a>, ';
    }
    #echo '</ul>';
}

function user_object_productivity ($user_id) {
	//echo "<script>alert($user_id);</script>";
	$user_id = (empty($user_id)) ? get_current_user_id() : $user_id;
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//variaveis assistentes
	$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata($user_id)->user_registered)));
	$now = time();
	global $wpdb;
	$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

	/*It must be splitted because it uses itself values, and it cant be accessed in real time*/
	$SEMPRE['totalDias'] = floor($datediff/(60*60*24));
	$SEMPRE['diasTrabalhados'] = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' GROUP BY DATE (`post_date`)');
	$SEMPRE['diasFolga'] = $SEMPRE['totalDias'] - $SEMPRE ['diasTrabalhados'];
	$SEMPRE['fatorProdutividade'] = round($SEMPRE['diasTrabalhados']/$SEMPRE['totalDias'], 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND post_date > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 7;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'];
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/$SETEDIAS['totalDias'], 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SEMANA['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	//Its to prevent a very intersting bug, when there are 2 posts with less than 24 hours of difference but are published at 2 differents days, it will result in a 2 posts for 1 day, grouped by date, because there are 2 differente days
	($SEMANA['diasTrabalhados']>$SEMANA['totalDias']) ? $SEMANA['diasTrabalhados'] = $SEMANA['totalDias'] : $SEMANA['diasTrabalhados'];
	$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
	$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

	$new_object_productivity = array(
		"sempre" => $SEMPRE,
		"trintadias" => $TRINTADIAS,
		"mes" => $MES,
		"setedias" => $SETEDIAS,
		"semana" => $SEMANA
	);
	//var_dump($new_object_productivity);
	return $new_object_productivity;
}

//
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
	//bootstrap
	#wp_register_script ('bootstrap-js', get_stylesheet_directory_uri() . '/assets/bootstrap.min.js', array( 'jquery' ),'1.0.0',true);

  	#var_dump(wp_enqueue_script('bootstrap-js'));die;
  	#wp_enqueue_style
	#wp_dequeue_style("bootstrap");
	#wp_dequeue_script("bootstrap");
	#var_dump(wp_print_styles());
	#var_dump(wp_dequeue_style("bootstrap"));
	#var_dump(wp_enqueue_style('bootstrap-css', get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css", __FILE__));die;
	#var_dump(wp_enqueue_style("boostrap-css", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css"));die;
	#var_dump(wp_enqueue_style("boostrap-css"));die;
	#var_dump(wp_enqueue_script("bootstrap-js", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.js"));
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