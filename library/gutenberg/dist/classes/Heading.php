<?php

namespace SangoBlocks;

class Heading {

	public function init() {}
	public function hh1() {
		return '
      #inner-footer .hh1,
      #inner-content .hh1  {
        padding: 0.5em 0;
        border-bottom: solid 3px black;
      }
    ';
	}

	public function hh2() {
		return '
    #inner-footer .hh2,
    #inner-content .hh2 {
      border-bottom-width: 2px;
      border-bottom-style: dashed;
      color: #009EF3;
      border-bottom: dashed 2px #009EF3;
    }
    ';
	}

	public function hh3() {
		return '
    #inner-footer .hh3,
    #inner-content .hh3 {
      border-bottom: double 5px #009EF3;
    }
    ';
	}

	public function hh4() {
		return '
    #inner-footer .hh4,
    #inner-content .hh4 {
      color: #009EF3;
      padding: 0.5em 0;
      border-top: solid 3px #009EF3;
      border-bottom: solid 3px #009EF3;
    }
    ';
	}


	public function hh5() {
		return '
    #inner-footer .hh5,
    #inner-content .hh5 {
      background: #c2edff;
      padding: 0.5em;
    }
    ';
	}


	public function hh6() {
		return '
    #inner-footer .hh6,
    #inner-content .hh6 {
      color: #009EF3;
      border: solid 3px #009EF3;
      padding: 0.5em;
      border-radius: 0.5em;
    }
    ';
	}

	public function hh7() {
		return '
    #inner-footer .hh7,
    #inner-content .hh7 {
      padding: 0.5em;
      color: #010101;
      background: #b4e0fa;
      border-bottom: solid 3px #009EF3;
    }
    ';
	}

	public function hh8() {
		return '
    #inner-footer .hh8,
    #inner-content .hh8 {
      padding: 0.5em;
      color: #494949;
      background: #fffaf4;
      border-left: solid 5px #ffaf58;
    }
    ';
	}

	public function hh9() {
		return '
    #inner-footer .hh9,
    #inner-content .hh9 {
      padding: 0.5em;
      background: #b4e0fa;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.23);
    }
    ';
	}

	public function hh10() {
		return "
      #inner-footer .hh10,
      #inner-content .hh10 {
        color: #505050;
        padding: 0.5em;
        display: block;
        line-height: 1.3;
        background: #b4e0fa;
        vertical-align: middle;
        border-radius: 25px 0px 0px 25px;
      }
      #inner-footer .hh10:before,
      #inner-content .hh10:before {
        display: inline-block;
        content: '●';
        color: white;
        margin-right: 8px;
      }
    ";
	}

	public function hh11() {
		return "
      #inner-footer .hh11,
      #inner-content .hh11 {
        position: relative;
        padding: 0.6em;
        background: #b4e0fa;
      }
      #inner-footer .hh11:after,
      #inner-content .hh11:after {
        position: absolute;
        content: '';
        top: 100%;
        left: 30px;
        border: 15px solid transparent;
        border-top: 15px solid #b4e0fa;
        width: 0;
        height: 0;
      }";
	}

	public function hh12() {
		return '
      #inner-content .hh12,
      #inner-content .hh12 {
        background: #b4e0fa;
        box-shadow: 0px 0px 0px 5px #b4e0fa;
        margin-left: auto;
        margin-right: auto;
        border: dashed 1px #96c2fe;
        padding: 0.2em 0.5em;
        color: #454545;
      }
    ';
	}

	public function hh13() {
		return '
    #inner-footer .hh13,
    #inner-content .hh13 {
      background: #b4e0fa;
      box-shadow: 0px 0px 0px 5px #b4e0fa;
      margin-left: auto;
      margin-right: auto;
      border: dashed 1px #fff;
      padding: 0.2em 0.5em;
      color: #454545;
    }
    ';
	}


	public function hh14() {
		return "
    #inner-footer .hh14,
    #inner-content .hh14 {
      position: relative;
      background: #b4e0fa;
      box-shadow: 0px 0px 0px 5px #b4e0fa;
      border: dashed 2px white;
      padding: 0.2em 0.5em;
      margin-left: auto;
      margin-right: auto;
      color: #454545;
    }
    #inner-footer .hh14:after,
    #inner-content .hh14:after {
      position: absolute;
      content: '';
      left: -7px;
      top: -7px;
      border-width: 0 0 15px 15px;
      border-style: solid;
      border-color: #fff #fff #a8d4ff;
      box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.15);
    }
    ";
	}

	public function hh15() {
		return '
    #inner-footer .hh15,
    #inner-content .hh15 {
      position: relative;
      padding: 0.5em;
      background: #7fbae9;
      color: white;
    }
    #inner-footer .hh15:before,
    #inner-content .hh15:before {
      position: absolute;
      top: 100%;
      left: 0;
      border: none;
      border-right: solid 20px #74a4cb;
      border-bottom: solid 15px transparent;
      content: "";
    }
    ';
	}

	public function hh16() {
		return '
    #inner-footer .hh16,
    #inner-content .hh16 {
      position: relative;
      padding: 0.5em;
      background: #a6d3c8;
      color: white;
    }
    #inner-footer .hh16:before,
    #inner-content .hh16:before {
      position: absolute;
      top: 100%;
      left: 0;
      border: none;
      border-right: solid 20px rgb(149, 158, 155);
      border-bottom: solid 15px transparent;
      content: "";
    }
    ';
	}

	public function hh17() {
		return '
    #inner-content .hh17 {
      position: relative;
      border-bottom: solid 3px #cbcbcb;
    }
    #inner-footer .hh17:after,
    #inner-content .hh17:after {
      display: block;
      position: absolute;
      bottom: -3px;
      width: 30%;
      border-bottom: solid 3px #009EF3;
      content: " ";
    }
    ';
	}

	public function hh18() {
		return '
    #inner-footer .hh18,
    #inner-content .hh18 {
      position: relative;
      border-bottom: solid 3px #b4e0fa;
    }
    #inner-footer .hh18:after,
    #inner-content .hh18:after {
      display: block;
      position: absolute;
      bottom: -3px;
      width: 30%;
      border-bottom: solid 3px #009EF3;
      content: " ";
    }
    ';
	}

	public function hh19() {
		return '
    #inner-footer .hh19,
    #inner-content .hh19 {
      position: relative;
      padding-left: 25px;
    }
    #inner-footer .hh19:before,
    #inner-content .hh19:before {
      position: absolute;
      bottom: -3px;
      left: 0;
      width: 0;
      height: 0;
      border: none;
      border-bottom: solid 15px rgb(119, 195, 223);
      border-left: solid 15px transparent;
      content: "";
    }
    #inner-footer .hh19:after,
    #inner-content .hh19:after {
      position: absolute;
      bottom: -3px;
      left: 10px;
      width: 100%;
      border-bottom: solid 3px rgb(119, 195, 223);
      content: "";
    }
    ';
	}

	public function hh20() {
		return '
      #inner-footer .hh20,
      #inner-content .hh20 {
        padding: 0.5em;
        background: repeating-linear-gradient(
          -45deg,
          #cce7ff,
          #cce7ff 3px,
          #e9f4ff 3px,
          #e9f4ff 7px
        );
        text-shadow: 0 0 5px white;
      }
    ';
	}

	public function hh21() {
		return '
    #inner-footer .hh21,
    #inner-content .hh21 {
      padding: 0.5em;
      border-left: solid 7px #009EF3;
      background: repeating-linear-gradient(
        -45deg,
        #cce7ff,
        #cce7ff 3px,
        #e9f4ff 3px,
        #e9f4ff 7px
      );
      text-shadow: 0 0 5px white;
    }
    ';
	}

	public function hh22() {
		return '
    #inner-footer .hh22,
    #inner-content .hh22 {
      padding: 0.5em;
      border-top: solid 2px #6cb4e4;
      border-bottom: solid 2px #6cb4e4;
      background: repeating-linear-gradient(
        -45deg,
        #f0f8ff,
        #f0f8ff 3px,
        #e9f4ff 3px,
        #e9f4ff 7px
      );
      color: #6cb4e4;
      text-align: center;
    }
    ';
	}

	public function hh23() {
		return '
    #inner-footer .hh23,
    #inner-content .hh23 {
      position: relative;
      padding: 0.3em 0;
    }
    #inner-footer .hh23:after,
    #inner-content .hh23:after {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 7px;
      background: repeating-linear-gradient(
        -45deg,
        #6ad1c8,
        #6ad1c8 2px,
        #fff 2px,
        #fff 4px
      );
      content: "";
    }
    ';
	}

	public function hh24() {
		return '
    #inner-footer .hh24,
    #inner-content .hh24 {
      display: table;
      position: relative;
      padding: 0 55px;
      margin: 0 auto;
    }
    #inner-footer .hh24:before,
    #inner-footer .hh24:after,
    #inner-content .hh24:before,
    #inner-content .hh24:after {
      display: inline-block;
      position: absolute;
      top: 50%;
      width: 45px;
      height: 1px;
      background-color: black;
      content: "";
    }
    #inner-footer .hh24:before,
    #inner-content .hh24:before {
      left: 0;
    }
    #inner-footer .hh24:after,
    #inner-content .hh24:after {
      right: 0;
    }
    ';
	}

	public function hh25() {
		return '
      #inner-footer .hh25,
      #inner-content .hh25 {
        position: relative;
        padding: 0.4em 1em;
        border-top: solid 2px black;
        border-bottom: solid 2px black;
        text-align: center;
      }
      #inner-footer .hh25:before,
      #inner-footer .hh25:after,
      #inner-content .hh25:before,
      #inner-content .hh25:after {
        position: absolute;
        top: -7px;
        width: 2px;
        height: -webkit-calc(100% + 14px);
        height: calc(100% + 14px);
        background-color: black;
        content: "";
      }
      #inner-footer .hh25:before,
      #inner-content .hh25:before {
        left: 7px;
      }
      #inner-footer .hh25:after,
      #inner-content .hh25:after {
        right: 7px;
      }
    ';
	}

	public function hh26() {
		return '
    #inner-footer .hh26,
    #inner-content .hh26 {
      display: inline-block;
      position: relative;
      top: 0;
      padding: 0.25em 1em;
      line-height: 1.4;
    }
    #inner-footer .hh26:before,
    #inner-footer .hh26:after,
    #inner-content .hh26:before,
    #inner-content .hh26:after {
      display: inline-block;
      position: absolute;
      top: 0;
      width: 8px;
      height: 100%;
      content: "";
    }
    #inner-footer .hh26:before,
    #inner-content .hh26:before {
      left: 0;
      border-top: solid 1px black;
      border-bottom: solid 1px black;
      border-left: solid 1px black;
    }
    #inner-footer .hh26:after,
    #inner-content .hh26:after {
      right: 0;
      border-top: solid 1px black;
      border-right: solid 1px black;
      border-bottom: solid 1px black;
      content: "";
    }
    ';
	}

	public function hh27() {
		return '
    #inner-footer .hh27:first-letter,
    #inner-content .hh27:first-letter {
      font-size: 2em;
    }
    ';
	}

	public function hh28() {
		return '
      #inner-footer .hh28,
      #inner-content .hh28 {
        position: relative;
        padding: 0.25em 0;
      }
      #inner-footer .hh28:after,
      #inner-content .hh28:after {
        display: block;
        height: 4px;
        background: linear-gradient(to right, #009EF3, rgba(255, 255, 255, 0));
        content: "";
      }
    ';
	}

	public function hh29() {
		return '
    #inner-footer .hh29,
    #inner-content .hh29 {
      position: relative;
      padding: 0.35em 0.5em;
      background: linear-gradient(
        to right,
        rgb(255, 186, 115),
        rgba(255, 255, 255, 0)
      );
      color: #545454;
    }
    ';
	}

	public function hh30() {
		return "
    #inner-footer .hh30,
    #inner-content .hh30 {
      position: relative;
      padding-left: 1.2em;
      line-height: 1.4;
    }
    #inner-footer .hh30:before,
    #inner-content .hh30:before {
      position: absolute;
      top: 0;
      left: 0;
      color: #5ab9ff;
      font-family: FontAwesome;
      font-size: 1em;
      content: \"\f00c\";
    }
    ";
	}

	public function hh31() {
		return "
    #inner-footer .hh31,
    #inner-content .hh31 {
      position: relative;
      padding: 0.5em 0.5em 0.5em 1.5em;
      border-top: dotted 1px gray;
      border-bottom: dotted 1px gray;
      background: #fffff4;
      color: #ff6a6a;
      line-height: 1.4;
    }
    #inner-footer .hh31:before,
    #inner-content .hh31:before {
      position: absolute;
      top: 0.5em;
      left: 0.25em;
      color: #ff6a6a;
      font-family: FontAwesome;
      font-size: 1em;
      content: \"\f138\";
    }
    ";
	}

	public function hh32() {
		return "
    #inner-footer .hh32,
    #inner-content .hh32 {
      position: relative;
      padding: 0.5em 0.5em 0.5em 1.8em;
      background: #81d0cb;
      color: white;
      line-height: 1.4;
    }
    #inner-footer .hh32:before,
    #inner-content .hh32:before {
      position: absolute;
      left: 0.5em;
      font-family: FontAwesome;
      content: \"\f14a\";
    }
    ";
	}

	public function hh33() {
		return '
    #inner-footer .hh33,
    #inner-content .hh33 {
      padding: 0.5em;
      border-radius: 0.5em;
      background: #b0dcfa;
      color: white;
    }
    ';
	}

	public function hh34() {
		return "
    #inner-footer .hh34,
    #inner-content .hh34 {
      position: relative;
      padding-left: 1.2em;
      color: #7b6459;
    }
    #inner-footer .hh34:before,
    #inner-content .hh34:before {
      position: absolute;
      top: 0;
      left: 0;
      color: #ff938b;
      font-family: FontAwesome;
      font-size: 1em;
      content: \"\f1b0\";
    }
    ";
	}

	public function hh35() {
		return "
    #inner-footer .hh35,
    #inner-content .hh35 {
      display: inline-block;
      box-sizing: border-box;
      position: relative;
      height: 50px; /*リボンの高さ*/
      padding: 0 30px; /*横の大きさ*/
      background: #f57a78; /*塗りつぶし色*/
      color: #fff; /*文字色*/
      font-size: 18px; /*文字の大きさ*/
      text-align: center;
      vertical-align: middle;
      line-height: 50px; /*リボンの高さ*/
    }
    #inner-footer .hh35:before,
    #inner-content .hh35:before,
    #inner-footer .hh35:after,
    #inner-content .hh35:after {
      position: absolute;
      z-index: 1;
      width: 0;
      height: 0;
      content: '';
      display: block;
    }
    #inner-footer .hh35:before,
    #inner-content .hh35:before {
      top: 0;
      left: 0;
      border-width: 25px 0 25px 15px;
      border-style: solid;
      border-color: transparent transparent transparent #fff;
    }
    #inner-footer .hh35:after,
    #inner-content .hh35:after {
      top: 0;
      right: 0;
      border-width: 25px 15px 25px 0;
      border-style: solid;
      border-color: transparent #fff transparent transparent;
    }
    ";
	}

	public function hh36() {
		return '
    #inner-footer .hh36,
    #inner-content .hh36 {
      display: inline-block;
      box-sizing: border-box;
      position: relative;
      height: 60px;
      padding: 0 30px 0 10px;
      background: #ffc668;
      color: #fff;
      font-size: 18px;
      text-align: center;
      vertical-align: middle;
      line-height: 60px;
    }
    #inner-footer .hh36:after,
    #inner-content .hh36:after {
      position: absolute;
      z-index: 1;
      width: 0;
      height: 0;
      content: "";
    }
    #inner-footer .hh36:after,
    #inner-content .hh36:after {
      top: 0;
      right: 0;
      border-width: 30px 15px 30px 0;
      border-style: solid;
      border-color: transparent #fff transparent transparent;
    }
    ';
	}
}
