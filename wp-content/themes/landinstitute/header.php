<?php
/**
 * The template for displaying website header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

// Page Tags - Advanced custom fields variables.
$bst_var_tracking = $bst_option_fields['custom_scripts'] ?? '';
$bst_var_ccss = $bst_option_fields['custom_css'] ?? '';
$bst_var_hscripts = $bst_option_fields['head_scripts'] ?? '';
$bst_var_bscripts = $bst_option_fields['body_scripts'] ?? '';

//hello bar
$bst_var_tbar_vsblty = $bst_option_fields['bst_var_tbar_vsblty'] ?? null;
$bst_var_hb_content = $bst_option_fields['bst_var_hb_content'] ?? null;
$cookie_days = $bst_option_fields['hello_bar_cookie_days'] ?? 1;

//page HelloBar Options
$base_theme_option_global_manual = $bst_fields['base_theme_option_global_manual'] ?? 'global';
$base_theme_option_content = $bst_fields['base_theme_option_content'] ?? null;

//header section
$bst_var_header_logo = $bst_option_fields['bst_var_header_logo'] ?? null;
$landinstitute_header_main_menu = $bst_option_fields['landinstitute_header_main_menu'] ?? null;
$bst_var_tohdr_btn = $bst_option_fields['bst_var_tohdr_btn'] ?? null;

$landinstitute_nav_button = $bst_option_fields['landinstitute_nav_button'] ?? null;
//Our Work Mega Menu 1
$landinstitute_nav_menu_title_1 = $bst_option_fields['landinstitute_nav_menu_title_1'] ?? null;
$landinstitute_select_nav_menu_1 = $bst_option_fields['landinstitute_select_nav_menu_1'] ?? null;

$landinstitute_nav_menu_title_2 = $bst_option_fields['landinstitute_nav_menu_title_2'] ?? null;
$landinstitute_select_nav_menu_2 = $bst_option_fields['landinstitute_select_nav_menu_2'] ?? null;

$landinstitute_nav_menu_title_3 = $bst_option_fields['landinstitute_nav_menu_title_3'] ?? null;
$landinstitute_select_nav_menu_3 = $bst_option_fields['landinstitute_select_nav_menu_3'] ?? null;

$landinstitute_nav_menu_title_4 = $bst_option_fields['landinstitute_nav_menu_title_4'] ?? null;
$landinstitute_select_nav_menu_4 = $bst_option_fields['landinstitute_select_nav_menu_4'] ?? null;

//Learn Mega Menu 2
$landinstitute_nav_button_two = $bst_option_fields['landinstitute_nav_button_two'] ?? null;
$landinstitute_title_two = $bst_option_fields['landinstitute_title_two'] ?? null;
$landinstitute_text_two = $bst_option_fields['landinstitute_text_two'] ?? null;
$landinstitute_button_one = $bst_option_fields['landinstitute_button_one'] ?? null;
$landinstitute_button_two = $bst_option_fields['landinstitute_button_two'] ?? null;
$landinstitute_button_three = $bst_option_fields['landinstitute_button_three'] ?? null;


$landinstitute_nav_menu_title_mega_two_1 = $bst_option_fields['landinstitute_nav_menu_title_mega_two_1'] ?? null;
$landinstitute_select_nav_menu_mega_two_1 = $bst_option_fields['landinstitute_select_nav_menu_mega_two_1'] ?? null;

$landinstitute_nav_menu_title_mega_two_2 = $bst_option_fields['landinstitute_nav_menu_title_mega_two_2'] ?? null;
$landinstitute_select_nav_menu_mega_two_2 = $bst_option_fields['landinstitute_select_nav_menu_mega_two_2'] ?? null;


//Search Popup
$landinstitute_to_title = $bst_option_fields['landinstitute_to_title'] ?? null;
$landinstitute_to_select_post = $bst_option_fields['landinstitute_to_select_post'] ?? null;
$landinstitute_to_common_search_title = $bst_option_fields['landinstitute_to_common_search_title'] ?? null;
$landinstitute_to_common_search_text = $bst_option_fields['landinstitute_to_common_search_text'] ?? null;
$landinstitute_to_popular_topics_title = $bst_option_fields['landinstitute_to_popular_topics_title'] ?? null;
$landinstitute_to_popular_topics = $bst_option_fields['landinstitute_to_popular_topics'] ?? null;




?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <?php
    // Add Head Scripts.
    if (BaseTheme::if_live()) {

        if ('' !== $bst_var_hscripts) {
            echo html_entity_decode($bst_var_hscripts, ENT_QUOTES);
        }
    }
    ?>

    <?php 
    // Ensure the theme supports 'site_icon' 
    if (function_exists('has_site_icon') && has_site_icon()) {
        wp_site_icon();
    } else { ?>
       <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/favicon-16x16.png">
    <link rel="icon" sizes="any"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/favicon.ico">
    <link rel="icon" type="image/svg+xml"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/icon.svg">
   <?php }
    ?>
  

    
    <link rel="manifest"
        href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/site.webmanifest">
    <meta name="theme-color" content="#FBF8F0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Base Theme Package">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton_color" content="#FBF8F0">
    <meta name="msapplication-TileColor" content="#FBF8F0">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="msapplication-TileImage"
        content="<?php echo esc_url(get_template_directory_uri()); ?>/assets/build/images/pwa/pwa-icon-144.png">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#FBF8F0">
    <?php
    // Tracking Code.
    if ('' !== $bst_var_tracking) {
        echo html_entity_decode($bst_var_tracking, ENT_QUOTES);
    }

    // Custom CSS.
    if ('' !== $bst_var_ccss) {
        echo '<style type="text/css">';
        echo html_entity_decode($bst_var_ccss, ENT_QUOTES);
        echo '</style>';
    }
    ?>
    <?php wp_head(); ?>

</head>
<?php
$cookie_name = 'helloBarClosed';
$cookie_class = 'hello-bar-appear';
$body_classes = array();

// If top bar visibility variable is empty, force removal class
if (empty($bst_var_tbar_vsblty)) {
    $cookie_class = 'hello-bar-remove';
}
// If cookie is set (bar closed by user), override to removal
elseif (isset($_COOKIE[$cookie_name])) {
    $cookie_class = 'hello-bar-remove';
}

if (!empty($cookie_class)) {
    $body_classes[] = $cookie_class;
}
?>


<body <?php body_class($body_classes); ?>> <?php wp_body_open(); ?>
    <?php
    if (BaseTheme::if_live()) {
        if ('' !== $bst_var_bscripts) {
            ?>
            <div style="display: none;">
                <?php echo html_entity_decode($bst_var_bscripts, ENT_QUOTES); ?>
            </div>
            <?php
        }
    }
    ?>

<a class="skip-link screen-reader-text"
    href="#page-section"><?php esc_html_e('Skip to content', 'land_institute'); ?></a>
<?php include get_template_directory() . '/partials/header/header-main.php'; ?>
<!-- Main Area Start -->
<main id="main-section" class="main-section">