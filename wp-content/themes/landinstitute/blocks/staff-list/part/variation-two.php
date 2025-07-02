<?php
$li_sl_staff_selection         = $bst_block_fields['li_sl_staff_selection'] ?? 'manual'; // 'manual' or 'category'
$li_sl_staff_selector          = $bst_block_fields['li_sl_staff_selector'] ?? [];
$li_sl_staff_category_selector = $bst_block_fields['_li_sl_select_staff_categories'] ?? [];

$show_by_category = $li_sl_staff_selection === 'category' && !empty($li_sl_staff_category_selector);
$show_by_selector = $li_sl_staff_selection === 'manual' && !empty($li_sl_staff_selector);

$bst_var_theme_default_avatar_for_staff  = $bst_option_fields['bst_var_theme_default_avatar_for_staff'] ?? null;

if (!$show_by_category && !$show_by_selector) return; // Exit if nothing to show
?>

<div class="staff-list tabbed-content-block">
	<div class="block-head">
		<?php
		if (!empty($li_sl_headline)) {
			echo BaseTheme::headline($li_sl_headline, 'heading-2 block-title mb-0');
			echo '<div class="gl-s52"></div>';
		} ?>
	</div>
	<div class="tabbed-block-content">
		<div class="tabs-listing">
			<ul class="tabs">
				<?php
				$terms = [];

				if ($show_by_category) {
					$terms = $li_sl_staff_category_selector;
				} elseif ($show_by_selector) {
					foreach ($li_sl_staff_selector as $post_id) {
						$post_terms = wp_get_post_terms($post_id, 'staff-category', ['parent' => 0]);
						foreach ($post_terms as $term) {
							$terms[$term->term_id] = $term;
						}
					}
					$terms = array_values($terms);
				}

				$tab_index = 1;
				foreach ($terms as $term) {
					$active = ($tab_index === 1) ? 'current' : '';
					echo '<li class="tab-link ' . esc_attr($active) . '" data-tab="tab-' . $tab_index . '">' . esc_html($term->name) . '</li>';
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
				$active = ($tab_index === 1) ? 'current fade-in' : '';
				$bg_color = get_field('li_globel_bg_color_options', 'term_' . $term->term_id) ?: 'bg-none';

				echo '<div id="tab-' . $tab_index . '" class="tab-content ' . $active . '" style="opacity:' . ($active ? '1' : '0') . ';">';
				echo '<div class="tab-row-block staff-listing">';

				$args = [
					'post_type'      => 'staff',
					'posts_per_page' => -1,
					'tax_query'      => [[
						'taxonomy' => 'staff-category',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					]],
				];

				if ($show_by_selector) {
					$args['post__in'] = $li_sl_staff_selector;
					$args['orderby']  = 'post__in';
				}

				$staff_query = new WP_Query($args);

				if ($staff_query->have_posts()) :
					while ($staff_query->have_posts()) : $staff_query->the_post();
						$title     = get_the_title();
						$position  = get_field('staff_designation');
						$image     = get_the_post_thumbnail_url(get_the_ID(), 'thumb_500');
						if (empty($image)) {
							$image = wp_get_attachment_image_url($bst_var_theme_default_avatar_for_staff, 'thumb_500');
						}
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
				else :
					echo '<p>No staff found for this category.</p>';
				endif;

				echo '</div></div>';
				$tab_index++;
			}

			// "All" tab
			echo '<div id="tab-' . $tab_index . '" class="tab-content" style="opacity:0;">';
			echo '<div class="tab-row-block staff-listing">';

			$all_args = [
				'post_type'      => 'staff',
				'posts_per_page' => -1,
			];

			if ($show_by_selector) {
				$all_args['post__in'] = $li_sl_staff_selector;
				$all_args['orderby']  = 'post__in';
			} elseif ($show_by_category) {
				$all_args['tax_query'] = [[
					'taxonomy' => 'staff-category',
					'field'    => 'term_id',
					'terms'    => wp_list_pluck($li_sl_staff_category_selector, 'term_id'),
				]];
			}

			$all_query = new WP_Query($all_args);

			if ($all_query->have_posts()) :
				while ($all_query->have_posts()) : $all_query->the_post();
					$title    = get_the_title();
					$position = get_field('staff_designation');
					$image    = get_the_post_thumbnail_url(get_the_ID(), 'thumb_500');
					if (empty($image)) {
						$image = wp_get_attachment_image_url($bst_var_theme_default_avatar_for_staff, 'thumb_500');
					}
					$link     = get_permalink();
					$terms    = wp_get_post_terms(get_the_ID(), 'staff-category');
					$bg_color = !empty($terms) ? (get_field('li_globel_bg_color_options', 'term_' . $terms[0]->term_id) ?: 'bg-none') : 'bg-none';

					echo '
					<a href="' . esc_url($link) . '" class="card-item ' . esc_attr($bg_color) . '">
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
			else :
				echo '<p>No staff found.</p>';
			endif;

			echo '</div></div>'; // Close all-tab
			?>
		</div>
	</div>
</div>