<?php
$li_sl_staff_selection         = $bst_block_fields['li_sl_staff_selection'] ?? 'manual'; // 'manual' or 'category'
$li_sl_staff_selector          = $bst_block_fields['li_sl_staff_selector'] ?? [];
$li_sl_staff_category_selector = $bst_block_fields['_li_sl_select_staff_categories'] ?? [];

$li_sl_hide_staff_filter = $bst_block_fields['li_sl_hide_staff_filter'] ?? '';
$li_sl_hide_all_tab_filter = $bst_block_fields['li_sl_hide_all_tab_filter'] ?? '';

$hide_staff_filter_class = ( $li_sl_hide_staff_filter == '1' ) ? 'show-filter' : 'none-hidden';
$hide_staff_filter_class_inner = ( $li_sl_hide_staff_filter == '1' ) ? 'none' : 'no-category-up';
$hide_all_tab_filter_class = ( $li_sl_hide_all_tab_filter == '1' ) ? 'show-filter' : 'none-hidden';

$show_by_category = $li_sl_staff_selection === 'category' && !empty($li_sl_staff_category_selector);
$show_by_selector = $li_sl_staff_selection === 'manual' && !empty($li_sl_staff_selector);

$bst_var_theme_default_avatar_for_staff = $bst_option_fields['bst_var_theme_default_avatar_for_staff'] ?? null;

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
		<div class="tabs-listing <?php echo esc_attr($hide_staff_filter_class); ?>">
			<ul class="tabs">
				<?php
				$terms = [];
				$all_staff_categories = [];

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

				// Build category list for JS filtering
				foreach ($terms as $term) {
					$all_staff_categories[] = $term->term_id;
				}

				$tab_index = 1;
				foreach ($terms as $term) {
					$active = ($tab_index === 1) ? 'current' : '';
					$bg_color = get_field('li_globel_bg_color_options', 'term_' . $term->term_id) ?: 'bg-none';
					echo '<li class="tab-link ' . esc_attr($active) . '" data-tab="tab-' . $tab_index . '" data-bg-color="' . $bg_color . '" data-category="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</li>';
					$tab_index++;
				}
				echo '<li class="tab-link '.esc_attr($hide_all_tab_filter_class).'" data-tab="tab-all" data-category="all">All</li>';
				?>
			</ul>
		</div>

		<div class="tab-content-group <?php echo esc_attr($hide_staff_filter_class_inner); ?>">
			<div class="tab-row-block staff-listing">
				<?php
				// Get all staff once
				$args = [
					'post_type'      => 'staff',
					'posts_per_page' => -1,
				];

				if ($show_by_selector) {
					$args['post__in'] = $li_sl_staff_selector;
					$args['orderby']  = 'post__in';
				} elseif ($show_by_category) {
					$args['tax_query'] = [[
						'taxonomy' => 'staff-category',
						'field'    => 'term_id',
						'terms'    => wp_list_pluck($li_sl_staff_category_selector, 'term_id'),
					]];
					$args['orderby'] = 'menu_order';
					$args['order']   = 'ASC';
				}

				$staff_query = new WP_Query($args);

				if ($staff_query->have_posts()) :
					while ($staff_query->have_posts()) : $staff_query->the_post();
						$title = get_the_title();
						$position = get_field('staff_designation',get_the_ID());
						$image = get_the_post_thumbnail_url(get_the_ID(), 'thumb_500');
						if (empty($image)) {
							$image = wp_get_attachment_image_url($bst_var_theme_default_avatar_for_staff, 'thumb_500');
						}
						$permalink = get_permalink();

						// Get staff categories
						$staff_terms = wp_get_post_terms(get_the_ID(), 'staff-category');
						$staff_category_ids = wp_list_pluck($staff_terms, 'term_id');
						$bg_color = !empty($staff_terms) ? (get_field('li_globel_bg_color_options', 'term_' . $staff_terms[0]->term_id) ?: 'bg-none') : 'bg-none';

						// Create data attributes for filtering
						$category_classes = implode(' ', array_map(function ($id) {
							return 'category-' . $id;
						}, $staff_category_ids));
						$category_data = implode(',', $staff_category_ids);

						echo '
						<a href="' . esc_url($permalink) . '" class="card-item staff-member ' . esc_attr($bg_color) . ' ' . esc_attr($category_classes) . '" data-categories="' . esc_attr($category_data) . '">
							<div class="card-body">
								<div class="gl-s52"></div>
								<div class="card-title mb-0 heading-5">' . esc_html($title) . '</div>
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
					echo '<div class="no-staff-message"><p class="center-align alignnone">No staff found.</p>';
					wp_reset_postdata();
				else :
				endif;
				?>
			</div>
		</div>
	</div>
</div>
