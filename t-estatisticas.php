<?php
/*Template Name: Estatisticas*/
?>
<?php get_header() ?>
<?php
//variaveis com dados
$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();

//variaveis assistentes
$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata(get_current_user_id( ))->user_registered)));
$now = time();
global $wpdb;
$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

//atribuindo valores
$SEMPRE['totalDias'] = floor($datediff/(60*60*24));
$SEMPRE['diasTrabalhados'] = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.get_current_user_id( ).' GROUP BY DATE (`post_date`)');
$SEMPRE['diasFolga'] = $SEMPRE['totalDias'] - $SEMPRE['diasTrabalhados'];
$SEMPRE['fatorProdutividade'] = round($SEMPRE['diasTrabalhados']/$SEMPRE['totalDias'], 2);

$TRINTADIAS['totalDias'] = 30;
$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.get_current_user_id( ).' AND post_date > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date`)');
$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

$MES['totalDias'] = date("j");
$MES['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".get_current_user_id( )." AND post_date > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date`)");
$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

$SETEDIAS['totalDias'] = 7;
$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".get_current_user_id( )." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date`)");;
$SETEDIAS['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'];
$SETEDIAS['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/$SETEDIAS['totalDias'], 2);

$startOfThisWeek = date('d', strtotime('this week'));
$SEMANA['totalDias'] = $MES['totalDias'] - $startOfThisWeek;
$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".get_current_user_id( )." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SEMANA['totalDias']." DAY) GROUP BY DATE (`post_date`)");
$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php
	echo "<script type='text/javascript'>
		google.load('visualization', '1', {packages:['gauge']});
      	google.setOnLoadCallback(drawChart);
      	function drawChart() {
        var data = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['Sempre', ".($SEMPRE['fatorProdutividade']*100)."],
			['30 dias', ".($TRINTADIAS['fatorProdutividade']*100)."],
			['Mes', ".($MES['fatorProdutividade']*100)."],
			['7 dias', ".($SETEDIAS['fatorProdutividade']*100)."],
			['Semana', ".($SEMANA['fatorProdutividade']*100)."],
		]);

        var options = {
          width: 900, height: 220,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          greenFrom:50, greenTo: 75,
          greyFrom:25, greyTo:50,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_gauges_div'));
        chart.draw(data, options);
      }

		</script>";
	?>
    <?php
	$week = date('W');
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

        	var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        	chart.draw(data, options);
        }</script>";
	?>
	<style type="text/css">
		.estats_box {
			width:180px; 
			/*border-radius:10px; */
			margin:10px;
			float:left;/*clear: both;*/
			/*background: #B1BEB1;
			background: #EEE;*/
			padding: 0 10px 10px 10px;*/
			/*border: 10px solid #DDD;*/
			background: #FFF;
		}
		.estats_box h3 {
			font-size: 14px;
			color: #000;
			font-weight: 600;
			text-align: center !important;
		}
		.estats_box li strong {float: right;}
		.estats_box li:nth-child(odd) {background: #EEE}
		/*.estats_box div {float:right;}
		.estats_box ul {float:left;}*/
	</style>

	<div style="background:#FFF;border-radius:10px; padding:40px;font-size:12px;margin:5px 0 40px 0;">
	<!--h2>Sobre voce</h2>
	<p>Estatísticas de <?php wp_get_current_user(); echo $current_user->user_firstname; ?></p>
	<p>Inicio da viagem no laborioso mundo de Pomodoros.com.br: <strong><?php echo date("d, F, Y", strtotime(get_userdata(get_current_user_id( ))->user_registered)); ?></strong></p-->
	<h1>Fator produtividade</h1>
	<p>Nos manter produtivos ao longo do tempo exige muito controle, com nossos exclusivos mostradores de produtividade, baseados em dias trabalhados, você recoloca seu projeto nos trilhos.</p>
	<p>Conta com cinco mostradores, cada um cobre um determinado período de tempo. Para aumentar todos os marcadores você precisa se manter sempre produtivo, os marcadores localizados mais a direita são os primeiros a sentir os efeitos. Para subir o primeiro marcador é necessário ser produtivo durante muitos dias.
	<div id='chart_gauges_div' style="padding:0 40px 0 20px;"></div>
	
	<div class="estats_box">
		<h3>Desde sempre</h3>
		<ul>
			<li>Dias desde o registro:<strong>
				<?php
				echo $SEMPRE['totalDias'];
				?> </strong></li>
			<li>Dias de trabalho:<strong>
				<?php
				//Dias de servidao cruel (dias de trabalho)
				echo $SEMPRE['diasTrabalhados']
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				//dias se sentindo culpado por nao trabalhar (dias sem trabalho)
				echo $SEMPRE['diasFolga'];
				?>
			</strong></li>
			<li>Fator produtividade:<strong>
				<?php
				echo $SEMPRE['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
		<!--div id="chart_div" style="width: 900px; height: 500px;margin-top:200px;"-->
	</div>
	
	<div class="estats_box">
		<h3>Últimos 30 dias</h3>
		<ul>
			<li>Dias de trabalho:<strong>
				<?php
				echo $TRINTADIAS['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				echo $TRINTADIAS['diasFolga'];
				?>
			</strong></li>
			<li>Fator produtividade:<strong>
				<?php
				echo $TRINTADIAS['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	
	<div class="estats_box">
		<h3>Mês atual</h3>
		<ul>
			<li>Dia atual:<strong>
				<?php
				echo $MES['totalDias'];
				?>
			</strong></li>
			<li>Dias de trabalho:<strong>
				<?php
				echo $MES['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				echo $MES['diasFolga'];
				?>
			</strong></li>
			<li>Fator produtividade:<strong>
				<?php
				echo $MES['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<div class="estats_box">
		<h3>Últimos 7 dias</h3>
		<ul>
			<li>Dias de trabalho:<strong>
				<?php
				echo $SETEDIAS['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				echo $SETEDIAS['diasFolga'];
				?>
			</strong></li>
			<li>Fator produtividade:<strong>
				<?php
				echo $SETEDIAS['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<div class="estats_box">
		<h3>Semana atual</h3>
		<ul>
			<li>Dia atual:<strong>
				<?php
				echo $SEMANA['totalDias'];
				?>
			</strong></li>

			<li>Dias de trabalho:<strong>
				<?php
				echo $SEMANA['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				echo $SEMANA['diasFolga'];
				?>
			</strong></li>
			<li>Fator produtividade:<strong>
				<?php
				echo $SEMANA['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	
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
	<hr style="clear:both;width:100%"></hr>
	</div><!-- #content -->
	
	<?php
	//echo do_shortcode('[contact-form-7 id="5140" title="Feedback"]');
	?>

	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
	
	
	<?php /*locate_template( array( 'sidebar.php' ), true ) */?>
<?php get_footer() ?>