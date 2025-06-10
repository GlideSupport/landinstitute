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
		$args = [
			'post_type'      => 'donor',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'post_status'    => 'publish',
		];
		$donors = new WP_Query($args);

		if ($donors->have_posts()) : ?>
			<div class="filter-logos-row">
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
						$image_html = wp_get_attachment_image($image_id, 'full', false, [ 'width'  => 200, 'height' => 102, 'alt'    => get_the_title()]);
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
								<div class="ui-20-18-bold logo-title"><?php the_title(); ?></div>
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
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<div class="gl-s64"></div>
		<div class="fillter-bottom">
			<div class="pagination-container">
				<div class="desktop-pages">
					<div class="arrow-btn prev">
						<div class="site-btn">Previous</div>
					</div>
					<div class="pagination-list">
						<button class="page-btn active">1</button>
						<button class="page-btn">2</button>
						<button class="page-btn">3</button>
						<span class="dots">...</span>
						<button class="page-btn">12</button>
					</div>
					<div class="arrow-btn next">
						<div class="site-btn">Next</div>
					</div>
				</div>
				<!-- Mobile Pagination -->
				<div class="mobile-pagination">
					<button id="prevBtn" class="arrow-btn"><img
							src="../assets/src/images/right-circle-arrow.svg"></button>
					<button id="pageTrigger" class="page-trigger ui-18-16-bold">1/26</button>
					<button id="nextBtn" class="arrow-btn"><img
							src="../assets/src/images/right-circle-arrow.svg"></button>
				</div>

				<!-- Mobile Popup -->
				<div id="paginationPopup" class="pagination-popup">
					<div class="popup-body">
						<div id="popupGrid" class="popup-grid"><button
								class="page-btn active">1</button><button
								class="page-btn">2</button><button
								class="page-btn">3</button><button
								class="page-btn">4</button><button
								class="page-btn">5</button><button
								class="page-btn">6</button><button
								class="page-btn">7</button><button
								class="page-btn">8</button><button
								class="page-btn">9</button><button
								class="page-btn">10</button><button
								class="page-btn">11</button><button class="page-btn">12</button>
						</div>
						<button id="popupPrev" class="arrow-btn"></button>
						<button id="popupNext" class="arrow-btn"></button>
					</div>
				</div>
			</div>
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