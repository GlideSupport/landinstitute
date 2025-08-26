<?php


function isValidString( $s ) {
	$pattern = '/\?p=\d+/';
	return preg_match( $pattern, $s ) === 1;
}

remove_action( 'wp_head', 'rel_canonical' );

/**
 * Custom canonical logic for paginated & filtered blog, event, and ambassador pages
 */
function glide_custom_paginated_canonical($canonical) {
	$paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
	$template = '';

	// Logic for Learn page
	if (is_page_template('templates/template-learn.php')) {
	$template = 'learn';
	$supported_keys = ['learn-type', 'learn-topic', 'learn-crop','learn-audience'];
	}
	elseif (is_page_template('templates/template-news.php')) {
	$template = 'news';
	$supported_keys = ['topic','type','crop','audience'];
	}
	// Logic for Event page
	elseif (is_page_template('templates/template-events.php')) {
	$template = 'events';
	$supported_keys = ['eventsview'];
	}
	// Logic for Find an Ambassador page

	// If template is found, process the URL
	if ($template) {
	$base_url = $paged > 1
	? home_url("{$template}/page/{$paged}/")
	: home_url("{$template}/");

	// Filter query args to only include supported keys
	$query_args = array_filter(
	$_GET,
	fn($k) => in_array($k, $supported_keys),
	ARRAY_FILTER_USE_KEY
	);

	// Handle the case when filters are applied:
	if (count($query_args) > 1) {
	// If multiple filters are applied, set the canonical to the base URL
	$canonical = trailingslashit($base_url);
	} elseif (count($query_args) == 1) {
	// If only one filter is applied, set the canonical to the filtered URL
	$canonical = add_query_arg($query_args, trailingslashit($base_url));
	} else {
	// If no filters, set the canonical to the base URL
	$canonical = trailingslashit($base_url);
	}
	}

	return $canonical;
}

/**
 * Override Yoast canonical and inject <meta name="robots"> tag for filtered pages
 */
function glide_override_yoast_canonicals() {
	// Check if the current page is one of the relevant templates
	if (
	is_page_template('templates/template-learn.php') ||
	is_page_template('templates/template-events.php') ||
	is_page_template('templates/template-news.php')
	) {
	// Override the canonical URL in Yoast
	add_filter('wpseo_canonical', 'glide_custom_paginated_canonical');
	}
}
add_action('wp', 'glide_override_yoast_canonicals');

/**
 * Override Yoast robots meta tag for paginated and filtered pages
 *
 * @param string $robots Current robots meta tag value.
 * @return string Modified robots meta tag value.
 */
function glide_override_yoast_robots($robots) {
 	$paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

	// Always noindex paginated pages
	if ($paged > 1) {
	return 'noindex,follow';
	}

	// Define filter keys you want to monitor
	$supported_keys = ['learn-type', 'learn-topic', 'learn-crop', 'learn-audience', 'topic', 'type', 'crop', 'audience', 'eventsview'];

	// Filter current URL parameters by supported keys
	$active_filters = array_filter(
	$_GET,
	fn($k) => in_array($k, $supported_keys),
	ARRAY_FILTER_USE_KEY
	);

	// If exactly 1 filter is present → noindex
	if (count($active_filters) === 1) {
	return 'noindex,follow';
	}

	// If multiple filters or no filters → allow indexing
	return $robots;
}

add_filter('wpseo_robots', 'glide_override_yoast_robots');
