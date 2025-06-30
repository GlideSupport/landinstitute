<?php if (!empty($li_mpc_headline_check) || !empty($li_mpc_kicker) || !empty($li_mpc_wysiwyg) || !empty($li_mpc_link) || !empty($li_mpc_image)) { ?>
<div class="midpage-cta-image-right">
    <div class="row-grid">
        <div class="col-left">
            <div class="gl-s156"></div>
            <?php echo !empty($li_mpc_kicker)  ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_mpc_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>
            <?php echo !empty($li_mpc_headline_check)  ? BaseTheme::headline($li_mpc_headline, 'heading-2 block-title mb-0')  : ''; ?>
            <?php echo (!empty($li_mpc_headline_check) && !empty($li_mpc_wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
            <?php echo !empty($li_mpc_wysiwyg) ? '<div class="body-20-18-regular body-content">' . html_entity_decode($li_mpc_wysiwyg) . '</div>' : ''; ?>
            <div class="gl-s156"></div>
        </div>
        <div class="col-right">
            <?php echo !empty($li_mpc_image) ? '<div class="pattern6">' . wp_get_attachment_image($li_mpc_image, 'thumb_1000', false, ['class' => 'desktop-img']) . '</div>' : ''; ?>
            <div class="gl-s156"></div>
            <div class="right-col-content">
            <?php echo !empty($li_mpc_link) ? '<div class="two-row-btn">' . BaseTheme::button($li_mpc_link, 'site-btn btn-sunflower-yellow') . '</div>' : ''; ?>
            </div>
            <div class="gl-s156"></div>
        </div>
    </div>
</div>
<?php } ?>
