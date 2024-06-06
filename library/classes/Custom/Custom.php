<?php

namespace SANGO\Custom;

use SANGO\App;

class Custom {

	protected $dir = '';

	/*　管理画面生成時に読み込ませるディレクトリー */
	public function register_build_dir( $dir ) {
		$this->dir = $dir;
	}

	public function build() {
		// TODO pathを外部から設定できるようにしたい
		$dir = $this->dir;
		App::requireDir( get_template_directory() . $dir );
		// 子テーマの設定も読み込み
		App::requireDir( get_theme_file_path() . $dir );
	}
}
