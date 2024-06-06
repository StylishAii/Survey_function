<?php

namespace SangoBlocks;

class SangoList {

	public function init() {}

	public function get_list_func_name( $className ) {
		if ( $className === 'li-dashed' ) {
			return 'dashed';
		} elseif ( $className === 'li-double' ) {
			return 'double';
		} elseif ( $className === 'li-tanbd' ) {
			return 'tanbd';
		} elseif ( $className === 'li-beige' ) {
			return 'beidge';
		} elseif ( $className === 'nobdr' ) {
			return 'nobdr';
		} elseif ( $className === 'li-circle' || $className === 'ol-circle' ) {
			return 'circle';
		} elseif ( $className === 'stitch-blue' || $className === 'stitch-red' || $className === 'stitch-orange' ) {
			return 'stitch';
		} elseif ( $className === 'li-chevron' ) {
			return 'chevron';
		} elseif ( $className === 'li-check' ) {
			return 'check';
		} elseif ( $className === 'li-yubi' ) {
			return 'yubi';
		} elseif ( $className === 'li-niku' ) {
			return 'niku';
		}
		return '';
	}

	public function dashed() {
		return '
      .li-dashed ul,
      .li-dashed ol {
        border-width: 2px;
        border-style: dashed;
      }
    ';
	}

	public function double() {
		return '
      .li-double ul,
      .li-double ol {
        border-width: 5px;
        border-style: double;
      }
    ';
	}

	public function tanbd() {
		return '
      .li-tandb ul,
      .li-tandb ol {
        padding: 1em 0 1em 1.3em;
        border-width: 2px;
        border-color: #373737;
        border-right: 0;
        border-left: 0;
        border-radius: 0;
      }
    ';
	}

	public function beidge() {
		return '
      .li-beige ul,
      .li-beige ol {
        border: 0;
        background: #fff9e7;
      }
    ';
	}

	public function nobdr() {
		return '
      .nobdr ul,
      .nobdr ol {
        border: 0;
      }
    ';
	}

	public function circle() {
		return '
      .ol-circle ol {
        list-style-type: none !important;
        padding: 1em 0.7em;
        counter-reset: number;
      }
      .ol-circle li {
        position: relative;
        padding: 0.5em 0 0.5em 34px;
        line-height: 1.5em;
      }

      .ol-circle li:before {
        display: inline-block;
        position: absolute;
        left: 0;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #5c9ee7;
        color: white;
        font-family: "Quicksand", sans-serif;
        font-size: 15px;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        line-height: 25px;
        content: counter(number);
        counter-increment: number;
      }
    ';
	}

	public function stitch() {
		return '
    .stitch-blue ul,
    .stitch-blue ol,
    .stitch-orange ul,
    .stitch-orange ol,
    .stitch-red ul,
    .stitch-red ol {
      margin: 2em 10px;
      border: dashed 2px #668ad8;
      border-radius: 10px;
      background: #f1f8ff;
      box-shadow: 0 0 0 10px #f1f8ff;
    }
    .stitch-orange ul,
    .stitch-orange ol {
      border-color: #ffa658;
      background: #fffbf1;
      box-shadow: 0 0 0 10px #fffbf1;
    }
    .stitch-red ul,
    .stitch-red ol {
      border-color: #f67c7c;
      background: #fff3f3;
      box-shadow: 0 0 0 10px #fff3f3;
    }
    ';
	}

	public function chevron() {
		return "

    .li-chevron ul {
      position: relative;
      padding: 1em 0.5em 1em 2.5em;
      border: solid 2px skyblue;
      border-radius: 5px;
    }

    .li-chevron li {
      list-style-type: none !important;
      padding: 0.5em 0;
      line-height: 1.5;
    }
    .li-chevron li:before {
      position: absolute;
      left: 1em;
      color: skyblue;
      font-family: FontAwesome;
      content: \"\\f138\";
    }
    ";
	}

	public function check() {
		return "
    .li-check li {
      list-style-type: none !important;
      padding: 0.5em 0;
      line-height: 1.5;
    }
    .li-check ul {
      position: relative;
      padding: 1em 0.5em 1em 2.5em;
      border: solid 2px #ffb03f;
    }
    .li-check li:before {
      position: absolute;
      left: 1em;
      color: #ffb03f;
      font-family: FontAwesome;
      content: \"\\f00c\";
    }
    ";
	}

	public function yubi() {
		return "
      .li-yubi li {
        list-style-type: none !important;
        padding: 0.5em 0;
        line-height: 1.5;
      }
      .li-yubi ul {
        position: relative;
        padding: 1em 0.5em 1em 2.5em;
        border: double 4px #21b384;
      }
      .li-yubi li:before {
        position: absolute;
        left: 1em;
        color: #21b384;
        font-family: FontAwesome;
        content: \"\\f0a4\";
      }
    ";
	}

	public function niku() {
		return "
    .li-niku li {
      list-style-type: none !important;
      padding: 0.5em 0;
      line-height: 1.5;
    }
    .li-niku ul {
      position: relative;
      padding: 1em 0.5em 1em 2.5em;
      border: solid 2px #ff938b;
      background: #fffaf1;
    }
    .li-niku li:before {
      position: absolute;
      left: 1em;
      color: #ff938b;
      font-family: FontAwesome;
      content: \"\\f1b0\";
    }
    ";
	}
}
