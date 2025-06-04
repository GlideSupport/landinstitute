<?php

/**
 * Block Name: Download List
 *
 * The template for displaying the custom gutenberg block named Download List.
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
$li_dl_headline = $bst_block_fields['li_dl_headline'] ?? null;
$li_dl_headline_check = BaseTheme::headline_check($li_dl_headline);
$li_dl_wysiwyg = $bst_block_fields['li_dl_wysiwyg'] ?? null;
$li_dl_main_repeater = $bst_block_fields['li_dl_main_repeater'] ?? null;
$li_dl_image = $bst_block_fields['li_dl_image'] ?? null;
$border_options = $bst_block_fields['li_global_border_options'] ?? 'none';
?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
    <div class="download-list sticky-lft-block">
        <div class="row-flex">
            <?php echo !empty($li_dl_image) ? '<div class="col-left sticky-img">' . wp_get_attachment_image($li_dl_image, 'thumb_1000') . '</div>' : ''; ?>
            <div class="cl-right">
                <div class="gl-s156"></div>
                <?php echo !empty($li_dl_headline_check) ? BaseTheme::headline($li_dl_headline, 'heading-2 block-title mb-0') : ''; ?>
                <?php echo (!empty($li_dl_headline_check) && !empty($li_dl_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
                <?php echo !empty($li_dl_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_dl_wysiwyg) . '</div><div class="gl-s52"></div>' : ''; ?>   
                <?php if (!empty($li_dl_main_repeater)) : 
                    $total_groups = count($li_dl_main_repeater);
                    $current_index = 0;?>
                    <?php foreach ($li_dl_main_repeater as $fiscal_group) : 
                        $fiscal_year = $fiscal_group['li_dl_title'];
                        $downloads = $fiscal_group['li_dl_inner_repeater'];
                        if(!empty($fiscal_year) && !empty($downloads)): ?>
                            <div class="list-list-block">
                                <?php if (!empty($fiscal_year)) : ?>
                                    <h4 class="heading-4 mb-0 block-title"><?php echo esc_html($fiscal_year); ?></h4>
                                    <div class="gl-s16"></div>
                                <?php endif; ?>
                                <?php if (!empty($downloads)) : ?>
                                    <div class="card-pdf-list">
                                        <?php foreach ($downloads as $file_item) : 
                                            $link = $file_item['li_dl_link'] ?? null;
                                            if ($link):
                                                $url = $link['url'];
                                                $title = $link['title'];
                                            if(!empty($url) && !empty($title)): ?>
                                                <a href="<?php echo esc_url($url); ?>" class="card-item" target="_blank" rel="noopener noreferrer">
                                                    <div class="card-item-left">
                                                        <div class="card-title ui-20-18-bold"> <?php echo esc_html($title); ?></div>
                                                        <div class="card-content tag-label">PDF</div>
                                                    </div>
                                                    <div class="card-item-right">
                                                        <div class="dot-btn">
                                                            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="View PDF">
                                                        </div>
                                                    </div>
                                                </a>
                                        <?php endif; endif; endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                                $current_index++;
                                echo ($current_index === $total_groups) ? '<div class="gl-s156"></div>' : '<div class="gl-s52"></div>';
                            ?>
                            <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
