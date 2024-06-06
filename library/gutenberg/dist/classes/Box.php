<?php

namespace SangoBlocks;

class Box {

	public function init() {}
	public function box1() {
		return '
      .box1 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border: solid 2px #000;
        font-weight: bold;
      }
    ';
	}

	public function box2() {
		return '
     .box2 {
         margin: 2em 0;
         padding: 1.5em 1em;
         border: solid 2px #d1d1d1;
         border-radius: 5px;
         background: #fff;
      }
    ';
	}

	public function box3() {
		return '
     .box3 {
         margin: 2em 0;
         padding: 1.5em 1em;
         background: #edf6ff;
         color: #2c2c2f;
      }
    ';
	}

	public function box4() {
		return '
    .box4 {
      margin: 2em 0;
      padding: 1.5em 1em;
      border-top: solid 3px #009EF3;
      border-bottom: solid 3px #009EF3;
      background: #eef7ff;
      color: #2c2c2f;
    }
    ';
	}

	public function box5() {
		return '
    .box5 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border: double 5px #4ec4d3;
        color: #474747;
    }
    ';
	}

	public function box6() {
		return '
    .box6 {
      margin: 2em 0;
      padding: 1.5em 1em;
      border: dashed 2px #009EF3;
      background: #edf6ff;
    }
    ';
	}

	public function box7() {
		return '
      .box7 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border-right: double 7px #4ec4d3;
        border-left: double 7px #4ec4d3;
        background: whitesmoke;
        color: #474747;
      }
    ';
	}

	public function box8() {
		return '
    .box8 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border-left: solid 6px #ffc06e;
        background: #fff8e8;
        color: #232323;
      }
    ';
	}

	public function box9() {
		return '
    .box9 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border-top: solid 6px #f47d7d;
        background: #fceded;
        color: #f47d7d;
        font-weight: bold;
      }
    ';
	}

	public function box10() {
		return '
    .box10 {
      margin: 2em 0;
      padding: 1.5em 1em;
      border-top: solid 6px #1dc1d6;
      background: #e4fcff;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.22);
      color: #00bcd4;
    }
    ';
	}

	public function box11() {
		return '
    .box11 {
      margin: 2em 0;
      padding: 1.5em 1em;
      border-top: solid 5px #5d627b;
      background: white;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.22);
      color: #5d627b;
    }
    ';
	}

	public function box12() {
		return '
    .box12 {
      margin: 2em 0;
      padding: 1.5em 1em;
      border-bottom: solid 6px #aac5de;
      border-radius: 9px;
      background: #c6e4ff;
      color: #5989cf;
      font-weight: bold;
    }
    ';
	}

	public function box13() {
		return '
    .box13 {
        margin: 2em 0;
        padding: 1.5em 1em;
        border-bottom: solid 6px #3f87ce;
        border-radius: 9px;
        background: #6eb7ff;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.22);
        color: #fff;
        font-weight: bold;
      }
    ';
	}

	public function box14() {
		return '
    .box14 {
        margin: 2em 10px;
        padding: 1.5em 1em;
        border: dashed 2px white;
        background: #d6ebff;
        box-shadow: 0 0 0 10px #d6ebff;
      }
    ';
	}

	public function box15() {
		return '
    .box15 {
        margin: 2em 10px;
        padding: 1.5em 1em;
        border: dashed 2px #ffc3c3;
        border-radius: 8px;
        background: #ffeaea;
        box-shadow: 0 0 0 10px #ffeaea;
        color: #565656;
      }
    ';
	}

	public function box16() {
		return '
    .box16 {
        margin: 2em 0;
        padding: 1.5em 1em;
        background: repeating-linear-gradient(
          -45deg,
          #f0f8ff,
          #f0f8ff 3px,
          #e9f4ff 3px,
          #e9f4ff 7px
        );
    }
    ';
	}

	public function box17() {
		return '
      .box17 {
        position: relative;
        margin: 2em 0;
        padding: 1em 2em;
        border-top: solid 2px black;
        border-bottom: solid 2px black;
      }
      .box17:before,
      .box17:after {
        position: absolute;
        top: -10px;
        width: 2px;
        height: -webkit-calc(100% + 20px);
        height: calc(100% + 20px);
        background-color: black;
        content: "";
      }
      .box17:before {
        left: 10px;
      }
      .box17:after {
        right: 10px;
      }
    ';
	}

	public function box18() {
		return '
      .box18 {
        position: relative;
        margin: 2em 0;
        padding: 1.5em 1em;
        border: solid 2px #ffcb8a;
        border-radius: 3px 0 3px 0;
      }
      .box18:before,
      .box18:after {
        position: absolute;
        width: 10px;
        height: 10px;
        border: solid 2px #ffcb8a;
        border-radius: 50%;
        content: "";
      }
      .box18:after {
        top: -12px;
        left: -12px;
      }
      .box18:before {
        right: -12px;
        bottom: -12px;
      }
  ';
	}

	public function box19() {
		return '
      .box19 {
        position: relative;
        padding: 1.5em 1em;
      }
      .box19:before,
      .box19:after {
        display: inline-block;
        position: absolute;
        width: 20px;
        height: 30px;
        content: "";
      }
      .box19:before {
        top: 0;
        left: 0;
        border-top: solid 1px #5767bf;
        border-left: solid 1px #5767bf;
      }
      .box19:after {
        right: 0;
        bottom: 0;
        border-right: solid 1px #5767bf;
        border-bottom: solid 1px #5767bf;
      }
  ';
	}

	public function box20() {
		return '
      .box20 {
        position: relative;
        top: 0;
        margin: 2em 0;
        padding: 1.5em 1em;
        background: #efefef;
      }
      .box20:before,
      .box20:after {
        display: inline-block;
        box-sizing: border-box;
        position: absolute;
        top: 0;
        width: 15px;
        height: 100%;
        content: "";
      }
      .box20:before {
        left: 0;
        border-top: dotted 2px #15adc1;
        border-bottom: dotted 2px #15adc1;
        border-left: dotted 2px #15adc1;
      }
      .box20:after {
        right: 0;
        border-top: dotted 2px #15adc1;
        border-right: dotted 2px #15adc1;
        border-bottom: dotted 2px #15adc1;
      }
    ';
	}

	public function box21() {
		return '
      .box21 {
        margin: 2em 0;
        padding: 1.3em;
        background: linear-gradient(to left, #92d2f8, #c4baff);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.13);
        color: #fff;
        font-weight: bold;
      }
    ';
	}

	public function box22() {
		return '
      .box22 {
        margin: 1em 0;
        padding: 1.5em 1em;
        border-left: solid 6px #009EF3;
        background: #f6f6f6;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.33);
      }
    ';
	}

	public function box23() {
		return "
      .box23 {
        position: relative;
        max-width: 400px;
        margin: 2em 0 2em 40px;
        padding: 20px;
        border-radius: 30px;
        background: #fff0c6;
      }
      .box23:before {
        position: absolute;
        bottom: 0;
        left: -40px;
        color: #fff0c6;
        font-family: FontAwesome;
        font-size: 15px;
        content: \"\\f111\";
      }
      .box23:after {
        position: absolute;
        bottom: 0;
        left: -23px;
        color: #fff0c6;
        font-family: FontAwesome;
        font-size: 23px;
        content: \"\\f111\";
      }
    ";
	}

	public function box24() {
		return '
      .box24 {
        position: relative;
        margin: 2em 0;
        padding: 0.8em 1em;
        background: #e6f4ff;
        color: #5c98d4;
        font-weight: bold;
      }
      .box24:after {
        position: absolute;
        top: 100%;
        left: 30px;
        width: 0;
        height: 0;
        border: 15px solid transparent;
        border-top: 15px solid #e6f4ff;
        content: "";
      }
    ';
	}
}
