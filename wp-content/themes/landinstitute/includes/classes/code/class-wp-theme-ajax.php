<?php
/**
 * Ajax related functions
 *
 * @link https://codex.wordpress.org/AJAX#Ajax_in_WordPress
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

namespace BaseTheme\Ajax;

/**
 * Template Class For Ajax
 *
 * Template Class
 *
 * @category Setting_Class
 * @package  Base Theme Package
 */
class WP_Theme_Ajax {
	/**
	 * Define class Constructor
	 **/
	public function __construct() {
        add_action('wp_ajax_search_filter', [$this, 'search_filter_callback']);
        add_action('wp_ajax_nopriv_search_filter', [$this, 'search_filter_callback']);

		add_action('wp_ajax_filter_logo_grid_filter', [$this, 'filter_logo_grid_filter_callback']);
		add_action('wp_ajax_nopriv_filter_logo_grid_filter', [$this, 'filter_logo_grid_filter_callback']);

		add_action('wp_ajax_load_more_events', [$this, 'load_more_events_callback']);
		add_action('wp_ajax_nopriv_load_more_events', [$this, 'load_more_events_callback']);

		add_action('wp_ajax_filter_past_events', [$this, 'filter_past_events_callback']);
		add_action('wp_ajax_nopriv_filter_past_events', [$this, 'filter_past_events_callback']);

		add_action('wp_ajax_filter_news', [$this, 'filter_news_callback']);
		add_action('wp_ajax_nopriv_filter_news', [$this, 'filter_news_callback']);

		add_action('wp_ajax_filter_learn', [$this, 'handle_ajax_news_learn']); 
		add_action('wp_ajax_nopriv_filter_learn', [$this, 'handle_ajax_news_learn']);

    }

	// Search Filter Ajax Callback
    public function search_filter_callback() {

		// 1. Inputs & Sanitization
		$paged      = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
		$search     = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
		$type       = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'all';
		$order_by   = (isset($_POST['orderby']) && $_POST['orderby'] === 'title') ? 'title' : 'date';
		$learn_type = isset($_POST['learntype']) ? sanitize_text_field($_POST['learntype']) : '';

		// 2. Query Arguments
		$post_types = ($type !== 'all') ? [$type] : ['post', 'event', 'page', 'news', 'staff'];

		$args = [
			'post_type'      => $post_types,
			'posts_per_page' => 12,
			'paged'          => $paged,
			'post_status'    => 'publish',
			's'              => $search,
		];

		// Default ordering
		if ($type === 'staff' && $order_by === 'title') {
			$args['meta_key'] = 'staff_last_name';
			$args['orderby']  = 'meta_value';
			$args['order']    = 'ASC';
		} else {
			$args['orderby'] = $order_by;
			$args['order']   = ($order_by === 'title') ? 'ASC' : 'DESC';
		}

		global $wpdb;

		// 3. 🔍 Extend Search (First + Last Name for staff)
		$search_filter = null;

		if (!empty($search) && in_array('staff', $post_types)) {

			$search_filter = function ($where, $query) use ($search, $wpdb) {

				if (!$query->is_main_query()) {
					return $where;
				}

				$like = '%' . $wpdb->esc_like($search) . '%';

				$where .= $wpdb->prepare("
					OR (
						{$wpdb->posts}.post_type = 'staff'
						AND (
							EXISTS (
								SELECT 1 FROM {$wpdb->postmeta} pm1
								WHERE pm1.post_id = {$wpdb->posts}.ID
								AND pm1.meta_key = 'staff_first_name'
								AND pm1.meta_value LIKE %s
							)
							OR
							EXISTS (
								SELECT 1 FROM {$wpdb->postmeta} pm2
								WHERE pm2.post_id = {$wpdb->posts}.ID
								AND pm2.meta_key = 'staff_last_name'
								AND pm2.meta_value LIKE %s
							)
						)
					)
				", $like, $like);

				return $where;
			};

			add_filter('posts_where', $search_filter, 10, 2);
		}

		// 4. Custom ORDER BY (Staff last name inside ALL)
		$orderby_filter = null;

		if ($order_by === 'title' && in_array('staff', $post_types)) {

			$orderby_filter = function ($orderby, $query) use ($wpdb) {

				if (!$query->is_main_query()) {
					return $orderby;
				}

				return "
					CASE 
						WHEN {$wpdb->posts}.post_type = 'staff' 
						THEN (
							SELECT pm.meta_value 
							FROM {$wpdb->postmeta} pm 
							WHERE pm.post_id = {$wpdb->posts}.ID 
							AND pm.meta_key = 'staff_last_name' 
							LIMIT 1
						)
						ELSE {$wpdb->posts}.post_title
					END ASC
				";
			};

			add_filter('posts_orderby', $orderby_filter, 10, 2);
		}

		// 5. Taxonomy Filter
		if (!empty($learn_type) && $learn_type !== 'all') {
			$args['tax_query'] = [[
				'taxonomy' => 'learn-type',
				'field'    => 'slug',
				'terms'    => $learn_type,
			]];
		}

		// 6. Run Query
		$query = new \WP_Query($args);

		// Remove filters
		if ($search_filter) {
			remove_filter('posts_where', $search_filter, 10);
		}

		if ($orderby_filter) {
			remove_filter('posts_orderby', $orderby_filter, 10);
		}

		// 7. Generate Results HTML
		ob_start();
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				get_template_part('partials/content', 'search-list');
			}
		} else {
			echo '<div class="not-found-block"><div class="not-found">No Search results found.</div></div>';
		}
		$results_html = ob_get_clean();

		// 8. Pagination
		set_query_var('search_query', $query);
		set_query_var('paged_var', $paged);

		ob_start();
		get_template_part('partials/content', 'search-pagination');
		$pagination_html = ob_get_clean();

		wp_reset_postdata();

		// 9. Response
		wp_send_json_success([
			'news_html'       => $results_html,
			'pagination_html' => $pagination_html,
		]);
	}

	public function filter_logo_grid_filter_callback(){
		check_ajax_referer('ajax_nonce', 'nonce');

		$donor_type     = $_POST['donor_type'] ?? 'all';
		$donation_level = $_POST['donation_level'] ?? 'all';
		$paged          = max(1, (int) ($_POST['paged'] ?? 1));

		$posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 9;
		if ($posts_per_page <= 0) {
			$posts_per_page = 9;
		}

		$tax_query = ['relation' => 'AND'];

		if ($donor_type !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'donor-type',
				'field'    => 'slug',
				'terms'    => $donor_type,
			];
		}

		if ($donation_level !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'donation-level',
				'field'    => 'slug',
				'terms'    => $donation_level,
			];
		}

		$args = [
			'post_type'      => 'donor',
			'post_status'    => 'publish',
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'orderby'        => 'title',
			'order'          => 'DESC',
			'tax_query'      => $tax_query,
		];

		$donors = new \WP_Query($args);

		ob_start();

		if ($donors->have_posts()) :
			while ($donors->have_posts()) :
				$donors->the_post();

				get_template_part('partials/content', 'donors-list');

			endwhile;

			wp_reset_postdata();
		else :
			echo '<div class="no-results">No donors found for this filter.</div>';
		endif;

		$html = ob_get_clean();

		// Pagination
		$pagination_html   = '';
		$total_pages       = $donors->max_num_pages;
		$total_found_posts = $donors->found_posts;

		if ($total_found_posts > $posts_per_page) {

			ob_start();

			// Pass variables to template
			set_query_var('paged', $paged);
			set_query_var('total_pages', $total_pages);

			get_template_part('partials/content', 'donors-pagination');

			$pagination_html = ob_get_clean();
		}

		wp_send_json_success([
			'html'            => $html,
			'pagination_html' => $pagination_html,
			'max_pages'       => $total_pages,
			'found_posts'     => $total_found_posts,
			'current_page'    => $paged,
		]);
	}

	public function load_more_events_callback(){
		$paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$posts_per_page = 10;

		$current_timestamp = current_time('timestamp');

		$eventargs = array(
			'post_type'      => 'event',
			'post_status'    => 'publish',
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'li_cpt_event_timestepm_with_selected_timezone',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'li_cpt_event_timestepm_with_selected_timezone_compare',
					'value'   => $current_timestamp,
					'type'    => 'NUMERIC',
					'compare' => '>='
				)
			)
		);

		$event_query = new \WP_Query($eventargs);

		ob_start();

		if ($event_query->have_posts()) :
			while ($event_query->have_posts()) : $event_query->the_post();
				$post_id = get_the_ID();
				$start_date = get_field('li_cpt_event_start_date');
				$end_date   = get_field('li_cpt_event_end_date');
				$event_display = get_formatted_event_datetime($post_id);

				$image = wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full');
				if (get_the_post_thumbnail_url($post_id, 'medium')) {
					$image = get_the_post_thumbnail_url($post_id, 'medium');
				}

				$excerpt = wp_trim_words(get_the_excerpt(), 25, '...');
				$url = get_permalink();

				set_query_var('start_date', $start_date);
				set_query_var('end_date', $end_date);
				set_query_var('image', $image);
				set_query_var('excerpt', $excerpt);
				set_query_var('url', $url);
				set_query_var('event_display', $event_display);

				get_template_part('partials/content', 'event-list');
			endwhile;
		else :
			echo '<div class="no-more-events">No more events.</div>';
		endif;

		$html = ob_get_clean();

		// Determine if there are more pages
		$has_more = ($paged < $event_query->max_num_pages);

		wp_reset_postdata();

		wp_send_json([
			'success'    => true,
			'html'       => $html,
			'has_more'   => $has_more,
			'next_page'  => $paged + 1
		]);
	}

	public function filter_past_events_callback(){
		check_ajax_referer('ajax_nonce', 'nonce');

		$term  = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
		$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

		$current_timestamp = strtotime(date('Y-m-d') . ' 00:00:00');

		$args = [
			'post_type'      => 'event',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'paged'          => $paged,
			'meta_key'       => 'li_cpt_event_timestepm_with_selected_timezone',
			'orderby'        => 'meta_value',
			'order'          => 'DESC',
			'meta_query'     => [
				[
					'key'     => 'li_cpt_event_timestepm_with_selected_timezone_compare',
					'value'   => $current_timestamp,
					'compare' => '<',
					'type'    => 'NUMERIC',
				],
			],
		];

		$query = new \WP_Query($args);

		if ($query->have_posts()) {

			ob_start();

			while ($query->have_posts()) {
				$query->the_post();

				get_template_part(
					'partials/content',
					'past-event-list',
					['post_id' => get_the_ID()]
				);
			}

			wp_reset_postdata();

			$html        = ob_get_clean();
			$total_pages = $query->max_num_pages;

			$pagination_html = '';

			if ($total_pages > 1) {

				ob_start();

				set_query_var('paged', $paged);
				set_query_var('total_pages', $total_pages);

				get_template_part('partials/content', 'past-event-pagination');

				$pagination_html = ob_get_clean();
			}

			wp_send_json_success([
				'html'            => $html,
				'pagination_html' => $pagination_html,
				'total_pages'     => $total_pages,
			]);

		} else {
			wp_send_json_success([
				'html' => '<p>No past events found.</p>',
			]);
		}

		wp_die();
	}

	
	public function filter_news_callback() {
		$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

		$tax_query = [];

		
		if (!empty($_POST['news_type']) && $_POST['news_type'] !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'news-type',
				'field'    => 'slug',
				'terms'    => sanitize_text_field($_POST['news_type']),
			];
		}

		if (!empty($_POST['news_topic']) && $_POST['news_topic'] !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'news-topic',
				'field'    => 'slug',
				'terms'    => sanitize_text_field($_POST['news_topic']),
			];
		}
		if (!empty($_POST['news_crop']) && $_POST['news_crop'] !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'news-crop',
				'field'    => 'slug',
				'terms'    => sanitize_text_field($_POST['news_crop']),
			];
		}
		if (!empty($_POST['news_audience']) && $_POST['news_audience'] !== 'all') {
			$tax_query[] = [
				'taxonomy' => 'news-audience',
				'field'    => 'slug',
				'terms'    => sanitize_text_field($_POST['news_audience']),
			];
		}

		// Add exclusions using the helper
		$exclude_taxonomies = ['news-crop', 'news-type', 'news-topic', 'news-audience'];

		foreach ($exclude_taxonomies as $taxonomy) {
			$exclude_query = get_exclude_tax_query_for_taxonomy($taxonomy);
			if (!empty($exclude_query)) {
				$tax_query[] = $exclude_query;
			}
		}

		$args = [
			'post_type'      => 'news',
			'posts_per_page' => 6,
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged'          => $paged,
		];

		if (!empty($tax_query)) {
			$args['tax_query'] = $tax_query;
		}

		set_query_var('requestdbyajax', 'yes');

		$news = new \WP_Query($args);
		$datafound = $news->have_posts() ? 'yes' : 'no';

		ob_start();
		include get_template_directory() . '/partials/content-news-list.php';
		$news_html = ob_get_clean();

		ob_start();
		include get_template_directory() . '/partials/content-news-pagination.php';
		$pagination_html = ob_get_clean();

		wp_send_json_success([
			'news_html'       => $news_html,
			'pagination_html' => $pagination_html,
			'datafound'       => $datafound,
		]);
	}


	public function handle_ajax_news_learn() {

		$paged = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;

		$tax_query = ['relation' => 'AND'];
		$exclude_taxonomies = [];

		// ACF settings
		$filter_setting = get_field('li_learn_filters', 131);

		$filters = [
			'learn-type'     => ['key' => 'post_type',      'enabled' => $filter_setting['enable_learn_type'] ?? false],
			'learn-topic'    => ['key' => 'learn_topic',    'enabled' => $filter_setting['enable_learn_topic'] ?? false],
			'learn-crop'     => ['key' => 'learn_crops',    'enabled' => $filter_setting['enable_learn_crop'] ?? false],
			'learn-audience' => ['key' => 'learn_audience', 'enabled' => $filter_setting['enable_learn_audience'] ?? false],
		];

		foreach ($filters as $taxonomy => $config) {

			// Always add to exclude list
			$exclude_taxonomies[] = $taxonomy;

			// Apply filter only if enabled
			if (
				$config['enabled'] &&
				!empty($_POST[$config['key']]) &&
				$_POST[$config['key']] !== 'all'
			) {
				$tax_query[] = [
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => sanitize_text_field($_POST[$config['key']]),
				];
			}
		}

		// Apply exclude logic
		if (!empty($exclude_taxonomies)) {
			foreach ($exclude_taxonomies as $taxonomy) {
				$exclude_query = get_exclude_tax_query_for_taxonomy($taxonomy);
				if (!empty($exclude_query)) {
					$tax_query[] = $exclude_query;
				}
			}
		}

		// Query args
		$args = [
			'post_type'      => 'post',
			'posts_per_page' => 12,
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged'          => $paged,
		];

		if (count($tax_query) > 1) {
			$args['tax_query'] = $tax_query;
		}

		$query = new \WP_Query($args);

		set_query_var('learn_query', $query);
		set_query_var('paged_var', $paged);
		set_query_var('requestdbyajax', 'yes');

		ob_start();
		get_template_part('partials/content', 'learn-list');
		$news_html = ob_get_clean();

		ob_start();
		get_template_part('partials/content', 'learn-pagination');
		$pagination_html = ob_get_clean();

		wp_reset_postdata();

		wp_send_json_success([
			'news_html'       => $news_html,
			'pagination_html' => $pagination_html,
			'datafound'       => $query->have_posts() ? 'yes' : 'no',
		]);
	}
		

}
new WP_Theme_Ajax();