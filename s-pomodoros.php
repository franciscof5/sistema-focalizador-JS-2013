<?php do_action( 'bp_before_sidebar' ); ?>
<div class="sidebar" id="sidebar_pomodoro">
	<div class="padder">
		<li>
			<h3 class="widget-title">Estatísticas de <?php get_currentuserinfo(); echo $current_user->user_firstname; ?> </h3>
			Membro ha dias:
			Dias de trabalho:
			Dias sem trabalho:
			Produtividade:
			Pomodoros/dia
			-Hoje
			-Ultima semana
			-Ultimo mes
			-Ultimo ano
			-Desde o comeco

			[COMUNIDADE]
			Pomodoros/dia
			-Hoje
			-Ultima semana
			-Ultimo mes
			-Ultimo ano
			-Desde o comeco

			<?php
			/*$author_query = array('posts_per_page' => '-1','author' => $current_user->ID);
			$author_posts = new WP_Query($author_query);
			while($author_posts->have_posts()) : $author_posts->the_post();
			?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>       
			
			<?php           
			endwhile;*/
			?>	
			<p><?php the_author_posts(); ?> pomodoros </p>
			<?php
			//get all posts for an author, then collect all categories
			//for those posts, then display those categories
			$cat_array = array();			
			$author_posts = new WP_Query( 'author="'.get_current_user_id().'"&post_status=any&nopaging=true' );
			// The Loop
			if ( $author_posts->have_posts() ) {
			       /* while ( $author_posts->have_posts() ) {
					$author_posts->the_post();
				}*/
				//echo $author_posts->post_count;
			} else {
				echo  "Você ainda não completou nenhum pomodoro";
			}
			/* Restore original Post Data */
			wp_reset_postdata();
			/*if( $author_posts ) {
				echo count($author_posts);
				/*  foreach ($author_posts as $author_post ) {
				    foreach(get_the_category($author_post->ID) as $category) {
				      $cat_array[$category->term_id] =  $category->term_id;
				    }
			  }
			} else {
				echo  "Você ainda não completou nenhum pomodoro";
			}*/
			//$cat_ids = implode(',', $cat_array);
			//wp_list_categories('include='.$cat_ids.'&title_li=Author Categories');
			?>
		</li>
	<?php dynamic_sidebar( 'pomodoros' ); ?>
	
	<?php /*
	<h3><script>document.write(txt_tips_heading)</script></h3>
	<p><script>document.write(txt_tips_description)</script></p>
	<input type="button" onclick="proxima_dica()" value="" id="botao_dicas">
	<ul id="dicas">
		<li id="dica_1"><script>document.write(txt_tips_1)</script></li>
		<li id="dica_2"><script>document.write(txt_tips_2)</script></li>
		<li id="dica_3"><script>document.write(txt_tips_3)</script></li>
		<li id="dica_4"><script>document.write(txt_tips_4)</script></li>
		<li id="dica_5"><script>document.write(txt_tips_5)</script></li>
		<li id="dica_6"><script>document.write(txt_tips_6)</script></li>
		<li id="dica_7"><script>document.write(txt_tips_7)</script></li>
		<li id="dica_8"><script>document.write(txt_tips_8)</script></li>
		<li id="dica_9"><script>document.write(txt_tips_9)</script></li>
		<li id="dica_10"><script>document.write(txt_tips_last)</script></li>
	</ul>
	*/ ?>
	</div>
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>