<?php
/*Template Name: Produtividade (productivity) */
?>
<?php get_header() ?>

<?php
/*$week = date('W');
$year = date('Y');
$query = new WP_Query( 'year=' . $year . '&w=' . $week );
echo " <script type='text/javascript'> 
		google.load('visualization', '1', {packages:['corechart']});
  		google.setOnLoadCallback(drawChart);

  
		function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', '2012', '2013'],
          ['1 trim',  1000,      400],
          ['2 trim',  1170,      460],
          ['3 trim',  660,       1120],
          ['4 trim',  1030,      540]
        ]);

        var options = {
          title: 'Pomodoros/dia',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

    	var chart = new google.visualizat	ion.AreaChart(document.getElementById('chart_div'));
    	chart.draw(data, options);
    }</script>";*/
?>

	<div class="content_nosidebar">
	<!--h2>Sobre voce</h2>
	<p>Estatísticas de <?php wp_get_current_user(); echo $current_user->user_firstname; ?></p>
	<p>Inicio da viagem no laborioso mundo de Pomodoros.com.br: <strong><?php echo date("d, F, Y", strtotime(get_userdata(get_current_user_id( ))->user_registered)); ?></strong></p-->
	<h1>Fator prod.</h1>
	<p>Nos manter produtivos ao longo do tempo exige muito controle, com nossos exclusivos mostradores de produtividade, baseados em dias trabalhados, você recoloca seu projeto nos trilhos.</p>
	<p>Conta com cinco mostradores, cada um cobre um determinado período de tempo. Para aumentar todos os marcadores você precisa se manter sempre produtivo, os marcadores localizados mais a direita são os primeiros a sentir os efeitos. Para subir o primeiro marcador é necessário ser produtivo durante muitos dias.
	
	<?php
	$usuario_alvo = get_current_user_id();
	get_template_part("part", "gauges"); 
	?>
	
	<!--
	Tabela com o fator produtividade por mes, desde sempre
	 -->
	<!--h3>Media de pomodoros/dia</h3>
	<ul>
		<li>Hoje:<strong></strong></li>
		<li>Ultima semana:<strong></strong></li>
		<li>Ultimo mes:<strong></strong></li>
		<li>Ultimo ano:<strong></strong></li>
		<li>Desde o comeco:<strong></strong></li>
	</ul>
	<h2>Comunidade</h2>
			Pomodoros/dia
			-Hoje
			-Ultima semana
			-Ultimo mes
			-Ultimo ano
			-Desde o comeco
	
	<div id="chart_div" style="width: 900px; height: 500px;"></div-->
	
	</div><!-- #content -->
	
	<?php
	//echo do_shortcode('[contact-form-7 id="5140" title="Feedback"]');
	?>

	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
	
	
	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
<?php get_footer() ?>