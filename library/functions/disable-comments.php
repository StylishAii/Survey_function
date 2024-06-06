<?php


function sng_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
// https://keithgreer.uk/wordpress-code-completely-disable-comments-using-functions-php

add_action( 'admin_init', 'sng_disable_comments_post_types_support' );

function sng_disable_comments_status() {
	return false;
}
add_filter( 'comments_open', 'sng_disable_comments_status', 20, 2 );
add_filter( 'pings_open', 'sng_disable_comments_status', 20, 2 );

function sng_disable_comments_hide_existing_comments( $comments ) {
	$comments = array();
	return $comments;
}
add_filter( 'comments_array', 'sng_disable_comments_hide_existing_comments', 10, 2 );
