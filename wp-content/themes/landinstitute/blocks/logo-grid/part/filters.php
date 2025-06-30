<?php $class = ($li_lg_logo_grid_layout == 'two-column') ? 'logo-grid-two' : 'logo-grid-three'; ?>
<div class="logo-grid-filters">
	<div class="heading-max max-800">
		<?php echo !empty($li_lg_headline_check) ? BaseTheme::headline($li_lg_headline, 'heading-2 block-title mb-0') : ''; ?>
		<?php echo (!empty($li_lg_headline_check) && !empty($li_lg_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
		<?php echo !empty($li_lg_wysiwyg) ? '<div class="body-20-18-regular block-content">' . html_entity_decode($li_lg_wysiwyg) . '</div>' : ''; ?>
	</div>
	<div class="gl-s64"></div>
	<div class="logo-grid-filters-row filter-block">
		<div class="filter">
			<div class="filter-title ui-18-16-bold">Filter:</div>
			<div class="filter-mobile-dropdown ui-18-16-bold">Show Filter</div>
			<div class="filter-dropdown-row">
				<div class="tab-dropdown">
					<button class="dropdown-toggle" id="donor-type" aria-expanded="false" aria-haspopup="true" aria-controls="donor-type">Donor type: All types
						<div class="arrow-icon"></div>
					</button>
				</div>
				<div class="tab-dropdown"> 
					<button class="dropdown-toggle" id="donation-level" aria-expanded="false" aria-haspopup="true" aria-controls="donation-level">Donation level: All
						levels<div class="arrow-icon"></div>
					</button>
				</div>
			</div>
		</div>
		<div class="gl-s64"></div>
		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = [
			'post_type'      => 'donor',
			'posts_per_page' => $li_lg_donors_pages_show_at_most,
			'orderby'        => 'title',
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged'          => $paged,
		];
		$donors = new WP_Query($args);
		$total_pages = $donors->max_num_pages;
		$current_page = max(1, $paged);

		if ($donors->have_posts()) : ?>
			<div class="filter-logos-row <?php echo $class; ?>" data-donor-count="<?php echo esc_attr($li_lg_donors_pages_show_at_most); ?>">
				<?php while ($donors->have_posts()) : $donors->the_post(); 
					// Get featured image
					$image_id = get_post_thumbnail_id(get_the_ID());
					$first_name = get_field('li_cpt_d_first_name',get_the_ID());
					$last_name = get_field('li_cpt_d_last_name',get_the_ID());

					$title = get_the_title();
					$title_words = explode(' ', trim($title));
					$first_initial = !empty($title_words[0]) ? strtoupper($title_words[0][0]) : '';
					$last_initial  = !empty($title_words[1]) ? strtoupper($title_words[1][0]) : '';
					$initials = $first_initial . $last_initial;
					$image_html = '';
					if ($image_id) {
						$image_html = wp_get_attachment_image($image_id, 'thumb_200', false, [ 'width'  => 200, 'height' => 102, 'alt'    => get_the_title()]);
					}
					// Get donation level terms (taxonomy)
					$levels = get_the_terms(get_the_ID(), 'donation-level');
					$level_name = !empty($levels) && !is_wp_error($levels) ? $levels[0]->name : '';
				?>
					<div class="filter-logos-col">
						<div class="filter-logos-click">
							<?php if ($image_id && $image_html) : ?>
								<div class="brand-logo brand-lists">
									<?php echo $image_html; ?>
								</div>
							<?php else : ?>
								<div class="brand-name brand-lists">
									<div class="brand-group-name"><?php echo esc_html($initials); ?></div>
								</div>
							<?php endif; ?>
							<div class="logo-content">
								<div class="gl-s24"></div>
								<div class="ui-20-18-bold logo-title"><?php echo get_the_title(); ?></div>
								<div class="gl-s2"></div>
								<?php if ($level_name) : ?>
									<div class="body-18-16-regular logo-content"><?php echo esc_html($level_name); ?></div>
								<?php endif; ?>
								<div class="gl-s24"></div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="gl-s64"></div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<div class="fillter-bottom">
			<?php if ($total_pages > 1): ?>
				<div class="pagination-container" data-current-page="<?php echo esc_attr($current_page); ?>" data-total-pages="<?php echo esc_attr($total_pages); ?>">

					<!-- Desktop Pagination -->
					<div class="desktop-pages">
						<div class="arrow-btn prev">
							<div class="site-btn" id="desktopPrev" <?php if ($current_page == 1) echo 'style="opacity: 0.5; pointer-events: none;"'; ?> aria-label="Previous">Previous</div>
						</div>

						<div class="pagination-list" id="paginationList">
							<?php
							$range = 2;
							$show_dots = false;

							for ($i = 1; $i <= $total_pages; $i++) {
								if (
									$i == 1 ||
									$i == $total_pages ||
									($i >= $current_page - $range && $i <= $current_page + $range)
								) {
									if ($show_dots) {
										echo '<span class="dots">...</span>';
										$show_dots = false;
									}
									$active_class = $i == $current_page ? 'active' : '';
									echo '<button class="page-btn ' . $active_class . '" data-page="' . esc_attr($i) . '">' . esc_html($i) . '</button>';
								} else {
									$show_dots = true;
								}
							}
							?>
						</div>

						<div class="arrow-btn next">
							<div class="site-btn" id="desktopNext" <?php if ($current_page == $total_pages) echo 'style="opacity: 0.5; pointer-events: none;"'; ?> aria-label="Next">Next</div>
						</div>
					</div>

					<!-- Mobile Pagination -->
					<div class="mobile-pagination">
						<button id="prevBtn" class="arrow-btn" <?php if ($current_page == 1) echo 'disabled'; ?> aria-label="Prev">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Previous">
						</button>
						<button id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html($current_page . '/' . $total_pages); ?></button>
						<button id="nextBtn" class="arrow-btn" <?php if ($current_page == $total_pages) echo 'disabled'; ?> aria-label="Next">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
						</button>
					</div>

					<!-- Mobile Popup -->
					<div id="paginationPopup" class="pagination-popup">
						<div class="popup-body">
							<div id="popupGrid" class="popup-grid">
								<?php for ($i = 1; $i <= $total_pages; $i++): ?>
									<?php $active = $i == $current_page ? 'active' : ''; ?>
									<button class="page-btn <?php echo esc_attr($active); ?>" data-page="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></button>
								<?php endfor; ?>
							</div>
							<button id="popupPrev" class="arrow-btn" <?php if ($current_page == 1) echo 'disabled'; ?>></button>
							<button id="popupNext" class="arrow-btn" <?php if ($current_page == $total_pages) echo 'disabled'; ?>></button>
						</div>
					</div>

				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
$terms = get_terms([
	'taxonomy'   => 'donor-type',
	'hide_empty' => true,
]);
?>
<ul id="donor-type" class="dropdown-menu" role="menu" aria-labelledby="donor-type">
	<li class="active"><a href="javascript:void(0)" data-term="all">All</a></li>
	<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
		<?php foreach ($terms as $term) : ?>
			<li>
				<a href="javascript:void(0)" data-term="<?php echo esc_attr($term->slug); ?>">
					<?php echo esc_html($term->name); ?>
				</a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
<?php
$terms = get_terms([
	'taxonomy'   => 'donation-level',
	'hide_empty' => true,
]);
?>
<ul id="donation-level" class="dropdown-menu" role="menu" aria-labelledby="donation-level">
	<li class="active"><a href="javascript:void(0)" data-term="all">All</a></li>
	<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
		<?php foreach ($terms as $term) : ?>
			<li>
				<a href="javascript:void(0)" data-term="<?php echo esc_attr($term->slug); ?>">
					<?php echo esc_html($term->name); ?>
				</a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>