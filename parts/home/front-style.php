<?php

use SangoBlocks\App;

$final_css     = '';
$content_width = get_post_meta( $post->ID, 'sng_content_width', true );
$padding_zero  = get_post_meta( $post->ID, 'sng_content_padding_zero', true );

if ( ! $content_width ) {
	$content_width = 1180;
}

$final_css .= <<<EOM
  body {
    --wp--custom--wrap--max-width: {$content_width}px;
  }
  @media screen and (max-width: {$content_width}px) {
    .sgb-full-bg:not(.sgb-full-bg--self-content-width) .sgb-full-bg__content {
      padding-right: var(--wp--custom--wrap--mobile--padding);
      padding-left: var(--wp--custom--wrap--mobile--padding);
      margin-right: 0 !important;
      margin-left: 0 !important;
      max-width: 100%;
    }
    // html .page-forfront .alignfull {
    //   margin-left: 0 !important;
    //   max-width: auto !important;
    //   width: auto !important;
    // }
  }
EOM;

if ( $padding_zero ) {
	$final_css .= <<<EOM
  #content.page-forfront {
    padding-top: 0;
    padding-bottom: 0;
  }
  body .entry-footer {
    margin-top: 0;
  }
  body .entry-content > *:first-child {
    margin-top: 0;
  }
EOM;
}

$final_css .= <<<EOM
#container { background: #FFF; }
#main { width: 100%; }
.maximg { margin-bottom: 0; }
.entry-footer { margin-top: 2rem; }
.page-forfront .alignfull {
  width: 100vw;
  margin-left: calc(50% - 50vw);
  max-width: 100vw !important;
}
@media only screen and (min-width: 1030px) and (max-width: 1239px) {
  .maximg { max-width: calc(92% - 58px); }
}
EOM;

App::get( 'css' )->register( 'front-style', $final_css );
