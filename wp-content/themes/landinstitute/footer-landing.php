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
?>

</main>

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
    </script>
<?php } ?>
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