<?php

function sng_rate_item_render( $block_content, $block ) {
	$richResult    = isset( $block['attrs']['showRichResults'] ) ? $block['attrs']['showRichResults'] : false;
	$title         = isset( $block['attrs']['title'] ) ? $block['attrs']['title'] : '';
	$title         = addslashes( $title );
	$reviewedTitle = isset( $block['attrs']['reviewedTitle'] ) ? $block['attrs']['reviewedTitle'] : '';
	$reviewedTitle = addslashes( $reviewedTitle );
	$title         = $reviewedTitle ? $reviewedTitle : $title;
	$rate          = isset( $block['attrs']['rate'] ) ? $block['attrs']['rate'] : '';
	$reviewedType  = isset( $block['attrs']['reviewedType'] ) ? $block['attrs']['reviewedType'] : 'Product';
	$publisherName = get_option( 'publisher_name', '' );
	$date          = get_the_date( 'Y-m-d\TH:m:s+09:00' );
	$author        = get_the_author();
	if ( ! $richResult ) {
		return $block_content;
	}

	$jsonLd = <<< EOM
  <script type="application/ld+json">
  {
	"@context": "http://schema.org",
	"@type": "Review",
	"itemReviewed": {
		"@type": "$reviewedType",
		"name": "$title",
		"image": "",
		"review": {
			"author": {
				"@type": "Person",
				"name": "$author"
			}
		}
	},
	"reviewRating": {
		"@type": "Rating",
		"ratingValue": "$rate"
	},
	"datePublished": "$date",
  "author": {
		"@type": "Person",
		"name": "$author"
	},
	"publisher": {
		"@type": "Organization",
		"name": "$publisherName"
	}
}
</script>
EOM;
	return $block_content . $jsonLd;
}

add_filter( 'render_block_sgb/rate-item', 'sng_rate_item_render', 10, 2 );
