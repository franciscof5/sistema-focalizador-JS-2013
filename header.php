<!DOCTYPE html>

	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

		<?php
		global $locale;
		if($locale=="pt_BR" || $locale=="pt")
			$apendix = "Brasil";
		else
			$apendix = "USA";
		?>
		<title>Pomodoros <?php echo $apendix;wp_title(); 
		#bp_page_title() ?></title>
		
		<?php do_action( 'bp_head' ) ?>
		
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_user() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
		
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />
		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<!--link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet' type='text/css'-->
		<?php wp_head(); ?>

		<meta name="viewport" content="width=device-width, user-scalable=no">
	</head>


<body <?php #body_class()  id="bp-default22" ?>>

<!--div id="audio"></div-->
<script type="text/javascript">
			jQuery().ready(function($) {
				/*$.each( "#header-content div span", function(index, value) {
					$(this).hide();
				});*/
				$( ".contem-icone " ).mouseenter(function() {
					$( ".icone-legenda" ).hide(100);
					if(!$(this).find( ".icone-legenda" ).is(":animated"))
					$(this).find( ".icone-legenda" ).show(400);
					/*$(this).*/
				});
				$( ".contem-icone" ).mouseout(function() {
					$( ".icone-legenda" ).hide(100);
				});
				/**/
				/*$("#settingsbutton").click(function(){
					$("#settingsbox").toggle();
				});
				$("#settingsbox").blur(function(){
				//$(document).click(function() {
					$("#settingsbox").hide();
				})*/
				
				/*$('html').click(function (e) {
				    if (e.target.id == 'settingsbutton') {
				        //do something
				        $("#settingsbox").toggle();
				    } else {
				        $("#settingsbox").hide();
				    }
				});*/
			});
		</script>

<span id='linha-fundo'></span>
<div id="" class="container-fluid content">

		<?php do_action( 'bp_before_header' ) ?>
		
		<?php /**/ ?>
		<nav class="navbar navbar-inverse ">
		  <div class="container-fluid">
		    <div class="navbar-header" style="margin-top: 5px">
		    
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#pomoNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="" title="Blog do Pomodoros" href="<?php bloginfo('url'); ?>">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" id="pomodoros-topo">
					</a>
		    </div>
		    <ul class="collapse navbar-collapse" style="margin-top: 5px"  id="pomoNavbar">
		      <?php if ( is_user_logged_in() ) { ?> 
		      <li>
		      	<div class="contem-icone ">
		      		<a title="Focar" href="<?php bloginfo('url'); ?>/focar/" alt="Focalizador">
		      			<div href="" id="icone-foc"><span class="icone-legenda hidden-lg"><script>document.write(txt_icon_focus)</script></span></div>
		      		<span class="hidden-sm hidden-md"><script>document.write(txt_icon_focus)</script></span>
		      		</a>
		      	</div>
		       </li>
		       <li>
		       	<div class="contem-icone ">
		       		<a title="Fator produtividade" href="<?php bloginfo('url'); ?>/colegas/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>">
		       			<div href="" id="icone-gauge">
		       				<span class="icone-legenda hidden-lg"><script>document.write(txt_icon_prod)</script></span>
		       			</div>
		       			<span class="hidden-sm hidden-md"><script>document.write(txt_icon_prod)</script></span>
		       		</a>
		       	</div>
		       </li>
		      <li>
		      	<div class="contem-icone ">
			      	<a title="Encontrar colegas" href="<?php bloginfo('url'); ?>/colegas/" alt="Amigos">
			      		<div href="" id="icone-amigo">
			      			<span class="icone-legenda hidden-lg"><script>document.write(txt_icon_col)</script></span>
			      		</div>
			      		<span class="hidden-sm hidden-md"><script>document.write(txt_icon_col)</script></span>
			      	</a>
			    </div>
		      </li>

		      <li>
		      	<div class="contem-icone">
		      	<a title="Ranking dos mais produtivos" href="<?php bloginfo('url'); ?>/ranking/">
		      		<div href="" id="icone-rank">
		      			<span class="icone-legenda hidden-lg"><script>document.write(txt_icon_rank)</script></span>
		      		</div>
		      		<span class="hidden-sm hidden-md"><script>document.write(txt_icon_rank)</script></span>
		      	</a>
		      	</div>
			  </li>

		      <li>
		      	<div class="contem-icone">
		      	<a title="Calendário de desempenho" href="<?php bloginfo('url'); ?>/calendar/">
		      		<div href="" id="icone-calend">
		      			<span class="icone-legenda hidden-lg"><script>document.write(txt_icon_cal)</script></span>
		      		</div>
		      		<span class="hidden-sm hidden-md"><script>document.write(txt_icon_cal)</script></span>
		      	</a>
		      	</div>
		      </li>
		     <?php } ?>
		    <ul class="nav navbar-nav navbar-right">
				
		      <?php if ( !is_user_logged_in() ) { ?> 
		      <li>
		      	<a title="Acessar sua conta" class="btn btn-link abrir_login" id="login_login" tabindex="1" style="padding-top: 10px;" /><script>document.write(txt_login);</script></a>
		      </li>
		      <li>
		      	<a href="/register" class="btn btn-link" role="button" aria-pressed="true" title="Criar uma conta Pomodoros.com.br" style="padding-top: 10px;" ><script>document.write(txt_register)</script></a>
		      </li>
		      <?php } else { ?> 
		      <!--li>
		      	<a title="Ver Blog" class="btn btn-link" href="/blog" style="padding-top: 10px;">Blog</a>
		      	</li-->
		      <!--li>
		      	<button title="Settings" id="settingsbutton" class="btn btn-link" href="/blog" style="padding-top: 10px;"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
		      </li-->
		      <li>
		      		<a title="My Account" id="settingsbutton" class="btn btn-link" href="<?php bloginfo('url'); ?>/minha-conta" style="padding-top: 10px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="hidden-sm hidden-md"><script>document.write(txt_myaccount)</script></span></a>
		      </li>
		      <li>
		      		<a title="Open Ticket" id="settingsbutton" class="btn btn-link" href="<?php bloginfo('url'); ?>/ticket" style="padding-top: 10px;"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <span class="hidden-sm hidden-md"><script>document.write(txt_support)</script></span></a>
		      </li>
		      <li>
		      	<a title="Desconectar-se" class="btn btn-link" href="<?php echo wp_logout_url(); ?>" style="padding-top: 10px;"><script>document.write(txt_logout)</script></a>
		      </li>
		      <?php } ?>
		    </ul>

		    </ul>
		  </div>		
		 
		</nav>
		<?php /**/ ?>

		<div id="loginlogbox">
			<?php wp_login_form(); ?>
			<div style="margin-top:-10px;">
				<?php do_action( 'wordpress_social_login' ); ?> 
				<div style="margin-top: -40px;">
					<?php do_action( 'bp_after_sidebar_login_form' ); ?>
				</div>
			</div>
		</div>
		
		<?php do_action( 'bp_header' ) ?>


		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>



	<div class="row">