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

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);
// Set the preview thumbnail for this block for gutenberg editor view.
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
	return;
}
// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = (isset($block['className'])) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if (!empty($block['anchor'])) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace('/', '-', $bst_block_name);
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_pt_headline = $bst_block_fields['li_pt_headline'] ?? null;
$li_pt_headline_check = BaseTheme::headline_check($li_pt_headline);
$li_pt_post_select_option = $bst_block_fields['li_pt_post_select_option'] ?? 'manual';
$li_pt_select_manual_post = $bst_block_fields['li_pt_select_manual_post'] ?? null;
$li_pt_select_taxonomies = $bst_block_fields['li_pt_select_taxonomies'] ?? null;
$li_pt_select_audience = $bst_block_fields['li_pt_select_audience'] ?? null;
$li_pt_select_crop = $bst_block_fields['li_pt_select_crop'] ?? null;
$li_pt_select_type = $bst_block_fields['li_pt_select_type'] ?? null;
$li_pt_select_topic = $bst_block_fields['li_pt_select_topic'] ?? null;

$li_pt_button = $bst_block_fields['li_pt_button'] ?? null;
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
		break;
		
	case 'by-taxonomies':
		$tax_query = array();

		if (!empty($li_pt_select_audience)) {
			$tax_query[] = array(
				'taxonomy' => 'learn-audience',
				'field'    => 'term_id',
				'terms'    => (array) $li_pt_select_audience, // Ensure array
				'operator' => 'IN',
			);
		}

		if (!empty($li_pt_select_crop)) {
			$tax_query[] = array(
				'taxonomy' => 'learn-crop',
				'field'    => 'term_id',
				'terms'    => (array) $li_pt_select_crop,
				'operator' => 'IN',
			);
		}

		if (!empty($li_pt_select_type)) {
			$tax_query[] = array(
				'taxonomy' => 'learn-type',
				'field'    => 'term_id',
				'terms'    => (array) $li_pt_select_type,
				'operator' => 'IN',
			);
		}

		if (!empty($li_pt_select_topic)) {
			$tax_query[] = array(
				'taxonomy' => 'learn-topic',
				'field'    => 'term_id',
				'terms'    => (array) $li_pt_select_topic,
				'operator' => 'IN',
			);
		}

		if (!empty($tax_query)) {
			// If multiple taxonomy queries exist, they should be AND'ed together
			if (count($tax_query) > 1) {
				$tax_query['relation'] = 'AND';
			}
			$args['tax_query'] = $tax_query;
			$args['orderby']   = 'date';
			$args['order']     = 'DESC';
		} else {
			// No taxonomies selected — return no results
			$args['post__in'] = array(0);
		}
   	 	break;




}

$posts_query = new WP_Query($args);
if (!empty($li_pt_headline_check) || $posts_query->have_posts()): ?>
	<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
		<div class="all-resources-block">
			<?php echo !empty($li_pt_headline_check) ? BaseTheme::headline($li_pt_headline, 'heading-2 block-title mb-0') . '<div class="gl-s52"></div>' : ''; ?>
			<div class="border-variable-slider">
				<?php
				// Count total posts before the loop
				$total_posts = $posts_query->found_posts;
				$drag_class = ($total_posts > 3) ? 'cursor-drag-icon' : '';
				?>
				<!-- Swiper -->
				<div class="swiper-container variable-slide-preview <?php echo $drag_class; ?>">
					<div class="swiper-wrapper">
						<?php
						$slide_classes = ['slide-larg', 'slide-xlarg', 'slide-smlarg', 'slide-xsmlarg'];
						$index = 0;
						while ($posts_query->have_posts()) : $posts_query->the_post();
							$post_id = get_the_ID();
							$title = get_the_title();
							$permalink = get_the_permalink();
							$youtube_url = get_field('li_ldo_youtube_url', $post_id);
							$class = $slide_classes[$index % count($slide_classes)];
						?>
							<div class="swiper-slide <?php echo esc_attr($class); ?>">
								<a href="<?php echo esc_url($permalink); ?>" class="border-image-content">
									<div class="variable-image">
										<?php
										if (has_post_thumbnail($post_id)) {
											echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_800');
										} elseif (!empty($youtube_url)) {
											preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$youtube_url,
												$matches );
											if (!empty($matches[1])) {
												$video_id = $matches[1];
												echo '<img src="' . esc_url('https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg') . '" alt="' . esc_attr($title) . '" width="800" height="800" />';
											} else {
												echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="800" height="800" />';
											}
										} else {
											echo '<img src="' . esc_url(wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full')) . '" alt="Default thumbnail" width="800" height="800" />';
										}
										?>
									</div>

									<div class="border-card-content">
										<div class="gl-s52"></div>
										<div class="mb-0 heading-6 block-title"><?php echo html_entity_decode($title); ?></div>
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
			<?php echo !empty($li_pt_button) ? '<div class="section-btn full-width-button">' . BaseTheme::button($li_pt_button, 'site-btn') . '</div>' : ''; ?>
		</div>
	</div>
<?php else : ?>
    <div class="no-posts-message">
        <?php
        if (!empty($li_pt_select_audience) || !empty($li_pt_select_crop) || !empty($li_pt_select_type) || !empty($li_pt_select_topic)) {
            echo '<p>No posts found for the selected filters.</p>';
        } else {
            echo '<p>No posts found.</p>';
        }
        ?>
    </div>
<?php endif; ?>