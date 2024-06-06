<?php

namespace SangoBlocks;

use SANGO\App;

class Conditional {

	public function init() {}

	private function is_shown_by_field( $fields ) {
		global $post;
		if ( count( $fields ) === 0 ) {
			return true;
		}
		if ( ! $post ) {
			return false;
		}
		foreach ( $fields as $field ) {
			$name      = $field['name'];
			$value     = $field['value'];
			$operator  = $field['operator'];
			$postField = App::get( 'field' )->get_by_name( $name );
			if ( ! $postField ) {
				continue;
			}
			$type       = $postField->field_type;
			$meta_value = get_post_meta( $post->ID, $name, true );
			if ( $type === 'checkbox' ) {
				if ( $value === '0' && $meta_value ) {
					return false;
				} elseif ( $value === '1' && ! $meta_value ) {
					return false;
				}
			} elseif ( $operator === '!=' && $meta_value === $value ) {
				return false;
			} elseif ( $operator === '==' && $meta_value !== $value ) {
				return false;
			}
		}
		return true;
	}
	public function hide_or_show_content( $block_content, $block ) {
		$device               = isset( $block['attrs']['device'] ) ? $block['attrs']['device'] : 'all';
		$categories           = isset( $block['attrs']['categories'] ) ? $block['attrs']['categories'] : array();
		$tags                 = isset( $block['attrs']['tags'] ) ? $block['attrs']['tags'] : array();
		$login                = isset( $block['attrs']['login'] ) ? $block['attrs']['login'] : '';
		$show_on_page         = isset( $block['attrs']['showOnPage'] ) ? $block['attrs']['showOnPage'] : true;
		$show_on_post         = isset( $block['attrs']['showOnPost'] ) ? $block['attrs']['showOnPost'] : true;
		$show_on_top          = isset( $block['attrs']['showOnTop'] ) ? $block['attrs']['showOnTop'] : true;
		$show_on_category_top = isset( $block['attrs']['showOnCategoryTop'] ) ? $block['attrs']['showOnCategoryTop'] : true;
		$fields               = isset( $block['attrs']['fields'] ) ? $block['attrs']['fields'] : array();
		$showOnPostTypes      = isset( $block['attrs']['showOnPostTypes'] ) ? $block['attrs']['showOnPostTypes'] : array();
		$showOnTaxonomies     = isset( $block['attrs']['showOnTaxonomies'] ) ? $block['attrs']['showOnTaxonomies'] : array();
		$post_type            = get_post_type();
		$status               = App::get( 'status' )->get_status();
		$is_top               = $status['is_top'] && ! $status['is_paged'];
		$is_category_top      = $status['is_category_top'];
		if ( ! $show_on_category_top ) {
			if ( $is_category_top ) {
				return '';
			}
		}
		if ( ! $show_on_top ) {
			if ( $is_top ) {
				return '';
			}
		}
		if ( ! $show_on_post ) {
			if ( $post_type === 'post' && ! $is_top && ! $is_category_top ) {
				return '';
			}
		}
		if ( ! $show_on_page ) {
			if ( $post_type === 'page' && ! $is_top && ! $is_category_top ) {
				return '';
			}
		}
		if ( $post_type !== 'page' && $post_type !== 'post' && count( $showOnPostTypes ) > 0 ) {
			if ( ! in_array( $post_type, $showOnPostTypes ) ) {
				return '';
			}
		}
		if ( count( $showOnTaxonomies ) > 0 ) {
			global $post;
			if ( ! $post ) {
				return '';
			}
			$flag = false;
			foreach ( $showOnTaxonomies as $showOnTaxonomy ) {
				$taxonomy = $showOnTaxonomy['taxonomy'];
				$terms    = $showOnTaxonomy['terms'];
				foreach ( $terms as $term ) {
					if ( has_term( $term, $taxonomy, $post->ID ) ) {
						$flag = true;
						break;
					}
				}
			}
			if ( ! $flag ) {
				return '';
			}
		}
		if ( $this->is_shown_by_field( $fields ) === false ) {
			return '';
		}
		if ( $device === 'mobile' && ! wp_is_mobile() ) {
			return '';
		}
		if ( $device === 'pc' && wp_is_mobile() ) {
			return '';
		}
		if ( count( $categories ) > 0 ) {
			if ( ! in_category( $categories ) ) {
				return '';
			}
		}
		if ( $login === 'login' && ! is_user_logged_in() ) {
			return '';
		}
		if ( $login === 'logout' && is_user_logged_in() ) {
			return '';
		}
		if ( count( $tags ) > 0 ) {
			if ( ! has_tag( $tags ) ) {
				return '';
			}
		}

		return $block_content;
	}
}
