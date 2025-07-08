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

<section class="container-1280 bg-base-cream pastevent">
	<div class="gl-s156"></div>
	<div class="wrapper">
		<div class="past-event-filter-title full-width-content">

			<?php echo !empty($past_events_headline_check) ? BaseTheme::headline($past_events_headline, 'heading-3 block-title mb-0') . '<div class="gl-s44"></div>' : ''; ?>

			<?php

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


			$today = date('Ymd');
			$args = [
				'post_type'      => 'event',
				'post_status'    => 'publish',
				'posts_per_page' => 6,
				'paged'          => $paged,
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
							$timezone = get_field('timezone', $post_id);

							$excerpt     = get_the_excerpt($post_id);
							$event_content = wp_trim_words($excerpt, 25, '...');
							$start_date_raw = get_field('li_cpt_event_start_date', $post_id);
							$end_date_raw   = get_field('li_cpt_event_end_date', $post_id);
			
							$event_start_time = get_field('li_cpt_event_start_time', $post_id);
							$event_end_time   = get_field('li_cpt_event_end_time', $post_id);
			
							$timezone = get_field('timezone', $post_id);
							$timezone_code = get_timezone_code($timezone); // Assumes you have a function for this
			
							// Format start/end as DateTime objects
							$start_datetime = new DateTime($start_date_raw . ' ' . $event_start_time);
							$end_datetime   = new DateTime($end_date_raw . ' ' . $event_end_time);
							$li_cpt_event_all_day = get_field('li_cpt_event_all_day',$post_id);

							if($li_cpt_event_all_day){ $days="All days";}

							// Optional: Set timezone if needed (if $timezone is a valid TZ name)
							if (!empty($timezone)) {
								try {
									$tz = new DateTimeZone($timezone);
									$start_datetime->setTimezone($tz);
									$end_datetime->setTimezone($tz);
								} catch (Exception $e) {
									// fallback silently
								}
							}
			
							// Format the full string
							if ($start_datetime->format('Y-m-d') === $end_datetime->format('Y-m-d')) {
								// Same day
								$event_display = $start_datetime->format('l, F j, Y g:i a') . ' ' . $timezone_code.' '.$days;
							} else {
								// Different days
								$event_display = $start_datetime->format('l, F j, Y g:i a') . ' '. $timezone_code.' '.$days;;
							}
							?>
							<div class="filter-content-card-item">
								<a href="<?php echo esc_url($event_link); ?>" class="filter-content-card-link">
									<div class="filter-card-content">
										<div class="gl-s52"></div>
										<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo $event_display; ?>
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

				<?php wp_reset_postdata();
			endif; ?>
				<?php
				if ($total_pages > 1): ?>

					<div class="fillter-bottom">
						<div class="pagination-container pagination-append-container">
							<!-- Desktop Pagination -->
							<div class="desktop-pages">
								<?php
								$has_prev = $current_page > 1;
								$prev_page = $current_page - 1;
								$prev_url = $has_prev
									? ($prev_page === 1
										? trailingslashit(home_url('/events/'))
										: trailingslashit(home_url('/events/')) . 'page/' . $prev_page . '/')
									: 'javascript:void(0);';

								$prev_class = $has_prev ? '' : 'disabled';
								?>
								<a href="<?php echo esc_url($prev_url); ?>"
									id="desktopPrev"
									class="arrow-btn prev page-btn <?php echo esc_attr($prev_class); ?>"
									data-page="<?php echo esc_attr($prev_page); ?>">
									<div class="site-btn">Previous</div>
								</a>
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
											$page_url = $i === 1
												? trailingslashit(home_url('/events/'))
												: trailingslashit(home_url('/events/')) . 'page/' . $i . '/';

											// Add rel if prev or next
											$rel = '';
											if ($i === $current_page - 1) $rel = 'prev';
											elseif ($i === $current_page + 1) $rel = 'next';

											echo '<a class="page-btn ' . esc_attr($active_class) . '" href="' . esc_url($page_url) . '" data-page="' . esc_attr($i) . '"' . ($rel ? ' rel="' . esc_attr($rel) . '"' : '') . '>' . esc_html($i) . '</a>';
											$show_dots = true;
										} elseif ($show_dots) {
											echo '<span class="dots">...</span>';
											$show_dots = false;
										}
									}
									?>
								</div>
						
								<?php
								$has_next = $current_page < $total_pages;
								$next_page = $current_page + 1;
								$next_url = $has_next
									? trailingslashit(home_url('/events/')) . 'page/' . $next_page . '/'
									: 'javascript:void(0);';

								$next_class = $has_next ? '' : 'disabled';
								$next_rel = $has_next ? 'next' : ''; // ✅ fixed this line
								?>

								<a href="<?php echo esc_url($next_url); ?>"
									id="desktopNext"
									class="arrow-btn next page-btn <?php echo esc_attr($next_class); ?>"
									data-page="<?php echo esc_attr($next_page); ?>"
									<?php echo $next_rel ? 'rel="' . esc_attr($next_rel) . '"' : ''; ?>>
									<div class="site-btn">Next</div>
								</a>
							</div>

								<!-- Mobile Pagination -->
							<div class="mobile-pagination">
								<?php
								// Prev button setup
								$prev_page = $current_page - 1;
								$prev_disabled = $current_page <= 1;
								$prev_url = $prev_disabled
									? 'javascript:void(0);'
									: ($prev_page === 1
										? trailingslashit(get_permalink())
										: trailingslashit(get_permalink()) . 'page/' . $prev_page . '/');
								$prev_rel = !$prev_disabled ? 'prev' : '';
								?>
								<a href="<?php echo esc_url($prev_url); ?>"
								id="prevBtn"
								class="arrow-btn page-btn <?php echo $prev_disabled ? 'disable' : ''; ?>"
								data-page="<?php echo esc_attr($prev_page); ?>"
								<?php echo $prev_rel ? 'rel="' . esc_attr($prev_rel) . '"' : ''; ?>>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Previous">
								</a>

								<button id="pageTrigger" class="page-trigger ui-18-16-bold">
									<?php echo esc_html($current_page . '/' . $total_pages); ?>
								</button>

								<?php
								// Next button setup
								$next_page = $current_page + 1;
								$next_disabled = $current_page >= $total_pages;
								$next_url = $next_disabled
									? 'javascript:void(0);'
									: trailingslashit(get_permalink()) . 'page/' . $next_page . '/';
								$next_rel = !$next_disabled ? 'next' : '';
								?>
								<a href="<?php echo esc_url($next_url); ?>"
								id="nextBtn"
								class="arrow-btn page-btn <?php echo $next_disabled ? 'disable' : ''; ?>"
								data-page="<?php echo esc_attr($next_page); ?>"
								<?php echo $next_rel ? 'rel="' . esc_attr($next_rel) . '"' : ''; ?>>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
								</a>
							</div>

							<!-- Mobile Popup Pagination -->
							<div id="paginationPopup" class="pagination-popup">
								<div class="popup-body">

									<!-- Grid of Page Numbers -->
									<div id="popupGrid" class="popup-grid">
										<?php
										for ($i = 1; $i <= $total_pages; $i++) {
											$active = $i == $current_page ? 'active' : '';
											$page_url = $i === 1
												? trailingslashit(get_permalink())
												: trailingslashit(get_permalink()) . 'page/' . $i . '/';

											echo '<a href="' . esc_url($page_url) . '" class="page-trigger ui-18-16-bold page-btn ' . $active . '" 
data-page="' . $i . '">' . $i . '</a>';
										}
										?>
									</div>

									<!-- Popup Prev Button -->
									<?php
									$popup_prev_page = $current_page - 1;
									$popup_prev_disabled = $current_page <= 1;
									$popup_prev_url = $popup_prev_disabled
										? 'javascript:void(0);'
										: ($popup_prev_page === 1
											? trailingslashit(get_permalink())
											: trailingslashit(get_permalink()) . 'page/' . $popup_prev_page . '/');
									?>
									<a id="popupPrev"
									class="arrow-btn page-btn <?php echo $popup_prev_disabled ? 'disable' : ''; ?>"
									href="<?php echo esc_url($popup_prev_url); ?>"
									data-page="<?php echo esc_attr($popup_prev_page); ?>">
									</a>

									<!-- Popup Next Button -->
									<?php
									$popup_next_page = $current_page + 1;
									$popup_next_disabled = $current_page >= $total_pages;
									$popup_next_url = $popup_next_disabled
										? 'javascript:void(0);'
										: trailingslashit(get_permalink()) . 'page/' . $popup_next_page . '/';
									?>
									<a id="popupNext"
									class="arrow-btn page-btn <?php echo $popup_next_disabled ? 'disable' : ''; ?>"
									href="<?php echo esc_url($popup_next_url); ?>"
									data-page="<?php echo esc_attr($popup_next_page); ?>">
									</a>
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