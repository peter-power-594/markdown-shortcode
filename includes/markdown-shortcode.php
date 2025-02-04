<?php

namespace MarkdownShortCode;

if ( ! class_exists( 'Core' ) ) {


	class Core {


		protected static $parser;


		protected static $settings = [
			'slug' => 'markdown-shortcode',
			'dir' => '',
			'release' => 'stable',
			'version' => '1.1.0',
			'ready' => false,
			'loaded' => false
		];


		public function __construct() {
			self::$settings[ 'dir' ] = plugin_dir_path( __FILE__ );
			add_action( 'after_setup_theme', [ self::class, 'register_markdown_shortcode' ] );
		}


		public static function register_markdown_shortcode() {
			if ( ! self::$settings[ 'ready' ] ) {
				add_shortcode( 'markdown', [ self::class, 'trigger_shortcode' ] );
				self::$settings[ 'ready' ] = true;
			}
		}


		public static function trigger_shortcode( $atts = [], $content = null ) {
			if ( isset( $atts ) && is_array( $atts ) && count( $atts ) > 0 ) {
				$html = '<div';
				foreach ( $atts as $key => $value ) {
					$html .= ' ' . preg_replace( '#[^a-z_-]#', '', $key ) . '="' . sanitize_text_field( $value ) . '"';
				}
				$html .= '>';
				$html .= self::render_content( $content );
				$html .= '</div>';
				return $html;
			}
			return self::render_content( $content );
		}


		public static function render_content( $content = '' ) {
			if ( ! isset( $content ) || empty( $content ) ) {
				return '';
			}
			if ( ! self::$settings[ 'loaded' ] ) {
				self::$settings[ 'loaded' ] = true;
				require_once self::$settings[ 'dir' ]  . 'Michelf/Markdown.inc.php';
				require_once self::$settings[ 'dir' ]  . 'Michelf/MarkdownExtra.inc.php';
				require_once self::$settings[ 'dir' ]  . 'Michelf/MarkdownInterface.inc.php';
				self::$parser = new \Michelf\Markdown();
			}
			return self::$parser->transform( $content );
		}

	}


	final class ShortCodeInstance {

		private static $instance;
	
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceOf \MarkdownShortCode\ShortCodeInstance ) ) {
				self::$instance = new \MarkdownShortCode\Core();
			}
			return self::$instance;
		}
	
	}


}
