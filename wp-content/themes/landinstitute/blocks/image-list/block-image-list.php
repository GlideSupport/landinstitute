<?php
/**
* Block Name: Image List
*
* The template for displaying the custom Gutenberg block named Image List.
*
* @package Base Theme Package
* @since 1.0.0
*/
 
list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);
 
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);
 
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
}
 
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name  = $block['className'] ?? null;
 
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if (!empty($block['anchor'])) {
	$bst_block_html_id = $block['anchor'];
}
 
if ($block['name']) {
	$bst_block_name = str_replace('/', '-', $block['name']);
	$bst_var_name   = 'block-' . $bst_block_name;
}
 
// Block variables
$li_il_heading        = $bst_block_fields['li_il_heading'] ?? null;
$li_il_heading_check  = BaseTheme::headline_check($li_il_heading);
$li_il_detail         = $bst_block_fields['li_il_detail'] ?? null;
 
?>
<div class="image-list-block">
    <?php echo !empty($li_il_heading_check) ? BaseTheme::headline($li_il_heading, 'heading-3 block-title mb-0') . '<div class="gl-s36"></div>' : ''; ?>
    <?php if(!empty($li_il_detail)){?>
    <div class="image-list-row">
        <?php foreach($li_il_detail as $details){ 
            $title=$details['title'];
            $subtitle=$details['subtitle'];
            $detail=$details['detail'];
            $image=$details['image'];?>
        <div class="image-list-col">
            <div class="row-flex">
                <?php if(!empty($image)){ ?>
                <div class="cl-left">
                    <div class="team-img">
                        <?php echo wp_get_attachment_image($image,'thumb_300'); ?>
                    </div>
                </div>
                <?php } ?>
                <?php if(!empty($title) || !empty($subtitle) || !empty($detail)) {?>
                <div class="cl-right">
                    <?php if(!empty($title)){ ?><h5 class="heading-5 block-title mb-0"><?php echo $title; ?></h5><?php } ?>
                    <?php if(!empty($title)&& !empty($subtitle)){ ?><div class="gl-s4"></div><?php } ?>
                    <?php if(!empty($subtitle)){ ?><div class="ui-eyebrow-16-15-regular team-sub"><?php echo $subtitle; ?></div><?php } ?>
                    <?php if(!empty($detail)&& !empty($subtitle)){ ?><div class="gl-s16"></div><?php } ?>
                    <?php if(!empty($detail)){ ?>
                    <div class="team-desc">
                        <div class="team-content body-20-18-regular">
                            <?php echo html_entity_decode($detail); ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>