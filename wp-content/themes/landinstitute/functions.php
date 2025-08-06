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

add_action('wp_ajax_filter_logo_grid_filter', 'ajax_filter_logo_grid_filter');
add_action('wp_ajax_nopriv_filter_logo_grid_filter', 'ajax_filter_logo_grid_filter');

function ajax_filter_logo_grid_filter()
{
	check_ajax_referer('ajax_nonce', 'nonce');

	$donor_type      = $_POST['donor_type'] ?? 'all';
	$donation_level  = $_POST['donation_level'] ?? 'all';
	$paged           = max(1, (int) ($_POST['paged'] ?? 1));

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

	$donors = new WP_Query($args);

	ob_start();

	if ($donors->have_posts()) :
		while ($donors->have_posts()) : $donors->the_post();
			$image_id = get_post_thumbnail_id(get_the_ID());
			$title    = get_the_title();
			$title_words = explode(' ', trim($title));
			$first_initial = !empty($title_words[0]) ? strtoupper($title_words[0][0]) : '';
			$last_initial  = !empty($title_words[1]) ? strtoupper($title_words[1][0]) : '';
			$initials = $first_initial . $last_initial;

			$image_html = $image_id ? wp_get_attachment_image($image_id, 'full', false, [
				'width'  => 200,
				'height' => 102,
				'alt'    => esc_attr($title),
			]) : '';

			$levels = get_the_terms(get_the_ID(), 'donation-level');
			$level_name = (!empty($levels) && !is_wp_error($levels)) ? $levels[0]->name : '';
?>
			<div class="filter-logos-col">
				<div class="filter-logos-click">
					<?php if ($image_html) : ?>
						<div class="brand-logo brand-lists"><?php echo $image_html; ?></div>
					<?php else : ?>
						<div class="brand-name brand-lists">
							<div class="brand-group-name"><?php echo esc_html($initials); ?></div>
						</div>
					<?php endif; ?>
					<div class="logo-content">
						<div class="gl-s24"></div>
						<div class="ui-20-18-bold logo-title"><?php echo esc_html($title); ?></div>
						<div class="gl-s2"></div>
						<?php if ($level_name) : ?>
							<div class="body-18-16-regular logo-content"><?php echo esc_html($level_name); ?></div>
						<?php endif; ?>
						<div class="gl-s24"></div>
					</div>
				</div>
			</div>
		<?php
		endwhile;
		wp_reset_postdata();
	else :
		echo '<div class="no-results">No donors found for this filter.</div>';
	endif;
	$html = ob_get_clean();
	// --- Pagination ---
$pagination_html = '';
$total_pages = $donors->max_num_pages;
$total_found_posts = $donors->found_posts;

if ($total_found_posts > $posts_per_page) {
	ob_start();

	// Capture current query vars
	$current_url = get_permalink();
	$donor_type = isset($_GET['donor_type']) ? sanitize_text_field($_GET['donor_type']) : '';
	$donation_level = isset($_GET['donation_level']) ? sanitize_text_field($_GET['donation_level']) : '';

	// Build query array for reuse
	$query_args = [];
	if ($donor_type) {
		$query_args['donor_type'] = $donor_type;
	}
	if ($donation_level) {
		$query_args['donation_level'] = $donation_level;
	}
	?>
	<div class="fillter-bottom">
		<div class="pagination-container">
			<div class="desktop-pages">
				<div class="arrow-btn prev">
					<a class="site-btn" href="<?php
						if ($paged > 1) {
							$prev_url = trailingslashit($current_url) . 'page/' . ($paged - 1) . '/';
							if (!empty($query_args)) {
								$prev_url .= '?' . http_build_query($query_args);
							}
							echo esc_url($prev_url);
						} else {
							echo '#';
						}
					?>" <?php if ($paged <= 1) echo 'style="opacity: 0.5; pointer-events: none;"'; ?>>Previous</a>
				</div>

				<div class="pagination-list">
					<?php
					$range = 2;
					$show_dots = false;

					for ($i = 1; $i <= $total_pages; $i++) {
						if ($i == 1 || $i == $total_pages || ($i >= $paged - $range && $i <= $paged + $range)) {
							if ($show_dots) {
								echo '<span class="dots">...</span>';
								$show_dots = false;
							}
							$page_url = trailingslashit($current_url) . 'page/' . $i . '/';
							if (!empty($query_args)) {
								$page_url .= '?' . http_build_query($query_args);
							}
							echo '<a class="page-btn' . ($i == $paged ? ' active' : '') . '" href="' . esc_url($page_url) . '" data-page="' . esc_attr($i) . '">' . esc_html($i) . '</a>';
						} else {
							$show_dots = true;
						}
					}
					?>
				</div>

				<div class="arrow-btn next">
					<a class="site-btn" href="<?php
						if ($paged < $total_pages) {
							$next_url = trailingslashit($current_url) . 'page/' . ($paged + 1) . '/';
							if (!empty($query_args)) {
								$next_url .= '?' . http_build_query($query_args);
							}
							echo esc_url($next_url);
						} else {
							echo '#';
						}
					?>" <?php if ($paged >= $total_pages) echo 'style="opacity: 0.5; pointer-events: none;"'; ?>>Next</a>
				</div>
			</div>

			<div class="mobile-pagination">
				<a id="prevBtn" class="arrow-btn" href="<?php
					if ($paged > 1) {
						$mobile_prev = trailingslashit($current_url) . 'page/' . ($paged - 1) . '/';
						if (!empty($query_args)) {
							$mobile_prev .= '?' . http_build_query($query_args);
						}
						echo esc_url($mobile_prev);
					} else {
						echo '#';
					}
				?>" <?php if ($paged <= 1) echo 'disabled'; ?>>
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Prev">
				</a>

				<span id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html($paged . '/' . $total_pages); ?></span>

				<a id="nextBtn" class="arrow-btn" href="<?php
					if ($paged < $total_pages) {
						$mobile_next = trailingslashit($current_url) . 'page/' . ($paged + 1) . '/';
						if (!empty($query_args)) {
							$mobile_next .= '?' . http_build_query($query_args);
						}
						echo esc_url($mobile_next);
					} else {
						echo '#';
					}
				?>" <?php if ($paged >= $total_pages) echo 'disabled'; ?>>
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
				</a>
			</div>

			<div id="paginationPopup" class="pagination-popup">
				<div class="popup-body">
					<div id="popupGrid" class="popup-grid">
						<?php for ($i = 1; $i <= $total_pages; $i++) :
							$page_url = trailingslashit($current_url) . 'page/' . $i . '/';
							if (!empty($query_args)) {
								$page_url .= '?' . http_build_query($query_args);
							}
						?>
							<a class="page-btn<?php echo ($i == $paged ? ' active' : ''); ?>" href="<?php echo esc_url($page_url); ?>" data-page="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></a>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
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



//news list filter


//event code



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

add_action('wp_ajax_load_more_events', 'load_more_events_callback');
add_action('wp_ajax_nopriv_load_more_events', 'load_more_events_callback');

function load_more_events_callback()
{
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

	$event_query = new WP_Query($eventargs);

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



// Past event filter
add_action('wp_ajax_filter_past_events', 'filter_past_events');
add_action('wp_ajax_nopriv_filter_past_events', 'filter_past_events');

function filter_past_events() {
	check_ajax_referer('ajax_nonce', 'nonce');
   
	$term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
   $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
   $today = date('Ymd'); // e.g., 20250704
   $current_timestamp = current_time('timestamp'); // WordPress-safe current UTC timestamp

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
   
   
	$query = new WP_Query($args);
   
	if ($query->have_posts()) {
	 ob_start();
	 
	 while ($query->have_posts()) {
	  $query->the_post();
	  $post_id = get_the_ID();
	  $event_title = get_the_title($post_id);
	  $event_link = get_permalink($post_id);  
	  $excerpt = get_the_excerpt( $post_id);
	  $event_content = wp_trim_words($excerpt, 25, '...');
	  $event_date = get_formatted_event_datetime($post_id);
   
	  ?>
		 <div class="filter-content-card-item">
						   <a href="<?php echo esc_url($event_link); ?>" class="filter-content-card-link">
							   <div class="filter-card-content">
							   <div class="gl-s52"></div>
							   <div class="eyebrow ui-eyebrow-16-15-regular"><?php echo $event_date; ?>
							   </div>
							   <div class="gl-s6"></div>
							   <div class="card-title heading-6 mb-0"><?php echo html_entity_decode($event_title); ?></div>
							   <div class="gl-s16"></div>
							   <div class="description ui-18-16-regular"><?php echo $event_content; ?></div>
							   <div class="gl-s20"></div>
							   <div class="read-more-link">
								   <div class="border-text-btn">Event Details</div>
							   </div>
							   <div class="gl-s80"></div>
						   </div>
						   </a>
					   </div>
	  <?php
	 }
		   
	 wp_reset_postdata();
		   $html        = ob_get_clean();
		   $total_pages = $query->max_num_pages;
   
		   $pagination_html = '';
		   if ($total_pages > 1) {
			   $pagination_html .= '<div class="pagination-container pagination-append-container">';
			   $pagination_html .= '<div class="pagination-container">';
		   
			   // Desktop Pagination
			   $pagination_html .= '<div class="desktop-pages">';
		   
			   // Previous Button (Desktop)
			   $prev_page = $paged - 1;
			   $prev_disabled = $paged <= 1;
			   $prev_url = $prev_disabled 
				   ? 'javascript:void(0);' 
				   : ($prev_page === 1 ? trailingslashit(home_url('/events/')) : trailingslashit(home_url('/events/')) . 'page/' . $prev_page . '/');
			   $pagination_html .= '<a id="desktopPrev" class="arrow-btn prev page-btn ' . ($prev_disabled ? 'disabled' : '') . '" href="' . esc_url($prev_url) . '" data-page="' . esc_attr($prev_page) . '" rel="'.($prev_disabled ? '' : 'prev').'"><div class="site-btn">Previous</div></a>';
		   
			   // Pagination Numbers
			   $pagination_html .= '<div id="paginationList" class="pagination-list">';
			   $range = 2;
			   $show_dots = false;
			   for ($i = 1; $i <= $total_pages; $i++) {
				   if ($i === 1 || $i === $total_pages || ($i >= $paged - $range && $i <= $paged + $range)) {
					   $active_class = $i === $paged ? 'active' : '';
					   $page_url = $i === 1 
						   ? trailingslashit(home_url('/events/')) 
						   : trailingslashit(home_url('/events/')) . 'page/' . $i . '/';
			   
					   // Determine rel attribute
					   $rel = '';
					   if ($i === $paged + 1) {
						   $rel = 'next';
					   } elseif ($i === $paged - 1) {
						   $rel = 'prev';
					   }
			   
					   $pagination_html .= '<a class="page-btn ' . $active_class . '" href="' . esc_url($page_url) . '" data-page="' . $i . '"' . ($rel ? ' rel="' . $rel . '"' : '') . '>' . $i . '</a>';
					   $show_dots = true;
				   } elseif ($show_dots) {
					   $pagination_html .= '<span class="dots">...</span>';
					   $show_dots = false;
				   }
			   }
			   
			   $pagination_html .= '</div>'; // end pagination list
		   
			   // Next Button (Desktop)
			   $next_page = $paged + 1;
			   $next_disabled = $paged >= $total_pages;
			   $next_url = $next_disabled 
				   ? 'javascript:void(0);' 
				   : trailingslashit(home_url('/events/')) . 'page/' . $next_page . '/';
			   $pagination_html .= '<a id="desktopNext" class="arrow-btn next page-btn ' . ($next_disabled ? 'disabled' : '') . '" href="' . esc_url($next_url) . '" data-page="' . esc_attr($next_page) . '" rel="'.($next_disabled ? '' : 'next').'"><div class="site-btn">Next</div></a>';
		   
			   $pagination_html .= '</div>'; // end desktop-pages
		   
			   // Mobile Pagination
			   $pagination_html .= '<div class="mobile-pagination">';
		   
			   // Prev Mobile
			   $rel_attr = !$prev_disabled ? ' rel="prev"' : '';
   
			   $pagination_html .= '<a id="prevBtn" class="arrow-btn page-btn ' . ($prev_disabled ? 'disabled' : '') . '" href="' . esc_url($prev_url) . '" data-page="' . esc_attr($prev_page) . '"' . $rel_attr . '>
				   <img src="' . get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg" alt="Previous">
			   </a>';
		   
			   // Page Trigger Button
			   $pagination_html .= '<button id="pageTrigger" class="page-trigger ui-18-16-bold page-btn">' . $paged . '/' . $total_pages . '</button>';
		   
			   // Next Mobile
			   $rel_attr = !$next_disabled ? ' rel="next"' : '';
			   $pagination_html .= '<a id="nextBtn" class="arrow-btn page-btn ' . ($next_disabled ? 'disabled' : '') . '" href="' . esc_url($next_url) . '" data-page="' . esc_attr($next_page) . '"' . $rel_attr . '>
				   <img src="' . get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg" alt="Next">
			   </a>';
   
		   
			   $pagination_html .= '</div>'; // end mobile-pagination
		   
			   // Mobile Popup Pagination
			   $pagination_html .= '<div id="paginationPopup" class="pagination-popup">';
			   $pagination_html .= '<div class="popup-body">';
			   $pagination_html .= '<div id="popupGrid" class="popup-grid">';
		   
			   for ($i = 1; $i <= $total_pages; $i++) {
				   $active = $i === $paged ? 'active' : '';
				   $page_url = $i === 1 
					   ? trailingslashit(home_url('/events/')) 
					   : trailingslashit(home_url('/events/')) . 'page/' . $i . '/';
			   
				   // Determine rel attribute
				   $rel = '';
				   if ($i === $paged - 1) {
					   $rel = 'prev';
				   } elseif ($i === $paged + 1) {
					   $rel = 'next';
				   }
			   
				   // Append rel only if needed
				   $rel_attr = $rel ? ' rel="' . esc_attr($rel) . '"' : '';
			   
				   $pagination_html .= '<a class="page-trigger ui-18-16-bold page-btn ' . esc_attr($active) . '" href="' . esc_url($page_url) . '" data-page="' . esc_attr($i) . '"' . $rel_attr . '>' . esc_html($i) . '</a>';
			   }
			   
		   
			   $pagination_html .= '</div>'; // popupGrid
		   
			   // Optional JS-based popup nav buttons
			   $pagination_html .= '<button id="popupPrev" class="arrow-btn"></button>';
			   $pagination_html .= '<button id="popupNext" class="arrow-btn"></button>';
		   
			   $pagination_html .= '</div>'; // popup-body
			   $pagination_html .= '</div>'; // paginationPopup
		   
			   $pagination_html .= '</div>'; // pagination-container
			   $pagination_html .= '</div>'; // pagination-append-container
		   }
		   
		   
		   
		   // Send both HTML and pagination
		   wp_send_json_success([
			   'html'            => $html,
			   'pagination_html' => $pagination_html,
			   'total_pages'     => $total_pages,
		   ]);
		   
	 echo ob_get_clean();
	} else {
	 echo '<p>No past events found.</p>';
	}
   
	wp_die();
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

	if ($start_date_raw == '') {
		return '';
	}

	// Normalize date formats
	if (preg_match('/^\d{8}$/', $start_date_raw)) {
		$start_date_raw = DateTime::createFromFormat('Ymd', $start_date_raw)->format('Y-m-d');
	}
	if (preg_match('/^\d{8}$/', $end_date_raw)) {
		$end_date_raw = DateTime::createFromFormat('Ymd', $end_date_raw)->format('Y-m-d');
	}

	// Default times if not set
	if (empty($event_start_time)) {
		$event_start_time = '00:00';
	}
	if (empty($event_end_time)) {
		$event_end_time = '23:59';

	}
    // Get timezone code (you must define this helper)
    $timezone_code = function_exists('get_timezone_code') ? get_timezone_code($timezone) : '';

    // Create DateTime objects
    $start_datetime = new DateTime("$start_date_raw $event_start_time");
    $end_datetime   = new DateTime("$end_date_raw $event_end_time");

    // Set timezone if available
    // if (!empty($timezone)) {
    //     try {
    //         $tz = new DateTimeZone($timezone);
    //         $start_datetime->setTimezone($tz);
    //         $end_datetime->setTimezone($tz);
    //     } catch (Exception $e) {
    //         // Fallback: no action
    //     }
    // }

    // Build display output
    if ($start_datetime->format('Y-m-d') === $end_datetime->format('Y-m-d')) {
        // Single-day event
        $event_display = $start_datetime->format('l, F j, Y g:i a') . " $timezone_code - " .
                         $end_datetime->format('g:i a') . " $timezone_code";
    } else {
        // Multi-day event
        $event_display = $start_datetime->format('l, F j, Y g:i a') . " $timezone_code - " .
                         $end_datetime->format('l, F j, Y g:i a') . " $timezone_code";
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




add_action('wp_ajax_filter_news', 'handle_ajax_news_filter');
add_action('wp_ajax_nopriv_filter_news', 'handle_ajax_news_filter');
function handle_ajax_news_filter() {
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
        'post_status'    => 'publish',
        'paged'          => $paged,
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    set_query_var('requestdbyajax', 'yes');

    $news = new WP_Query($args);
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



add_action('wp_ajax_filter_learn', 'handle_ajax_news_learn');
add_action('wp_ajax_nopriv_filter_learn', 'handle_ajax_news_learn');

function handle_ajax_news_learn() {
    // Optional: enable this if you're using nonce security
    // check_ajax_referer('news_ajax_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $tax_query = [];
    $exclude_taxonomies = [];

    $filter_setting = get_field('li_learn_filters', 131);

    $enable_type     = $filter_setting['enable_learn_type'];
    $enable_crop     = $filter_setting['enable_learn_crop'];
    $enable_audience = $filter_setting['enable_learn_audience'];
    $enable_topic    = $filter_setting['enable_learn_topic'];


      $exclude_taxonomies[] = 'learn-type';

        if (!empty($_POST['post_type']) && $_POST['post_type'] !== 'all') {
            $tax_query[] = [
                'taxonomy' => 'learn-type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['post_type']),
            ];
        }


    // Learn Topic
  $exclude_taxonomies[] = 'learn-topic';

        if (!empty($_POST['learn_topic']) && $_POST['learn_topic'] !== 'all') {
            $tax_query[] = [
                'taxonomy' => 'learn-topic',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['learn_topic']),
            ];
        }

    // Learn Crop
        $exclude_taxonomies[] = 'learn-crop';

        if (!empty($_POST['learn_crops']) && $_POST['learn_crops'] !== 'all') {
            $tax_query[] = [
                'taxonomy' => 'learn-crop',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['learn_crops']),
            ];
        }

    // Learn Audience
    $exclude_taxonomies[] = 'learn-audience';

        if (!empty($_POST['learn_audience']) && $_POST['learn_audience'] !== 'all') {
            $tax_query[] = [
                'taxonomy' => 'learn-audience',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['learn_audience']),
            ];
        }

	

    // Learn Type
    $exclude_taxonomies[] = 'learn-type';

        if (!empty($_POST['post_type']) && $_POST['post_type'] !== 'all') {
            $tax_query[] = [
                'taxonomy' => 'learn-type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['post_type']),
            ];
        }

    // Hardcoded exclusions
   // $exclude_taxonomies = ['learn-crop', 'learn-topic'];

   if(!empty($exclude_taxonomies)){
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
        'post_status'    => 'publish',
        'paged'          => $paged,
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

	//print_r($args);

    $query = new WP_Query($args);

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

    $datafound = $query->have_posts() ? 'yes' : 'no';

    wp_send_json_success([
        'news_html'       => $news_html,
        'pagination_html' => $pagination_html,
        'datafound'       => $datafound,
    ]);
}

add_action('wp_ajax_search_filter', 'search_filter_Callback');
add_action('wp_ajax_nopriv_search_filter', 'search_filter_Callback');

function search_filter_Callback() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    $order_by = isset($_POST['orderby']) && in_array($_POST['orderby'], ['date', 'title']) ? $_POST['orderby'] : 'date';
    $search_type = isset($_POST['type']) ? $_POST['type'] : '';

    // Full list of allowed post types
    $allowed_post_types = ['post', 'event', 'page', 'news', 'staff'];

    // Get excluded post types from ACF Options
    $excluded_post_types = get_field('li_search_exclude_post_type', 'option');
    if (!is_array($excluded_post_types)) {
        $excluded_post_types = [];
    }

    // Remove excluded from allowed
    $filtered_post_types = array_diff($allowed_post_types, $excluded_post_types);

    // If user selected a specific post type, validate it
    if (!empty($search_type) && $search_type !== 'all') {
        if (in_array($search_type, $filtered_post_types)) {
            $post_types = [$search_type];
        } else {
            // fallback to filtered list if user input is invalid
            $post_types = $filtered_post_types;
        }
    } else {
        $post_types = $filtered_post_types;
    }

    $args = [
        'post_type'      => $post_types,
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'paged'          => $paged,
        'orderby'        => $order_by,
        'order'          => ($order_by === 'title') ? 'ASC' : 'DESC',
    ];

    if (!empty($search_query)) {
        $args['s'] = $search_query;
    }

    $query = new WP_Query($args);

    set_query_var('search_query', $query);
    set_query_var('paged_var', $paged);

    ob_start();
    get_template_part('partials/content', 'search-list');
    $results_html = ob_get_clean();

    ob_start();
    get_template_part('partials/content', 'search-pagination');
    $pagination_html = ob_get_clean();

    wp_reset_postdata();

    wp_send_json_success([
        'news_html'       => $results_html,
        'pagination_html' => $pagination_html,
    ]);
}




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
        $allowed_post_types = ['staff', 'event', 'post', 'news', 'page'];

        // ACF field to exclude post types (array expected)
        $excluded_post_types = get_field('li_search_exclude_post_type', 'option');
        if (!is_array($excluded_post_types)) {
            $excluded_post_types = [];
        }

        // Final allowed list after exclusion
        $final_post_types = array_diff($allowed_post_types, $excluded_post_types);

        // Sanitize user input
        $posttype = isset($_GET['search-type']) ? sanitize_text_field($_GET['search-type']) : '';

        if ($posttype) {
            if (in_array($posttype, $final_post_types)) {
                $query->set('post_type', [$posttype]);
            } else {
                $query->set('post_type', $final_post_types); // fallback
            }
        } else {
            $query->set('post_type', $final_post_types); // default
        }
    }
}
add_action('pre_get_posts', 'limit_search_to_specific_post_types');


add_action( 'template_redirect', 'dpf_fix_duplicate_pagination_url' );
function dpf_fix_duplicate_pagination_url() {
    // Don't run in admin or during AJAX requests
    if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        return;
    }

    // Get raw request URI safely
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';

    // Only care about path + query; ignore host
    $path  = wp_parse_url( $request_uri, PHP_URL_PATH ) ?? '';
    $query = wp_parse_url( $request_uri, PHP_URL_QUERY );

    // Normalize path: remove duplicate slashes
    $path = preg_replace( '#(?<!:)//+#', '/', $path );

    // 1) If there are multiple /page/<num> segments -> treat as invalid (404)
    $page_segments = [];
    if ( preg_match_all( '#/page/(\d+)/?#i', $path, $matches ) ) {
        $page_segments = $matches[1]; // array of captured numbers
    }

    if ( count( $page_segments ) > 1 ) {
        // Show 404 and exit (same behavior you had)
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
        // load 404 template (this will end execution)
        include( get_query_template( '404' ) );
        exit;
    }

    // 2) If the path ends with /page/<num> (without trailing slash), redirect to trailing-slash version
    // Match patterns like: /learn/page/2  or /learn/something/page/2
    if ( preg_match( '#/page/(\d+)$#i', $path, $m ) ) {
        $page = intval( $m[1] );

        // Build the clean path with trailing slash
        $clean_path = rtrim( $path ) . '/'; // adds trailing slash

        // Build full redirect URL using home_url to preserve site URL / subdirectory install
        $redirect = home_url( $clean_path );

        // Re-append query string if present
        if ( ! empty( $query ) ) {
            $redirect .= '?' . $query;
        }

        // Perform 301 redirect
        wp_safe_redirect( $redirect, 301 );
        exit;
    }

    // Otherwise do nothing and allow normal flow
}


 