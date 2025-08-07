<?php if (!empty($li_iat_headline_check) || !empty($li_iat_kicker) || !empty($li_iat_wysiwyg) || !empty($li_iat_button) || !empty($li_iat_bg_image)): ?>
<div class="image-alongside-text  variation-pattern ">
    <?php echo !empty($li_iat_bg_image) ? '<div class="col-left">' . wp_get_attachment_image($li_iat_bg_image, 'thumb_1200', false) . '</div>' : ''; ?>
    <div class="col-right">
        <div class="gl-s156"></div>
        <?php echo !empty($li_iat_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_iat_kicker) . '</div>' : ''; ?>
        <?php echo (!empty($li_iat_kicker) && !empty($li_iat_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
        <?php echo !empty($li_iat_headline_check) ? BaseTheme::headline($li_iat_headline, 'heading-2 mb-0 block-title') : ''; ?>
        <?php echo (!empty($li_iat_headline_check) && !empty($li_iat_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
        <?php echo !empty($li_iat_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_iat_wysiwyg) . '</div>' : ''; ?>
        <?php echo (!empty($li_iat_wysiwyg) && !empty($li_iat_button)) ? '<div class="gl-s30"></div>' : ''; ?>
        <?php echo !empty($li_iat_button) ? '<div class="block-btn">' . BaseTheme::button($li_iat_button, 'site-btn text-link') . '</div>' : ''; ?>
        <div class="gl-s156"></div>
    </div>
</div>
<?php endif; ?>
