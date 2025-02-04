<?php
/**
 * Markdown Shortcode
 *
 * Plugin Name: Markdown Shortcode
 * Description: Standalone shortcode to render markdown with Michel Fortin's Markdown library.
 * Version:	 1.1.0
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

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/markdown-shortcode.php';

if ( ! function_exists( 'markdown_shortcode' ) ) {
	function markdown_shortcode( $content = '' ) {
		if ( ! isset( $content ) || empty( $content ) ) {
			return \MarkdownShortCode\ShortCodeInstance::instance();
		}
		else {
			$my_instance = \MarkdownShortCode\ShortCodeInstance::instance();
			return $my_instance::render_content( $content );		
		}
	}
	// Run
	markdown_shortcode();
}
