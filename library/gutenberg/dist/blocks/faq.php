<?php

use SangoBlocks\App;

function sng_faq_render( $block_content, $block ) {
	$innerBlocks     = isset( $block['innerBlocks'] ) ? $block['innerBlocks'] : array();
	$enableAccordion = isset( $block['attrs']['enableAccordion'] ) ? $block['attrs']['enableAccordion'] : false;
	$richResult      = isset( $block['attrs']['showRichResults'] ) ? $block['attrs']['showRichResults'] : false;
	if ( $enableAccordion ) {
		$id = wp_unique_id( 'sgb-faq-id' );
		$js = <<< EOM
    sng.domReady(() => {
      const container = document.querySelector("#$id");
      const items = container.querySelectorAll('.wp-block-sgb-faq-item');
      items.forEach(item => {
        const hq = item.querySelector('.hhq');
        const ha = item.querySelector('.hha');
        hq.addEventListener('click', () => {
          ha.classList.toggle('hha--visible');
          hq.classList.toggle('hhq--visible');
        });
      });
    });
EOM;
		App::get( 'js' )->register( $id, $js, false );
		$block_content = "<div id=\"$id\">$block_content</div>";
	}

	if ( ! $richResult ) {
		return $block_content;
	}

	$mainEntity = '[';

	foreach ( $innerBlocks as $innerBlock ) {
		$question     = isset( $innerBlock['attrs']['question'] ) ? $innerBlock['attrs']['question'] : '';
		$answer       = isset( $innerBlock['attrs']['answer'] ) ? $innerBlock['attrs']['answer'] : '';
		$innerContent = isset( $innerBlock['innerBlocks'] ) ? $innerBlock['innerBlocks'] : '';
		$freeInput    = isset( $innerBlock['attrs']['freeInput'] ) ? $innerBlock['attrs']['freeInput'] : false;
		if ( $freeInput ) {
			$answer = '';
			foreach ( $innerBlock['innerBlocks'] as $i => $childBlock ) {
				$answer .= $childBlock['innerHTML'];
			}
			$answer = str_replace( array( "\n", "\r" ), '', $answer );
		}
		$question    = addslashes( $question );
		$answer      = addslashes( $answer );
		$mainEntity .= <<< EOM
      {
        "@type": "Question",
        "name": "$question",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "$answer"
        }
      }
EOM;
		if ( $innerBlock !== end( $innerBlocks ) ) {
			$mainEntity .= ',';
		}
	}
	$mainEntity .= ']';

	$jsonLd = <<< EOM
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": $mainEntity
      }
    </script>
EOM;
	return $block_content . $jsonLd;
}

add_filter( 'render_block_sgb/faq', 'sng_faq_render', 10, 2 );
