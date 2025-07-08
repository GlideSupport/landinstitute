<?php
/**
 * Blocks related functions
 *
 * @link
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

namespace BaseTheme\Blocks;

use BaseTheme;

/**
 * Template Class For Blocks
 *
 * Template Class
 *
 * @category Setting_Class
 * @package  Base Theme Package
 */
class WP_Theme_Blocks {
	/**
	 * Define class Constructor
	 **/
	public function __construct() {
		add_action( 'init', array( $this, 'register_acf_blocks' ) );
	}

	/**
	 * A function in which all acf blocks are registered
	 *
	 *  @return void
	 */
	public function register_acf_blocks() {

		register_block_type( BASETHEME_BLOCK_DIR . '/section-container' );

		// Register a block - Hero.
		self::register_acf_block('hero');
		
		// Register a block - Two Column Text.
		self::register_acf_block('two-column-text');
		
		// Register a block - Internal Link List.
		self::register_acf_block('internal-link-list');
		
		// Register a block - Impact Map.
		self::register_acf_block('impact-map');
		
		// Register a block - Post Teaser.
		self::register_acf_block('post-teaser');
		
		// Register a block - CTA Grid.
		self::register_acf_block('cta-grid');
		
		// Register a block - Full Width Image.
		self::register_acf_block('full-width-image');

		// Register a block - Testimonial.
		self::register_acf_block('testimonial');

		// Register a block - Airtable Map.
		self::register_acf_block('airtable-map');

		// Register a block - Stats.
		self::register_acf_block('stats');

		// Register a block - Logo Grid.
		self::register_acf_block('logo-grid');

		// Register a block - Theme Button.
		self::register_acf_block('theme-button');

		// Register a block - Numbered Grid.
		self::register_acf_block('numbered-grid');

		// Register a block - Midpage CTA.
		self::register_acf_block('midpage-cta');

		// Register a block - Staff List.
		self::register_acf_block('staff-list');

		// Register a block - Theme Form.
		self::register_acf_block('theme-form');

		// Register a block - Lead Paragraph.
		self::register_acf_block('lead-paragraph');

		// Register a block - CTA Slider.
		self::register_acf_block('cta-slider');

		// Register a block - Logos w/ Text.
		self::register_acf_block('logos-w-text');

		// Register a block - FAQ.
		self::register_acf_block('faq');

		// Register a block - Text List .
		self::register_acf_block('text-list');

		// Register a block - Image Gallery.
		self::register_acf_block('image-gallery');

		// Register a block - CTA Columns.
		self::register_acf_block('cta-columns');

		// Register a block - CTA Rows.
		self::register_acf_block('cta-rows');

		// Register a block - Timeline.
		self::register_acf_block('timeline');
		
		// Register a block - Image Alongside Text.
		self::register_acf_block('image-alongside-text');
		
		// Register a block - Scrolling Text.
		self::register_acf_block('scrolling-text');
		
		// Register a block - Event Teaser.
		self::register_acf_block('event-teaser');
		
		// Register a block - Theme Divider.
		self::register_acf_block('theme-divider');
		
		// Register a block - Image List.
		self::register_acf_block('image-list');
		
		// Register a block - Icon Grid.
		self::register_acf_block('icon-grid');
		
		// Register a block - Video Alongside Text.
		self::register_acf_block('video-alongside-text');
		
		// Register a block - Theme Video.
		self::register_acf_block('theme-video');
		
		// Register a block - Block Quote.
		self::register_acf_block('block-quote');
		
		// Register a block - Tabbed Content.
		self::register_acf_block('tabbed-content');
		
		// Register a block - Map Embed.
		self::register_acf_block('map-embed');
		
		// Register a block - Letter.
		self::register_acf_block('letter');
		
		// Register a block - Download List.
		self::register_acf_block('download-list');

		// Register a block - BG Pattern.
		self::register_acf_block('bg-pattern');
		
		// Register a block - Memorial PDFS.
		self::register_acf_block('memorial-pdfs');
		
		// Register a block - Accordion with Image.
		self::register_acf_block('accordion-with-image');
		
		// Register a block - Text List.
		self::register_acf_block('text-list');
		
		// Register a block - Airtable Map.
		self::register_acf_block('airtable-map');

		// Register a block - Info Box.
		self::register_acf_block('info-box');

		// Register a block - Past Event.
		self::register_acf_block('past-events');

		// Register a block - Lead Paragraph.
		self::register_acf_block('lead-paragraph');

		// [register_here].
	}


	/**
	 * A function which is used to register a block
	 *
	 * @param string  $block_name is the name of the block.
	 * @param boolean $has_script is boolean value that determines if block need to include script or not.
	 * @param array   $block_scripts is array to use when need external file in the block.
	 *
	 *  @return void
	 */
	protected static function register_acf_block( $block_name = null, $has_script = false, $block_scripts = null ) {
		if ( $has_script ) {
			$block_script_order = array( 'jquery' );
			$dependencies       = array();
			if ( $block_scripts ) {
				$dependencies = BaseTheme::register_scripts( $block_scripts );
			}
			$block_script_order = array_merge( $block_script_order, $dependencies );
			BaseTheme::register_script(
				'blocks/' . $block_name . '/' . $block_name . '.js',
				$block_script_order,
				args:array(
					'in_footer' => true,
					'strategy'  => 'defer',
				),
			);
		}
		register_block_type( BASETHEME_BLOCK_DIR . '/' . $block_name );
	}
}
new WP_Theme_Blocks();