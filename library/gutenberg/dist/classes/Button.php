<?php

namespace SangoBlocks;

class Button {

	public function init() {}
	public function flat1() {
		return '
      .btn-flat1 a,
      .flat1 {
        display: inline-block;
        padding: 0.25em 0.5em;
        background: #ececec;
        color: #00bcd4;
        font-weight: bold;
      }
      .btn-flat1 a:hover,
      .flat1:hover {
        background: #00bcd4;
        color: white;
      }
    ';
	}

	public function flat2() {
		return '
      .btn-flat2 a,
      .flat2 {
        display: inline-block;
        padding: 0.3em 1em;
        border: solid 2px #67c5ff;
        border-radius: 3px;
        color: #67c5ff;
      }
      .btn-flat2 a:hover,
      .flat2:hover {
        background: #67c5ff;
        color: white;
      }
    ';
	}

	public function flat3() {
		return '
      .btn-flat3 a,
      .flat3 {
        display: inline-block;
        padding: 0.4em 1em;
        border: double 4px #67c5ff;
        border-radius: 3px;
        color: #67c5ff;
      }
      .btn-flat3 a:hover,
      .flat3:hover {
        background: #fffbef;
      }
    ';
	}

	public function flat4() {
		return '
    .btn-flat4 a,
    .flat4 {
      display: inline-block;
      padding: 0.5em 1em;
      border: dashed 2px #67c5ff;
      border-radius: 3px;
      color: #67c5ff;
    }
    .btn-flat4 a:hover,
    .flat4:hover {
      border-style: dotted;
      color: #679efd;
    }
    ';
	}

	public function flat5() {
		return '
    .btn-flat5 a,
    .flat5 {
      display: inline-block;
      padding: 0.5em 1em;
      border: dashed 2px #67c5ff;
      border-radius: 3px;
      color: #67c5ff;
    }
    .btn-flat5 a:hover,
    .flat5:hover {
      background: #cbedff;
      color: #fff;
    }
    ';
	}

	public function flat6() {
		return '
      .btn-flat6 a,
      .flat6 {
        display: inline-block;
        position: relative;
        padding: 0.5em 1em;
        border-right: solid 4px #668ad8;
        border-left: solid 4px #668ad8;
        background: #e1f3ff;
        color: #668ad8;
        font-weight: bold;
      }
      .btn-flat6 a:hover,
      .flat6:hover {
        background: #668ad8;
        color: #fff;
      }
    ';
	}

	public function flat7() {
		return '
      .btn-flat7 a,
      .flat7 {
        display: inline-block;
        position: relative;
        padding: 0.25em 0;
        color: #67c5ff;
        font-weight: bold;
      }
      .btn-flat7 a:hover,
      .flat7:before {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 4px;
        border-radius: 3px;
        background: #67c5ff;
        content: "";
      }
      .flat7:hover:before {
        top: -webkit-calc(100% - 3px);
        top: calc(100% - 3px);
      }
    ';
	}

	public function flat8() {
		return '
    .btn-flat8 a,
    .flat8 {
      display: inline-block;
      position: relative;
      padding: 0.25em 0.5em;
      border-radius: 0 20px 20px 0;
      background: #ececec;
      color: #00bcd4;
      font-weight: bold;
    }
    .btn-flat8 a:hover,
    .flat8:hover {
      background: #636363;
    }
    ';
	}

	public function flat9() {
		return '
      .btn-flat9 a,
      .flat9 {
        display: inline-block;
        position: relative;
        padding: 0.25em 0.5em;
        background: #00bcd4;
        color: #fff;
        font-weight: bold;
      }
      .btn-flat9 a:hover,
      .flat9:hover {
        background: #29a299;
      }
    ';
	}

	public function flat10() {
		return '
      .btn-flat10 a,
      .flat10 {
        display: inline-block;
        position: relative;
        padding: 8px 10px 5px 10px;
        border-bottom: solid 4px #ffa000;
        border-radius: 15px 15px 0 0;
        background: #fff1da;
        color: #ffa000;
        font-weight: bold;
      }
      .btn-flat10 a:hover,
      .flat10:hover {
        background: #ffc25c;
        color: #fff;
      }
    ';
	}

	public function flat11() {
		return '
    .btn-flat11 a,
    .flat11 {
      display: inline-block;
      position: relative;
      padding: 0.5em 1em;
      padding: 0.5em 1em;
      border-right: solid 4px #668ad8;
      border-left: solid 4px #668ad8;
      background: repeating-linear-gradient(
        -45deg,
        #cce7ff,
        #cce7ff 3px,
        #e9f4ff 3px,
        #e9f4ff 7px
      );
      text-shadow: 0 0 5px white;
      color: #668ad8;
      font-weight: bold;
    }
    .btn-flat11 a:hover,
    .flat11:hover {
      background: repeating-linear-gradient(
        -45deg,
        #cce7ff,
        #cce7ff 5px,
        #e9f4ff 5px,
        #e9f4ff 9px
      );
    }
    ';
	}

	public function grad1() {
		return '
    .btn-grad1 a,
    .grad1 {
      display: inline-block;
      padding: 0.5em 1em;
      border-radius: 3px;
      background: linear-gradient(45deg, #709dff 0%, #92e6ff 100%);
      color: #fff;
    }
    .btn-grad1 a:hover,
    .grad1:hover {
      background: linear-gradient(90deg, #709dff 0%, #92e6ff 100%);
    }
    ';
	}

	public function grad2() {
		return '
    .btn-grad2 a,
    .grad2 {
      display: inline-block;
      padding: 0.5em 1em;
      border-radius: 3px;
      background: linear-gradient(95deg, #ff7070 0%, #fdd973 100%);
      color: #fff;
    }
    .btn-grad2 a:hover,
    .grad2:hover {
      background: linear-gradient(140deg, #ff7070 0%, #fdd973 100%);
    }
    ';
	}

	public function grad3() {
		return '
      .btn-grad3 a,
      .grad3 {
        display: inline-block;
        padding: 7px 20px;
        border-radius: 25px;
        background: linear-gradient(45deg, #ffc107 0%, #ff8b5f 100%);
        color: #fff;
      }
      .btn-grad3 a:hover,
      .grad3:hover {
        background: linear-gradient(45deg, #ffc107 0%, #f76a35 100%);
      }
    ';
	}

	public function grad4() {
		return '
      .btn-grad4 a,
      .grad4 {
        display: inline-block;
        padding: 0.5em 1em;
        background: linear-gradient(#6795fd 0%, #67ceff 100%);
        color: #fff;
      }
      .btn-grad4 a:hover,
      .grad4:hover {
        background: linear-gradient(#6795fd 0%, #67ceff 70%);
      }
    ';
	}

	public function cubic1() {
		return '
    .btn-cubic1 a,
    .cubic1 {
      display: inline-block;
      padding: 0.5em 1em;
      border-bottom: solid 4px rgba(0, 0, 0, 0.27);
      border-radius: 3px;
      color: #fff;
    }
    .btn-cubic1 a:hover,
    .cubic1:active {
      border-bottom: none;
      box-shadow: 0 0 1px rgba(0, 0, 0, 0.2); /*影を小さく*/
      -webkit-transform: translateY(4px);
      -ms-transform: translateY(4px);
      transform: translateY(4px); /*下に動く*/
    }
    ';
	}

	public function cubic2() {
		return '
    .btn-cubic2 a,
    .cubic2 {
      display: inline-block;
      position: relative;
      padding: 6px 15px 4px;
      border-bottom: solid 2px rgba(0, 0, 0, 0.2);
      border-radius: 4px; /*角の丸み*/
      box-shadow: inset 0 2px 0 rgba(255, 255, 255, 0.2),
        0 2px 2px rgba(0, 0, 0, 0.19);
      color: #fff;
      font-weight: bold;
    }
    .btn-cubic2 a:hover,
    .cubic2:active {
      border-bottom: solid 2px rgba(0, 0, 0, 0.05);
      box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
    }
    ';
	}

	public function cubic3() {
		return '
    .btn-cubic3 a,
    .cubic3 {
      display: inline-block;
      position: relative;
      padding: 0.25em 0.5em;
      border: solid 1px rgba(0, 0, 0, 0.19);
      border-radius: 4px;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
      text-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
      color: #fff;
    }
    .btn-cubic3 a:hover,
    .cubic3:active {
      border: solid 1px rgba(0, 0, 0, 0.05);
      box-shadow: none;
      text-shadow: none;
    }
    ';
	}
}
