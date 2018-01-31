<div id="content" class="content_default  col-xs-12">
<div class="padder">
<h1>Exportar CSV</h1>
Tenha mais controle sobre seus dados e de seus funcionários, visualize as informações onde está acostumado, assim é possível por exemplo utilizar o Microsoft Excel ou o OpenOffice Calc.

<?php 
if(function_exists('revert_database_schema'))revert_database_schema();
echo do_shortcode('[wpcsv_export_form]'); ?>

Aviso: futuramente será possível importar pomodoros.
</div>
</div>