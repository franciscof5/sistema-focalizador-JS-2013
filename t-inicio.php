<?php
/*Template Name: Inicio*/

/*Language files are loaded on header*/
?>

	<div id="content" class="content_default  col-xs-12 col-sm-9">
	
		<div class="padder">
		<?php if(is_home()) { ?>
			<div id="blog-welcome">
			<h3 style="font-family: Forte;">Blog do pomodoros</h3>
			
			<p>Novidades e histórico do projeto, no ar desde 2010.</p>
			
			<?php if(is_user_logged_in()) { ?>
				<?php $current_user = wp_get_current_user(); ?>
				<?php 
				/*$recent = get_posts(array(
				    'author'=>$current_user->ID,
				    'post_type'=>'projectimer_focus',
				    'post_statys' => 'draft',
				    #'orderby'=>'date',
				    #'order'=>'desc',
				    'numberposts'=>1
				));*/
				$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),
		              //'orderby'   => 'title',
		              //'order'     => 'ASC',
		              'posts_per_page' => 1,
		            );
				$recent = get_posts($args); #new WP_Query( $args );
				#var_dump($post);die;
				if( $recent ){
				  $title = ", sua tarefa mais recente é <i>".get_the_title($recent[0]->ID)."</i>";
				}else{
				  $title = ", você ainda não começou nenhuma tarefa"; //No published posts
				} ?>
				
				<?php /*-<p>Olá <?php echo $current_user->display_name.$title; ?>, <a href="/focar">acessar aplicativo online e focar</a>.</p>*/ 
				$msg_saudacao = "Olá ".$current_user->display_name." ".$title.", <a href=/focar>acessar aplicativo online e focar</a>";
				#$msg_saudacao = "OLA";
				#$msg_saudacao2="";
				
				?>
			<?php } else {
				$msg_saudacao = "Caro visitante, <a href=/register>crie sua conta GRÁTIS</a> para acessar o aplicativo online";
				$msg_saudacao2 = "Se já possui um usuário, <a id=testes href=# class=abrir_login>acesse sua conta</a>";
			} 
			
			echo "<script type='text/javascript'>alertify.log('".$msg_saudacao."');</script>";
			if(isset($msg_saudacao2))
			echo "<script type='text/javascript'>alertify.log('".$msg_saudacao2."');</script>";
			
			?>
			</div>
			<hr />
		<?php } ?>
		
		<?php do_action( 'bp_before_blog_home' ) ?>

		<div class="page" id="blog-latest">

			<?php if ( have_posts() ) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ) ?>

					<div class="post" id="post-<?php the_ID(); ?>">

				    <?php if(function_exists('set_shared_database_schema')) {
			       			set_shared_database_schema();
			       			#NEED TO SHARE TO SHOW POST CORRECTLY
			       		}
				        /*$post_thumbnail_id = get_post_thumbnail_id();
				        $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
				        ?>
				        <div class="post-image">
				            <img title="image title" alt="thumb image" class="wp-post-image" src="<?php echo $post_thumbnail_url; ?>" style="width:100%; height:auto;">
				        </div>

						<?php  #if ( has_post_thumbnail() ) : */ ?>
							<div style="background: #222;width: 100%;">
							<center>
						    <a style="margin:0 auto;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						       <?php 
						       #add_filter( 'upload_dir', 'shared_upload_dir' );
						       #var_dump(the_post_thumbnail('full'));
						       if ( has_post_thumbnail() ) {
						       		
									the_post_thumbnail( array(500,200) );
								}
						       #echo get_the_ID();
						       #var_dump(the_post_thumbnail(get_the_ID(), 'full')); 
						       ?>
						    </a>
						    </center>
						    </div>
						<?php #endif;  ?>
						<div class="author-box">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '60' ); ?>
							<?php
							#<p> 
							#printf( __( 'Por %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) )
							#printf( bp_core_get_userlink( $post->post_author ) );
							#</p>
							?>
						</div>

						<div class="post-content">
							<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<p class="date"><?php the_time("j \d\\e F \d\\e Y") ?> <em><?php #_e( 'em', 'buddypress' ) ?> <?php #the_category(', ') ?> <?php #printf( __( 'por %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></em></p>

							<div class="entry">
								<?php 
								if(!is_single())
								the_excerpt("... continuar lendo.");
								else
								the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							</div>

							<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ) ?>

				<?php endwhile; ?>

				<div class="navigation">

					<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
					<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>

				</div>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

				<?php locate_template( array( 'searchform.php' ), true ) ?>

			<?php endif; ?>
		</div>

		<?php do_action( 'bp_after_blog_home' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 's-blog.php' ), true ) ?>


<?php /*if (is_user_logged_in()) {
		wp_redirect( home_url()."/focar" ); exit;
	} else {
		wp_redirect( home_url()."/blog" ); exit;
		}*/ ?>
<?php #get_header() ?>

<?php 
//It was used for an old incorrect way to develop
/*if ( current_user_can( 'manage_options' ) ) { ?>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/pomodoro-functions-admin.js" type="text/javascript"></script>
<?php } else { ?>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/pomodoro-functions.js" type="text/javascript"></script>
<?php } */ ?>



		<!--Template-->
		<?php /*get_sidebar(); ?>
	
		<?php //locate_template( array( 's-pomodoros.php' ), true ); ?>
		<div class="content_pomodoro">
			<?php locate_template( array( 'pomodoro/pomodoros-painel.php' ), true ); ?>
		</div><!-- #content -->
	<? } else { <div id="content_inicio">*?>
		
			<div class="circulo col-xs-3" id="">
				<h3>Pomodoros.com.br</h3>
				<img />
				<p>Rede social de produtividade, para pessoas e equipes compartilharem seus projeto e estudos com colegas.</p>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Como funciona</h3>
				<img />
				<p>Escreva a tarefa que precisa fazer e inicie o cronômetro, você deve focar na sua tarefa sem distrações.</p>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Técnica dos Pomod.</h3>
				<img />
				<p>São 25 minutos focando na tarefa e 5 minutos de descanso, formando um ciclo. Após 4 ciclos tem um intervalo de 20 minutos.</p>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Origem</h3>
				<img />
				<p>Criada pelo italiano Francesco Cerello, na década de 80, para estudar para provas. Usava um relógio em forma de tomate, para tempo de pizza.</p>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Benefícios</h3>
				<img />
				<ul>
					<li>Ajuda a cumprir prazos</li>
					<li>Mais foco e produtividade</li>
					<li>Controle sobre demandas</li>
					<li>Diminui ansiedade</li>
				</ul>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Funcionalidade</h3>
				<img />
				<ul>
					<li>Calendário de pomodoros</li>
					<li>Prêmios para os melhores</li>
					<li>Salvar pomodoro para depois</li>
					<li>Seus pomodoros nas nuvens</li>
					<li>Pomodoros por projetos</li>
				</ul>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Rede social</h3>
				<img />
				<p>Estudar sozinho nunca mais! Encontre seus colegas de trabalho, escola e faculdade, compartilhe e comente suas tarefas.</p>
			</div>
			<div class="circulo col-xs-3" id="">
				<h3>Brasil</h3>
				<img />
				<p>Tecnologia nacional, desenvolvida por empresa brasileira.</p>
			</div>
			<?php
				/*
				$my_id = 3096;
				
				$post_id = get_post($my_id); 
				$title = $post_id->post_title;
				$content = $post_id->post_content;
				_e("<h1>".$title."</h1>");
				_e($content);
				echo '<h2>Teste</h2>';
				*/
			?> 
			
		
	<?php // </div><!-- #content -->} ?>
	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
	
	
	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
<?php #get_footer() ?>