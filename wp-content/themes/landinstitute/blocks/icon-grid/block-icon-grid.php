<?php

/**
 * Block Name: Icon Grid
 *
 * The template for displaying the custom gutenberg block named Icon Grid.
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
$li_ig_headline = $bst_block_fields['li_ig_headline'] ?? null;
$li_ig_headline_check = BaseTheme::headline_check($li_ig_headline);
$li_ig_wysiwyg = $bst_block_fields['li_ig_wysiwyg'] ?? null;
$li_ig_repeater = $bst_block_fields['li_ig_repeater'] ?? null;

?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
<div class="has-border-bottom icon-grid-block">
    <div class="heading-max">
        <h2 class="heading-2 mb-0 block-title">Icon Grid</h2>
        <div class="gl-s30"></div>
        <div class="block-content body-20-18-regular">Quisque cras purus sed nulla diam convallis
            porta egestas. Leo lorem pellentesque enim mattis sollicitudin etiam. Dui
            ornare nunc aenean nibh quis. Vitae aliquet tellus rhoncus quam. Sed purus purus in ut
            facilisi netus facilisis a. Quis
            vel suscipit tempor commodo venenatis volutpat rutrum bibendum.</div>
    </div>
    <div class="gl-s64"></div>
    <div class="icon-grid-row">
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Crop-Development.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Crop Development</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Perennial crops that are better for the
                world</div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Civic-Science-thin.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Participatory science</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Collaborating with communities</div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Natural-Systems-thin.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Natural Systems</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Using nature to improve soil and
                sustainabilityUsing nature to improve soil and sustainability</div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Scaling-Sustainability-thin.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Scaling Sustainability</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Bringing perennial crops from farm to
                marketBringing perennial crops from farm to market</div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Shifting-the-Culture-thin.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Shifting the Culture</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Building knowledge for sustainable
                agriculture</div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
        <div class="icon-grid-col">
            <div class="icon-grid-image">
                <img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Future-Landscapes-thin.svg"
                    width="" height="" />
            </div>
            <div class="gl-s24"></div>
            <div class="ui-24-21-bold cta-title">Future Landscapes</div>
            <div class="gl-s4"></div>
            <div class="cta-content body-20-18-regular">Exploring the future for perennial success
            </div>
            <div class="gl-s8"></div>
            <div class="cta-links">
                <a href="" class="border-text-btn">
                    Read more </a>
            </div>
        </div>
    </div>
    </div>
</div>