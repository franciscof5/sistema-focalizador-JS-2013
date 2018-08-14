<?php get_header(); ?>

<?php get_sidebar(); ?>

<div class="content_pomodoro col-xs-12 col-sm-6">
		
	<div id="pomodoro-painel">		
			
		<div id="pomodoro-relogio">							
		<form><input type="button" value="loading..." id="action_button_id" tabindex="1" disabled="disabled" /></form>

		<div id="relogio">

			<div id="back">
			<div id="upperHalfBack">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
				<img id="minutesUpLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" class="asd" /><img id="minutesUpRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
				<img id="secondsUpLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="secondsUpRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
			</div>
			<div id="lowerHalfBack">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
				<img id="minutesDownLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="minutesDownRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
				<img id="secondsDownLeftBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="secondsDownRightBack" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
			</div>
			</div>
			<div id="front">
			<div id="upperHalf">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
				<img id="minutesUpLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="minutesUpRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
				<img id="secondsUpLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Left/0.png" /><img id="secondsUpRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Up/Right/0.png"/>
			</div>
			<div id="lowerHalf">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/spacer.png" />
				<img id="minutesDownLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="minutesDownRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
				<img id="secondsDownLeft" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Left/0.png" /><img id="secondsDownRight" src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/Double/Down/Right/0.png" />
			</div>
			</div>
		</div><!--fecha relogio-->
		
		<input type="text" disabled="disabled" id="secondsRemaining_box">
		
		<ul id="pomolist">
			<li class="pomoindi" id="pomoindi1">&nbsp;</li>		
			<li class="pomoindi" id="pomoindi2">&nbsp;</li>
			<li class="pomoindi" id="pomoindi3">&nbsp;</li>
			<li class="pomoindi" id="pomoindi4">&nbsp;</li>
		</ul>
		
		<button onclick="reset_pomodoro_session()" style="margin: 8px 0 0 12px;padding: 0 2px;"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
		<button onclick="set_continuous_session()" style="margin: 8px 0 0 4px;padding: 0 2px;" id="resetter_btn"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
		</div><!--fecha pomodoros painel-->
		<br />
		
		<div id="div_status"><script>document.write(txt_mat_introducing)</script></div>
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/mascote_foca.png" />
		<br />
		<br />
		

		<form name="pomopainel" id="pomopainel">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-4">
						<label><span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> Volume</label><br />
					</div>
					<div class="col-xs-4">
                        <div class="material-switch pull-right" style="float: right;">
                            <input id="sound-switcher" name="someSwitchOption001" type="checkbox" checked="checked" />
                            <label for="sound-switcher" class="label-success"></label>
                        </div>
                        <label style="float:right"><!--span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span--> FX &nbsp; </label>
					</div>
					<div class="col-xs-4">
                        <div class="material-switch pull-right" style="float: right;">
                            <input id="voice-switcher" name="someSwitchOption001" type="checkbox" checked="checked" />
                            <label for="voice-switcher" class="label-success"></label>
                        </div>
                        <label style="float:right"><!--span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span--> Voice &nbsp; </label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-1">
						<span class="glyphicon glyphicon-volume-off" aria-hidden="true"></span>
					</div>
					<div class="col-xs-9">
						<input type="range" id="rangeVolume">
					</div>
					<div class="col-xs-1">
						<span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
					</div>
				</div>			
			</div>
			
		 	<div class="form-group">
				<label><span class="glyphicon glyphicon-paste" aria-hidden="true"></span> <script>document.write(txt_write_task_title)</script></label><br />
				<input type="text" id="title_box" maxlength="70" tabindex="2" name="ti33" class="form-control">
				</input>
			</div>
			<div class="form-group">
				<label><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> <script>document.write(txt_write_task_tags)</script></label>
				<select id="tags_box" class="js-example-tags " tabindex="3" multiple="multiple" placeholder="Does not work, use data-placeholder with js trick"  data-placeholder="projeto1, projeto2"></select>
			</div>
			<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><strong>EXTRA</strong></button>
			<div class="collapse" id="collapseExample">
  				<div class="well">
					
					<div class="form-group">
						<label><span class="glyphicon glyphicon-text-background" aria-hidden="true"></span> <script>document.write(txt_write_task_desc)</script></label>
						<textarea rows="4" cols="34" id="description_box" tabindex="4" class="form-control"></textarea>
					</div>
					
					<input type="hidden" id="data_box">
					<input type="hidden" id="status_box">
					<input type="hidden" id="post_id_box">
					<input type="hidden" id="pomodoroAtivoBox" value='<?php echo get_user_meta(get_current_user_id(), "pomodoroAtivo", true); ?>'>
					
					<br />
					<label><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> <script>document.write(txt_write_task_category)</script></label><br />
					<ul>
						<li><input type="radio" name="cat_vl" value="26"><script>document.write(txt_write_task_category_study)</script></li>
						<li><input type="radio" name="cat_vl" value="27"><script>document.write(txt_write_task_category_work)</script></li>
						<li><input type="radio" name="cat_vl" value="28"><script>document.write(txt_write_task_category_personal)</script></li>
					</ul>
					<label><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <script>document.write(txt_write_task_privacy)</script></label><br />
					<ul>
						<li><input type="radio" name="priv_vl" value="publish" CHECKED><script>document.write(txt_write_task_privacy_pub)</script></li>
						<li><input type="radio" name="priv_vl" value="private" ><script>document.write(txt_write_task_privacy_pri)</script></li>
					</ul>
				</div>
			</div>
			<a href="#" class="button btn btn-dark" id="botao-salvar-modelo"> <script>document.write(txt_write_task_save)</script> </a>
		</form>

		

		<style>
			/*ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
			li { margin: 5px; padding: 5px; width: 150px; }*/
		</style>
		<script>
			jQuery( function() {
				
				jQuery( "#contem-ciclo" ).droppable({
			        /*activeClass: "ui-state-default",
			        hoverClass: "ui-state-hover",
			        drop: function(event, ui) {
			            var newClone = $(ui.helper).clone();
			            $(this).after(newClone);
			            $(this).height($(this).height+20);
			        }*/
			    });
				/*jQuery( ".sidebar li" ).sortable({});*/
				jQuery( "#contem-ciclo" ).sortable({
				  revert: true,
				  	over: function() {
				      removeIntent = false;
				    }, //Remove function
				    out: function() {
				      removeIntent = true;
				    },
				    beforeStop: function(event, ui) {
				      if (removeIntent == true) {
				        ui.item.remove();
				      }
					}
				});

				jQuery( "#contem-modelos li" ).draggable({
					connectToSortable: "#contem-ciclo",
					snap: "#contem-ciclo",
					snapMode: "outer",
					helper: "clone",
					revert: "invalid",
					cursor: "move",
				});
				jQuery( "ul, li" ).disableSelection();
			});
		</script>
		<h3 class="widget-title"><script>document.write("Automatic cycle")</script></h3>
		<ul id="contem-ciclo" style="">
			<li>Drop tasks here</li>
  			<!--li id="draggable" class="ui-state-highlight">Drag me down</li-->
		</ul>
		<h3 class="widget-title"><script>document.write(txt_write_task_model)</script></h3>
		<!--p><script>document.write(txt_write_task_model_desc)</script></p-->
		
		<!--p><button style="float: right; margin-top: -14px;" onclick="alert('teste');"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button></p-->

		
		<ul id="contem-modelos" class="row">
			<?php
			if(function_exists("revert_database_schema"))revert_database_schema();

			$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'pending',
		              'author'   => get_current_user_id(),
		              //'orderby'   => 'title',
		              'order'     => 'ASC',
		              'posts_per_page' => -1,
		            );
			$the_query = new WP_Query( $args );
			
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$counter = $post->ID;
				#echo '<li id="modelo-carregado-'.$counter.'" class="row">';
				echo '<li id="modelo-carregado-'.$counter.'">';
				$taglist = "";
				$posttags = get_the_tags();
				  if ($posttags) {
				    foreach($posttags as $tag) {
				    	$taglist.="'".$tag->slug."', ";
				    }
				}
				?>
				
				<!--div class='col-xs-10'-->
				<div style="width: 90%;float: left;" class="model-container" data-modelid="<?php echo $counter ?>">
				<?php 
					echo "<strong id=bxtag$counter>".$taglist."</strong>";
					echo "<span id=bxtitle$counter>".get_the_title()."</span>";
					echo "<p><span id=bxcontent$counter>".get_the_content()."</span></p>"; ?>
				</div>
				<!--a href="#" onclick='load_model(<?php echo $counter ?>)'>
				LO
				</a-->
				<!--div class='col-xs-2'-->
				<div class="delete-task-model" style="float: right;">
					<a href='#' class='btn btn-xs btn-danger delete-task-model-btn' data-modelid="<?php echo $counter ?>"><span class="glyphicon glyphicon-trash"></span></a>
					<?php 
					#onclick='delete_model(<?php echo $counter ?)' 
					#echo "<input type='button' class='btn btn-xs btn-primary' value='carregar' onclick='load_model($counter)'><br /> <br /><input type='button' class='btn btn-xs btn-success' value='concluir' onclick='delete_model($counter)'>"; ?>
				</div>
				
				</li>
				
			<?php 
			endwhile;
			// Reset Post Data
			wp_reset_postdata();
			?>
		</ul>
		<div class="row"></div>
	</div>
	
</div><!-- #content -->
<?php locate_template( array( 's-pomodoros.php' ), true ); ?>

<?php get_footer(); ?>