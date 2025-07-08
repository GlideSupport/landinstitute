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
		ob_start(); ?>
		<div class="fillter-bottom">
			<div class="pagination-container">
				<div class="desktop-pages">
					<div class="arrow-btn prev">
						<div class="site-btn" <?php if ($paged <= 1) echo ' style="opacity: 0.5; pointer-events: none;"'; ?>>Previous</div>
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
								echo '<button class="page-btn' . ($i == $paged ? ' active' : '') . '" data-page="' . esc_attr($i) . '">' . esc_html($i) . '</button>';
							} else {
								$show_dots = true;
							}
						}
						?>
					</div>
					<div class="arrow-btn next">
						<div class="site-btn" <?php if ($paged >= $total_pages) echo ' style="opacity: 0.5; pointer-events: none;"'; ?>>Next</div>
					</div>
				</div>

				<div class="mobile-pagination">
					<button id="prevBtn" class="arrow-btn" <?php if ($paged <= 1) echo ' disabled'; ?>>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Prev">
					</button>
					<button id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html($paged . '/' . $total_pages); ?></button>
					<button id="nextBtn" class="arrow-btn" <?php if ($paged >= $total_pages) echo ' disabled'; ?>>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
					</button>
				</div>

				<div id="paginationPopup" class="pagination-popup">
					<div class="popup-body">
						<div id="popupGrid" class="popup-grid">
							<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
								<button class="page-btn<?php echo ($i == $paged ? ' active' : ''); ?>" data-page="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></button>
							<?php endfor; ?>
						</div>
						<button id="popupPrev" class="arrow-btn"></button>
						<button id="popupNext" class="arrow-btn"></button>
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
add_action('wp_ajax_filter_news_posts', 'filter_news_posts_callback');
add_action('wp_ajax_nopriv_filter_news_posts', 'filter_news_posts_callback');

function filter_news_posts_callback()
{
	$type  = sanitize_text_field($_POST['news_type'] ?? 'all');
	$topic = sanitize_text_field($_POST['news_topic'] ?? 'all');

	$args = [
		'post_type' => 'news',
		'post_status' => 'publish',
		'posts_per_page' => 9,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'tax_query' => [],
	];

	if ($type !== 'all') {
		$args['tax_query'][] = [
			'taxonomy' => 'news-type',
			'field'    => 'slug',
			'terms'    => $type,
		];
	}

	if ($topic !== 'all') {
		$args['tax_query'][] = [
			'taxonomy' => 'news-topic',
			'field'    => 'slug',
			'terms'    => $topic,
		];
	}

	if (!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post();
			$title = get_the_title();
			$date = get_the_date('M j, Y');
			$permalink = get_the_permalink();
			$short_Desc = get_the_excerpt();
			$short_content = wp_trim_words($short_Desc, 15, '...');
			$topics = get_the_terms(get_the_ID(), 'news-topic');
			$topics_name = !empty($topics) && !is_wp_error($topics) ? $topics[0]->name : '';

		?>
			<div class="filter-content-card-item">
				<a href="<?php echo esc_html($permalink); ?>" class="filter-content-card-link">
					<div class="filter-card-content">
						<div class="gl-s52"></div>
						<div class="top-sub-list d-flex flex-wrap">
							<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($date); ?></div>
							<?php if ($topics_name): ?>
								<div class="ui-eyebrow-16-15-regular">•</div>
							<?php endif; ?>
							<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($topics_name); ?></div>
						</div>
						<div class="gl-s8"></div>
						<div class="card-title heading-7"><?php echo esc_html($title); ?>
						</div>
						<?php if ($short_content): ?>
							<div class="gl-s16"></div>
							<div class="description ui-18-16-regular"><?php echo html_entity_decode($short_content); ?>
							</div>
						<?php endif; ?>

						<div class="gl-s20"></div>
						<div class="read-more-link">
							<div class="border-text-btn">Read more</div>
						</div>
						<div class="gl-s80"></div>
					</div>
				</a>
			</div>
		<?php endwhile;
	else :
		echo '<p>No posts found.</p>';
	endif;

	wp_reset_postdata();
	wp_die();
}


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

	// $event_query = new WP_Query([
	// 	'post_type'      => 'event',
	// 	'post_status'    => 'publish',
	// 	'posts_per_page' => 1,
	// 	'paged'          => $paged,
	// 	'orderby'        => 'meta_value',
	// 	'meta_key'       => 'li_cpt_event_start_date',
	// 	'order'          => 'ASC'
	// ]);

	$eventargs = array(
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'paged'          => $paged,
		'orderby'        => 'meta_value',
		'meta_key'       => 'li_cpt_event_start_date',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'li_cpt_event_start_date',
				'value'   => date('Ymd'), // current date in Ymd format (e.g., 20250708)
				'type'    => 'NUMERIC',   // important if the field is stored as number or string
				'compare' => '>='         // only future or today
			)
		)
	);
	$event_query = new WP_Query($eventargs);

	if ($event_query->have_posts()) :
		while ($event_query->have_posts()) : $event_query->the_post();
			$start_date = get_field('li_cpt_event_start_date');
			$end_date   = get_field('li_cpt_event_end_date');

			$image  = "https://landinstdev.wpenginepowered.com/wp-content/uploads/demo.webp";
			if (get_the_post_thumbnail_url(get_the_ID(), 'medium')) {
				$image      = get_the_post_thumbnail_url(get_the_ID(), 'medium');
			}

			// $image      = get_the_post_thumbnail_url(get_the_ID(), 'medium');
			$excerpt    = get_the_excerpt();
			$excerpt = wp_trim_words($excerpt, 25, '...');
			$url        = get_permalink();
			$all_day = get_field('li_cpt_event_all_day'); // checkbox or true/false

			set_query_var('start_date', $start_date);
			set_query_var('end_date', $end_date);
			set_query_var('image', $image);
			set_query_var('excerpt', $excerpt);
			set_query_var('url', $url);
			set_query_var('all_day', $all_day);
			get_template_part('partials/content', 'event-list');
		endwhile;
	else :
		echo '<p>No more events.</p>';
	endif;

	wp_reset_postdata();
	wp_die(); // Important!
}


// Past event filter
add_action('wp_ajax_filter_past_events', 'filter_past_events');
add_action('wp_ajax_nopriv_filter_past_events', 'filter_past_events');

function filter_past_events() {
	check_ajax_referer('ajax_nonce', 'nonce');
   
	$term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
   $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
   $today = date('Ymd'); // e.g., 20250704
   
   $args = [
	 'post_type'      => 'event',
	 'post_status'    => 'publish',
	 'posts_per_page' => 6,
	 'paged'          => $paged,
	 'meta_key'       => 'li_cpt_event_start_date',
	 'orderby'        => 'meta_value',
	 'order'          => 'DESC',
	 'meta_query'     => [
	   [
		 'key'     => 'li_cpt_event_start_date',
		 'value'   => $today,
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
	  $start_date_raw = get_field('li_cpt_event_start_date', $post_id);
	  $end_date_raw = get_field('li_cpt_event_end_date', $post_id);
   
   
	  $start_date = new DateTime($start_date_raw);
	  $end_date   = new DateTime($end_date_raw);
   
	  $start_formatted = $start_date->format('l, F j, Y'); // e.g., Friday, May 2, 2025
	  $end_formatted   = $end_date->format('l, F j, Y');   // e.g., Saturday, May 3, 2025
	  $excerpt = get_the_excerpt( $post_id);
	  $event_content = wp_trim_words($excerpt, 25, '...');
   
	  $start_date_raw = get_field('li_cpt_event_start_date', $post_id);
	  $end_date_raw   = get_field('li_cpt_event_end_date', $post_id);

	  $event_start_time = get_field('li_cpt_event_start_time', $post_id);
	  $event_end_time   = get_field('li_cpt_event_end_time', $post_id);

	  $timezone = get_field('timezone', $post_id);
	  $timezone_code = get_timezone_code($timezone); // Assumes you have a function for this

	  // Format start/end as DateTime objects
	  $start_datetime = new DateTime($start_date_raw . ' ' . $event_start_time);
	  $end_datetime   = new DateTime($end_date_raw . ' ' . $event_end_time);

	  // Optional: Set timezone if needed (if $timezone is a valid TZ name)
	  if (!empty($timezone)) {
		  try {
			  $tz = new DateTimeZone($timezone);
			  $start_datetime->setTimezone($tz);
			  $end_datetime->setTimezone($tz);
		  } catch (Exception $e) {
			  // fallback silently
		  }
	  }

	  // Format the full string
	  if ($start_datetime->format('Y-m-d') === $end_datetime->format('Y-m-d')) {
		  // Same day
		  $event_display = $start_datetime->format('l, F j, Y g:i a') . ' ' . $timezone_code . ' – ' . $end_datetime->format('g:i a') . ' ' . $timezone_code;
	  } else {
		  // Different days
		  $event_display = $start_datetime->format('l, F j, Y g:i a') . ' ' . $timezone_code . ' – ' . $end_datetime->format('l, F j, Y g:i a') . ' ' . $timezone_code;
	  }
   
	  ?>
		 <div class="filter-content-card-item">
						   <a href="<?php echo esc_url($event_link); ?>" class="filter-content-card-link">
							   <div class="filter-card-content">
							   <div class="gl-s52"></div>
							   <div class="eyebrow ui-eyebrow-16-15-regular"><?php echo $event_display; ?> All Day
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
			   $pagination_html .= '<a id="desktopPrev" class="arrow-btn prev page-btn ' . ($prev_disabled ? 'disable' : '') . '" href="' . esc_url($prev_url) . '" data-page="' . esc_attr($prev_page) . '" rel="'.($prev_disabled ? '' : 'prev').'"><div class="site-btn">Previous</div></a>';
		   
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
			   $pagination_html .= '<a id="desktopNext" class="arrow-btn next page-btn ' . ($next_disabled ? 'disable' : '') . '" href="' . esc_url($next_url) . '" data-page="' . esc_attr($next_page) . '" rel="'.($next_disabled ? '' : 'next').'"><div class="site-btn">Next</div></a>';
		   
			   $pagination_html .= '</div>'; // end desktop-pages
		   
			   // Mobile Pagination
			   $pagination_html .= '<div class="mobile-pagination">';
		   
			   // Prev Mobile
			   $rel_attr = !$prev_disabled ? ' rel="prev"' : '';
   
			   $pagination_html .= '<a id="prevBtn" class="arrow-btn page-btn ' . ($prev_disabled ? 'disable' : '') . '" href="' . esc_url($prev_url) . '" data-page="' . esc_attr($prev_page) . '"' . $rel_attr . '>
				   <img src="' . get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg" alt="Previous">
			   </a>';
		   
			   // Page Trigger Button
			   $pagination_html .= '<button id="pageTrigger" class="page-trigger ui-18-16-bold page-btn">' . $paged . '/' . $total_pages . '</button>';
		   
			   // Next Mobile
			   $rel_attr = !$next_disabled ? ' rel="next"' : '';
			   $pagination_html .= '<a id="nextBtn" class="arrow-btn page-btn ' . ($next_disabled ? 'disable' : '') . '" href="' . esc_url($next_url) . '" data-page="' . esc_attr($next_page) . '"' . $rel_attr . '>
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

    return $timezones[$timezone_value] ?? "Unknown";
}