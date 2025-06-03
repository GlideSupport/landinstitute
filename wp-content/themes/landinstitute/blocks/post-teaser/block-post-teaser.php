<?php
/**
 * Block Name: Post Teaser
 *
 * The template for displaying the custom gutenberg block named Post Teaser.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );

// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
	return;
}
// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_pt_headline = $bst_block_fields['li_pt_headline'] ?? null;
$li_pt_headline_check = BaseTheme::headline_check($li_pt_headline);
$li_pt_post_select_option = $bst_block_fields['li_pt_post_select_option'] ?? 'manual';
$li_pt_select_manual_post = $bst_block_fields['li_pt_select_manual_post'] ?? null;
$li_pt_button = $bst_block_fields['li_pt_button'] ?? null;
$border_options = $bst_block_fields['li_global_border_options'] ?? 'none';

// Query posts based on selection
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
);

switch ($li_pt_post_select_option) {
    case 'manual':
        if (!empty($li_pt_select_manual_post)) {
            $args['post__in'] = $li_pt_select_manual_post;
            $args['orderby'] = 'post__in';
            $args['posts_per_page'] = count($li_pt_select_manual_post);
        }
        break;
        
    case 'most-recent':
        // Default args are already set for most recent
        break;
        
    // You could add more cases here for other selection options
}

$posts_query = new WP_Query($args);
if(!empty($li_pt_headline_check) && $posts_query->have_posts()): ?>
	<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<div class="all-resources-block <?php echo esc_attr($border_options); ?>">
			<?php echo !empty($li_pt_headline_check) ? BaseTheme::headline($li_pt_headline, 'heading-2 block-title mb-0') . '<div class="gl-s52"></div>' : ''; ?>
			<div class="border-variable-slider">
				<!-- Swiper -->
				<div class="swiper-container variable-slide-preview cursor-drag-icon">
					<div class="swiper-wrapper">
						<?php 
						$slide_classes = ['slide-larg', 'slide-xlarg', 'slide-smlarg', 'slide-xsmlarg'];
						$index = 0;						
						while ($posts_query->have_posts()) : $posts_query->the_post(); 
							$post_id = get_the_ID();
							$title = get_the_title();
							$permalink = get_the_permalink();
							$bg_pattern_image = get_field('li_po_bg_image',$post_id);
							$has_pattern = !empty($bg_pattern_image);
							// Calculate class for current slide
    						$class = $slide_classes[$index % count($slide_classes)];
						?>
						<div class="swiper-slide <?php echo esc_attr($class); ?>">
							<a href="<?php echo esc_url($permalink); ?>" class="border-image-content">
								<div class="variable-image <?php echo $has_pattern ? 'pattern-image' : ''; ?>">
									<?php if ($has_pattern && $bg_pattern_image) : ?>
											<?php echo wp_get_attachment_image($bg_pattern_image, 'thumb_800'); ?>
									<?php endif; ?>
									<?php if ($has_pattern && $bg_pattern_image) : ?><div class="pattern-child-image"><?php endif; ?>
									<?php if (has_post_thumbnail()) : ?>
										<?php echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_800'); ?>
									<?php else : ?>
										<img src="<?php echo esc_url(BASETHEME_DEFAULT_IMAGE); ?>" alt="Default thumbnail" width="800" height="800" />
									<?php endif; ?>
									<?php if ($has_pattern && $bg_pattern_image) : ?></div><?php endif; ?>
								</div>
								<div class="border-card-content">
									<div class="gl-s52"></div>
									<h6 class="mb-0 heading-6 block-title"><?php echo esc_html($title); ?></h6>
									<div class="gl-s16"></div>
									<div class="card-btn">
										<div class="border-text-btn">Read more</div>
									</div>
									<div class="gl-s80"></div>
								</div>
							</a>
						</div>
						<?php 
							$index++;
						endwhile; 
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
			<?php echo !empty($li_pt_button) ? '<div class="section-btn full-width-button">' . BaseTheme::button($li_pt_button, 'site-btn') . '</div>' : '';?>
		</div>
	</div>
<?php endif; ?>