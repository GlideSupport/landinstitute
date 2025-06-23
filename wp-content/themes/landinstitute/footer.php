<?php

/**
 * The template for displaying website footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();
// Default Footer Options.
$bst_var_footer_scripts = $bst_option_fields['footer_scripts'] ?? '';



// Schema Markup - ACF variables.
$bst_var_schema_check = $bst_option_fields['bst_var_schema_check'] ?? null;
if ($bst_var_schema_check) {
    $bst_var_schema_business_name = $bst_option_fields['bst_var_schema_business_name'] ?? null;
    $bst_var_schema_business_legal_name = $bst_option_fields['bst_var_schema_business_legal_name'] ?? null;
    $bst_var_schema_street_address = $bst_option_fields['bst_var_schema_street_address'] ?? null;
    $bst_var_schema_locality = $bst_option_fields['bst_var_schema_locality'] ?? null;
    $bst_var_schema_region = $bst_option_fields['bst_var_schema_region'] ?? null;
    $bst_var_schema_postal_code = $bst_option_fields['bst_var_schema_postal_code'] ?? null;
    $bst_var_schema_map_short_link = $bst_option_fields['bst_var_schema_map_short_link'] ?? null;
    $bst_var_schema_latitude = $bst_option_fields['bst_var_schema_latitude'] ?? null;
    $bst_var_schema_longitude = $bst_option_fields['bst_var_schema_longitude'] ?? null;
    $bst_var_schema_opening_hours = $bst_option_fields['bst_var_schema_opening_hours'] ?? null;
    $bst_var_schema_telephone = $bst_option_fields['bst_var_schema_telephone'] ?? null;
    $bst_var_schema_business_email = $bst_option_fields['bst_var_schema_business_email'] ?? null;
    $bst_var_schema_business_logo = $bst_option_fields['bst_var_schema_business_logo'] ?? null;
    $bst_var_schema_price_range = $bst_option_fields['bst_var_schema_price_range'] ?? null;
    $bst_var_schema_type = $bst_option_fields['bst_var_schema_type'] ?? null;
}
// Custom - ACF variables.
$bst_var_footer_logo = $bst_option_fields['bst_var_footer_logo'] ?? null;
$bst_var_ftrop_title = $bst_option_fields['bst_var_ftrop_title'] ?? null;
$bst_var_ftrop_text = $bst_option_fields['bst_var_ftrop_text'] ?? null;
$bst_var_ftrop_form_title = $bst_option_fields['bst_var_ftrop_form_title'] ?? null;
$bst_var_ftrop_form_selector = $bst_option_fields['bst_var_ftrop_form_selector'] ?? null;
$li_select_footer_legal_menu = $bst_option_fields['landinstitute_select_footer_legal_menu'] ?? null;
$bst_var_ftrop_copyright = $bst_option_fields['bst_var_ftrop_copyright'] ?? null;
$bst_var_social_profiles = $bst_option_fields['bst_var_social_profiles'] ?? null;

//Menu fields
$li_footer_menu_label_1 = $bst_option_fields['landinstitute_footer_menu_label_1'] ?? '';
$li_footer_menu_link_1 = $bst_option_fields['landinstitute_footer_menu_link_1'] ?? '';
$li_select_footer_menu_1 = $bst_option_fields['landinstitute_select_footer_menu_1'] ?? '';

$li_footer_menu_label_2 = $bst_option_fields['landinstitute_footer_menu_label_2'] ?? '';
$li_footer_menu_link_2 = $bst_option_fields['landinstitute_footer_menu_link_2'] ?? '';
$li_select_footer_menu_2 = $bst_option_fields['landinstitute_select_footer_menu_2'] ?? '';

$li_footer_menu_label_3 = $bst_option_fields['landinstitute_footer_menu_label_3'] ?? '';
$li_footer_menu_link_3 = $bst_option_fields['landinstitute_footer_menu_link_3'] ?? '';
$li_select_footer_menu_3 = $bst_option_fields['landinstitute_select_footer_menu_3'] ?? '';

$li_footer_menu_label_4 = $bst_option_fields['landinstitute_footer_menu_label_4'] ?? '';
$li_footer_menu_link_4 = $bst_option_fields['landinstitute_footer_menu_link_4'] ?? '';
$li_select_footer_menu_4 = $bst_option_fields['landinstitute_select_footer_menu_4'] ?? '';

$li_footer_menu_label_5 = $bst_option_fields['landinstitute_footer_menu_label_5'] ?? '';
$li_footer_menu_link_5 = $bst_option_fields['landinstitute_footer_menu_link_5'] ?? '';
$li_select_footer_menu_5 = $bst_option_fields['landinstitute_select_footer_menu_5'] ?? '';

$li_footer_menu_label_6 = $bst_option_fields['landinstitute_footer_menu_label_6'] ?? '';
$li_footer_menu_link_6 = $bst_option_fields['landinstitute_footer_menu_link_6'] ?? '';
$li_select_footer_menu_6 = $bst_option_fields['landinstitute_select_footer_menu_6'] ?? '';

$li_footer_menu_label_7 = $bst_option_fields['landinstitute_footer_menu_label_7'] ?? '';
$li_footer_menu_link_7 = $bst_option_fields['landinstitute_footer_menu_link_7'] ?? '';
$li_select_footer_menu_7 = $bst_option_fields['landinstitute_select_footer_menu_7'] ?? '';

$li_footer_menu_label_8 = $bst_option_fields['landinstitute_footer_menu_label_8'] ?? '';
$li_footer_menu_link_8 = $bst_option_fields['landinstitute_footer_menu_link_8'] ?? '';
$li_select_footer_menu_8 = $bst_option_fields['landinstitute_select_footer_menu_8'] ?? '';

$li_footer_menu_label_9 = $bst_option_fields['landinstitute_footer_menu_label_9'] ?? '';
$li_footer_menu_link_9 = $bst_option_fields['landinstitute_footer_menu_link_9'] ?? '';
$li_select_footer_menu_9 = $bst_option_fields['landinstitute_select_footer_menu_9'] ?? '';

//Page options
$li_po_nav_button = $bst_fields['li_po_nav_button'] ?? null;
$li_po_sub_nav_sticky = $bst_fields['li_po_sub_nav_sticky'] ?? null;

$li_po_nav_button_position  = $bst_fields['li_po_nav_button_position'] ?? 'left';
$li_po_nav_left_button = $bst_fields['li_po_nav_left_button'] ?? null;
$li_po_left_btn_arrow_position  = $bst_fields['li_po_left_btn_arrow_position'] ?? 'right';

$button_position_class = '';
$button_bg_class = '';
$button_arrow_position = '';

if ($li_po_nav_button_position == 'right') {
    $button_position_class =  'footer-subnav-variation';
    $button_bg_class = 'btn-sunflower-yellow';
}

if ($li_po_nav_button_position == 'left' && $li_po_left_btn_arrow_position == 'left') {
    $button_arrow_position = 'previous-arrow';
}

?>

</main>
<footer id="footer-section" class="footer-section site-footer">

    <?php get_template_part('partials/cta'); ?>
    <!-- Footer Start -->
    <div class="footer-main">
        <div class="gl-s96"></div>
        <div class="wrapper">
            <div class="footer-row">
                <div class="col-left">
                    <?php if ($bst_var_footer_logo): ?>
                        <div class="footer-logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>" role="button" aria-label="Site URL" data-text="Site URL">
                                <?php echo wp_get_attachment_image($bst_var_footer_logo, 'thumb_200') ?>
                            </a>
                        </div>
                        <div class="gl-s36"></div>
                    <?php endif; ?>
                    <div class="footer-intro">
                        <?php echo $bst_var_ftrop_title ? '<h5 class="heading-5 block-title mb-0">' . html_entity_decode($bst_var_ftrop_title) . '</h5><div class="gl-s12"></div>' : ''; ?>
                        <?php echo $bst_var_ftrop_text ? '<div class="intro-content body-20-18-regular">' . html_entity_decode($bst_var_ftrop_text) . '</div><div class="gl-s64"></div>' : ''; ?>
                    </div>

                    <div class="footer-newsletter">
                        <?php echo $bst_var_ftrop_form_title ? ' <div class="form-title ui-24-21-bold">' . html_entity_decode($bst_var_ftrop_form_title) . '</div><div class="gl-s30"></div>' : ''; ?>
                    </div>
                    <?php echo do_shortcode('[gravityform id="' . $bst_var_ftrop_form_selector . '" title="false" description="false" ajax="true" tabindex="0"]'); ?>
                    <div class="gl-s64"></div>
                    <div class="social-icons">
                        <?php BaseTheme::the_social_icons($bst_var_social_profiles); ?>
                    </div>
                    <div class="gl-s64"></div>
                    <div class="legal-nav">
                        <nav>
                            <?php
                            if (!empty($li_select_footer_legal_menu) && is_array($li_select_footer_legal_menu) && !empty($li_select_footer_legal_menu['slug'])) {
                                wp_nav_menu(
                                    array(
                                        'menu'             => $li_select_footer_legal_menu['slug'],
                                        'fallback_cb'      => 'BaseTheme::nav_fallback',
                                        'container'   => false,
                                    )
                                );
                            }
                            ?>
                        </nav>
                    </div>
                    <div class="gl-s8"></div>
                    <?php echo !empty($bst_var_ftrop_copyright) ? '<div class="copy-right">&copy; ' . date('Y') . ' ' . html_entity_decode($bst_var_ftrop_copyright) . '</div>' : ''; ?>
                </div>
                <div class="col-right">
                    <?php for ($i = 1; $i <= 9; $i++) :
                        $label = ${"li_footer_menu_label_" . $i};
                        $link = ${"li_footer_menu_link_" . $i};
                        $menu = ${"li_select_footer_menu_" . $i};
                    ?>
                        <div class="footer-nav">
                            <?php if (!empty($link)) : ?>
                                <a href="<?php echo esc_url($link['url']); ?>"
                                    target="<?php echo esc_attr($link['target']); ?>"
                                    title="<?php echo esc_attr($link['title']); ?>"
                                    role="<?php echo esc_attr($link['title']); ?>"
                                    aria-label="<?php echo esc_attr($link['title']); ?>">
                                <?php endif; ?>
                                <div class="footer-nav-title"> <?php echo esc_html($label); ?></div>
                                <div class="gl-s16"></div>
                                <?php if (!empty($link)) : ?>
                                </a>
                            <?php endif; ?>
                            <div class="footer-nav-item" role="navigation">
                                <nav>
                                    <?php if (!empty($menu) && is_array($menu) && !empty($menu['slug'])) {
                                        wp_nav_menu(
                                            array(
                                                'menu'        => $menu['slug'],
                                                'fallback_cb' => 'BaseTheme::nav_fallback',
                                                'container'   => false,
                                            )
                                        );
                                    } ?>
                                </nav>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="gl-s96"></div>
    </div>
    <?php if (!empty($li_po_nav_button) && !empty($li_po_sub_nav_sticky) && is_array($li_po_sub_nav_sticky) && !empty($li_po_sub_nav_sticky['slug'])): ?>
        <div class="footer-sub-nav-sticky bg-base-cream <?php echo esc_attr($button_position_class); ?>">
            <div class="row-flex">
                <div class="cl-left">
                    <?php if ($li_po_nav_button):
                        $link_url = $li_po_nav_button['url'];
                        $link_title = $li_po_nav_button['title'];
                        $link_target = $li_po_nav_button['target'] ? $li_po_nav_button['target'] : '_self'; ?>
                        <a class="jump-arrow <?php echo esc_attr($button_bg_class); ?> <?php echo esc_attr($button_arrow_position); ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                            <div class="arrow-icon"></div>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="cl-right">
                    <?php
                    if (!empty($li_po_sub_nav_sticky) && is_array($li_po_sub_nav_sticky) && !empty($li_po_sub_nav_sticky['slug'])) {
                        wp_nav_menu(
                            array(
                                'menu'           => $li_po_sub_nav_sticky['slug'],
                                'fallback_cb'    => 'BaseTheme::nav_fallback',
                                'container'      => false,
                                'menu_class'     => '',
                                'depth'          => 1,
                            )
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Footer End -->
    <?php
    if ($bst_var_schema_check) {
    ?>
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "<?php echo esc_html($bst_var_schema_type); ?>",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo esc_html($bst_var_schema_locality); ?>",
                    "addressRegion": "<?php echo esc_html($bst_var_schema_region); ?>",
                    "postalCode": "<?php echo esc_html($bst_var_schema_postal_code); ?>",
                    "streetAddress": "<?php echo esc_html($bst_var_schema_street_address); ?>"
                },
                "hasMap": "<?php echo esc_html($bst_var_schema_map_short_link); ?>",
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "<?php echo esc_html($bst_var_schema_latitude); ?>",
                    "longitude": "<?php echo esc_html($bst_var_schema_longitude); ?>"
                },
                "name": "<?php echo esc_html($bst_var_schema_business_name); ?>",
                "openingHours": "<?php echo esc_html($bst_var_schema_opening_hours); ?>",
                "telephone": "<?php echo esc_html($bst_var_schema_telephone); ?>",
                "email": "<?php echo esc_html($bst_var_schema_business_email); ?>",
                "url": "<?php echo esc_url(home_url()); ?>",
                "image": "<?php echo esc_html($bst_var_schema_business_logo); ?>",
                "legalName": "<?php echo esc_html($bst_var_schema_business_legal_name); ?>",
                "priceRange": "<?php echo esc_html($bst_var_schema_price_range); ?>"
            }
        </script> <?php } ?>
</footer>
<?php wp_footer(); ?>
<?php
if ('' !== $bst_var_footer_scripts) {
?>
    <div style="display: none;">
        <?php echo html_entity_decode($bst_var_footer_scripts, ENT_QUOTES); ?>
    </div>
<?php } ?>
</body>

</html>