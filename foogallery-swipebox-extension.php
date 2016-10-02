<?php
/**
 * FooGallery Swipebox Extension
 *
 * Use the nice responsive swipebox for your FooGallery.
 *
 * @package   Swipebox_Lightbox_FooGallery_Extension
 * @author    Gabriel Ruffieux
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Gabriel Ruffieux
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - Swipebox
 * Description: Use the nice responsive swipebox for your FooGallery.
 * Version:     1.0.0
 * Author:      Gabriel Ruffieux
 * Author URI:  
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'Swipebox_Lightbox_FooGallery_Extension' ) ) {

	define('SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL', plugin_dir_url( __FILE__ ));
	define('SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION', '1.0.0');

	require_once( 'foogallery-swipebox-init.php' );

	class Swipebox_Lightbox_FooGallery_Extension {

		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_gallery_template_field_lightboxes', array($this, 'add_lightbox') );
			add_action( 'wp_enqueue_scripts', array($this, 'load_swipebox') );
			add_action( 'foogallery_template_lightbox-swipebox', array($this, 'add_required_files') );
			add_filter( 'foogallery_attachment_html_link_attributes', array($this, 'add_html_attributes') );
		}

		/**
		 * Add our lightbox to the lightbox dropdown on the gallery edit page
		 */
		function add_lightbox($lightboxes) {
			$lightboxes['swipebox'] = __( 'Swipebox', 'foogallery-swipebox' );
			return $lightboxes;
		}

		/**
		 * Add any JS or CSS required by the extension
		 */
		function add_required_files() {
			//enqueue the lightbox script
			wp_enqueue_script( 'swipebox', SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . 'js/lightbox-swipebox.js', array('jquery'), SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION );
			//optional : enqueue the init code to hook up your lightbox
			wp_enqueue_script( 'swipebox_init', SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . 'js/lightbox-swipebox-init.js', array('swipebox'), SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION, true );
			//enqueue the lightbox stylesheets
			foogallery_enqueue_style( 'swipebox', SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . 'css/lightbox-swipebox.css', array(), SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION );
		}
		
		function load_swipebox() {
			//enqueue the lightbox script
			wp_enqueue_script( 'jquery-swipebox', SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . 'swipebox/js/jquery.swipebox.min.js', array('jquery'), SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION );
			wp_enqueue_style( 'jquery-swipebox', SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . 'swipebox/css/swipebox.min.css', array(), SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_VERSION );
		}

		/**
		 * Optional. Alter the anchor attributes so that the lightbox extension can work
		 */
		function add_html_attributes($attr) {
			global $current_foogallery;

			$lightbox = foogallery_gallery_template_setting( 'lightbox' );

			//if the gallery is using our lightbox, then alter the HTML so the lightbox script can find it
			if ( 'swipebox' == $lightbox ) {
				//add custom attributes to the anchor
				$attr['rel'] = "swipebox[foogallery-{$current_foogallery->ID}]";
				$attr['class'] = "swipebox";
			}

			return $attr;
		}
	}
}