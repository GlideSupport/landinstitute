<?php

/**
 * Block Name: Logo Grid
 *
 * The template for displaying the custom gutenberg block named Logo Grid.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);


// Set the block name for it's ID & class from it's file name.
$bst_block_name = $block['name'];
$bst_block_name = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);
// Set the preview thumbnail for this block for gutenberg editor view.
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
}

// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = (isset($block['className'])) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace('/', '-', $bst_block_name);
	$bst_var_name = 'block-' . $bst_block_name;
}

// Block variables.
$aot_lg_kicker_text = $bst_block_fields['aot_lg_kicker_text'] ?? null;
$aot_lg_logo = $bst_block_fields['aot_lg_logo'] ?? null;
?>

<?php if (!empty($aot_lg_kicker_text) || !empty($aot_lg_logo)) { ?>
		<div id="<?php echo esc_html($bst_block_html_id); ?>"
			class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>"
			style="<?php echo esc_html($bst_block_styles); ?>	">

			<div class="logo-grid">
				<?php if($aot_lg_kicker_text){ ?>
					<div class="block-label label-s-med center-align">
						<?php echo html_entity_decode($aot_lg_kicker_text); ?>
					</div>
					<div class="gl-s36"></div>
				<?php } ?>

				<?php if(!empty($aot_lg_logo)){ ?>
					<div class="logo-grid-row">
						<?php foreach ($aot_lg_logo as $logo):
							$logogird = $logo['logo'];
							?>
							<?php if(!empty($logogird)){ ?>
								<div class="logo-grid-column">
									<div class="logo-brand-group">
										<div class="mask-mode"
											style="mask-image: url(<?php echo esc_url(wp_get_attachment_image_url($logogird, 'thumb_300')); ?>);">
											<?php echo wp_get_attachment_image($logogird, 'thumb_300', false, array('class' => 'brand-logo')); ?>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php endforeach; ?>
					</div>
				<?php } ?>
			</div>
		</div>
<?php } ?>