<?php

namespace SangoBlocks;

class Profile {
	public function init() {
		add_filter( 'get_avatar', array( $this, 'get_avatar' ), 10, 5 );
	}

	public function get_avatar( $avatar, $id, $size, $default, $alt ) {
		$user = get_user_by( 'id', $id );
		if ( $user === false || ! $user->profile_avatar ) {
			return $avatar;
		}
		$new_avatar_id = $user->profile_avatar;
		$images        = wp_get_attachment_image_src( $new_avatar_id, 'full' );
		$src           = $images[0];
		$new_avatar    = "<img alt='{$alt}' src='{$src}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return $new_avatar;
	}

	public function render_user_by_manual( $options, $content ) {
		$description     = $content;
		$background      = array( $options['profileBackground'], $options['profileBackgroundWidth'], $options['profileBackgroundHeight'] );
		$avatar          = $options['profileImg'];
		$profileUserName = $options['profileUserName'];
		$bgColor         = $options['bgColor'];

		ob_start();
		sng_show_profile(
			array(
				'background'       => $background,
				'avatar'           => $avatar,
				'display_name'     => $profileUserName,
				'description'      => $description,
				'socials'          => array(),
				'description_wrap' => 'div',
			)
		);

		$contents = ob_get_contents();
		ob_end_clean();
		$contents = preg_replace( '/<ul class="profile-sns dfont">([\s\S]*?)<\/ul>/', '', $contents );
		$contents = str_replace( 'profile-content', 'profile-content profile-content--manual', $contents );
		if ( $bgColor ) {
			$contents = str_replace( 'class="my_profile"', "class=\"my_profile\" style=\"background-color: $bgColor\"", $contents );
		}
		return $contents;
	}

	public function render_user_by_id( $id, $options ) {
		$user         = get_user_by( 'id', $id );
		$nl2br        = $options['nl2br'];
		$show_socials = $options['showSocials'];
		$bgColor      = $options['bgColor'];

		if ( ! $id ) {
			return '';
		}

		if ( ! $user ) {
			return;
		}

		$avatar         = get_avatar_url( $id );
		$description    = get_user_meta( $id, 'description', true );
		$profile_bg     = get_user_meta( $id, 'profile_bg', true );
		$profile_avatar = get_user_meta( $id, 'profile_avatar', true );
		if ( $profile_avatar ) {
			$avatars = wp_get_attachment_image_src( $profile_avatar, 'full' );
			$avatar  = $avatars[0];
		}
		$background = array();

		if ( $nl2br ) {
			$description = nl2br( $description );
		}
		if ( $profile_bg ) {
			$background = wp_get_attachment_image_src( $profile_bg, 'full' );
		}
		if ( ! $background ) {
			$template_image_path_base = get_template_directory_uri() . '/library/images/';
			$background               = array( $template_image_path_base . 'default.jpg', 924, 572 );
		}

		$socials = array(
			'X'                 => esc_url( get_user_meta( $id, 'twitter', true ) ),
			'fab fa-facebook-f' => esc_url( get_user_meta( $id, 'facebook', true ) ),
			'fab fa-instagram'  => esc_url( get_user_meta( $id, 'instagram', true ) ),
			'fa fa-rss'         => esc_url( get_user_meta( $id, 'feedly', true ) ),
			'fab fa-line'       => esc_url( get_user_meta( $id, 'line', true ) ),
			'fab fa-youtube'    => esc_url( get_user_meta( $id, 'youtube', true ) ),
			'Threads'           => esc_url( get_user_meta( $id, 'threads', true ) ),
		);

		if ( ! $show_socials ) {
			$socials = array();
		}

		ob_start();
		sng_show_profile(
			array(
				'background'   => $background,
				'avatar'       => $avatar,
				'display_name' => $user->display_name,
				'description'  => $description,
				'socials'      => $socials,
			)
		);

		$contents = ob_get_clean();
		if ( $bgColor ) {
			$contents = str_replace( 'class="my_profile"', "class=\"my_profile\" style=\"background-color: $bgColor\"", $contents );
		}
		return $contents;
	}
}
