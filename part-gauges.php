<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php
function object_productivity ($user_id) {
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
	$SEMPRE['diasTrabalhados'] = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.$user_id.' GROUP BY DATE (`post_date`)');
	$SEMPRE['diasFolga'] = $SEMPRE['totalDias'] - $SEMPRE ['diasTrabalhados'];
	$SEMPRE['fatorProdutividade'] = round($SEMPRE['diasTrabalhados']/$SEMPRE['totalDias'], 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.$user_id.' AND post_date > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 7;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'];
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/$SETEDIAS['totalDias'], 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `wp_posts` WHERE `post_author` = ".$user_id." AND post_date > DATE_SUB(NOW(), INTERVAL ".$SEMANA['totalDias']." DAY) GROUP BY DATE (`post_date`)");
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
$produtividade_usuario = object_productivity($GLOBALS["alvo"]);
//echo "<script>alert('desenha gagues');</script>";

//var_dump($produtividade_usuario);

echo "<script type='text/javascript'>
	google.load('visualization', '1', {packages:['gauge']});
  	google.setOnLoadCallback(drawChart);
  	function drawChart() {
    var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['Sempre', ".($produtividade_usuario["sempre"]['fatorProdutividade']*100)."],
		['30 dias', ".($produtividade_usuario["trintadias"]['fatorProdutividade']*100)."],
		['Mes', ".($produtividade_usuario["mes"]['fatorProdutividade']*100)."],
		['7 dias', ".($produtividade_usuario["setedias"]['fatorProdutividade']*100)."],
		['Semana', ".($produtividade_usuario["semana"]['fatorProdutividade']*100)."],
	]);

    var options = {
     
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
<div id='chart_gauges_div'></div>

<div id="estats_box_div">
	<div class="estats_box">
		<h3>Desde sempre</h3>
		<ul>
			<li>Dias registrado:<strong>
				<?php
				echo $produtividade_usuario["sempre"]['totalDias'];
				?> </strong></li>
			<li>Dias trabalho:<strong>
				<?php
				//Dias de servidao cruel (dias de trabalho)
				echo $produtividade_usuario["sempre"]['diasTrabalhados']
				?>
			</strong></li>
			<li>Dias descanso:<strong>
				<?php
				//dias se sentindo culpado por nao trabalhar (dias sem trabalho)
				echo $produtividade_usuario["sempre"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["sempre"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
		<!--div id="chart_div" style="width: 900px; height: 500px;margin-top:200px;"-->
	</div>
	
	<div class="estats_box">
		<h3>Últimos 30 dias</h3>
		<ul>
			<li>Dias trabalho:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias descanso:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	
	<div class="estats_box">
		<h3>Mês atual</h3>
		<ul>
			<li>Dia atual:<strong>
				<?php
				echo $produtividade_usuario["mes"]['totalDias'];
				?>
			</strong></li>
			<li>Dias de trabalho:<strong>
				<?php
				echo $produtividade_usuario["mes"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias de descanso:<strong>
				<?php
				echo $produtividade_usuario["mes"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["mes"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<div class="estats_box">
		<h3>Últimos 7 dias</h3>
		<ul>
			<li>Dias trabalho:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias descanso:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<div class="estats_box">
		<h3>Semana atual</h3>
		<ul>
			<li>Dia atual:<strong>
				<?php
				echo $produtividade_usuario["semana"]['totalDias'];
				?>
			</strong></li>

			<li>Dias trabalho:<strong>
				<?php
				echo $produtividade_usuario["semana"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>Dias descanso:<strong>
				<?php
				echo $produtividade_usuario["semana"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["semana"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<hr style="clear:both;width:100%"></hr>
</div>