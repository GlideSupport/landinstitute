<?php if (!empty($li_mpc_headline_check) || !empty($li_mpc_kicker) || !empty($li_mpc_wysiwyg) || !empty($li_mpc_link)) : ?>
<div class="midpage-cta variation-text-only">
	<?php echo !empty($li_mpc_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_mpc_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>
	<?php echo !empty($li_mpc_headline_check) ? BaseTheme::headline($li_mpc_headline, 'block-title mb-0 heading-2') : ''; ?>
	<?php echo (!empty($li_mpc_headline_check) && !empty($li_mpc_wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
	<?php echo !empty($li_mpc_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_mpc_wysiwyg) . '</div>' : ''; ?>
	<?php echo (!empty($li_mpc_wysiwyg) || !empty($li_mpc_link)) ? '<div class="gl-s44"></div>' : ''; ?>
	<?php echo !empty($li_mpc_link) ? '<div class="block-btn">' . BaseTheme::button($li_mpc_link, 'site-btn btn-brown xsm-btn') . '</div><div class="gl-s80"></div>' : ''; ?>
</div>
<?php endif; ?>
