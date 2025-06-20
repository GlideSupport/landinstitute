<?php
$li_sl_staff_selector = $bst_block_fields['li_sl_staff_selector'] ?? null;
?>
<div class="staff-list tabbed-content-block has-border-bottom">
	<div class="block-head">
		<h2 class="block-title heading-2 mb-0">Staff</h2>
		<div class="gl-s52"></div>
	</div>
	<div class="tabbed-block-content">
	<div class="tabs-listing">
		<?php
		$terms = get_terms([ 'taxonomy' => 'staff-category', 'hide_empty' => false, ]);

		if (!empty($terms) && !is_wp_error($terms)) :
		?>
			<ul class="tabs">
				<?php
				$tab_index = 1;
				foreach ($terms as $term) {
					$active_class = ($tab_index === 1) ? 'current' : '';
					echo '<li class="tab-link ' . $active_class . '" data-tab="tab-' . $tab_index . '">' . esc_html($term->name) . '</li>';
					$tab_index++;
				}
				echo '<li class="tab-link" data-tab="tab-' . $tab_index . '">All</li>';
				?>
			</ul>
	</div>

	<div class="tab-content-group">
		<?php
			$tab_index = 1;
			foreach ($terms as $term) {
				$active_class = ($tab_index === 1) ? 'current fade-in' : '';

				// Get the category color for this specific term
				$bg_color = get_field('li_globel_bg_color_options', 'term_' . $term->term_id);
				if (empty($bg_color)) {
					$bg_color = 'bg-none'; // Default fallback
				}
				echo '<div id="tab-' . $tab_index . '" class="tab-content ' . $active_class . '" style="opacity: ' . ($active_class ? '1' : '0') . ';">';
				echo '<div class="tab-row-block staff-listing">';

				// Query posts in this staff-category
				$query = new WP_Query([
					'post_type' => 'staff',
					'posts_per_page' => -1,
					'tax_query' => [[
						'taxonomy' => 'staff-category',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					]],
				]);

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
						$title = get_the_title();
						$position = get_field('staff_designation', get_the_ID());
						echo '
						<a href="' . get_permalink() . '" class="card-item ' . esc_attr($bg_color) . '">
							<div class="card-body">
								<div class="gl-s52"></div>
								<h5 class="card-title mb-0 heading-5">' . esc_html($title) . '</h5>
								<div class="gl-s6"></div>
								<div class="ui-eyebrow-16-15-regular sub-head">' . esc_html($position) . '</div>
								<div class="gl-s20"></div>
								<div class="card-btn">
									<div class="border-text-btn">Read more</div>
								</div>
							</div>
							<div class="card-img">
								<div class="gl-s30"></div>
								<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" />
							</div>
						</a>';
					endwhile;
					wp_reset_postdata();
				endif;

				echo '</div></div>';
				$tab_index++;
			}

			// "All" tab - here we need to get the color for each staff member's category
			echo '<div id="tab-' . $tab_index . '" class="tab-content" style="opacity: 0;">';
			echo '<div class="tab-row-block staff-listing">';

			$all_query = new WP_Query([
				'post_type' => 'staff',
				'posts_per_page' => -1,
			]);

			if ($all_query->have_posts()) :
				while ($all_query->have_posts()) : $all_query->the_post();
					$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
					$title = get_the_title();
					$position = get_field('staff_designation', get_the_ID());
					
					// Get the staff member's category to determine color
					$staff_terms = wp_get_post_terms(get_the_ID(), 'staff-category');
					$staff_bg_color = 'bg-sunflower-yellow'; // Default for "All" tab
					
					
					echo '
						<a href="' . get_permalink() . '" class="card-item ' . esc_attr($staff_bg_color) . '">
							<div class="card-body">
								<div class="gl-s52"></div>
								<h5 class="card-title mb-0 heading-5">' . esc_html($title) . '</h5>
								<div class="gl-s6"></div>
								<div class="ui-eyebrow-16-15-regular sub-head">' . esc_html($position) . '</div>
								<div class="gl-s20"></div>
								<div class="card-btn">
									<div class="border-text-btn">Read more</div>
								</div>
								</div>
									<div class="card-img">
										<div class="gl-s30"></div>
										<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" />
								</div>
						</a>';
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p>No staff members found.</p>';
			endif;

			echo '</div></div>'; // Close "All" tab
		endif;
		?>
	</div>
</div>
