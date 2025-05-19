<?php
/**
 * Template part for footer cta
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object ) = BaseTheme::defaults();

$bst_var_to_cta_headline  = $bst_option_fields['bst_var_tocta_title'] ?? null;
$bst_var_tocta_bg_image   = $bst_option_fields['bst_var_tocta_bg_image'] ?? null;
$bst_var_tocta_button_one = $bst_option_fields['bst_var_tocta_button_one'] ?? null;
$bst_var_tocta_button_two = $bst_option_fields['bst_var_tocta_button_two'] ?? null;

$bst_var_cta_visibility   = $bst_fields['bst_var_cta_visibility'] ?? null;
$bst_var_pocta_title      = $bst_fields['bst_var_pocta_title'] ?? $bst_var_to_cta_headline;
$bst_var_pocta_bg_image   = $bst_fields['bst_var_pocta_bg_image'] ?? $bst_var_tocta_bg_image;
$bst_var_pocta_button_one = $bst_fields['bst_var_pocta_button_one'] ?? $bst_var_tocta_button_one;
$bst_var_pocta_button_two = $bst_fields['bst_var_pocta_button_two'] ?? $bst_var_tocta_button_two;

?>
<section id="cta-section" class="cta-section">
	<!-- cta Start -->
	<div class="cta-single">
		<div class="wrapper">
			<?php echo !empty($bst_var_pocta_bg_image) ? '<div class="footer-logo">' . wp_get_attachment_image($bst_var_pocta_bg_image, 'thumb_200') . '</div>' : ''; ?>
			<?php echo !empty($bst_var_pocta_title) ? '<div class="gl-s52"></div><h2 class="heading-2 block-title mb-0">' . esc_html($bst_var_pocta_title) . '</h2>' : ''; ?>
			<?php echo !empty($bst_var_pocta_button_one) ? '<div class="gl-s52"></div><div class="block-btn center-align">' . BaseTheme::button($bst_var_pocta_button_one, 'site-btn btn-red-cta') . '</div>' : ''; ?>
			<?php echo !empty($bst_var_pocta_button_two) ? '<div class="gl-s52"></div><div class="block-btn center-align">' . BaseTheme::button($bst_var_pocta_button_two, 'site-btn btn-red-cta') . '</div>' : ''; ?>
		</div>
	</div>
	<!-- cta End -->
</section>
