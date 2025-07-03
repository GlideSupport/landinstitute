<?php

/**
 * Block Name: Memorial PDFS
 *
 * The template for displaying the custom gutenberg block named Memorial PDFS.
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
$li_mp_headline = $bst_block_fields['li_mp_headline'] ?? null;
$li_mp_headline_check = BaseTheme::headline_check($li_mp_headline);
$li_mp_kicker = $bst_block_fields['li_mp_kicker'] ?? null;
$li_mp_wysiwyg = $bst_block_fields['li_mp_wysiwyg'] ?? null;
$li_mp_grid_layout = $bst_block_fields['li_mp_grid_layout'] ?? null;
$li_mp_main_repeater = $bst_block_fields['li_mp_main_repeater'] ?? null;

if($li_mp_grid_layout=='two-column'):
    $class="logo-grid-two";
elseif ($li_mp_grid_layout=='three-column') :
    $class="logo-grid-three";
else :
    $class="logo-grid-four";
endif;
?>

<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
    <div class="contributors-block">
        <div class="heading-max max-800">
            <?php echo !empty($li_mp_kicker) ? '<div class="ui-eyebrow-20-18-regular sub-head">' . esc_html($li_mp_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>   
            <?php echo !empty($li_mp_headline_check) ? BaseTheme::headline($li_mp_headline, 'heading-2 mb-0 block-title') : ''; ?>
            <?php echo (!empty($li_mp_headline_check) && !empty($li_mp_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
            <?php echo !empty($li_mp_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_mp_wysiwyg) . '</div>' : ''; ?>
        </div>
        <?php if (!empty($li_mp_main_repeater)):
            $total_groups = count($li_mp_main_repeater);
            $current_index = 0;?>
                <div class="gl-s52"></div>
                <?php foreach ($li_mp_main_repeater as $group): 
                    $group_title = $group['li_mp_title'] ?? '';
                    $entries = $group['li_mp_inner_repeater'] ?? [];
                    ?>
                    <?php if (!empty($group_title) || (!empty($entries))): ?>
                        <div class="designation-block">
                            <div class="heading-4 block-title mb-0"><?php echo esc_html($group_title); ?></div>
                            <div class="gl-s16"></div>
                            <?php if (!empty($entries)): ?>
                                <div class="designation-row <?php echo $class; ?>">
                                    <?php foreach ($entries as $entry): 
                                        $name = $entry['li_mp_name'] ?? '';
                                        $designation = $entry['li_mp_designation'] ?? ''; 
                                        if(!empty($name) || !empty($designation)):?>
                                            <div class="designation-col">
                                                <div class="designation-view">
                                                    <?php if (!empty($name)): ?>
                                                        <div class="ui-18-16-bold designation-name"><?php echo esc_html($name); ?></div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($designation)): ?>
                                                        <div class="ui-16-15-regular designation-list"><?php echo esc_html($designation); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                            $current_index++;
                            echo ($current_index === $total_groups) ? '' : '<div class="gl-s52"></div>';
                        ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
    </div>
</div>
