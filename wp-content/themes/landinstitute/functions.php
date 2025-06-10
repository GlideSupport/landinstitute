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

if ( ! defined( 'BASETHEME_BLOCK_DIR' ) ) {
	define( 'BASETHEME_BLOCK_DIR', __DIR__ . '/blocks' );
}

$bst_folder_includes = bst_includes( __DIR__ . '/includes/classes' );
/**
 * Checks if any file have error while including it.
 */
foreach ( $bst_folder_includes as $bst_folders ) {
	foreach ( $bst_folders as $bst_file ) {
		$bst_filepath = locate_template( str_replace( __DIR__ . '/', '', $bst_file ) );
		if ( file_exists( $bst_filepath ) ) {
			require_once $bst_filepath;
		} else {
			echo 'Unable to load configuration file ' . esc_html( basename( $bst_file ) ) . ' please check file name in functions.php in your current active theme.';
		}
	}
}
/**
 * Get folder Dir
 *
 * @param string $directory Folder dir path.
 */
function bst_includes( $directory ) {
	$folders = array();

	// Get all files and folders in the specified directory.
	$items = scandir( $directory );

	// Iterate through each item.
	foreach ( $items as $item ) {
		$full_path = $directory . '/' . $item;

		// Check if the item is a directory and not '.' or '..'.
		if ( is_dir( $full_path ) && '.' !== $item && '..' != $item ) {
			$folders[ $item ] = glob( __DIR__ . '/includes/classes/' . $item . '/*.php' );
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



// Register AJAX actions
// add_action('wp_ajax_filter_logo_grid_filter', 'ajax_filter_logo_grid_filter');
// add_action('wp_ajax_nopriv_filter_logo_grid_filter', 'ajax_filter_logo_grid_filter');

function ajax_filter_logo_grid_filter() {
    check_ajax_referer('ajax_nonce', 'nonce');

    $donor_type = $_POST['donor_type'] ?? 'all';
    $donation_level = $_POST['donation_level'] ?? 'all';
    $paged = max(1, $_POST['paged'] ?? 1);

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
        'posts_per_page' => 6,
        'paged'          => $paged,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => $tax_query,
    ];

    $donors = new WP_Query($args);

    ob_start();

    if ($donors->have_posts()) :
        while ($donors->have_posts()) : $donors->the_post();
            $image_id = get_post_thumbnail_id(get_the_ID());
            $title = get_the_title();
            $title_words = explode(' ', trim($title));
            $first_initial = !empty($title_words[0]) ? strtoupper($title_words[0][0]) : '';
            $last_initial  = !empty($title_words[1]) ? strtoupper($title_words[1][0]) : '';
            $initials = $first_initial . $last_initial;

            $image_html = $image_id ? wp_get_attachment_image($image_id, 'full', false, ['width' => 200, 'height' => 102, 'alt' => $title]) : '';

            $levels = get_the_terms(get_the_ID(), 'donation-level');
            $level_name = !empty($levels) && !is_wp_error($levels) ? $levels[0]->name : '';
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

    $response = [
        'html' => ob_get_clean(),
        'max_pages' => $donors->max_num_pages,
        'current_page' => $paged,
        'total' => $donors->found_posts
    ];

    wp_send_json_success($response);
}