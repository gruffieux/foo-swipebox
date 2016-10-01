<?php
//This init class is used to add the extension to the extensions list while you are developing them.
//When the extension is added to the supported list of extensions, this file is no longer needed.

if ( !class_exists( 'Swipebox_Lightbox_FooGallery_Extension_Init' ) ) {
	class Swipebox_Lightbox_FooGallery_Extension_Init {

		function __construct() {
			add_filter( 'foogallery_available_extensions', array( $this, 'add_to_extensions_list' ) );
		}

		function add_to_extensions_list( $extensions ) {
			$extensions[] = array(
				'slug'=> 'swipebox',
				'class'=> 'Swipebox_Lightbox_FooGallery_Extension',
				'title'=> __('Swipebox', 'foogallery-swipebox'),
				'file'=> 'foogallery-swipebox-extension.php',
				'description'=> __('Use the nice responsive swipebox for your FooGallery.', 'foogallery-swipebox'),
				'author'=> 'Gabriel Ruffieux',
				'author_url'=> 'https://github.com/gruffieux',
				'thumbnail'=> SWIPEBOX_LIGHTBOX_FOOGALLERY_EXTENSION_URL . '/assets/extension_bg.png',
				'tags'=> array( __('lightbox', 'foogallery') ),	//use foogallery translations
				'categories'=> array( __('Build Your Own', 'foogallery') ), //use foogallery translations
				'source'=> 'generated'
			);

			return $extensions;
		}
	}

	new Swipebox_Lightbox_FooGallery_Extension_Init();
}