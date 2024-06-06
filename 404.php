<?php get_header(); ?>
	<div id="content">
	<div id="inner-content" class="wrap">
		<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
		<?php get_template_part( 'content', 'not-found' ); ?>
		</main>
		<?php get_sidebar(); ?>  
	</div>
	</div>
<?php get_footer(); ?>