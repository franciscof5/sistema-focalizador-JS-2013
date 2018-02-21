//BEFORE START CODE CHECK OUT README.MD OR GITHUB FOR FULL DOCUMENTATION

//SYSTEM VARS
{
	var pomodoros_to_big_rest=4;

	var pomodoroTime = 1500;
	var restTime = 300;
	var bigRestTime = 1800;
	var intervalMiliseconds = 1000;

	//for testing
	//pomodoroTime = 15;restTime = 30;bigRestTime = 180;intervalMiliseconds = 10;

	//Dynamic clock var
	//var is_interrupt_button;
	var m1;
	var m2;
	var m3;
	var m4;
	var m1_current = 9;
	var m2_current = 9;
	var s1_current = 9;
	var s2_current= 9;

	//Pomodoro session control vars
	var pomodoro_actual = 1;
	var is_pomodoro = true; //is_pomodoros is when using timer for focusing (otherwise ir resting)
	var secondsRemaining = 0;//pomodoroTime;
	var interval_clock=false;

	//
	var noSleep;
	var artyom_voice;
	var stopWarningNoTaskFound=false;
	var soundManager;
	var volumeLevel;
	var pomodoro_completed_sound;
	var active_sound;
	var session_reseted_sound;

}
function startTest() {
	pomodoroTime = 15;restTime = 30;bigRestTime = 180;intervalMiliseconds = 10;
}
//With that line jQuery can use the selector ($) and jQuery use the selector (jQuery), without conflict
//jQuery.noConflict();

//jQuery.getScript("projectimer-pomodoros-shared-parts.js");

jQuery(document).ready(function ($) {
	//
	jQuery('input[type="range"]').rangeslider();
	//Voice recon and speech JS
	startContinuousArtyom();
	//
	startNoSleepWakeLock();
	//Sound library for Sound FX 
	startSoundMan();
	//
	change_status(txt_loading_initial_data);	
	load_initial_data();//
	secondsRemaining = pomodoroTime;
	convertSeconds(secondsRemaining);
	flip_number(true);
	
	//listen to changes
	jQuery("#title_box, #description_box, #tags_box, #rangeVolume").change(function() {
		change_status(txt_update_current_task);
		//update_pomodoro_clipboard();
	});
	
	//
	jQuery("#action_button_id").val(textPomodoro);
	jQuery("#action_button_id").prop('disabled', false);

	//
	
	//Check updates on task every 15s (if not on focus)
	listen_changes_on_task_form = setInterval(function() {
		if(!jQuery("#title_box").is(":focus") && !jQuery("#tags_box").data('select2').isOpen() && !jQuery("#description_box").is(":focus"))
		load_initial_data();
	},15000);
});

function load_initial_data() {
	var data = {
		action: 'load_session',
		//dataType: "json"
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";

		if(response==0 && !stopWarningNoTaskFound) {
			//alertify.error("Tarefa não encontrada");
			change_status(txt_no_task_found);

			jQuery('#tags_box').select2({
				tags: true,
				//closeOnSelect: false,
				//maximumSelectionLength: 3,
				//createSearchChoice: true,
				width: '100%',
				tokenSeparators: [","],
				placeholder: function() {
					jQuery(this).data('placeholder');
				}
			});
			stopWarningNoTaskFound=true;
		} else {
			var postReturned = jQuery.parseJSON( response.slice( 0, - 1 ) );
			
			//alert(postReturned['ID']);
			title_box.value = postReturned['post_title'];
			tags_box.value  = postReturned['post_tags'];
			description_box.value = postReturned['post_content'];
			data_box.value = postReturned['post_data'];
			status_box.value = postReturned['post_status'];
			post_id_box.value = postReturned['ID'];
			secundosRemainingFromPHP = postReturned['secs'];
			//tags_total = postReturned['tags_total'];

			//COPY
			tags = postReturned['post_tags'];

			//alert(jQuery('#tags_box').select2());
			jQuery('#tags_box').empty();
			if(tags) {
				//
				jQuery('#tags_box').append('<optgroup label="'+txt_in_use+'">');
				jQuery.each(tags, function(i) {
					text_variable = tags[i];
					jQuery('#tags_box').append( '<option value="'+text_variable+'" selected=selected>'+text_variable+'</option>' );
				});
				jQuery('#tags_box').append('</optgroup>');
			}

			tags_list = postReturned['tags_total'];
			//alert(tags_list);
			if(tags_list) {
				jQuery('#tags_box').append('<optgroup label="'+txt_available+'">');
				jQuery.each(tags_list, function(i) {
					text_variable = tags_list[i];
					jQuery('#tags_box').append( '<option value="'+text_variable+'">'+text_variable+'</option>' );
				});
				jQuery('#tags_box').append('</optgroup>');
			}
			jQuery('#tags_box').select2({
				tags: true,
				//closeOnSelect: false,
				//maximumSelectionLength: 3,
				//createSearchChoice: true,
				width: '100%',
				tokenSeparators: [","],
				placeholder: function() {
					jQuery(this).data('placeholder');
				}
			});
			//change_status(secundosRemainingFromPHP);
			//alert(secundosRemainingFromPHP);
			//secundosRemainingFromPHP = secundosRemainingFromPHP.substring(rex[5], str.length - 1);
			
			
			/*if(secundosRemainingFromPHP<0) {
				//alertify.log("time lost");
				secundosRemainingFromPHP*=-1;
			}
			//alert(status_box.value);
			if(status_box.value=="draft") {//era pending
				//alert("secundosRemainingFromPHP"+secundosRemainingFromPHP+" pomodoroTime:"+pomodoroTime);
				if(secundosRemainingFromPHP) {
					//pomodoroTime = 18000;
					//alert("1111"+secundosRemainingFromPHP+" pt:"+pomodoroTime);
					if(secundosRemainingFromPHP>pomodoroTime) {
						secondsRemaining = pomodoroTime;
						delete_model(postReturned['ID']);
						change_status(txt_time_losted + Math.round(((secundosRemainingFromPHP/60)/60)) + txt_hours_ago);	
					} else {
						secondsRemaining = pomodoroTime-secundosRemainingFromPHP;
						//alert(secondsRemaining + " d " + pomodoroTime);
						//alert("1111"+secundosRemainingFromPHP+" pt:"+pomodoroTime);
						//change_status(txt_time_found + Math.round(secundosRemainingFromPHP/60) + txt_minutes);
						
						//alert(secondsRemaining);
						//if(!interval_clock)
						//start_clock();
					}
					//alert(secondsRemaining);
				}
			} else if (status_box.value=="draft") {
				//secondsRemaining = pomodoroTime;

				//change_status(txt_mat_load_return +  Math.round(((secundosRemainingFromPHP/60)/60)) + " h");	
				//change_status("...");	
			}*/
			//document.getElementById("secondsRemaining_box").value=secondsRemaining + "s";
			//
			volumeLevel=postReturned['range_volume'];
			jQuery("#rangeVolume").val(volumeLevel);
			soundManager.setVolume(volumeLevel);
			pomodoro_completed_sound.setVolume(volumeLevel);
			active_sound.setVolume(volumeLevel);
			session_reseted_sound.setVolume(volumeLevel);
			//alert(volumeLevel);
			//if(volumeLevel>1)
				//startContinuousArtyom();
			if(artyom_voice!=undefined && volumeLevel>1 )
				artyom_voice.initialize({volume:volumeLevel/100});
			//artyom_voice.volume = volumeLevel/100;
		}
		//Functions to make the effect of flip on countdown_clock
		//change_status(response);
		//alert(secundosRemainingFromPHP);
		//secondsRemaining -= secundosRemainingFromPHP;
	});
	/*if(secondsRemaining==0)
	secondsRemaining = pomodoroTime;
	convertSeconds(secondsRemaining);
	flip_number(true);*/
	//se tiver um pomodoro rolando não pode alterar a data do rascunho
	/*if(secondsRemaining!=pomodoroTime) {
		alert("POMODORO ROLANDO"+secondsRemaining);
	}*/
	//alert(secundosRemainingFromPHP);
}

function update_pomodoro_clipboard (post_stts) {
	var postcat=getRadioCheckedValue("cat_vl");
	var privornot=getRadioCheckedValue("priv_vl");
	var data = {
		action: 'update_session',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		//post_tags: tags_box.value,
		post_tags: jQuery('#tags_box').val(),
		post_cat: postcat,
		//post_id: post_id_box.value,
		//post_data: data_box.value,
		post_priv: privornot,
		range_volume: jQuery('#rangeVolume').val(),
	};
	
	if(interval_clock) {
		//alert(interval_clock);
		data["ignora_data"]=true;
	}
	
	if(post_stts) {
		//data["post_status"] = post_stts;
	} 
	

	volumeLevel = jQuery("#rangeVolume").val();
	soundManager.setVolume(volumeLevel);
	pomodoro_completed_sound.setVolume(volumeLevel);
	active_sound.setVolume(volumeLevel);
	session_reseted_sound.setVolume(volumeLevel);
	if(artyom_voice!=undefined && volumeLevel>1)
		artyom_voice.initialize({volume:volumeLevel/100});
	//artyom_voice.volume = volumeLevel/100;

	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		rex = response.split("$^$ ");
		change_status("Os dados foram salvados " + rex[0]);
		//alert(response['ID']);
		status_box.value = rex[1];
		data_box.value = rex[2].slice(0, -1);
		//title_box.value = rex[0];
		//tags_box.value  = rex[1];
		//description_box.value = rex[2];
	});
	/*} else {
		if(!$primeiroAviso) {
			$primeiroAviso=true;
			change_status("Você precisa colocar um título na tarefa, antes de salvar")
		} else {
			alert("Você precisa colocar um título na tarefa, antes de salvar")
		}
	}*/
}

//Only one button trigger all actions for timmer manager
function action_button() {
	if(interval_clock) {
		//The user clicked on Interrupt button 	-> Check if the timmer (countdown_clock()) are running
		interrupt();
	} else {
		//The user clicked on Pomodoro or Rest button
		start_clock();
	}
	startNoSleepWakeLock();
	//startContinuousArtyom();//BROKES SLOW DEVICES
	//update_pomodoro_clipboard();//Isso sim é a verdadeira gambiarra, aplicada ao nível extremo, como não salva a data quando usa "pending", então salva um rascunho com a data de agora e altera para pending que não mexe na data

}
//Start countdown
function start_clock() {
	active_sound.play();
	//TODO: post_status="future;"
	interval_clock = setInterval('countdown_clock()', intervalMiliseconds);

	//is_pomodoros is when using 25min for focusing
	if(is_pomodoro) {
		change_button(textInterruptFocus, "#006633");//Chage button to "interrupt"
		//update_pomodoro_clipboard("pending");
		change_status(txt_started_countdown + jQuery("#title_box").val());
	} else {
		change_button(textInterruptRest, "#990000");//Chage button to "interrupt"
		change_status(txt_rest_started);
	}
	//startContinuousArtyom();
}

//Function called every second when pomodoros are running
function countdown_clock (){
	//Everty second of pomodoros running these functions are called
	secondsRemaining--;
	//Function user to convert number, like 140, into clock time, like 2:20
	convertSeconds(secondsRemaining);
	//Functions to make the effect of flip on countdown_clock
	flip_number();
	//Test the end of the time
	if(secondsRemaining==0)
	complete();
	//Change the title to time
	changeTitle();
	//
	document.getElementById("secondsRemaining_box").value=secondsRemaining + "s";
}


//This is the reason of all the code, the time when user complete a pomodoro, these satisfaction!
function complete() {
	//is_interrupt_button = false;
	pomodoro_completed_sound.stop();
	pomodoro_completed_sound.play();
	//update_pomodoro_clipboard();//pensei que podia ser EXCESSIVAMENTE
	stop_clock();	
	//changeTitle(txt_title_done);
	if(is_pomodoro) {
		turn_on_pomodoro_indicator(pomodoro_actual);
		savepomo();
		is_pomodoro = false;
		if(pomodoro_actual==pomodoros_to_big_rest) {
			//big rest
			pomodoro_actual=1;
			change_button(textBigRest, "#0F0F0F");
			change_status(txt_bigrest_countdown);
			secondsRemaining=bigRestTime;
			changeTitle(txt_title_big_rest);
			reset_indicators_display();
		} else {
			//normal rest
			pomodoro_actual++;
			change_button(textRest, "#0F0F0F");
			change_status(txt_normalrest_countdown);
			secondsRemaining=restTime;
			changeTitle(txt_title_rest);
		}
	} else {
		change_button(textPomodoro, "#0F0F0F");
		change_status(txt_completed_rest, "er");
		is_pomodoro=true;
		secondsRemaining=pomodoroTime;
		changeTitle(txt_title_done);
	}
}


//Just stop de contdown_clock function at certains moments
function stop_clock() {
	window.clearInterval(interval_clock);
	//pomodoro_completed_sound.play();
	interval_clock=false;
	//update_pomodoro_clipboard();
	//alert(is_pomodoro);
	//Functions to make the effect of flip on countdown_clock
	if(is_pomodoro) {
		convertSeconds(restTime);
	} else {
		convertSeconds(pomodoroTime);
	}
	flip_number(true);
	document.getElementById("secondsRemaining_box").value=pomodoroTime+"s";//pomodoroTime
	//is_interrupt_button = false;
}

//Function to show status warnings at bottom of the clock
function change_status(txt, stts) {
	console.log("change_status: " + txt);
	if(artyom_voice) {
		artyom_voice.shutUp();
		//artyom_voice.initialize({volume:0.1});
		if(volumeLevel>1)
		artyom_voice.say(txt, {onStart() {window.artyom_voice.dontObey();},onEnd() {window.artyom_voice.obey();}});
	}
	
	if(typeof stts=="undefined")
		alertify.log(txt);
	else if(stts=="suc")
		alertify.success(txt);
	else if(stts=="er")
		alertify.error(txt);

	document.getElementById("div_status").innerHTML=txt;
}

//Function to change button text and color
function change_button (valueset, colorset) {
	var button = jQuery("#action_button_id");
	//var button = document.getElementById("action_button_id");
	button.val(valueset);
	button.animate({'background-color': colorset}, 2000);
	//button.set('morph', {duration: 2000});
	//button.morph({/*'border': '2px solid #F00',*/'background-color': colorset});
}

//
function interrupt() {
	//pomodoro_completed_sound.play();
	//document.getElementById("secondsRemaining_box").value = "";
	//if(!is_pomodoro)is_pomodoro=true;
	pomodoro_completed_sound.play(1);//STARTS FOWARD
	//if(is_pomodoro)is_pomodoro=false;//NAO
	is_pomodoro=true;//SEMPRE QUE INTERROMPER VOLTA PARA FOCAR, CERTO?
	//
	change_status(txt_interrupted_countdowns, "er");
	//convertSeconds(0);
	//flip_number();
	change_button(textPomodoro, "#0F0F0F");
	//update_pomodoro_clipboard("trash");
	//
	stop_clock();
	//secondsRemaining=0;
	secondsRemaining = pomodoroTime;
	convertSeconds(secondsRemaining); //ALWASY 25 MIN WHEN INTERRUPT
	flip_number(secondsRemaining);
	//alert(pomodoroTime);
	//is_interrupt_button=false;
	//if(!is_pomodoro)is_pomodoro=true;
}

//Auxiliar function to countdown_clock() function
function convertSeconds(secs) {
	minutes=secs/60;
	
	if(minutes>10) {
		someValueString = '' + minutes;
		someValueParts = someValueString.split('');
		m1 = parseFloat(someValueParts[0]);
		m2 = parseFloat(someValueParts[1]);
	} else {
		m1 = parseFloat(0);
		m2 = parseFloat(minutes);
	}
	//seconds%=secs/60;
	if(secs%60!=0) {
		seconds=secs%60;
		otherValueString = '' + seconds;
		otherValueParts = otherValueString.split('');
		if(seconds>10) {
			s1 = parseFloat(otherValueParts[0]);
			s2 = parseFloat(otherValueParts[1]);
		} else {
			s1=0;
			s2=parseFloat(otherValueParts[0]);
		}
	} else {
		s1=0;
		s2=0;
	}
	//alert(m1+""+m2+":"+s1+""+s2);
}

function reset_pomodoro_session() {
	//zerar_pomodoro()
	interrupt();
	pomodoro_actual=1;
	session_reseted_sound.play();
	reset_indicators_display();
	//changeTitle("Sessão de pomodoros reiniciada...");
	change_status(txt_session_reseted);
}

//Function to "light" one pomodoro
function turn_on_pomodoro_indicator (indicator_number) {
	//var pomo = ;
	//console.log("turn_on_pomodoro_indicator:"+indicator_number);
	jQuery("#pomoindi"+indicator_number).animate({'background-position': '-30px','background-color': '#FFF'});
}

//Function to restart the pomodoros
function reset_indicators_display() {
	jQuery("#pomoindi1").animate({'background-position': '0px','background-color': '#EEEEEE'});
	jQuery("#pomoindi2").animate({'background-position': '0px','background-color': '#EEEEEE'});
	jQuery("#pomoindi3").animate({'background-position': '0px','background-color': '#EEEEEE'});
	jQuery("#pomoindi4").animate({'background-position': '0px','background-color': '#EEEEEE'});
}

//Functions to make the effect on the clock
function flip_number(force) {
	/*if(force) {
		var m1_current = 9;
		var m2_current = 9;
		var s1_current = 9;
		var s2_current = 9;
	}*/
	//alert(m1 + " cur:" + m1_current);
	if( m2 != m2_current || force){
		flip('minutesUpRight', 'minutesDownRight', m2, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Right/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Right/');
		m2_current = m2;
	}
	if( m1 != m1_current || force){	
		flip('minutesUpLeft', 'minutesDownLeft', m1, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Left/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Left/');
		m1_current = m1;
	}
	if (s2 != s2_current || force){
		flip('secondsUpRight', 'secondsDownRight', s2, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Right/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Right/');
		s2_current = s2;
	}
	if (s1 != s1_current || force){
		flip('secondsUpLeft', 'secondsDownLeft', s1, 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Up/Left/', 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/Double/Down/Left/');
		s1_current = s1;
	}
}

function flip (upperId, lowerId, changeNumber, pathUpper, pathLower){
	//var upperBackId = upperId+"Back";

	var upperBackId = jQuery("#"+upperId+"Back");
	var upperId     = jQuery("#"+upperId);
	var lowerBackId = jQuery("#"+lowerId+"Back");
	var lowerId     = jQuery("#"+lowerId);

	upperId.css("height", "64px");
	upperId.attr("src", upperBackId.attr("src"));
	upperBackId.attr("src", pathUpper+parseInt(changeNumber)+".png");
	upperId.animate({"height": "0"});
	
	lowerId.css("height", "64px");
	lowerId.attr("src", lowerBackId.attr("src"));
	lowerBackId.attr("src", pathLower+parseInt(changeNumber)+".png");
	lowerId.css("margin-top", "0");
	lowerId.animate({"height": "0", "margin-top": "50px"});
	//lowerId.animate({});
	
	//lowerId.animate({height:20, "top:64px", marginTop:0},200)
	//lowerId.animate({top: '-=1px'});

	//jQuery(lowerId).src = pathLower+parseInt(changeNumber)+".png";
	//jQuery(lowerId).css("height", "0px");
	//jQuery(lowerId).css("visibility", "visible");


	//upperBackId.animate({"height": "64px"});

	//upperId.animate({"visibility": "hidden"});
	//upperBackId.animate({"visibility": "visible"});
	/*var flipUpper = new Fx.Tween(upperId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
	flipUpper.addEvents({
		'complete': function(){
			var flipLower = new Fx.Tween(lowerId, {duration: 200, transition: Fx.Transitions.Sine.easeInOut});
				flipLower.addEvents({
					'complete': function(){	
						lowerBackId = lowerId+"Back";
						jQuery(lowerBackId).src = jQuery(lowerId).src;
						jQuery(lowerId).css("visibility", "hidden");
						jQuery(upperId).css("visibility", "hidden");
					}				});					
				flipLower.start('height', 64);
				
		}
	});
	flipUpper.start('height', 0);*/
}

//The real life at pomodoros: jQuery calling php function on functions.php
function savepomo() {
	var postcat=getRadioCheckedValue("cat_vl");
	var privornot=getRadioCheckedValue("priv_vl");
	//TODO: verificar se o último post publicado já faz mais que pomodoroTime (25min), evitando flood e 2 navegadores abertos
	var data = {
		action: 'save_progress',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: tags_box.value,
		post_cat: postcat,
		post_priv: privornot
	};

	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response)		
		change_status(txt_save_success, "suc");
		else
		change_status(txt_save_error, "er");
		/*Append the fresh completed pomodoro at the end of the list, simulating the data
		var d=new Date();
		data = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds();//new Date(year, month, day, hours, minutes, seconds);
		if(response[0]=="1")
		jQuery("#points_completed").append('<li>'+data+" -> "+description.value+'</li>');*/
	});
}

//Load e Save model function
function save_model () {
	change_status(txt_salving_model);
	var data = {
		action: 'save_modelnow',
		post_titulo: title_box.value,
		post_descri: description_box.value,
		post_tags: tags_box.value
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response) {
			if(response==0) {
				change_status(txt_salving_model_task_null);
			} else {
				var sessao_atual=response;
				//primeiro salva o post, para depois pegar o id do mesmo
				jQuery("#contem-modelos").append('<ul id="modelo-carregado-'+sessao_atual+'"><li><input type="text" value="'+title_box.value+'" disabled="disabled" id="bxtitle'+sessao_atual+'"><br /><input type="text" value="'+description_box.value+'" disabled="disabled" id="bxcontent'+sessao_atual+'"><br /><input type="text" value="'+tags_box.value+'" disabled="disabled" id="bxtag'+sessao_atual+'"><p><input type="button" value="usar modelo" onclick="load_model('+sessao_atual+')"><input type="button" value="apaga" onclick="delete_model('+sessao_atual+')"></p></li></ul>');
				/*jQuery("#botao-salvar-modelo").val("sessão salvada com sucesso");
				jQuery("#botao-salvar-modelo").attr('disabled', 'disabled');*/
				document.getElementById("bxcontent"+sessao_atual).focus();
				change_status(txt_salving_model_success);
			}
		}
		else
		change_status(txt_save_error);
	});
}

function delete_model(task_model_id) {
	//PHP deletar post task_model_id
	change_status(txt_deleting_model);
	var data = {
		action: 'save_modelnow',
		post_para_deletar: task_model_id
	};
	jQuery.post(ajaxurl, data, function(response) {
		if(response=="NOTIN")window.location.href = "/";
		if(response) {
			change_status(txt_deleting_model_sucess);
			jQuery("#modelo-carregado-"+task_model_id).remove();
		} else {
			change_status(txt_save_error);
		}
	});
}

function load_model(task_model_id) {
	//alert(jQuery("#bxtitle"+task_model_id).text());
	jQuery("#title_box").val(jQuery("#bxtitle"+task_model_id).text());
	jQuery("#description_box").val(jQuery("#bxcontent"+task_model_id).text());
	
	if(jQuery("#bxtag"+task_model_id))
	jQuery("#tags_box").val(jQuery("#bxtag"+task_model_id).text());
	else
	jQuery("#tags_box").val("");
	
	jQuery("#action_button_id").focus();
	change_status(txt_loading_model);
}

//Change the <title> of the document
function changeTitle (newtit) {
	if(!newtit) {
		var task_name = document.getElementById('title_box');
		document.title = Math.round(m1)+""+Math.round(m2)+":"+s1+""+s2 + " - " + task_name.value;
	} else {
		document.title = newtit;
	}
}

function getRadioCheckedValue(radio_name){
   var oRadio = document.forms["pomopainel"].elements[radio_name];
	//alert(oRadio.length);
   for(var i = 0; i < oRadio.length; i++)
   {
      if(oRadio[i].checked)
      {
         return oRadio[i].value;
      }
   }
   return '';
}


//Sound configuration
function startSoundMan() {
	soundManager.url = 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/assets/soundmanager2.swf';
	soundManager.onready(function() {
		// Ready to use; soundManager.createSound() etc. can now be called.
		active_sound = soundManager.createSound({id: 'mySound2',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/crank-2.mp3',});
		//active_sound = soundManager.createSound({id: 'mySound2',url: 'https://pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/77711__sorohanro__solo-trumpet-06in-f-90bpm.mp3',});
		pomodoro_completed_sound = soundManager.createSound({id:'mySound3',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/23193__kaponja__10trump-tel.mp3',});
		session_reseted_sound = soundManager.createSound({id:'mySound4',url: 'https://www.pomodoros.com.br/wp-content/themes/sistema-focalizador-javascript/pomodoro/sounds/magic-chime-02.mp3',});
	});
	//soundManager.setVolume(volumeLevel);
	soundManager.onerror = function() {alert(txt_sound_error+"...");}
}
//
//
var grupoDeComandos = [{
	    indexes:["iniciar", "focar", "começar", "interromper"], // These spoken words will trigger the execution of the command
	    action:function(){ // Action to be executed when a index match with spoken word
	        artyom_voice.say("Pois não");//era: comando recebido
	        action_button();
	    }
	},
];

var groupOfCommands = [{
	    indexes:["start", "focus", "begin", "interrupt", "stop"], // These spoken words will trigger the execution of the command
	    action:function(){ // Action to be executed when a index match with spoken word
	        artyom_voice.say("Ok");
	        action_button();
	    }
	},
];

var groupSwith = [{
    // note that if you're in spanish for example
    // the command should be instead : "Iniciar en ingles, Iniciar en alemán" etc...
    indexes:["switch to portuguese","switch to english"],
    action: function(i){
        switch(i){
            case 0: start("pt-PT"); break;
            case 1: start("en-US"); break;
        }
    }
}];

// This function activates artyom and will listen all that you say forever (requires https conection, otherwise a dialog will request if you allow the use of the microphone)
function startContinuousArtyom(){
	artyom_voice = new Artyom();
	//
    artyom_voice.fatality();// use this to stop any of
    //
    //alert(data_from_php.php_locale);
    if(data_from_php.php_locale=="pt_BR")
    	artyom_lang = "pt-PT";
    else
    	artyom_lang = "en-US";
    //
    setTimeout(function(){// if you use artyom.fatality , wait 250 ms to initialize again.
         artyom_voice.initialize({
            lang:artyom_lang,// A lot of languages are supported. Read the docs !
            continuous:true,// Artyom will listen forever
            listen:true, // Start recognizing
            debug:true, // Show everything in the console
            speed:1, // talk normally
            //volume: volumeLevel/100,
            //volume: 0,
            //name: "pomodoro",
        }).then(function(){
            console.log("Ready to work !");
        });
    },250);
    //
    if(data_from_php.php_locale=="pt_BR")
    	artyom_voice.addCommands(grupoDeComandos);
    else
    	artyom_voice.addCommands(groupOfCommands);

    artyom_voice.addCommands(groupSwith);

    /*artyom_voice.when("COMMAND_RECOGNITION_END",function(status){
	          startContinuousArtyom();
	   
	});
	artyom_voice.when("SPEECH_SYNTHESIS_END",function(){
	          startContinuousArtyom();
	    
	});*/
}

function startNoSleepWakeLock() {
	noSleep = new NoSleep();
	function enableNoSleep() {
	  noSleep.enable();
	  document.removeEventListener('touchstart', enableNoSleep, false);
	  document.removeEventListener('click', enableNoSleep, false);
	}
	document.addEventListener('touchstart', enableNoSleep, false);
	document.addEventListener('click', enableNoSleep, false);
}

