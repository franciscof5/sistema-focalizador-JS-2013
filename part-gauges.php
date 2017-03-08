<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php

$produtividade_usuario = user_object_productivity(bp_displayed_user_id());
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
				echo $produtividade_usuario["sempre"]['diasTrabalhados'];
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