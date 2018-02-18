<?php
//
//remove_filter('template_redirect', 'redirect_canonical');
show_admin_bar( false );
add_filter( 'redirect_canonical','custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url, $requested_url ) {
	if ( preg_match("/ranking/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("/calendar/",$redirect_url) ) {
		return FALSE;
	} else {
		return $redirect_url;
	}
}
//


if(function_exists("set_shared_database_schema"))
add_action("wpcf7_init", "set_shared_database_schema", 10, 2);

function get_author_post_tags_wpa78489($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $posts = get_posts(array(
    	'post_type' => "projectimer_focus",
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

	$SETEDIAS['totalDias'] = 6;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'] +1;
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/($SETEDIAS['totalDias']+1), 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".($SEMANA['totalDias']-1)." DAY) GROUP BY DATE (`post_date`)");
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

if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

//date_default_timezone_set('America/Sao_Paulo');
//
#ADMIN can view the bar finally
#if(!current_user_can('administrator'))
#add_filter('show_admin_bar', '__return_false'); 

add_action( 'login_form_middle', 'add_lost_password_link' );
#add_action( 'admin_menu', 'edit_admin_menus' ); 
#add_action('init', 'myStartSession', 1);
#add_action('wp_logout', 'myEndSession');
#add_action('wp_login', 'myEndSession');
add_action('wp_ajax_save_progress', 'save_progress');
add_action('wp_ajax_nopriv_save_progress', 'save_progress');
add_action('wp_ajax_load_session', 'load_session');
add_action('wp_ajax_nopriv_load_session', 'load_session');
add_action('wp_ajax_update_session', 'update_session');
add_action('wp_ajax_nopriv_update_session', 'update_session');
add_action('wp_ajax_save_modelnow', 'save_modelnow');
add_action('wp_ajax_nopriv_save_modelnow', 'save_modelnow');
add_action( 'admin_menu', 'my_remove_menu_pages' );
add_action('wp_logout','go_home');
add_action( 'init', 'create_post_type' );
add_action('init', 'load_scritps');

add_action('pre_get_posts', 'force_revert_f5sites_shared', 10, 2);

function force_revert_f5sites_shared() {
	if(is_tag()) {
	#echo $_SERVER['SERVER_NAME'];
	#if($_SERVER['SERVER_NAME']=="www.pomodoros.com.br")
		if(function_exists("revert_database_schema"))
		revert_database_schema();
	}
}

function default_page() {
  return '/focar';
}

add_filter('login_redirect', 'default_page');

function load_scritps() {	
	//jquery colors
	wp_enqueue_script("jquery-color", get_bloginfo("stylesheet_directory")."/assets/jquery.color-2.1.2.min.js");
	
	//alertify
	wp_enqueue_script("alertify-js", get_bloginfo("stylesheet_directory")."/assets/alertify.min.js");
	wp_enqueue_style('alertify-css', get_bloginfo("stylesheet_directory")."/assets/alertify.core_and_default_merged.css", __FILE__);
	
	//bootstrap
	wp_enqueue_script("bootstrap-js", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.js");
	wp_enqueue_style('bootstrap-css', get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css", __FILE__);
	
	//select2
	wp_enqueue_script("select2-js", get_bloginfo("stylesheet_directory")."/assets/select2/select2.full.min.js");
	wp_enqueue_script("select2-jsbr", get_bloginfo("stylesheet_directory")."/assets/select2/select2_locale_pt-BR.js");
	wp_enqueue_style('select2-css', get_bloginfo("stylesheet_directory")."/assets/select2/select2.min.css", __FILE__);

	//no sleep
	wp_enqueue_script("nosleep-js", get_bloginfo("stylesheet_directory")."/assets/NoSleep.min.js");

	//
	wp_enqueue_script("artyom-js", get_bloginfo("stylesheet_directory")."/assets/artyom.window.min.js");
	#wp_enqueue_script("speakW-js", get_bloginfo("stylesheet_directory")."/assets/speakWorker.js");
	
	#<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css" />
	//inter8
	global $locale;
	if(function_exists("locale_accept_from_http"))
		$locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	else
		$locale = "pt_BR";
	//echo $locale;die;
	if($locale=="")
		$locale=="en_US";
	

	$user_lang_pref = get_user_meta(get_current_user_id(), "pomodoros_lang", true);
	if($user_lang_pref=="")
		$user_lang_pref="pt_BR";
	//var_dump($user_lang_pref);
	/*if($user_lang_pref) {
		//var_dump($user_lang_pref);die;
		if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "pt_BR" );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "en_US" );
		}
	} else {*/
	if($_GET && isset($_GET["lang"])) {
		if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {	
			$user_lang_pref="pt_BR";
			update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_pref );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			$user_lang_pref="en_US";
			update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_pref );
		}
	}
	

	if($user_lang_pref!=$locale) {
		$locale=$user_lang_pref;
	}
	
	$filelang = $locale.".js";
	
	#var_dump($filelang."#");
	//if(qtranxf_getLanguage() == "en")
		//$filelang="en.js";
	   //else if(qtranxf_getLanguage() == "pt")
		//$filelang="pt-br.js";
	//} else {
		//If the function doesnt exists then call the default language
		//$filelang="pt-br.js";
	//}

	wp_enqueue_script("pomodoros-language", get_bloginfo("stylesheet_directory")."/languages/".$filelang, __FILE__);

	// Register the script
	//wp_register_script( 'some_handle', 'path/to/myscript.js' );
	wp_register_script("pomodoros-js", get_bloginfo("stylesheet_directory")."/pomodoro/pomodoro-functions.js", __FILE__);

	// Localize the script with new data
	$translation_array = array(
		'php_locale' => $locale,
	);
	
	wp_localize_script( 'pomodoros-js', 'data_from_php', $translation_array );

	// Enqueued script with localized data.
	//wp_enqueue_script( 'pomodoros-js' );
		#echo get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.js";
	wp_register_script("projectimer-pomodoros-shared-parts-js", get_bloginfo("stylesheet_directory")."/pomodoro/projectimer-pomodoros-shared-parts.js", __FILE__);
	#
	#VIA CSS wp_enqueue_style("projectimer-pomodoros-shared-parts-css", get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.css", __FILE__);

	//
	wp_register_script("sound-js", get_bloginfo("stylesheet_directory")."/assets/soundmanager2-nodebug-jsmin.js", __FILE__);

	wp_register_script("rangeslider-js", get_bloginfo("stylesheet_directory")."/assets/rangeslider.min.js", __FILE__);
	
}

function show_lang_options($showtitle) {
	global $locale;
	
	if($locale!="en" && $locale!="en_US") { ?>
		<?php if($showtitle) { ?>
			<h3 class="widget-title">Change Language</h3>
		<?php } else { ?>
			<strong>Change Language:</strong>
		<?php } ?>
		<a href="?lang=en_US">English</a>
	<?php } else { ?>
		<?php if($showtitle) { ?>
			<h3 class="widget-title">Mudar Idioma</h3>
		<?php } else { ?>
			<strong>Mudar Idioma:</strong>
		<?php } ?>
		<a href="?lang=pt_BR">Português</a>
	<?php }
}

function show_most_recent_task() {
	echo '<h3 class="widget-title">Tarefa recente</h3>';
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user(); 
		$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),

		              'posts_per_page' => 1,
		            );
		$recent = get_posts($args);
		if( $recent ){
		  $title = ", sua tarefa mais recente é <i>".get_the_title($recent[0]->ID)."</i>";
		}else{
		  $title = ", você ainda não começou nenhuma tarefa"; //No published posts
		} 
		$msg_saudacao = "Olá ".$current_user->display_name." ".$title.", <a href=/focar>acessar aplicativo online e focar</a>";
	} else {
		$msg_saudacao = "Caro visitante, <a href=/register>crie sua conta GRÁTIS</a> para acessar o aplicativo online";
		$msg_saudacao2 = "Se já possui um usuário, <a id=testes href=# class=abrir_login>acesse sua conta</a>";
	} 
			
	echo $msg_saudacao;
	if(isset($msg_saudacao2))
	echo $msg_saudacao2;
	#die();
}

#get_projectimer_tags_COPY();
function get_projectimer_tags_COPY($excludeTags=NULL) {
	
	if(function_exists('revert_database_schema'))revert_database_schema();
	global $please_dont_change_wpdb_woo_separated_tables;
	$please_dont_change_wpdb_woo_separated_tables=true;

	$args = array(
		'post_type' => array("projectimer_focus"),
		'author'        =>  get_current_user_id(),
		'post_status' => array("publish", "future", "pending", "draft"),
		'posts_per_page' => -1,

	);
	$all_projectimer_tags = get_posts( $args );
	$please_dont_change_wpdb_woo_separated_tables=false;
	#set_shared_database_schema();
	#var_dump($all_projectimer_tags);
	$terms = array();
	foreach ($all_projectimer_tags as $post) {
		$tags = get_the_terms($post->ID, 'post_tag');
		#var_dump($tags);
		if($tags) {
			foreach ($tags as $tag) {
				//array_
				//$t = "<option>".$tag->slug."</option>";
				$t = $tag->slug;
				if(!in_array($t, $terms)) {
					if($excludeTags) {
						if(!in_array($t, $excludeTags))
						$terms[] = $t;
					} else {
						$terms[] = $t;
					}

				}
			}
		}
		//$terms[] = $tags;
	}
	#var_dump($terms);die;
	return $terms;
}

#
function reset_configurations () {
	delete_user_meta(get_current_user_id(), "pomodoroAtivo");
}

function add_lost_password_link() {
    return '<a href="/wp-login.php?action=lostpassword">Esqueci a senha (forgot password)</a>';
}

function go_home(){
	wp_redirect( home_url() );
	exit();
}

function my_remove_menu_pages() {
	wp_get_current_user();
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

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 

function woo_custom_order_button_text() {
    return __( 'Realizar Doação', 'woocommerce' ); 
}

// removes Order Notes Title - Additional Information
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
/*function edit_admin_menus() {  
	global $menu;  
	$menu[5][0] = 'Pomodoros'; // Change Posts to Pomodoros
}  

/*function myStartSession() {
	if(!session_id()) {
		session_start();
	}
 
}

function myEndSession() {
    session_destroy ();
}*/


function checkLogin() {
	if(!get_current_user_id()) {
		header('Content-type: application/json');//CRUCIAL
		echo json_encode("NOTIN");
		die();
	}
}
function save_progress () {
	checkLogin();
	//$pomo_completed = date("Y-m-d H:i")."|".$_POST['descri'];
	//$save_progress = add_user_meta(get_current_user_id(), "pomodoro_completed", $pomo_completed);
	
	/*if($save_progress) {
		echo "true";
	} else {
		echo "false";
	}*/

	/*$args = array(
	    'post_type' => 'projectimer_focus',
	    'post_status' => 'draft',
	    'author'   => get_current_user_id(),
	    //'orderby'   => 'title',
	    //'order'     => 'ASC',
	    'posts_per_page' => 1,
	);
	$post = get_posts($args); #new WP_Query( $args );
	echo $post[0]->ID;*/
	#revert_database_schema();
	#global $wpdb;
	#global $table_prefix;
	#$prefix=$table_prefix;
	
	#
	/*$wpdb->posts=$prefix."posts";
	$wpdb->postmeta=$prefix."postmeta";
	$wpdb->terms=$prefix."terms";
	$wpdb->term_taxonomy=$prefix."term_taxonomy";
	$wpdb->term_relationships=$prefix."term_relationships";
	$wpdb->termmeta=$prefix."termmeta";
	$wpdb->taxonomy=$prefix."taxonomy";*/
	//var_dump($wpdb);
	#force_database_aditional_tables_share();
	//
	#define(FORCE_NOT_PUBLISH_SHARED, true);
	global $force_publish_post_not_shared;
	$force_publish_post_not_shared = true;
	if(!$_POST['post_priv'])
		$_POST['post_priv']="publish";
	$tagsinput = explode(" ", $_POST['post_tags']);
	$agora = date("Y-m-d H:i:s");
	$my_post = array(
		'post_type' => 'projectimer_focus',
		'post_title' => $_POST['post_titulo'],
		'post_content' => $_POST['post_descri'],
		'post_status' => $_POST['post_priv'],
		'post_category' => array(1, $_POST['post_cat']),
		'post_author' => $current_user->ID,
		'tags_input' => array($_POST['post_tags']),
		'post_date' => $agora,
		'post_date_gmt' => $agora,
		//'post_category' => array(0)
	);

	$ok = wp_insert_post( $my_post );

	if($ok) {
		if(function_exists("cp_module_notify_displayNoticesFor"))
		cp_module_notify_displayNoticesFor(cp_currentUser());

		
		//$id = get_current_postid_for_user(get_current_user_id());
		$id = $ok;
		$current_user = get_currentuserinfo();
		$namefull = $current_user->user_firstname." ".$current_user->user_lastname;
		$user_id = $current_user->ID;

		$act_args = array(
			'user_id' => $user_id,
			'item_id' => $id,
			'component' => 'projectimer',
			'type' => 'projectimer_start',
		);
		//
		if($_POST["post_priv"]=="private")
			$act_args['hide_sitewide'] = true;
		//
		$act_args['action'] = "<p><a href='/colegas/".$current_user->user_login."'><span class=activity_title>".$namefull."</span></a> completou <a href='".get_permalink($ok)."'><span class=hidden>$id</span>".$_POST['post_titulo']." (25 min)</a></p>";
	
		//var_dump($act_args);
		$ac = bp_activity_add( $act_args );
		//
		echo "ATIVI:".$ac;
	} else {
		//echo " ERROR NOT PUBLISHED"; #NOT RESPONSE FOR ERROR
	}

	
	//echo wp_publish_post( $my_post );

	/*$sql = "INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ";
	$sql .= "(' ','".$current_user->ID."',"."'".$agora."',"."'".$agora."',"."'".$_POST['post_descri']."',"."'".$_POST['post_titulo']."',"."'".$post_excerpt."',"."'".$post_status."',"."'".$comment_status."',"."'".$ping_status."',"."'".$posd_password."',"."'".$post_name."',"."'".$to_ping."',"."'".$pinged."',"."'".$post_modified."',"."'".$post_modified_gmt."',"."'".$post_content_filtered."',"."'".$post_parent."',"."'".$guid."',"."'".$menu_order."',"."'projectimer_focus',"."'".$post_mime_type."',"."'".$comment_count."'),";

	$res = mysql_query($sql); 
	if($res): print 'Successful Insert'; else: print 'Unable to update table'; endif;
	*/
	
	#echo do_action( "save_post_projectimer_focus", int $post_ID, WP_Post $post, bool $update )
	
	die(); 
}

#
function load_session () {
	checkLogin();
	//checa se já existe um rascunho, caso não cria o primeiro
	
	
	/*if($pomodoroAtivo=="") {
		
		//If there is no active post, look for any type of post, for the current user
		$args = array(
			'post_type' => 'projectimer_focus',
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
	} else {*/
		//O cara já tem um pomodoroAtivo, só carregar	
		//$res = get_posts($args);
		#$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
		//if(!$pomodoroAtivo) {
			//$last_post = get_most_recent_post_of_user( get_current_user_id() );
			//$pomodoroAtivo = $last_post->post_id;
			#get_most_recent_post_of_user( $user_id );
			//$pomodoroAtivo = 1;//INITIAL POMODORO
			//$post = get_post($pomodoroAtivo);
		//} else {
		#$post = get_post($pomodoroAtivo);


		#date_default_timezone_set('America/Sao_Paulo');
		$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),
		              //'orderby'   => 'title',
		              //'order'     => 'ASC',
		              'posts_per_page' => 1,
		            );
		$post = get_posts($args); #new WP_Query( $args );
		#var_dump($post);die;

		if(!$post) {
			//$pomodoroAtivo = 2;//LOST POMODORO
			reset_configurations();
			echo "0";
			//$post = get_post($pomodoroAtivo);
		} else {

			#$pomodoroAtivo = update_user_meta(get_current_user_id(), "pomodoroAtivo", $post[0]->ID);
			
			//}
			
			//var_dump($post);
			$tags = wp_get_post_tags($post[0]->ID);
			$tags_list = array();
			foreach ($tags as $t) {
				# code...
				$tags_list[]=$t->name;
			}
			//if($post[0]->post_status=="pending") {
			$post[0]->post_date;
			//echo " i ".date("Y-m-d H:i:s");//, strtotime('+25 minutes')
			$timePost  = strtotime($post[0]->post_date);
			//echo " i ";
			
			$agora = strtotime(current_time("Y-m-d H:i:s"));
			
			//echo " S:";
			$secs = ($timePost - $agora);

			/*$date = new DateTime( $post[0]->post_date_gmt );
			$date2 = new DateTime( "2014-01-13 04:29:10" );
			echo " s2:".$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();*/
			//$secs = 1000;
			//} 
			$postReturned['post_title'] = $post[0]->post_title;
			$postReturned['post_tags'] = $tags_list;
			$postReturned['post_content'] = $post[0]->post_content;
			$postReturned['ID'] = $post[0]->ID;
			$postReturned['post_date'] = $post[0]->post_date;
			$postReturned['post_status'] = $post[0]->post_status;
			$postReturned['secs'] = $secs;
			$postReturned['agora'] = $agora;
			$postReturned['tags_total'] = get_projectimer_tags_COPY();

			$vol = get_user_meta(get_current_user_id(), "rangeVolume", true);
			if($vol<0 || $vol>100 || $vol=="")
				$vol=100;
			$postReturned['range_volume'] = $vol;
			//

			//header('Content-type: application/json');//CRUCIAL
			//if($pomodoroAtivo)
			echo json_encode($postReturned);
		}
		#echo "Carreguei sua última tarefa, basta acionar o botão FOCAR! e arregaçar as mangas."."$^$ ".$post->post_title."$^$ ".$tags[0]->name."$^$ ".$post->post_content."$^$ ".$post->post_date."$^$ ".$post->post_status."$^$ ".$post->ID."$^$ ".$secs;
		//}
	//}

	/*} else {
		//O cara ainda não tem pomodoroAtivo
		echo "É a sua primeira visita? Configurei uma tarefa como exemplo abaixo! $^$ Organizar ambiente$^$ projeto-organizacao$^$ Organizar mesa e gaveta, arquivar papéis do ano passado. Nessa área você pode escrever mais detalhes da tarefa. Uma curiosidade, organizar o ambiente é a tarefa número 1 de quem usa o Pomodoros.com.br pela primeira vez $^$ ";
	}*/
	//echo "META[pomodoativo]:".$reqweasdasd.get_current_user_id();
}

function update_session () {
	checkLogin();
	//UPDATE DRAFT POMODOROS ON TASK FORM
	$args = array(
	          'post_type' => 'projectimer_focus',
	          'post_status' => 'draft',
	          'author'   => get_current_user_id(),
	          //'orderby'   => 'title',
	          //'order'     => 'ASC',
	          'posts_per_page' => 1,
	        );
	$post = get_posts($args); #new WP_Query( $args );

	#var_dump($post);die;
	#$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	$pomodoroAtivo =  $post[0]->ID;

	
	//$tagsinput = explode(" ", $_POST['post_tags']);
	

	//$agora = date("Y-m-d H:i:s");
	
	/*if($_POST['ignora_data']) {
		//echo "com o pomodoro rolando. ";
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "pending",
			'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	} else {*/
		//echo "com o relógio parado. ";
		$my_post = array(
			'ID'	=> $pomodoroAtivo,
			#'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			//'post_author' => get_current_user_id(),
			'tags_input' => $_POST['post_tags'],
			//'post_status' => "draft",
			//'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	//}
	//if($_POST["post_status"]!="") {
	//	$my_post["post_status"] = $_POST["post_status"];
	//}
	
	//$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);

	#if(function_exists("force_database_aditional_tables_share")) {
	#	force_database_aditional_tables_share();
	#}
	if($pomodoroAtivo=="") {
		//Não tem pomodoro ativo
		$save_progress = wp_insert_post( $my_post );
		update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		$pomodoroAtivo = update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		//$pomodoroAtivo = "NAO ACHOU";
		//$pomodoroAtivo = $save_progress;
		//echo "Salvando pela primeira vez.";
	} else {
		//Atualiza o pomodoro ativo
		//$my_post["ID"] = $pomodoroAtivo;
		$save_progress = wp_update_post( $my_post );
		//echo "Atualizando seu pomodoro ativo.";
		//SO USADA PARA TESTES
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
	}

	//RETORNANDO VALORES
	#$post_atual_pega_data = get_post($pomodoroAtivo);

	//echo "$^$ ".$post_atual_pega_data->post_status."$^$ ".$post_atual_pega_data->post_date;
	$postReturned['post_status'] = $post_atual_pega_data[0]->post_status;
	$postReturned['post_date'] = $post_atual_pega_data[0]->post_date;
	$postReturned['ID'] = $post_atual_pega_data[0]->ID;
	$postReturned['pomodoroAtivo'] = $pomodoroAtivo;
	$postReturned['tags_recebidas'] = $_POST['post_tags'];
	//$postReturned['psot_atual_pega_data'] = $my_post;
	$postReturned['save_progress'] = $save_progress;
	
	$vok = update_user_meta(get_current_user_id(), "rangeVolume", $_POST['range_volume']);

	$postReturned['volume_ok'] = $vok;
	//

	header('Content-type: application/json');//CRUCIAL
	echo json_encode($postReturned);
	
}

function update_pomo_active () {
	checkLogin();
	//echo "update_pomo";
	$tagsinput = explode(" ", $_POST['post_tags']);
	$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	$agora = date("Y-m-d H:i:s");
	
	/*if($_POST['ignora_data']) {
		//echo "com o pomodoro rolando. ";
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "pending",
			'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	} else {*/
		//echo "com o relógio parado. ";
		$my_post = array(
			//'ID'	=> $pomodoroAtivo;
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			//'post_status' => "draft",
			'edit_date' => true,
			'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	//}
	//if($_POST["post_status"]!="") {
	//	$my_post["post_status"] = $_POST["post_status"];
	//}
	
	//$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);

	if($pomodoroAtivo=="") {
		//Não tem pomodoro ativo
		$save_progress = wp_insert_post( $my_post );
		update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		$pomodoroAtivo = $save_progress;
		//echo "Salvando pela primeira vez.";
	} else {
		//Atualiza o pomodoro ativo
		$my_post["ID"] = $pomodoroAtivo;
		$save_progress = wp_update_post( $my_post );
		//echo "Atualizando seu pomodoro ativo.";
		//SO USADA PARA TESTES
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
	}

	//RETORNANDO VALORES
	$post_atual_pega_data = get_posts($pomodoroAtivo);
	//echo "$^$ ".$post_atual_pega_data->post_status."$^$ ".$post_atual_pega_data->post_date;
	$postReturned['post_status'] = $post_atual_pega_data[0]->post_status;
	$postReturned['post_date'] = $post_atual_pega_data[0]->post_date;
	$postReturned['ID'] = $post_atual_pega_data[0]->ID;
	$postReturned['pomodoroAtivo'] = $pomodoroAtivo;
	$postReturned['post_atual_pega_data'] = $my_post;
	$postReturned['save_progress'] = $save_progress;
	

	//

	header('Content-type: application/json');//CRUCIAL
	echo json_encode($postReturned);
	
}

function save_modelnow () {
	checkLogin();
	if(function_exists("revert_database_schema"))revert_database_schema();
	if(isset($_POST['post_para_deletar'])) {
		#echo "deletando: ".$_POST['post_para_deletar'];
		echo wp_trash_post($_POST['post_para_deletar']);
		#die;
	} else {
		$tagsinput = explode(" ", $_POST['post_tags']);	
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => "pending",
			'post_author' => $current_user->ID,
			'tags_input' => array($_POST['post_tags'])
		);
		$idofpost = wp_insert_post( $my_post );
		echo $idofpost;
		#die();
	}
}

register_sidebar( array(
	'name' => __( 'blog'),
	'id' => 'blog',
	'description' => __( 'blog sidebar'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => __( 'Geral Esquerda'),
	'id' => 'geral',
	'description' => __( 'Sidebar geral, fica na esquerda'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => __( 'Pomodoros Direita'),
	'id' => 'pomodoros',
	'description' => __( 'Fica na DIREITA em focus'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => __( 'Ranking'),
	'id' => 'ranking',
	'description' => __( 'apenas mostra o ranking'),
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );
function create_post_type() {
	createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN();
}

function createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN() {
	
	if ( ! post_type_exists( "projectimer_focus" ) ) {
		$labelFocus = array(
			'name'  => __( 'Focus',' projectimer-plugin' ), 
			'singular_name' => __( 'Focus',    ' projectimer-plugin' ),
			'add_new'    => __( 'Add New', ' projectimer-plugin' ),
			'add_new_item'  => __( 'Add New Focus',    ' projectimer-plugin' ),
			'edit'  => __( 'Edit', ' projectimer-plugin' ),
			'edit_item'  => __( 'Edit Focus', ' projectimer-plugin' ),
			'new_item'   => __( 'New Focus', ' projectimer-plugin' ),
			'view'  => __( 'View Focus', ' projectimer-plugin' ),
			'view_item'  => __( 'View Focus', ' projectimer-plugin' ),
			'search_items'  => __( 'Search Focus', ' projectimer-plugin' ),
			'not_found'  => __( 'No Focus found', ' projectimer-plugin' ),
			'not_found_in_trash' => __( 'No Focus found in Trash', ' projectimer-plugin' ),
			'parent'     => __( 'Parent Focus',     ' projectimer-plugin' ),
		);
		
		$postTypeFocusParams = array(
			'labels'  => $labelFocus,
			'singular_label'  => __( 'Focus', ' projectimer-plugin' ),
			'public'  => true,
			//'show_ui' => true,
			'menu_icon' => WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . '/images/projectimer-focus-icon.png',
			'description' => 'Post type for Projectimer Plugin',
			'menu_position'   => 20,
			'can_export' => true,
			'hierarchical'    => false,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'cycle', 'with_front' => false ),
			'query_var'  => true,
			'taxonomies' => array('post_tag'),
			'supports'   => array( 'title', 'content', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' )
		);

		register_post_type("projectimer_focus", $postTypeFocusParams);
	}
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
