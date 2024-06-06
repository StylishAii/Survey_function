<?php

ob_start();

?>

<form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
  <div>
    <input type="search" class="searchform__input" name="s" value="" placeholder="検索" />
    <button type="submit" class="searchform__submit" aria-label="検索"><?php fa_tag("search","search",false) ?></button>
  </div>
</form>

<?php

$contents = ob_get_clean();

echo apply_filters('sng_searchform', $contents);
