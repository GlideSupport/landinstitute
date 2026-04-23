<?php

/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * Please note that missing files will produce a fatal error.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

if (! defined('BASETHEME_BLOCK_DIR')) {
	define('BASETHEME_BLOCK_DIR', __DIR__ . '/blocks');
}

$bst_folder_includes = bst_includes(__DIR__ . '/includes/classes');
/**
 * Checks if any file have error while including it.
 */
foreach ($bst_folder_includes as $bst_folders) {
	foreach ($bst_folders as $bst_file) {
		$bst_filepath = locate_template(str_replace(__DIR__ . '/', '', $bst_file));
		if (file_exists($bst_filepath)) {
			require_once $bst_filepath;
		} else {
			echo 'Unable to load configuration file ' . esc_html(basename($bst_file)) . ' please check file name in functions.php in your current active theme.';
		}
	}
}
/**
 * Get folder Dir
 *
 * @param string $directory Folder dir path.
 */
function bst_includes($directory)
{
	$folders = array();

	// Get all files and folders in the specified directory.
	$items = scandir($directory);

	// Iterate through each item.
	foreach ($items as $item) {
		$full_path = $directory . '/' . $item;

		// Check if the item is a directory and not '.' or '..'.
		if (is_dir($full_path) && '.' !== $item && '..' != $item) {
			$folders[$item] = glob(__DIR__ . '/includes/classes/' . $item . '/*.php');
		}
	}
	$folders['other'] = array(
		__DIR__ . '/includes/project.php',
	);

	return $folders;
}

/**
 * Define default image constant for the theme
 * This checks if a custom default image is set in theme options,
 * otherwise uses the default image from theme directory
 */
if (!defined('BASETHEME_DEFAULT_IMAGE')) {
	// Get theme defaults including post ID, fields, and option fields
	list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

	// Check if custom default image is set in theme options
	if ($bst_option_fields['bst_var_theme_default_image']):
		// Use custom default image from theme options
		define('BASETHEME_DEFAULT_IMAGE', $bst_option_fields['bst_var_theme_default_image']);
	else:
		// Use fallback default image from theme directory
		define(
			'BASETHEME_DEFAULT_IMAGE',
			esc_url(get_template_directory_uri()) . '/assets/src/images/default-image.webp'
		);
	endif;
}



function date_formatting($start_date, $end_date)
{
	$final_date = '';
	if ($start_date == '') {
		return;
	}
	if ($end_date == '') {
		return;
	}
	$start_date = explode(' ', date('F j Y', strtotime($start_date)));
	$end_date   = explode(' ', date('F j Y', strtotime($end_date)));

	if ($start_date[2] == $end_date[2]) {
		if ($start_date[0] == $end_date[0]) {
			$final_date .= $start_date[0];
			if ($start_date[1] == $end_date[1]) {
				$final_date .= ' ' . $start_date[1];
			} else {
				$final_date .= ' ' . $start_date[1] . '-' . $end_date[1];
			}
			if ($start_date[2] == $end_date[2]) {
				$final_date .= ', ' . $start_date[2];
			}
		} else {
			if ($start_date[1] == $end_date[1]) {
				$final_date .= ' ' . $start_date[0] . '-' . $end_date[0] . ' ' . $start_date[1];
			} else {
				$final_date .= ' ' . $start_date[0] . ' ' . $start_date[1] . '-' . $end_date[0] . ' ' . $end_date[1];
			}
			if ($start_date[2] == $end_date[2]) {
				$final_date .= ', ' . $start_date[2];
			}
		}
	} else {
		$final_date .= implode(' ', $start_date) . ', ' . implode(' ', $end_date);
	}
	return $final_date;
}


function date_formatting_new($start_date, $end_date) {
    $start_ts = strtotime($start_date);
    $end_ts   = strtotime($end_date);

    // Check if same year
    $start_year = date('Y', $start_ts);
    $end_year   = date('Y', $end_ts);

    if ($start_year === $end_year) {
        // Same year: omit year from start date
        $start_fmt = date('M j', $start_ts);
    } else {
        // Different years: include year in start date
        $start_fmt = date('M j, Y', $start_ts);
    }

    // End date always includes year
    $end_fmt = date('M j, Y', $end_ts);

    return $start_fmt . ' - ' . $end_fmt;
}


function event_current_length($buffer, $item)
{
	$length = 1;
	foreach ($buffer as $value) {
		if ($value == $item) {
			$length++;
		}
	}
	return $length;
}

function event_length($arr, $item)
{
	$length = 0;
	foreach ($arr as $key => $value) {
		$time       = strtotime($value['end_date']);
		$final      = date('Y-m-d', strtotime('+1 day', $time));
		$period_raw = new DatePeriod(
			new DateTime($value['start_date']),
			new DateInterval('P1D'),
			new DateTime($final)
		);
		foreach ($period_raw as $k => $v) {
			$month         = date('F Y', strtotime($v->format('Y-m-d')));
			$current_month = date('F Y');
			if (strtotime($month) < strtotime($current_month)) {
				continue;
			}
			$current_date = date('Y-m-d');
			if (strtotime($v->format('Y-m-d')) < strtotime($current_date)) {
				continue;
			}
			if ($value['pID'] == $item) {
				$length++;
			}
		}
	}
	return $length;
}


function array_flatten($arr)
{
	$data = array();
	foreach ($arr as $value) {
		foreach ($value as $v) {
			$data[] = $v;
		}
	}
	return $data;
}
function sort_array($arr, $key)
{
	$item = [];

	foreach ($arr as $k => $row) {
		if ($key === 'length' && is_array($row) && isset($row['name'])) {
			$item[$k] = strlen($row['name']);
		} elseif (is_array($row) && isset($row[$key])) {
			$item[$k] = $row[$key];
		} else {
			$item[$k] = null;
		}
	}

	array_multisort($item, SORT_DESC, $arr);
	return $arr;
}
function date_list($month)
{
	$list       = array();
	$start_date = '01-' . $month;
	$start_time = strtotime($start_date);
	$end_time   = strtotime('+1 month', $start_time);
	for ($i = $start_time; $i < $end_time; $i += 86400) {
		$list[] = date('Y-m-d', $i);
	}
	return $list;
}
function month_sort($input)
{
	usort(
		$input,
		function ($a, $b) {
			$a = strtotime($a);
			$b = strtotime($b);
			return $a - $b;
		}
	);
	return $input;
}
function number_to_words($num)
{
	$first_word  = array('eth', 'first', 'second', 'third', 'fouth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'elevents', 'twelfth', 'thirteenth', 'fourteenth', 'fifteenth', 'sixteenth', 'seventeenth', 'eighteenth', 'nineteenth', 'twentieth');
	$second_word = array('', '', 'twenty', 'thirthy', 'forty', 'fifty');

	if ($num <= 20) {
		return $first_word[$num];
	}

	$first_num  = substr($num, -1, 1);
	$second_num = substr($num, -2, 1);

	return $string = str_replace('y-eth', 'ieth', $second_word[$second_num] . '-' . $first_word[$first_num]);
}


function custom_events_rewrite_rule() {
	   add_rewrite_rule('^events/page/([0-9]+)/?', 'index.php?pagename=events&paged=$matches[1]', 'top');
	   add_rewrite_rule('^news/page/([0-9]+)/?', 'index.php?pagename=news&paged=$matches[1]', 'top');

}

add_action('init', 'custom_events_rewrite_rule');

function get_timezone_code($timezone_value) {
    $timezones = [
        "Pacific/Midway" => "SST",
        "Pacific/Honolulu" => "HST",
        "America/Anchorage" => "AKST",
        "America/Los_Angeles" => "PST",
        "America/Denver" => "MST",
        "America/Chicago" => "CST",
        "America/New_York" => "EST",
        "America/Caracas" => "VET",
        "America/Halifax" => "AST",
        "America/St_Johns" => "NST",
        "America/Argentina/Buenos_Aires" => "ART",
        "Atlantic/South_Georgia" => "GST",
        "Atlantic/Azores" => "AZOT",
        "Europe/London" => "GMT",
        "Europe/Berlin" => "CET",
        "Europe/Helsinki" => "EET",
        "Europe/Moscow" => "MSK",
        "Asia/Tehran" => "IRST",
        "Asia/Dubai" => "GST",
        "Asia/Kabul" => "AFT",
        "Asia/Karachi" => "PKT",
        "Asia/Kolkata" => "IST",
        "Asia/Kathmandu" => "NPT",
        "Asia/Dhaka" => "BST",
        "Asia/Yangon" => "MMT",
        "Asia/Bangkok" => "ICT",
        "Asia/Shanghai" => "CST",
        "Asia/Tokyo" => "JST",
        "Australia/Adelaide" => "ACST",
        "Australia/Sydney" => "AEST",
        "Asia/Magadan" => "MAGT",
        "Pacific/Auckland" => "NZST",
        "Pacific/Tongatapu" => "TOT"
    ];

    return $timezones[$timezone_value] ?? "";
}



function get_formatted_event_datetime($post_id) {
    $start_date_raw      = get_field('li_cpt_event_start_date', $post_id);
    $end_date_raw        = get_field('li_cpt_event_end_date', $post_id);
    $event_start_time    = get_field('li_cpt_event_start_time', $post_id);
    $event_end_time      = get_field('li_cpt_event_end_time', $post_id);
    $timezone            = get_field('timezone', $post_id);
    $all_day             = get_field('li_cpt_event_all_day', $post_id); // checkbox

    if (empty($start_date_raw)) {
        return '';
    }

    // Normalize date formats (ACF date picker usually stores as Ymd)
    if (preg_match('/^\d{8}$/', $start_date_raw)) {
        $start_date_raw = DateTime::createFromFormat('Ymd', $start_date_raw)->format('Y-m-d');
    }
    if (!empty($end_date_raw) && preg_match('/^\d{8}$/', $end_date_raw)) {
        $end_date_raw = DateTime::createFromFormat('Ymd', $end_date_raw)->format('Y-m-d');
    }

    // If no end date, assume same as start
    if (empty($end_date_raw)) {
        $end_date_raw = $start_date_raw;
    }

    // Get timezone code (you must define this helper)
    $timezone_code = function_exists('get_timezone_code') ? get_timezone_code($timezone) : '';

    // Create DateTime objects
    $start_datetime = new DateTime($start_date_raw . (!empty($event_start_time) ? " $event_start_time" : ''));
    $end_datetime   = new DateTime($end_date_raw . (!empty($event_end_time) ? " $event_end_time" : ''));

    // Build display output
    if ($start_datetime->format('Y-m-d') === $end_datetime->format('Y-m-d')) {
        // Single-day event
        if (!empty($event_start_time) && !empty($event_end_time)) {
            // With times
            $event_display = $start_datetime->format('D, M j, Y g:i a') . " $timezone_code - " . $end_datetime->format('g:i a') . " $timezone_code";
        } elseif (!empty($event_start_time)) {
            // Only start time
            $event_display = $start_datetime->format('D, M j, Y g:i a') . " $timezone_code";
        } else {
            // Date only
            $event_display = $start_datetime->format('D, M j, Y');
        }
    } else {
        // Multi-day event
        if (!empty($event_start_time) && !empty($event_end_time)) {
            $event_display = $start_datetime->format('D, M j, Y g:i a') . " $timezone_code - " .
                             $end_datetime->format('D, M j, Y g:i a') . " $timezone_code";
        } else {
            $event_display = $start_datetime->format('D, M j, Y') . " - " .
                             $end_datetime->format('D, M j, Y');
        }
    }

    // Add all-day label
    if ($all_day) {
        $event_display .= ' - All day';
    }

    return $event_display;
}



add_action('save_post', 'save_event_timestamp_with_timezone', 20, 3);
function save_event_timestamp_with_timezone($post_id, $post, $update) {
    if (get_post_type($post_id) !== 'event') return;

    remove_action('save_post', 'save_event_timestamp_with_timezone', 20);

    $timezone       = get_field('timezone', $post_id) ?: 'UTC';

    // Start
    $start_date_raw = get_field('li_cpt_event_start_date', $post_id);
    $start_time_raw = get_field('li_cpt_event_start_time', $post_id);

    // End
    $end_date_raw = get_field('li_cpt_event_end_date', $post_id);
    $end_time_raw = get_field('li_cpt_event_end_time', $post_id);

    $start_timestamp = null;
    $end_timestamp   = null;
    $compare_timestamp = null;

    try {
        // --- Start timestamp ---
        if ($start_date_raw) {
            $start_date = (preg_match('/^\d{8}$/', $start_date_raw))
                ? DateTime::createFromFormat('Ymd', $start_date_raw)->format('Y-m-d')
                : $start_date_raw;

            $start_time = preg_replace('/\s+/', '', $start_time_raw ?: '00:00');
            $start_dt = new DateTime("$start_date $start_time", new DateTimeZone($timezone));
            $start_timestamp = $start_dt->getTimestamp();

            update_field('li_cpt_event_timestepm_with_selected_timezone', $start_timestamp, $post_id);
        }

        // --- End timestamp ---
        if ($end_date_raw) {
            $end_date = (preg_match('/^\d{8}$/', $end_date_raw))
                ? DateTime::createFromFormat('Ymd', $end_date_raw)->format('Y-m-d')
                : $end_date_raw;

            $end_time = preg_replace('/\s+/', '', $end_time_raw ?: '00:00');
            $end_dt = new DateTime("$end_date $end_time", new DateTimeZone($timezone));
            $end_timestamp = $end_dt->getTimestamp();

            update_field('li_cpt_event_end_timestepm_with_selected_timezone', $end_timestamp, $post_id);
        }

        // --- Compare timestamp ---
        if ($end_timestamp !== null) {
            $compare_timestamp = $end_timestamp;
        } elseif ($start_timestamp !== null) {
            $compare_timestamp = $start_timestamp;
        }

        if ($compare_timestamp !== null) {
            update_field('li_cpt_event_timestepm_with_selected_timezone_compare', $compare_timestamp, $post_id);
        }

    } catch (Exception $e) {
        // error_log("Timestamp save error for post $post_id: " . $e->getMessage());
    }

    add_action('save_post', 'save_event_timestamp_with_timezone', 20, 3);
}



// Custom orderby for staff last name to handle empty values
function custom_staff_last_name_orderby($orderby, $query) {
    global $wpdb;

    if ($query->get('meta_key') === 'staff_last_name' OR $query->get('staff_sorting')) {
        $orderby = "
            CASE 
                WHEN {$wpdb->postmeta}.meta_value = '' THEN 1
                ELSE 0
            END ASC,
            {$wpdb->postmeta}.meta_value ASC
        ";
    }

    return $orderby;
}
add_filter('posts_orderby', 'custom_staff_last_name_orderby', 10, 2);


//script 
//add_action('init', 'run_event_timestamp_update_once');
function run_event_timestamp_update_once() {
    if (!is_admin() || !current_user_can('manage_options')) return;

    if (get_option('event_timestamp_update_done')) return;

    $args = [
        'post_type'      => 'event',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ];

    $posts = get_posts($args);

    foreach ($posts as $post_id) {
        $timezone        = get_field('timezone', $post_id) ?: 'UTC';
        $all_day         = get_field('li_cpt_event_all_day', $post_id);

        $start_date_raw  = get_field('li_cpt_event_start_date', $post_id);
        $start_time_raw  = get_field('li_cpt_event_start_time', $post_id);

        $end_date_raw    = get_field('li_cpt_event_end_date', $post_id);
        $end_time_raw    = get_field('li_cpt_event_end_time', $post_id);

        $start_timestamp = null;
        $end_timestamp   = null;
        $compare_timestamp = null;

        try {
            // --- Start Timestamp ---
            if ($start_date_raw) {
                $start_date = preg_match('/^\d{8}$/', $start_date_raw)
                    ? DateTime::createFromFormat('Ymd', $start_date_raw)->format('Y-m-d')
                    : $start_date_raw;

                $start_time = preg_replace('/\s+/', '', $start_time_raw ?: '00:00');
                $start_dt = new DateTime("$start_date $start_time", new DateTimeZone($timezone));
                $start_timestamp = $start_dt->getTimestamp();

                update_field('li_cpt_event_timestepm_with_selected_timezone', $start_timestamp, $post_id);
            }

            // --- End Timestamp ---
            if ($end_date_raw) {
                $end_date = preg_match('/^\d{8}$/', $end_date_raw)
                    ? DateTime::createFromFormat('Ymd', $end_date_raw)->format('Y-m-d')
                    : $end_date_raw;

                $end_time = preg_replace('/\s+/', '', $end_time_raw ?: '00:00');
                $end_dt = new DateTime("$end_date $end_time", new DateTimeZone($timezone));
                $end_timestamp = $end_dt->getTimestamp();

                update_field('li_cpt_event_end_timestepm_with_selected_timezone', $end_timestamp, $post_id);
            }

            // --- Compare Timestamp ---
            if ($all_day) {
                $compare_date_raw = $end_date_raw ?: $start_date_raw;

                if ($compare_date_raw) {
                    $compare_date = preg_match('/^\d{8}$/', $compare_date_raw)
                        ? DateTime::createFromFormat('Ymd', $compare_date_raw)->format('Y-m-d')
                        : $compare_date_raw;

                    $compare_dt = new DateTime("$compare_date 00:00", new DateTimeZone($timezone));
                    $compare_timestamp = $compare_dt->getTimestamp();
                }
            } else {
                $compare_timestamp = $end_timestamp ?? $start_timestamp;
            }

            if ($compare_timestamp !== null) {
                update_field('li_cpt_event_timestepm_with_selected_timezone_compare', $compare_timestamp, $post_id);
            }

        } catch (Exception $e) {
            // error_log("Error for post $post_id: " . $e->getMessage());
        }
    }

    update_option('event_timestamp_update_done', true);
    set_transient('event_timestamp_update_success_notice', true, 30);
}

add_action('admin_notices', 'show_event_timestamp_update_notice');
function show_event_timestamp_update_notice() {
    if (!current_user_can('manage_options')) return;

    if (get_transient('event_timestamp_update_success_notice')) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Event timestamps updated successfully (with all-day fallback logic).</strong></p></div>';
        delete_transient('event_timestamp_update_success_notice');
    }
}

function exclude_dynamic_learn_tax_terms_from_frontend($query) {
    // Only skip for admin dashboard
    if (is_admin()) {
        return;
    }

    // ACF option field mapping by taxonomy
    $taxonomy_acf_map = array(
        'learn-crop'        => 'li_learn_crop_category',
        'learn-type'        => 'li_learn_type_category',
        'learn-topic'       => 'li_learn_topics_category',
        'learn-audience'    => 'li_learn_audience_category',
        'news-crop'         => 'li_news_crop_category',
        'news-type'         => 'li_news_type_category',
        'news-topic'        => 'li_news_topics_category',
        'news-audience'     => 'li_news_audience_category',
        'event-crop'        => 'li_events_crop_category',
        'event-tags'        => 'li_events_topics_category',
        'event-categories'  => 'li_event_category',
        'event-audience'    => 'li_event_audience_category',
    );

    $tax_query = [];

    foreach ($taxonomy_acf_map as $taxonomy => $acf_field) {
        $term_ids = get_field($acf_field, 'option');

        if (!empty($term_ids) && is_array($term_ids)) {
            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'include'    => $term_ids,
                'hide_empty' => false,
            ]);

            if (!empty($terms) && !is_wp_error($terms)) {
                $term_slugs = wp_list_pluck($terms, 'slug');

                $tax_query[] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term_slugs,
                    'operator' => 'NOT IN',
                ];
            }
        }
    }

    if (!empty($tax_query)) {
        $existing_tax_query = $query->get('tax_query');
        if (!empty($existing_tax_query)) {
            $query->set('tax_query', array_merge($existing_tax_query, $tax_query));
        } else {
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'exclude_dynamic_learn_tax_terms_from_frontend');


function get_excluded_term_slugs_by_taxonomy($taxonomy) {
    // Map of taxonomy => ACF field
    $taxonomy_acf_map = array(
        'learn-crop'        => 'li_learn_crop_category',
        'learn-type'        => 'li_learn_type_category',
        'learn-topic'       => 'li_learn_topics_category',
        'learn-audience'    => 'li_learn_audience_category',
        'news-crop'         => 'li_news_crop_category',
        'news-type'         => 'li_news_type_category',
        'news-topic'        => 'li_news_topics_category',
        'news-audience'     => 'li_news_audience_category',
        'event-crop'        => 'li_events_crop_category',
        'event-tags'        => 'li_events_topics_category',
        'event-categories'  => 'li_event_category',
        'event-audience'    => 'li_event_audience_category',
    );

    if (!isset($taxonomy_acf_map[$taxonomy])) {
        return []; // Invalid taxonomy
    }

    $acf_field = $taxonomy_acf_map[$taxonomy];
    $term_ids = get_field($acf_field, 'option');

    if (empty($term_ids) || !is_array($term_ids)) {
        return [];
    }

    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'include'    => $term_ids,
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }

    return wp_list_pluck($terms, 'slug');
}

function get_exclude_tax_query_for_taxonomy($taxonomy) {
    $slugs = get_excluded_term_slugs_by_taxonomy($taxonomy);

    if (empty($slugs)) {
        return [];
    }

    return [
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $slugs,
        'operator' => 'NOT IN',
    ];
}


/**
 * Generate a tax_query clause to exclude all posts associated with a given taxonomy.
 *
 * @param string $taxonomy_slug Taxonomy to exclude posts from.
 * @return array Tax query clause for WP_Query.
 */
function get_taxonomy_exclusion_query($taxonomy_slug) {
    if (!taxonomy_exists($taxonomy_slug)) {
        return []; // Invalid taxonomy
    }

    $terms = get_terms([
        'taxonomy'   => $taxonomy_slug,
        'hide_empty' => false,
        'fields'     => 'slugs',
    ]);

    if (empty($terms) || is_wp_error($terms)) {
        return []; // No terms to exclude
    }

    return [[
        'taxonomy' => $taxonomy_slug,
        'field'    => 'slug',
        'terms'    => $terms,
        'operator' => 'NOT IN',
    ]];
}

function limit_search_to_specific_post_types($query) {
    if ($query->is_main_query() && $query->is_search() && !is_admin()) {

        // Allowed post types
        $allowed_post_types = ['staff', 'event', 'news', 'post', 'page'];

        $excluded_post_types = get_field('li_search_exclude_post_type', 'option')??[];
       
        $final_post_types = array_diff($allowed_post_types, $excluded_post_types);

        $posttype   = isset($_GET['search-type']) ? sanitize_text_field($_GET['search-type']) : '';
        $order_by   = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';
        $learn_type = isset($_GET['learntype']) ? sanitize_text_field($_GET['learntype']) : '';

        if ($posttype !== "" OR $posttype !== 'all') {
            $query->set('post_type', $allowed_post_types);
        }else{
            $query->set('post_type', $final_post_types);
        }

        // Apply staff-specific sorting
        if ($posttype === 'staff' && $order_by === 'title') {

        
            $query->set('meta_query', [
                [
                    'relation' => 'OR',
            
                    // First priority: posts WITH last name
                    'has_last_name' => [
                        'key'     => 'staff_last_name',
                        'compare' => 'EXISTS',
                    ],

                    // Second: posts WITHOUT last name
                    'no_last_name' => [
                        'relation' => 'OR',

                        [
                            'key'     => 'staff_last_name',
                            'compare' => 'NOT EXISTS',
                        ],
                        [
                            'key'     => 'staff_last_name',
                            'value'   => '',
                            'compare' => '=',
                        ],
                    ],
                ]
            ]);

            $query->set('orderby', [
                'has_last_name' => 'ASC',   
                'meta_value'    => 'ASC', 
            ]);      

            $query->set('meta_key', 'staff_last_name');
            $query->set('meta_type', 'CHAR');

            // IMPORTANT: flag to use in orderby filter
            $query->set('staff_sorting', true);

        } else {
            $query->set('orderby', $order_by ? $order_by : 'date');
            $query->set('order', ($order_by === 'title') ? 'ASC' : 'DESC');
        }

        if($learn_type !== 'all' AND  $learn_type !== ''){
            // Taxonomy filters
            $tax_query = [];
            $taxonomies = get_taxonomies(['public' => true], 'names');

            foreach ($taxonomies as $taxonomy) {
                if (!empty($_GET[$taxonomy])) {
                    $tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($_GET[$taxonomy]),
                    ];
                }
            }

            if (!empty($tax_query)) {
                $query->set('tax_query', $tax_query);
            }
        }else{
            $query->set('tax_query', []);
        }

    }
}
// add_action('pre_get_posts', 'limit_search_to_specific_post_types');


add_action('template_redirect', 'll_fix_duplicate_pagination_url');
function ll_fix_duplicate_pagination_url() {
    $request_uri = $_SERVER['REQUEST_URI'];

    // Count how many times "/page/" appears
    $page_count = substr_count($request_uri, '/page/');

    if ($page_count > 1) {
        // Show 404 page
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include(get_query_template('404'));
        exit;
    } else {
        // Ensure trailing slash after page number
        if (preg_match('#/page/\d+$#', $request_uri)) {
            // Redirect to correct URL with slash
            $corrected_url = $request_uri . '/';
            wp_redirect($corrected_url, 301);
            exit;
        }
    }
}

// Helper to get post type label
function get_post_type_label($post_type_slug) {
    $post_type_obj = get_post_type_object($post_type_slug);
    return $post_type_obj ? $post_type_obj->labels->name : ucfirst($post_type_slug);
}


add_filter( 'posts_clauses', function( $clauses, $query ) {
    global $wpdb;

    if (
        isset( $query->query['post_type'] )
        && $query->query['post_type'] === 'staff'
        && isset( $query->query['orderby'] )
        && $query->query['orderby'] === 'custom_staff_order'
    ) {
        // Join with staff_last_name meta
        $clauses['join'] .= " 
            LEFT JOIN $wpdb->postmeta AS staff_last_name
            ON ($wpdb->posts.ID = staff_last_name.post_id 
                AND staff_last_name.meta_key = 'staff_last_name')";

        $clauses['orderby'] = "
            CASE 
                WHEN staff_last_name.meta_value IS NULL 
                     OR staff_last_name.meta_value = '' 
                THEN 1 ELSE 0 
            END ASC,
            staff_last_name.meta_value ASC,
            $wpdb->posts.post_date DESC
        ";
    }

    return $clauses;
}, 10, 2 );