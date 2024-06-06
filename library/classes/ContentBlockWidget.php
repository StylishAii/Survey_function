<?php

use SANGO\App;

// 広告ウィジェット
class ContentBlockWidget extends WP_Widget {
	public function __construct() {
		parent::__construct( false, $name = '【SANGO】コンテンツブロック' );
	}
	public function widget( $args, $instance ) {
		global $post;
		$cb              = App::get( 'content-block' );
		$id              = isset( $instance['cb'] ) ? $instance['cb'] : '';
		$class_name      = isset( $instance['class_name'] ) ? $instance['class_name'] : '';
		$hide_cb_on_top  = isset( $instance['hide_cb_on_top'] ) ? esc_attr( $instance['hide_cb_on_top'] ) : '';
		$hide_categories = isset( $instance['hide_categories'] ) ? $instance['hide_categories'] : array();
		$cat             = get_query_var( 'cat' );
		$content         = $cb->get_content_block( $id, $class_name );
		$status          = \SANGO\App::get( 'status' )->get_status();

		if ( $status['is_top'] && ! $status['is_paged'] ) {
			if ( $hide_cb_on_top ) {
				return;
			}
		}

		// カテゴリーページの場合
		if ( $cat ) {
			$category = get_category( $cat );
			foreach ( $hide_categories as $hide_category ) {
				if ( isset( $category->cat_ID ) && $hide_category === strval( $category->cat_ID ) ) {
					return;
				}
			}
			// 記事ページの場合
		} else {
			$categories = get_the_category();
			foreach ( $categories as $category ) {
				foreach ( $hide_categories as $hide_category ) {
					if ( $hide_category === strval( $category->term_id ) ) {
						return;
					}
				}
			}
		}

		?>
	<div class="my_content_block">
		<?php echo $content; ?>
	</div>
		<?php
	}
	public function form( $instance ) {

		$cb              = isset( $instance['cb'] ) ? esc_attr( $instance['cb'] ) : '';
		$id              = isset( $instance['cb'] ) ? $instance['cb'] : '';
		$title           = isset( $instance['title'] ) ? $instance['title'] : '';
		$class_name      = isset( $instance['class_name'] ) ? $instance['class_name'] : '';
		$hide_cb_on_top  = isset( $instance['hide_cb_on_top'] ) ? esc_attr( $instance['hide_cb_on_top'] ) : '';
		$hide_categories = isset( $instance['hide_categories'] ) ? $instance['hide_categories'] : array();
		$categories      = get_categories();
		$block           = App::get( 'content-block' );
		$content_blocks  = $block->available_content_block_name_list();
		?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">タイトル:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'class_name' ); ?>">クラス名:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'class_name' ); ?>" name="<?php echo $this->get_field_name( 'class_name' ); ?>" type="text" value="<?php echo $class_name; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'cb' ); ?>">コンテンツブロック</label>
		<select name="<?php echo $this->get_field_name( 'cb' ); ?>">
		<option value="">選択してください</option>
		<?php
		if ( $content_blocks && count( $content_blocks ) > 0 ) {
			foreach ( $content_blocks as $key => $label ) {
				?>
			<option value="<?php echo $key; ?>"
										<?php
										if ( intval( $key ) === intval( $id ) ) {
											echo ' selected'; }
										?>
			><?php echo $label; ?></option>
				<?php
			}
		}
		?>
		</select>
	</p>
	<p>
		<input id="<?php echo $this->get_field_id( 'hide_cb_on_top' ); ?>" name="<?php echo $this->get_field_name( 'hide_cb_on_top' ); ?>" type="checkbox" value="1" <?php checked( $hide_cb_on_top, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'hide_cb_on_top' ); ?>">トップページでは表示しない</label>
	</p>
	<p><small>チェックの入っているカテゴリーのページではコンテンツブロックを非表示にします。</small></p>
	<p>
		<?php
		foreach ( $categories as $category ) {
			$checked = '';
			foreach ( $hide_categories as $hide_category ) {
				if ( $hide_category === strval( $category->term_id ) ) {
					$checked = ' checked';
					break;
				}
			}
			?>
		<label style="display: inline-block; margin-right: 5px;">
			<input type="checkbox" value="<?php echo $category->term_id; ?>" name="<?php echo $this->get_field_name( 'hide_categories' ); ?>[]" <?php echo $checked; ?>/>
			<?php echo $category->name; ?>
		</label>
			<?php
		}
		?>
	</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance                    = $old_instance;
		$instance['cb']              = $new_instance['cb'];
		$instance['title']           = $new_instance['title'];
		$instance['class_name']      = $new_instance['class_name'];
		$instance['hide_cb_on_top']  = $new_instance['hide_cb_on_top'];
		$instance['hide_categories'] = $new_instance['hide_categories'];
		return $instance;
	}
}
