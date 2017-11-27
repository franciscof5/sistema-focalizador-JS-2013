<!DOCTYPE html <?php language_attributes(); ?>>

<!--html xmlns="http://www.w3.org/1999/xhtml"-->
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php the_title(); #bp_page_title() ?></title>
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
		<link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet' type='text/css'>
		<?php wp_head(); ?>
	<link href="<?php echo bloginfo('stylesheet_directory'); ?>/_inc/select2/select2.css" rel="stylesheet"/>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css" />
	<!--[if lt IE 9]>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.ie.min.css" />
	<![endif]-->


	<!--link href="<?php echo bloginfo('stylesheet_directory'); ?>/assets/bootstrap.min.css" rel="stylesheet"/>
	<script type="text/javascript" src="<?php echo bloginfo('stylesheet_directory'); ?>/assets/bootstrap.min.js"></script-->

	<meta name="viewport" content="width=device-width, user-scalable=no">
</head>

<?php if (function_exists('mbj_notify_bar_display')) { mbj_notify_bar_display(); }?>
<?php if (function_exists("activate_maintenance_mode")) { activate_maintenance_mode();} ?>

<body <?php #body_class() ?> id="bp-default22">

<script type="text/javascript">
	var noSleep = new NoSleep();

	function enableNoSleep() {
			noSleep.enable();
	document.removeEventListener('touchstart', enableNoSleep, false);
	}

	// Enable wake lock.
	// (must be wrapped in a user input event handler e.g. a mouse or touch handler)
	document.addEventListener('touchstart', enableNoSleep, false);

	// ...

	// Disable wake lock at some point in the future.
	// (does not need to be wrapped in any user input event handler)
	noSleep.disable();
</script>
<span id='linha-fundo'></span>
<div id="wrapper" class="container-fluid content">

		<?php do_action( 'bp_before_header' ) ?>
		
			<!--span id='linha-fundo<?php if (is_front_page()) echo "-home" ?>'></span-->
			
		<?php //} ?>
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
			});
		</script>
		<nav class="navbar navbar-inverse ">
		  <div class="container-fluid">
		    <div class="navbar-header" style="margin-top: 5px">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#pomoNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="" title="Pomodoros.com.br" href="<?php bloginfo('url'); ?>">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" id="pomodoros-topo">
					</a>
		    </div>
		    <ul class="collapse navbar-collapse" style="margin-top: 5px"  id="pomoNavbar">
		      <?php if ( is_user_logged_in() ) { ?> 
		      <li>
		      	<div class="contem-icone ">
		      		<a title="Focar" href="<?php bloginfo('url'); ?>/focar/" alt="Focalizador">
		      			<div href="" id="icone-foc"><span class="icone-legenda hidden-lg">Focar</span></div>
		      		
		      		<span class="hidden-sm hidden-md">Focar</span>
		      		</a>
		      	</div>
		       </li>

		       <li>
		       	<div class="contem-icone ">
		       		<a title="Fator produtividade" href="<?php bloginfo('url'); ?>/colegas/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>">
		       		
		       			<div href="" id="icone-gauge">
		       				<span class="icone-legenda hidden-lg">Produtividade</span>
		       			</div>
		       			
		       		
		       			<span class="hidden-sm hidden-md">Produtividade</span>
		       		</a>
		       	</div>
		       </li>

		     
		      <li>
		      	<div class="contem-icone ">
			      	<a title="Encontrar colegas" href="<?php bloginfo('url'); ?>/colegas/" alt="Amigos">
			      		<div href="" id="icone-amigo">
			      			<span class="icone-legenda hidden-lg">Colegas</span>
			      		</div>
			      		
			      		<span class="hidden-sm hidden-md">Colegas</span>
			      		
			      		
			      	</a>
			    </div>
		      </li>

		      <li>
		      	<div class="contem-icone">
		      	<a title="Ranking dos mais produtivos" href="<?php bloginfo('url'); ?>/ranking/">
		      		<div href="" id="icone-rank">
		      			<span class="icone-legenda hidden-lg">Ranking</span>
		      		</div>
		      		
		      		<span class="hidden-sm hidden-md">Ranking</span>
		      	</a>
		      	</div>
			  </li>

		      <li>
		      	<div class="contem-icone">
		      	<a title="Calendário de desempenho" href="<?php bloginfo('url'); ?>/calendar/">
		      		<div href="" id="icone-calend">
		      			<span class="icone-legenda hidden-lg">Calendário</span>
		      		</div>
		      		
		      		
		      		<span class="hidden-sm hidden-md">Calendário</span>
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
		      <li>
		      	<a title="Ver Blog" class="btn btn-link" href="/blog" style="padding-top: 10px;">Blog</a>
		      	</li>
		      <li>

		      	<a title="Desconectar-se" class="btn btn-link" href="<?php echo wp_logout_url(); ?>" style="padding-top: 10px;"><script>document.write(txt_logout)</script></a>

		      </li>
		      <?php } ?>
		    </ul>

		    </ul>
		  </div>		
		 
		</nav>
		

		<div id="loginlogbox">
			<?php wp_login_form(); ?>
			<div style="margin-top:-10px;">
				<?php do_action( 'bp_after_sidebar_login_form' ); ?>
			</div>
		</div>
		<?php /*
		<!--div id="settingsbox">
			BOTAO FECHAR
			<!--h3>Tempo do pomodoro:</h3>
			<sub>Recomendamos aos usuários não mudarem o tempo dos pomodoros, se esforce para se adaptar aos 25 minutos que vale a pena</sub-->
			<p>Você pode utilizar nossos sitema para medir o tempo de diversas maneiras, mas lembre-se, para participar dos sorteios de prêmios é preciso usar a configuraćão oficial</p>
			<p>VOLUME: </p>
			<h3>Tipo de relógio</h3>
			<p>Técnica dos Pomodoros - Configuraćões oficiais [participa em sorteios]</p>
			<p>Técnica dos Pomodoros - ConfiguraćÕes do usuário</p>
			<div>
				<form>
				Tempo do pomodoro:
				Tempo do descanso:
				Intervalo entre pomodoros:
				checkbox - Declaro que não participarei dos sorteios
				</form>
			</div>
			<p>Crônometro convencional com intervalo regressivo</p>
			<p>Crônometro convencional sem intervalo</p>
			<h3>Marcador de ponto</h3>
			<p>Ativar marcador de entrada e saída de expediente?</p>
		</div-->*/
		?>
		
		<?php do_action( 'bp_header' ) ?>


		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>



	<div class="row">