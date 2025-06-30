<?php

/**
 * Block Name: Tabbed Content
 *
 * The template for displaying the custom gutenberg block named Tabbed Content.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);


// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
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
    $bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_tc_headline = $bst_block_fields['li_tc_headline'] ?? null;
$li_tc_headline_check = BaseTheme::headline_check($li_tc_headline);
$li_tc_wysiwyg = $bst_block_fields['li_tc_wysiwyg'] ?? null;
$li_tc_repeater = $bst_block_fields['li_tc_repeater'] ?? null;


if (!empty($li_tc_headline_check) || !empty($li_tc_wysiwyg) || !empty($li_tc_repeater)): ?>
    <div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
        <div class="tabbed-content-block">
            <div class="heading-max ">
                <?php echo !empty($li_tc_headline_check) ? BaseTheme::headline($li_tc_headline, 'heading-2 mb-0 block-title') : ''; ?>
                <?php echo (!empty($li_tc_headline_check) && !empty($li_tc_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
                <?php echo !empty($li_tc_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_tc_wysiwyg) . '</div>' : ''; ?>
            </div>
            <?php echo (!empty($li_tc_headline_check) && !empty($li_tc_wysiwyg)) ? '<div class="gl-s52"></div>' : ''; ?>
            <?php if (!empty($li_tc_repeater) && is_array($li_tc_repeater)) : ?>
            <div class="tabbed-block-content">
                <div class="tabs-listing">
                    <ul class="tabs">
                        <?php foreach ($li_tc_repeater as $index => $tab) : 
                            $tab_id = 'tab-' . ($index + 1); ?>
                            <li class="tab-link <?php echo $index === 0 ? 'current' : ''; ?>" data-tab="<?php echo esc_attr($tab_id); ?>">
                                <?php echo esc_html($tab['tab_label']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="tab-content-group">
                    <?php foreach ($li_tc_repeater as $index => $tab) : 
                        $tab_id = 'tab-' . ($index + 1);
                        $title = $tab['title'] ?? '';
                        $wysiwyg = $tab['wysiwyg'] ?? '';
                        $image_id = $tab['image'] ?? '';
                    ?>
                    <div id="<?php echo esc_attr($tab_id); ?>" class="tab-content <?php echo $index === 0 ? 'current' : ''; ?>">
                        <div class="tab-row-block">
                            <div class="cl-left">
                                <div class="gl-s80"></div>
                                <div class="tab-content-wrapp">
                                    <?php if ($title): ?>
                                        <h4 class="heading-4 block-title mb-0"><?php echo esc_html($title); ?></h4>
                                        <div class="gl-s20"></div>
                                    <?php endif; ?>
                                    <?php if ($wysiwyg): ?>
                                        <div class="body-20-18-regular tab-area-content">
                                            <?php echo html_entity_decode($wysiwyg); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="gl-s80"></div>
                            </div>
                            <?php if ($image_id): ?>
                                <div class="cl-right">
                                    <?php echo !empty($image_id) ? '<div class="tab-image">' . wp_get_attachment_image($image_id, 'thumb_700') . '</div>' : ''; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>