<?php

use SangoBlocks\App;

function sng_build_table_css( $options ) {
	$id                    = $options['id'];
	$tableWidth            = $options['tableWidth'];
	$fixFirstCol           = $options['fixFirstCol'];
	$fixFirstRow           = $options['fixFirstRow'];
	$headingFirstCol       = $options['headingFirstCol'];
	$headingBgColor        = $options['headingBgColor'];
	$headingColor          = $options['headingColor'];
	$borderColor           = $options['borderColor'];
	$borderWidth           = $options['borderWidth'];
	$cellMinWidth          = $options['cellMinWidth'];
	$cellMaxWidth          = $options['cellMaxWidth'];
	$iconSize              = $options['iconSize'];
	$iconCircleColor       = $options['iconCircleColor'];
	$iconDoubleCircleColor = $options['iconDoubleCircleColor'];
	$iconCrossColor        = $options['iconCrossColor'];
	$iconCheckColor        = $options['iconCheckColor'];
	$iconTriangleColor     = $options['iconTriangleColor'];

	$css = '';

	if ( $iconSize ) {
		$css .= "#{$id} .sgb-table-icon {
      min-height: {$iconSize}em;
    }";
		$css .= "#{$id} .sgb-table-icon:before {
      font-size: {$iconSize}em;
    }";
	}

	if ( $iconCircleColor ) {
		$css .= "#{$id} .sgb-table-icon[data-type='circle']:before {
      color: {$iconCircleColor};
    }";
	}

	if ( $iconDoubleCircleColor ) {
		$css .= "#{$id} .sgb-table-icon[data-type='double-circle']:before {
      color: {$iconDoubleCircleColor};
    }";
	}

	if ( $iconCrossColor ) {
		$css .= "#{$id} .sgb-table-icon[data-type='cross']:before {
      color: {$iconCrossColor};
    }";
	}

	if ( $iconCheckColor ) {
		$css .= "#{$id} .sgb-table-icon[data-type='check']:before {
      color: {$iconCheckColor};
    }";
	}

	if ( $borderWidth ) {
		$css .= "
      #{$id} {
        --sgb-table-border-width: {$borderWidth}px;
      }
    ";
	}

	if ( $borderColor ) {
		$css .= "
      #{$id} table {
        border-width: var(--sgb-table-border-width, 2px);
        border-color: {$borderColor};
      }
      #{$id} table td,
      #{$id} table th {
        border-width: var(--sgb-table-border-width, 2px);
        border-color: {$borderColor};
      }
    ";
	} else {
		$borderColor = '#e0e0e0';
	}
	if ( $cellMinWidth ) {
		$css .= "
      #{$id} table td,
      #{$id} table th {
        min-width: {$cellMinWidth}px;
      }
    ";
	}
	if ( $cellMaxWidth ) {
		$css .= "
      #{$id} table td,
      #{$id} table th {
        max-width: {$cellMaxWidth}px;
      }
    ";
	}
	if ( $tableWidth && $fixFirstCol ) {
		$css .= "
      #{$id} figure {
        overflow-x: auto;
      }
      #{$id} table {
        width: {$tableWidth}px;
        max-width: {$tableWidth}px;
        border-collapse: separate;
        border-left: none;
      }
      #{$id} table td,
      #{$id} table th {
        border-bottom: var(--sgb-table-border-width, 2px) solid $borderColor;
      }
      #{$id} table tbody tr:last-child td,
      #{$id} table tbody tr:last-child th,
      #{$id} table tfoot tr td,
      #{$id} table tfoot tr th {
        border-bottom: none;
      }
      #{$id} table tfoot tr td,
      #{$id} table tfoot tr th {
        border-top: var(--sgb-table-border-width, 2px) dotted $borderColor;
      }
      #{$id} table tr > :first-child {
        position: sticky;
        top: 0;
        left: 0;
        z-index: 2;
        border-left: var(--sgb-table-border-width, 2px) solid $borderColor;
      }
      #{$id} table tbody tr:last-child > :first-child {
        border-bottom: none;
      }
      #{$id} table tfoot tr td:first-child,
      #{$id} table tfoot tr th:first-child {
        border-bottom: none;
      }
      #{$id} .is-style-sango-table-scroll-hint table td {
        white-space: normal;
      }
    ";
	}

	if ( $fixFirstRow ) {
		$top  = is_user_logged_in() ? '3var(--sgb-table-border-width, 2px)' : '0';
		$css .= "
      #{$id} figure {
        overflow: visible;
      }
      #{$id} table {
        border-collapse: separate;
        border-top: none;
      }
      #{$id} table thead tr > td,
      #{$id} table thead tr > th {
        position: sticky;
        z-index: 1;
        top: {$top};
        border-top: var(--sgb-table-border-width, 2px) solid $borderColor;
        border-color: $borderColor;
      }
      #{$id} table td,
      #{$id} table th {
        border-bottom: var(--sgb-table-border-width, 2px) solid $borderColor;
      }
      #{$id} table thead th:last-child {
        border-right: none;
      }
      #{$id} table tbody tr:last-child td,
      #{$id} table tbody tr:last-child th,
      #{$id} table tfoot tr td,
      #{$id} table tfoot tr th {
        border-bottom: none;
      }
      #{$id} table tfoot tr td,
      #{$id} table tfoot tr th {
        border-top: var(--sgb-table-border-width, 2px) dotted {$borderColor};
      }
      #{$id} table thead:empty + tbody tr:first-child td,
      #{$id} table thead:empty + tbody tr:first-child th {
        position: sticky;
        z-index: 1;
        top: {$top};
        border-top: var(--sgb-table-border-width, 2px) solid $borderColor;
      }
    ";
	}

	if ( $headingFirstCol ) {
		$backgroundColor = $headingBgColor ? "background-color: {$headingBgColor};" : '';
		$color           = $headingColor ? "color: {$headingColor};" : '';

		$css .= "
    #{$id} table tr td:first-child {
      padding: 7px;
      border-right: var(--sgb-table-border-width, 2px) solid $borderColor;
      border-bottom: var(--sgb-table-border-width, 2px) solid $borderColor;
      background-color: #f8f9fa;
      text-align: center;
      font-weight: bold;
      white-space: nowrap;
      $backgroundColor
      $color
    }
    #{$id} table tfoot tr td:first-child {
      padding: 7px;
      text-align: center;
      font-weight: bold;
      white-space: nowrap !important;
      $backgroundColor
      $color
    }
    #{$id} table tbody tr:last-child td:first-child {
      border-bottom: none;
    }
    ";
	}

	if ( $headingColor ) {
		$css .= "
      #{$id} table th {
        color: {$headingColor};
      }
    ";
	}

	if ( $headingBgColor ) {
		$css .= "
      #{$id} table th {
        background-color: {$headingBgColor};
      }
    ";
	}

	return $css;
}

function sng_table_render( $block_content, $block ) {
	if ( $block['blockName'] !== 'core/table' ) {
		return $block_content;
	}
	wp_enqueue_style(
		'sango_theme_icon_style',
		App::getUrl( 'icon.build.css' )
	);
	$id                    = isset( $block['attrs']['blockId'] ) ? $block['attrs']['blockId'] : '';
	$tableWidth            = isset( $block['attrs']['tableWidth'] ) ? $block['attrs']['tableWidth'] : 1200;
	$fixFirstCol           = isset( $block['attrs']['fixFirstCol'] ) ? $block['attrs']['fixFirstCol'] : '';
	$fixFirstRow           = isset( $block['attrs']['fixFirstRow'] ) ? $block['attrs']['fixFirstRow'] : '';
	$headingFirstCol       = isset( $block['attrs']['headingFirstCol'] ) ? $block['attrs']['headingFirstCol'] : '';
	$headingBgColor        = isset( $block['attrs']['headingBgColor'] ) ? $block['attrs']['headingBgColor'] : '';
	$headingColor          = isset( $block['attrs']['headingColor'] ) ? $block['attrs']['headingColor'] : '';
	$borderColor           = isset( $block['attrs']['borderColor'] ) ? $block['attrs']['borderColor'] : '';
	$borderWidth           = isset( $block['attrs']['borderWidth'] ) ? $block['attrs']['borderWidth'] : 2;
	$cellMinWidth          = isset( $block['attrs']['cellMinWidth'] ) ? $block['attrs']['cellMinWidth'] : '';
	$cellMaxWidth          = isset( $block['attrs']['cellMaxWidth'] ) ? $block['attrs']['cellMaxWidth'] : '';
	$iconSize              = isset( $block['attrs']['iconSize'] ) ? $block['attrs']['iconSize'] : '';
	$iconCircleColor       = isset( $block['attrs']['iconCircleColor'] ) ? $block['attrs']['iconCircleColor'] : '';
	$iconCrossColor        = isset( $block['attrs']['iconCrossColor'] ) ? $block['attrs']['iconCrossColor'] : '';
	$iconTriangleColor     = isset( $block['attrs']['iconTriangleColor'] ) ? $block['attrs']['iconTriangleColor'] : '';
	$iconDoubleCircleColor = isset( $block['attrs']['iconDoubleCircleColor'] ) ? $block['attrs']['iconDoubleCircleColor'] : '';
	$iconCheckColor        = isset( $block['attrs']['iconCheckColor'] ) ? $block['attrs']['iconCheckColor'] : '';

	$css = sng_build_table_css(
		array(
			'id'                    => $id,
			'tableWidth'            => $tableWidth,
			'fixFirstCol'           => $fixFirstCol,
			'fixFirstRow'           => $fixFirstRow,
			'headingFirstCol'       => $headingFirstCol,
			'headingBgColor'        => $headingBgColor,
			'headingColor'          => $headingColor,
			'borderColor'           => $borderColor,
			'cellMinWidth'          => $cellMinWidth,
			'cellMaxWidth'          => $cellMaxWidth,
			'iconSize'              => $iconSize,
			'iconCircleColor'       => $iconCircleColor,
			'iconCrossColor'        => $iconCrossColor,
			'iconTriangleColor'     => $iconTriangleColor,
			'iconDoubleCircleColor' => $iconDoubleCircleColor,
			'iconCheckColor'        => $iconCheckColor,
			'borderWidth'           => $borderWidth,
		)
	);

	if ( ! $css ) {
		return $block_content;
	}

	App::get( 'css' )->register( $id, $css );
	return "<div id=\"$id\">$block_content</div>";
}

add_filter( 'render_block', 'sng_table_render', 10, 2 );
