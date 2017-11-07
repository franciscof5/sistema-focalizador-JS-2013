<?php
/*Template Name: Inicio*/

/*Language files are loaded on header*/
?>
<?php if (is_user_logged_in()) {
		wp_redirect( home_url()."/focar" ); exit;
	} else {
		wp_redirect( home_url()."/blog" ); exit;
		} ?>
<?php get_header() ?>

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
	<? } else { <div id="content_inicio">*/?>
		
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
<?php get_footer() ?>