<?php // 検索ボタン ?>
<div class="header-search">
	<?php if ( ! get_option( 'no_header_search' ) && wp_is_mobile() ) : ?>
	<label class="header-search__open" for="header-search-input"><?php fa_tag( 'search', 'search', false ); ?></label>
	<?php endif; ?>
	<input type="checkbox" class="header-search__input" id="header-search-input" onclick="document.querySelector('.header-search__modal .searchform__input').focus()">
	<label class="header-search__close" for="header-search-input"></label>
	<div class="header-search__modal">
	<?php get_template_part( 'searchform' ); ?>
	</div>
</div>