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
			<div class="md-mobile-filter-main">
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

					$title = html_entity_decode(get_the_title());
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

	<?php
		// SEO rel="prev/next"
		if ($current_page > 1) {
			$prev_link = ($current_page - 1 == 1) ? get_pagenum_link(1) : get_pagenum_link($current_page - 1);
			echo '<link rel="prev" href="' . esc_url($prev_link) . '">';
		}
		if ($current_page < $total_pages) {
			$next_link = get_pagenum_link($current_page + 1);
			echo '<link rel="next" href="' . esc_url($next_link) . '">';
		}
	?>

	<div class="pagination-container" data-current-page="<?php echo esc_attr($current_page); ?>" data-total-pages="<?php echo esc_attr($total_pages); ?>">

		<!-- Desktop Pagination -->
		<div class="desktop-pages">
			<div class="arrow-btn prev">
				<?php if ($current_page > 1): ?>
					<a class="site-btn" id="desktopPrev" href="<?php echo esc_url($prev_link); ?>" rel="prev">Previous</a>
				<?php else: ?>
					<span class="site-btn disabled">Previous</span>
				<?php endif; ?>
			</div>

			<div class="pagination-list" id="paginationList">
				<?php
				$range = 2;
				$ellipsis = false;
				for ($i = 1; $i <= $total_pages; $i++) {
					if (
						$i == 1 || $i == $total_pages ||
						($i >= $current_page - $range && $i <= $current_page + $range)
					) {
						if ($ellipsis) {
							echo '<span class="dots">...</span>';
							$ellipsis = false;
						}
						$is_active = $i == $current_page;
						$btn_class = $is_active ? 'page-btn active' : 'page-btn';
						$link = ($i == 1) ? get_pagenum_link(1) : get_pagenum_link($i);
						$current_attr = $is_active ? ' aria-current="page"' : '';
						echo '<a href="' . esc_url($link) . '" class="' . $btn_class . '" data-page="' . esc_attr($i) . '"' . $current_attr . '>' . esc_html($i) . '</a>';
					} else {
						$ellipsis = true;
					}
				}
				?>
			</div>

			<div class="arrow-btn next">
				<?php if ($current_page < $total_pages): ?>
					<a class="site-btn" id="desktopNext" href="<?php echo esc_url($next_link); ?>" rel="next">Next</a>
				<?php else: ?>
					<span class="site-btn disabled">Next</span>
				<?php endif; ?>
			</div>
		</div>

		<!-- Mobile Pagination -->
		<div class="mobile-pagination">
			<a id="prevBtn" class="arrow-btn" href="<?php echo esc_url($prev_link); ?>" <?php if ($current_page == 1) echo 'style="opacity:.5; pointer-events:none;"'; ?> aria-label="Previous" rel="prev">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Previous">
			</a>
			<button id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html($current_page . '/' . $total_pages); ?></button>
			<a id="nextBtn" class="arrow-btn" href="<?php echo esc_url($next_link); ?>" <?php if ($current_page == $total_pages) echo 'style="opacity:.5; pointer-events:none;"'; ?> aria-label="Next" rel="next">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
			</a>
		</div>

		<!-- Mobile Popup -->
		<div id="paginationPopup" class="pagination-popup">
			<div class="popup-body">
				<div id="popupGrid" class="popup-grid">
					<?php for ($i = 1; $i <= $total_pages; $i++): ?>
						<?php $active = $i == $current_page ? 'active' : ''; ?>
						<a class="page-btn <?php echo esc_attr($active); ?>" href="<?php echo esc_url(get_pagenum_link($i)); ?>" <?php if ($i == $current_page) echo 'aria-current="page"'; ?>>
							<?php echo esc_html($i); ?>
						</a>
					<?php endfor; ?>
				</div>
				<a id="popupPrev" class="arrow-btn" href="<?php echo esc_url($prev_link); ?>" <?php if ($current_page == 1) echo 'style="opacity:.5; pointer-events:none;"'; ?> aria-label="Previous" rel="prev"></a>
				<a id="popupNext" class="arrow-btn" href="<?php echo esc_url($next_link); ?>" <?php if ($current_page == $total_pages) echo 'style="opacity:.5; pointer-events:none;"'; ?> aria-label="Next" rel="next"></a>
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
<div class="logo-filter-main">
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
</div>