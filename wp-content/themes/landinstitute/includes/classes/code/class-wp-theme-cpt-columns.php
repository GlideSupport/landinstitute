<?php

/**
 * Custom related functions
 *
 * @link
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

namespace BaseTheme\CPT_Columns;

/**
 * Template Class For Custom
 *
 * Template Class
 *
 * @category Setting_Class
 * @package  Base Theme Package
 */
class WP_Theme_CPT_Columns extends \Boilerplate
{
	/**
	 * Define class Constructor
	 **/
	public function __construct()
	{

		// Add custom column to Staff CPT admin list
		add_filter('manage_staff_posts_columns', array($this, 'add_staff_category_column'));
		// Populate custom column with category name
		add_action('manage_staff_posts_custom_column', array($this, 'show_staff_category_column_content'), 10, 2);
		// Make the column sortable (optional)
		add_filter('manage_edit-staff_sortable_columns', array($this, 'make_staff_category_column_sortable'));
	}

	public function add_staff_category_column($columns)
	{
		unset($columns['date']);
		$columns['staff_category'] = __('Staff Category', 'land_institute');
		$columns['date'] = __('Date', 'land_institute');
		return $columns;
	}

	public function show_staff_category_column_content($column, $post_id)
	{
		if ($column === 'staff_category') {
			$terms = get_the_terms($post_id, 'staff-category');
			if (!empty($terms) && !is_wp_error($terms)) {
            $links = [];
            foreach ($terms as $term) {
                $url = admin_url('edit.php?post_type=staff&staff-category=' . $term->slug);
                $links[] = '<a href="' . esc_url($url) . '">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $links);
        }
		}
	}

	public function make_staff_category_column_sortable($columns)
	{
		$columns['staff_category'] = 'staff_category';
		return $columns;
	}
}
new WP_Theme_CPT_Columns();