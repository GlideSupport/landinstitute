<?php

/**
 * Block Name: Airtable Map
 * Description: Template for displaying the Airtable Map custom Gutenberg block.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Get block defaults
list($block_id, $bst_block_fields,) = BaseTheme::defaults($block['id']);

// Block name and styles
$block_name = str_replace('acf/', '', $block['name']);
$block_styles = BaseTheme::convert_to_css($block);

// Preview image in editor
if (!empty($block['data']['preview'])) {
    echo '<img src="' . esc_url(get_template_directory_uri() . "/blocks/{$block_name}/" . $block['data']['preview']) . '" style="width:100%; height:auto;">';
    return;
}

// Alignment and custom class
$align_class = !empty($block['align']) ? 'align' . $block['align'] : '';
$class_name = $block['className'] ?? '';

// HTML ID
$html_id = !empty($block['anchor']) ? $block['anchor'] : 'block-' . $block_name . '-' . $block['id'];

// Block wrapper class
$wrapper_class = trim("{$align_class} {$class_name} international-Initiative-map-filter block-acf-{$block_name}");

// Block variables.
$li_to_add_map_shortcode = $bst_block_fields['li_to_add_map_shortcode'] ?? '';

if (!empty($li_to_add_map_shortcode)): ?>
    <section id="<?php echo esc_attr($html_id); ?>" class="<?php echo esc_attr($wrapper_class); ?>" style="<?php echo esc_attr($block_styles); ?>">
        <?php echo do_shortcode('[wpgmza id="' . $li_to_add_map_shortcode . '"]'); ?>
    </section>
<?php endif; ?>