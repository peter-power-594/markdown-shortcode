<?php
/**
 * Markdown Shortcode
 *
 * Plugin Name: Markdown Shortcode
 * Description: Standalone shortcode to render markdown with Michel Fortin's Markdown library.
 * Version:	 1.0.0
 * Author:	  Pierre-Henri Lavigne
 * Author URI:  https://github.com/peter-power-594/markdown-shortcode
 * License:	 GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: markdown-shortcode
 * Domain Path: /languages
 * Requires at least: 4.9
 * Tested up to: 6.7.1
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * The markdown library written by Michel Fortin can actually be installed or updated via Composer,
 * and is currentlybundled as it is: a permissive license. Please refer to the License.md file for more details.
 */

namespace MarkdownShortCode;
defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'ShortCode' ) ) {


	class Core {


		protected static $parser;


		protected static $settings = [
			'slug' => 'markdown-shortcode',
			'dir' => '',
			'release' => 'stable',
			'version' => '1.0.0',
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
				require_once self::$settings[ 'dir' ]  . './includes/Michelf/Markdown.inc.php';
				require_once self::$settings[ 'dir' ]  . './includes/Michelf/MarkdownExtra.inc.php';
				require_once self::$settings[ 'dir' ]  . './includes/Michelf/MarkdownInterface.inc.php';
				self::$parser = new \Michelf\Markdown();
			}
			return self::$parser->transform( $content );
		}

	}


	final class ShortCodeInstance {

		private static $instance;
	
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceOf \MarkdownShortCode\Core ) ) :
				self::$instance = new \MarkdownShortCode\Core();
			endif;
			return self::$instance;
		}
	
	}


	if ( ! function_exists( 'markdown_shortcode' ) ) :
		function markdown_shortcode() {
			return \MarkdownShortCode\ShortCodeInstance::instance();
		}
		// Run
		markdown_shortcode();
	endif;


}
