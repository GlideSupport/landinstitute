<?php

/**
 * Custom Post Type Columns Management
 *
 * Handles custom columns for Staff and Event post types in WordPress admin.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

namespace BaseTheme\CPT_Columns;

/**
 * Custom Post Type Columns Class
 *
 * Adds and manages custom columns for Staff and Event post types in admin listings.
 *
 * @category Admin_Columns
 * @package  Base Theme Package
 */
class WP_Theme_CPT_Columns extends \Boilerplate
{
	/**
	 * Constructor - Sets up all the column filters and actions
	 */
	public function __construct()
	{
		// Staff CPT columns
		add_filter('manage_staff_posts_columns', [$this, 'add_staff_category_column']);
		add_action('manage_staff_posts_custom_column', [$this, 'show_staff_category_column_content'], 10, 2);
		add_filter('manage_edit-staff_sortable_columns', [$this, 'make_staff_category_column_sortable']);

		// Event CPT columns
		add_filter('manage_event_posts_columns', [$this, 'custom_event_columns']);
		add_action('manage_event_posts_custom_column', [$this, 'custom_event_column_content'], 10, 2);
		add_filter('manage_edit-event_sortable_columns', [$this, 'make_event_columns_sortable']);
		add_action('pre_get_posts', [$this, 'order_events_by_start_date_in_admin']);
	}

	/**
	 * Add Staff Category column to Staff CPT admin list
	 *
	 * @param array $columns Existing columns
	 * @return array Modified columns
	 */
	public function add_staff_category_column($columns)
	{
		unset($columns['date']);
		$columns['staff_category'] = __('Staff Category', 'land_institute');
		$columns['date'] = __('Date', 'land_institute');
		return $columns;
	}

	/**
	 * Display content for Staff Category column
	 *
	 * @param string $column Column name
	 * @param int $post_id Post ID
	 */
	public function show_staff_category_column_content($column, $post_id)
	{
		if ($column === 'staff_category') {
			$this->display_term_links($post_id, 'staff-category');
		}
	}

	/**
	 * Make Staff Category column sortable
	 *
	 * @param array $columns Sortable columns
	 * @return array Modified sortable columns
	 */
	public function make_staff_category_column_sortable($columns)
	{
		$columns['staff_category'] = 'staff_category';
		return $columns;
	}

	/**
	 * Add custom columns to Event CPT admin list
	 *
	 * @param array $columns Existing columns
	 * @return array Modified columns
	 */
	public function custom_event_columns($columns)
	{
		// Insert after 'title'
		$new_columns = [];
		foreach ($columns as $key => $value) {
			$new_columns[$key] = $value;
			if ($key === 'title') {
				$new_columns['event_datetime'] = __('Date and Time', 'land_institute');
				$new_columns['event_cat'] = __('Event Categories', 'land_institute');
				$new_columns['event_tags'] = __('Event Tags', 'land_institute');
			}
		}
		return $new_columns;
	}

	/**
	 * Display content for custom Event columns
	 *
	 * @param string $column Column name
	 * @param int $post_id Post ID
	 */
	public function custom_event_column_content($column, $post_id)
	{
		switch ($column) {
			case 'event_datetime':
				$this->display_event_datetime($post_id);
				break;
			case 'event_cat':
				$this->display_term_links($post_id, 'event-categories');
				break;
			case 'event_tags':
				$this->display_term_links($post_id, 'event-tags');
				break;
		}
	}

	/**
	 * Make Event columns sortable
	 *
	 * @param array $columns Sortable columns
	 * @return array Modified sortable columns
	 */
	public function make_event_columns_sortable($columns)
	{
		$columns['event_datetime'] = 'li_cpt_event_start_date';
		return $columns;
	}

	/**
	 * Custom ordering for Events by start date in admin
	 *
	 * @param \WP_Query $query The WP_Query instance
	 */
	public function order_events_by_start_date_in_admin($query)
	{
		if (!is_admin() || !$query->is_main_query()) {
			return;
		}

		// Order event posts by start date by default
		if ($query->get('post_type') === 'event' && !$query->get('orderby')) {
			$query->set('meta_key', 'li_cpt_event_start_date');
			$query->set('orderby', 'meta_value');
			$query->set('order', 'DESC'); // Upcoming first
			$query->set('meta_type', 'DATE');
		}

		// Handle manual sorting by start date
		if ($query->get('orderby') === 'li_cpt_event_start_date') {
			$query->set('meta_key', 'li_cpt_event_start_date');
			$query->set('orderby', 'meta_value');
		}
	}

	/**
	 * Helper method to display term links for a taxonomy
	 *
	 * @param int $post_id Post ID
	 * @param string $taxonomy Taxonomy name
	 */
	private function display_term_links($post_id, $taxonomy)
	{
		$terms = get_the_terms($post_id, $taxonomy);
		if (empty($terms) || is_wp_error($terms)) {
			return;
		}

		$post_type = get_post_type($post_id);
		$links = array_map(function ($term) use ($taxonomy, $post_type) {
			$url = admin_url("edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}");
			return sprintf('<a href="%s">%s</a>', esc_url($url), esc_html($term->name));
		}, $terms);

		echo implode(', ', $links);
	}

	/**
	 * Helper method to display formatted event datetime information
	 *
	 * @param int $post_id Post ID
	 */
	private function display_event_datetime($post_id)
	{
		$start_date = get_field('li_cpt_event_start_date', $post_id);
		$end_date = get_field('li_cpt_event_end_date', $post_id);
		$start_time = get_field('li_cpt_event_start_time', $post_id);
		$end_time = get_field('li_cpt_event_end_time', $post_id);
		$all_day = get_field('li_cpt_event_all_day', $post_id);
		$timezone = get_field('timezone', $post_id);

		// Format dates
		$start_date_fmt = $start_date ? date_i18n('F j, Y', strtotime($start_date)) : '';
		$end_date_fmt = $end_date ? date_i18n('F j, Y', strtotime($end_date)) : '';

		// Format times
		$start_time_fmt = $start_time ? date_i18n('g:i a', strtotime($start_time)) : '';
		$end_time_fmt = $end_time ? date_i18n('g:i a', strtotime($end_time)) : '';
		$tz_code = $timezone ? get_timezone_code($timezone) : '';

		// Display date range
		if ($start_date_fmt && $end_date_fmt) {
			echo esc_html("$start_date_fmt - $end_date_fmt") . '<br>';
		} elseif ($start_date_fmt) {
			echo esc_html($start_date_fmt) . '<br>';
		}

		// Display time information
		if ($all_day) {
			esc_html_e('All Day', 'land_institute');
		} elseif ($start_time_fmt && $end_time_fmt) {
			echo esc_html("$start_time_fmt - $end_time_fmt") . ' ' . esc_html($tz_code);
		} else {
			echo '—';
		}
	}
}

new WP_Theme_CPT_Columns();
