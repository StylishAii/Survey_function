<?php

if ( is_active_sidebar( 'home_header' ) && ( is_front_page() && is_paged() === false ) ) {
	dynamic_sidebar( 'home_header' );
}
