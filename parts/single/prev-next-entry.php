<?php
	/**
	 * 前の記事へ、次の記事へ
	 */
	$prev_post = get_adjacent_post( false, '', true );
	$next_post = get_adjacent_post( false, '', false );
if ( $prev_post || $next_post ) :
	?>
<div class="prnx_box">
	<?php
	if ( $prev_post ) :
		$prev_id = $prev_post->ID;
		?>
	<a href="<?php the_permalink( $prev_id ); ?>" class="prnx pr">
		<p><?php fa_tag( 'angle-left', 'angle-left', false ); ?> 前の記事</p>
		<div class="prnx_tb">
		<?php if ( get_the_post_thumbnail( $prev_id ) ) : ?>
			<figure><?php echo get_the_post_thumbnail( $prev_id, 'thumb-160' ); ?></figure>
		<?php endif; ?>  
		<span class="prev-next__text"><?php lim_title( $prev_id ); ?></span>
		</div>
	</a>
		<?php
	endif;
	if ( $next_post ) :
		$next_id = $next_post->ID;
		?>
		<a href="<?php the_permalink( $next_id ); ?>" class="prnx nx">
		<p>次の記事 <?php fa_tag( 'angle-right', 'angle-right', false ); ?></p>
		<div class="prnx_tb">
		<span class="prev-next__text"><?php lim_title( $next_id ); ?></span>
		<?php if ( get_the_post_thumbnail( $next_id ) ) : ?>
			<figure><?php echo get_the_post_thumbnail( $next_id, 'thumb-160' ); ?></figure>
		<?php endif; ?>
		</div>
	</a>
	<?php endif; ?>
</div>
<?php endif; ?>