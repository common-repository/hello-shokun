<?php
/*
Plugin Name: Hello-shokun
Version: 1.1
Description: これはただのプラグインではありません。
このプラグインが有効にされると、プラグイン管理画面以外の管理パネルの右上に shokun0803 の迷言がランダムに表示されます。
このプラグインは WordCamp Tokyo 2015 コントリビューターデイで学習のためにフォークして作成されたプラグインです。
Author: shokun0803
Text Domain: hello-shokun
Domain Path: /languages
*/
Class Hello_Shokun {
	/** @var Shokun  */
	private $shokun;
	public function __construct( Shokun $shokun ) {
		$this->shokun = $shokun;
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_shortcode( 'shokun', array( $this->shokun, 'say' ) );
	}
	public function admin_notices() {
		$chosen = $this->shokun->say();
		echo "<p id='shokun'>$chosen</p>";
	}
	public function admin_head() {
		$x = is_rtl() ? 'left' : 'right';
		echo "
        <style type='text/css'>
        #shokun {
            float: $x;
            padding-$x: 15px;
            padding-top: 5px;
            margin: 0;
            font-size: 11px;
        }
        </style>
        ";
	}
}
interface Shokun {
	/**
	 * @return string
	 */
	public function say();
}
Class Shokunsan implements Shokun {
	public function say() {
		$words = $this->getWords();
		return $words[ array_rand( $words ) ];
	}
	/**
	 * @return array
	 */
	public function getWords() {
		return array(
			"WordPress が大好きです！",
			"遅いわね、止まって見えるわ。",
			"5次元はどこにある？そりゃー給食の後でしょ！",
			"うーむ、どうやら迷子になったらしい…(´д｀)",
			"横須賀って遠いね…",
			"なぜか秋葉なう。",
			"ヾ(*ΦωΦ)ﾉ",
			"ふわっふー",
			"ハロウィンと言えば仮想だよね！",
			"ひと狩り行こうぜ！じゃなかった、ひと喰い行こうぜ！…でもなかった、飯喰い行こうぜ！（お腹がすきました）",
			"冷たいお茶を買ってきてくれたんじゃないのか…冷たいなぁ…(；´Д｀)",
			"だまれ！こぞう！",
		);
	}
}
function hello_shokun_init() {
	$shokunsan = new Shokunsan();
	new Hello_Shokun( $shokunsan );
}
add_action( 'plugins_loaded', 'hello_shokun_init' );
