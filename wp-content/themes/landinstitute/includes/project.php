<?php
/**
 * Custom functions added to current project
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Traffix Theme
 * @since 1.0.0
 */

function glide_posts_add_rewrite_rules( $wp_rewrite ) {
	$new_rules         = array(
		'resources/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=' . $wp_rewrite->preg_index( 1 ),
		'resources/(.+?)/?$'            => 'index.php?post_type=post&name=' . $wp_rewrite->preg_index( 1 ),
	);
	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	return $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'glide_posts_add_rewrite_rules' );

function isValidString( $s ) {
	$pattern = '/\?p=\d+/';
	return preg_match( $pattern, $s ) === 1;
}

remove_action( 'wp_head', 'rel_canonical' );
function glide_add_self_paginated_canonical($canonical) {
	if ( is_page_template('templates/template-blog.php') ) {
		$keys = ['category','paged'];
		$query_params = array_intersect_key($_GET, array_flip($keys));

		if (!empty($query_params)) {
			$canonical = add_query_arg($query_params, $canonical);
		}
	}
	return $canonical;
}
function glide_update_yoast_seo_canonical_paginated() {
	if ( is_page_template( 'templates/template-blog.php' ) ) { // Adjust template name
        add_filter( 'wpseo_canonical', 'glide_add_self_paginated_canonical', 10, 1 );
    }
}
add_action( 'wp', 'glide_update_yoast_seo_canonical_paginated' );