<?php
$li_sl_staff_selector = $bst_block_fields['li_sl_staff_selector'] ?? null;
$li_sl_staff_category_selector = $bst_block_fields['_li_sl_select_staff_categories'] ?? []; // ACF Taxonomy field
$selected_category_ids = is_array($li_sl_staff_category_selector) ? wp_list_pluck($li_sl_staff_category_selector, 'term_id') : [];
$bst_var_theme_default_avatar_for_staff  = $bst_option_fields['bst_var_theme_default_avatar_for_staff'] ?? null;

$use_category_mode = !empty($selected_category_ids);
?>
<div class="staff-list tabbed-content-block has-border-bottom">
	<div class="block-head">
		<h2 class="block-title heading-2 mb-0">Staff</h2>
		<div class="gl-s52"></div>
	</div>
	<?php if (!empty($li_sl_staff_selector) || $use_category_mode) : ?>
		<div class="tabbed-block-content">
			<div class="tabs-listing">
				<?php
				// Get terms based on selected categories or selected staff
				$terms_args = [
					'taxonomy'   => 'staff-category',
					'hide_empty' => true,
					'parent'     => 0,
				];

				if ($use_category_mode) {
					$terms_args['include'] = $selected_category_ids;
				} else {
					$terms_args['object_ids'] = $li_sl_staff_selector;
				}

				$terms = get_terms($terms_args);

				if (!empty($terms) && !is_wp_error($terms)) :
				?>
					<ul class="tabs">
						<?php
						$tab_index = 1;
						foreach ($terms as $term) {
							$active_class = ($tab_index === 1) ? 'current' : '';
							echo '<li class="tab-link ' . esc_attr($active_class) . '" data-tab="tab-' . $tab_index . '">' . esc_html($term->name) . '</li>';
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
						$bg_color = get_field('li_globel_bg_color_options', 'term_' . $term->term_id) ?: 'bg-none';

						echo '<div id="tab-' . $tab_index . '" class="tab-content ' . $active_class . '" style="opacity:' . ($active_class ? '1' : '0') . ';">';
						echo '<div class="tab-row-block staff-listing">';

						$query_args = [
							'post_type'      => 'staff',
							'posts_per_page' => -1,
							'orderby'        => 'post__in',
							'tax_query'      => [[
								'taxonomy' => 'staff-category',
								'field'    => 'term_id',
								'terms'    => $term->term_id,
							]],
						];

						if (!$use_category_mode) {
							$query_args['post__in'] = $li_sl_staff_selector;
						}

						$staff_query = new WP_Query($query_args);

						if ($staff_query->have_posts()) :
							while ($staff_query->have_posts()) : $staff_query->the_post();
								$title     = get_the_title();
								$image     = get_the_post_thumbnail_url(get_the_ID(), 'thumb_500');
								if (empty($image)) {
									$image = wp_get_attachment_image_url($bst_var_theme_default_avatar_for_staff, 'thumb_500');
								}
								$position  = get_field('staff_designation');
								$permalink = get_permalink();

								echo '
								<a href="' . esc_url($permalink) . '" class="card-item ' . esc_attr($bg_color) . '">
									<div class="card-body">
										<div class="gl-s52"></div>
										<h5 class="card-title mb-0 heading-5">' . esc_html($title) . '</h5>
										<div class="gl-s6"></div>
										<div class="ui-eyebrow-16-15-regular sub-head">' . esc_html($position) . '</div>
										<div class="gl-s20"></div>
										<div class="card-btn"><div class="border-text-btn">Read more</div></div>
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

					// "ALL" tab
					echo '<div id="tab-' . $tab_index . '" class="tab-content" style="opacity:0;">';
					echo '<div class="tab-row-block staff-listing">';

					$all_query_args = [
						'post_type'      => 'staff',
						'posts_per_page' => -1,
						'orderby'        => 'post__in',
					];

					if ($use_category_mode) {
						$all_query_args['tax_query'] = [[
							'taxonomy' => 'staff-category',
							'field'    => 'term_id',
							'terms'    => $selected_category_ids,
						]];
					} else {
						$all_query_args['post__in'] = $li_sl_staff_selector;
					}

					$all_query = new WP_Query($all_query_args);

					if ($all_query->have_posts()) :
						while ($all_query->have_posts()) : $all_query->the_post();
							$title     = get_the_title();
							$image     = get_the_post_thumbnail_url(get_the_ID(), 'thumb_500');

							if (empty($image)) {
								$image = wp_get_attachment_image_url($bst_var_theme_default_avatar_for_staff, 'thumb_500');
							}
							$position  = get_field('staff_designation');
							$permalink = get_permalink();

							$staff_terms = wp_get_post_terms(get_the_ID(), 'staff-category');
							$bg_color    = 'bg-sunflower-yellow'; // default

							if (!empty($staff_terms)) {
								$bg = get_field('li_globel_bg_color_options', 'term_' . $staff_terms[0]->term_id);
								if (!empty($bg)) {
									$bg_color = $bg;
								}
							}

							echo '
							<a href="' . esc_url($permalink) . '" class="card-item ' . esc_attr($bg_color) . '">
								<div class="card-body">
									<div class="gl-s52"></div>
									<h5 class="card-title mb-0 heading-5">' . esc_html($title) . '</h5>
									<div class="gl-s6"></div>
									<div class="ui-eyebrow-16-15-regular sub-head">' . esc_html($position) . '</div>
									<div class="gl-s20"></div>
									<div class="card-btn"><div class="border-text-btn">Read more</div></div>
								</div>
								<div class="card-img">
									<div class="gl-s30"></div>
									<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" />
								</div>
							</a>';
						endwhile;
						wp_reset_postdata();
					endif;

					echo '</div></div>'; // End All tab
				?>
			</div>
		<?php endif; ?>
		</div>
	<?php endif; ?>
</div>