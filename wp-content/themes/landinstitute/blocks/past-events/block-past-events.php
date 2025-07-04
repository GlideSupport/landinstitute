<?php

/**
 * Block Name: Past Events
 *
 * The template for displaying the custom gutenberg block named Past Events.
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
if (!empty($block['anchor'])) {
	$bst_block_html_id = $block['anchor'];
}

// Making the unique ID for the block.
if ($block['name']) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace('/', '-', $bst_block_name);
	$bst_var_name = 'block-' . $bst_block_name;
}

// Block variables.
$past_events_headline = $bst_block_fields['li_past_events_headline'] ?? null;
$past_events_headline_check  = BaseTheme::headline_check($past_events_headline);
$past_events_button = $bst_block_fields['li_past_events_button'] ?? null;

?>

<section class="container-1280 bg-base-cream">
	<div class="gl-s156"></div>
	<div class="wrapper">
		<div class="past-event-filter-title full-width-content">

	<?php echo !empty($past_events_headline_check) ? BaseTheme::headline($past_events_headline, 'heading-3 block-title mb-0') . '<div class="gl-s44"></div>' : ''; ?>
	
	<?php
	$today = date('Ymd');
	$args = [
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'posts_per_page' => 4,
		'paged'          => 1,
		'meta_key'       => 'li_cpt_event_start_date',
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
		'meta_query'     => [
			[
				'key'     => 'li_cpt_event_start_date',
				'value'   => $today,
				'compare' => '<',
				'type'    => 'NUMERIC'
			]
		]
	];


	
	$query = new WP_Query($args);
	$total_pages = $query->max_num_pages;
	$current_page = max(1, get_query_var('paged', 1));
	if ($query->have_posts()) :
	?>
		<div class="filter-block">
			<div class="filter-content-cards-grid filter-content-cards-variation">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php
					$post_id = get_the_ID();
					$event_title = get_the_title($post_id);
					$event_link = get_permalink($post_id);

					$start_date_raw = get_field('li_cpt_event_start_date', $post_id);
					$end_date_raw = get_field('li_cpt_event_end_date', $post_id);

					$event_content = get_field('li_cpt_event_wysiwyg', $post_id);

					$start_date = new DateTime($start_date_raw);
					$end_date   = new DateTime($end_date_raw);

					$start_formatted = $start_date->format('l, F j, Y'); // e.g., Friday, May 2, 2025
					$end_formatted   = $end_date->format('l, F j, Y');   // e.g., Saturday, May 3, 2025



					$event_location = get_field('event_location', $post_id);
					$event_categories = get_the_terms($post_id, 'event-category');
					// Date formatting
					$start_date = $start_date_raw ? strtotime($start_date_raw) : false;
					$end_date = $end_date_raw ? strtotime($end_date_raw) : false;

					if ($start_date && $end_date && $start_date !== $end_date) {
						if (date('F', $start_date) !== date('F', $end_date)) {
							$event_date = strtoupper(date('F j', $start_date) . ' – ' . date('F j, Y', $end_date));
						} else {
							$event_date = strtoupper(date('F j', $start_date) . '–' . date('j, Y', $end_date));
						}
					} elseif ($start_date) {
						$event_date = strtoupper(date('l, F j, Y', $start_date));
					} else {
						$event_date = '';
					}
					?>
					<div class="filter-content-card-item">
						<a href="<?php echo esc_url($event_link); ?>" class="filter-content-card-link">
							<div class="filter-card-content">
							<div class="gl-s52"></div>
							<div class="eyebrow ui-eyebrow-16-15-regular"><?= $start_formatted ?> - <?= $end_formatted ?> All Day
							</div>
							<div class="gl-s6"></div>
							<div class="card-title heading-6 mb-0"><?php echo html_entity_decode($event_title); ?></div>
							<div class="gl-s16"></div>
							<div class="description ui-18-16-regular"><?php echo $event_content; ?></div>
							<div class="gl-s20"></div>
							<div class="read-more-link">
								<div class="border-text-btn">Event Details</div>
							</div>
							<div class="gl-s80"></div>
						</div>
						</a>
					</div>

				<?php endwhile; ?>
				
			</div>
		
			<?php wp_reset_postdata(); endif; ?>
			<?php
			 if ($total_pages > 1): ?>
		
			<div class="fillter-bottom">
			<div class="pagination-container pagination-append-container">
				<!-- Desktop Pagination -->
				<div class="desktop-pages">
					<div id="desktopPrev" class="arrow-btn prev" <?php if ($current_page == 1) echo 'disabled'; ?>><div class="site-btn">Previous</div></div>
					<!-- <div class="arrow-btn prev"><div class="site-btn">Previous</div></div> -->
					<div id="paginationList" class="pagination-list">
						<?php
						$range = 2;
						$show_dots = false;

						for ($i = 1; $i <= $total_pages; $i++) {
							if (
								$i == 1 ||
								$i == $total_pages ||
								($i >= $current_page - $range && $i <= $current_page + $range)
							) {
								$active_class = $i == $current_page ? 'active' : '';
								echo '<button class="page-btn ' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
								$show_dots = true;
							} elseif ($show_dots) {
								echo '<span class="dots">...</span>';
								$show_dots = false;
							}
						}
						?>
					</div>
					<!-- <div class="arrow-btn next"><div class="site-btn">Next</div></div> -->
					<div id="desktopNext" class="arrow-btn next" <?php if ($current_page == $total_pages) echo 'disabled'; ?>><div class="site-btn">Next</div></div>
				</div>

				<!-- Mobile Pagination -->
				<div class="mobile-pagination">
					<button id="prevBtn" class="arrow-btn" <?php if ($current_page == 1) echo 'disabled'; ?>>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
					<button id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo $current_page . '/' . $total_pages; ?></button>
					<button id="nextBtn" class="arrow-btn" <?php if ($current_page == $total_pages) echo 'disabled'; ?>>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
					</button>
				</div>

				<!-- Mobile Popup Pagination -->
				<div id="paginationPopup" class="pagination-popup">
					<div class="popup-body">
						<div id="popupGrid" class="popup-grid">
							<?php
							for ($i = 1; $i <= $total_pages; $i++) {
								$active = $i == $current_page ? 'active' : '';
								echo '<button class="page-btn ' . $active . '" data-page="' . $i . '">' . $i . '</button>';
							}
							?>
						</div>
						<button id="popupPrev" class="arrow-btn"></button>
						<button id="popupNext" class="arrow-btn"></button>
					</div>
				</div>

			</div>
			</div>
			<?php endif; ?>
			<?php echo !empty($past_events_button) ? '<div class="gl-s36"></div><div class="block-btn">' . BaseTheme::button($past_events_button, 'site-btn') . '</div>' : ''; ?>
				
		</div>	
		</div>
	</div>
</div>
</section>
