<?php
/**
 * Plugin Name:     Lightning Header Logo After Widget
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Vektor,Inc.
 * Author URI:      YOUR SITE HERE
 * Text Domain:     lightning-header-logo-after-widget
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Lightning_Header_Logo_After_Widget
 */

// Your code starts here.

if ( ! class_exists( 'Lightning_Header_Logo_After_Widget' ) ) {
	class Lightning_Header_Logo_After_Widget {

		/*
		-------------------------------------------
		  実行
		-------------------------------------------
		*/
		public function __construct() {

			if ( is_active_sidebar( 'header-logo-after-widget-area' ) ) {
				add_action( 'lightning_header_logo_after', array( $this, 'lightning_header_logo_after_widget' ) );
				add_action( 'wp_head', array( $this, 'print_css' ) );
			}
			add_action( 'after_setup_theme', array( $this, 'remove_header_contact' ) );
			add_action( 'widgets_init', array( $this, 'register_widget' ) );
		}

		public static function remove_header_contact() {
			if ( is_active_sidebar( 'header-logo-after-widget-area' ) ) {
				global $lightning_header_contact;
				remove_action( 'lightning_header_logo_after', array( $lightning_header_contact, 'lightning_header_contact_html' ) );
			}
		}

		public static function register_widget() {
			$description  = '<ul>';
			$description .= '<li>この領域にウィジェットがセットされている場合はデフォルトの電話番号とお問い合わせボタンは表示されなくなります。</li>';
			$description .= '<li>この領域には任意のHTMLあるいは画像ウィジェットを配置する事を想定しています。CSSで独自のデザイン調整が必要です。</li>';
			$description .= '<li>モバイル時に非表示にする場合は、「外観 > カスタマイズ」画面の「追加CSS」パネルなどに <br>@media (max-width: 991px){<br>.headerLogoAfter { display:none; }<br>}</br>を記載してください。</li>';
			$description .= '</ul>';

			register_sidebar(
				array(
					'name'          => __( 'ヘッダー 右側エリア', 'lightning' ),
					'id'            => 'header-logo-after-widget-area',
					'before_widget' => '<aside class="widget headerLogoAfter %2$s" id="%1$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h1 class="widget-title subSection-title">',
					'after_title'   => '</h1>',
					'description'   => $description,
				)
			);
		}

		/*
		-------------------------------------------
		  Header contact
		-------------------------------------------
		*/

		public static function lightning_header_logo_after_widget() {
			dynamic_sidebar( 'header-logo-after-widget-area' );

		} // public static function lightning_header_contact_html() {



		public static function print_css() {
			$dynamic_css = '/* Lightning_Header_Logo_After_Widget */
			@media (max-width: 991px){
				.headerLogoAfter { display:none; }
			}
			';
			// delete before after space
			$dynamic_css = trim( $dynamic_css );
			// convert tab and br to space
			$dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
			// Change multiple spaces to single space
			$dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );
			wp_add_inline_style( 'lightning-design-style', $dynamic_css );
		}


	} // class Lightning_Header_Logo_After_Widget {

	// フックさせるために変数に入れているので外さない。
	$lightning_header_logo_after_widget = new Lightning_Header_Logo_After_Widget();
}
