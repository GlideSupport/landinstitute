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
<!-- cta Start -->
<?php if (($bst_var_cta_visibility == true)): ?>
	<div class="footer-cta">
		<div class="wrapper">
			<div class="row-grid">
				<div class="col-left">
					<?php echo !empty($bst_var_pocta_title) ? '<div class="gl-s156"></div><h2 class="heading-2 block-title mb-0">' . esc_html($bst_var_pocta_title) . '</h2><div class="gl-s156"></div>' : ''; ?>
				</div>
				<div class="col-right">
				<?php echo !empty($bst_var_pocta_bg_image) ? '<div class="pattern6">' . wp_get_attachment_image($bst_var_pocta_bg_image, 'thumb_1000', false, ['class' => 'desktop-img']) . '</div><div class="gl-s156"></div>' : ''; ?>
					<div class="right-col-content">
						<?php echo !empty($bst_var_pocta_button_one) ? '<div class="two-row-btn">' . BaseTheme::button($bst_var_pocta_button_one, 'site-btn btn-sunflower-yellow arrow-heart-symbol sm-btn') . '</div>' : ''; ?>
						<?php echo (!empty($bst_var_pocta_button_one) && !empty($bst_var_pocta_button_two)) ? '<div class="gl-s12"></div>' : ''; ?>
						<?php echo !empty($bst_var_pocta_button_two) ? '<div class="two-row-btn">' . BaseTheme::button($bst_var_pocta_button_two, 'site-btn btn-sky-blue sm-btn') . '</div>' : ''; ?>
					</div>
					<div class="gl-s156"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- cta End -->