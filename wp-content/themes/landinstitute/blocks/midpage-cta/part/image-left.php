<?php if (!empty($li_mpc_headline_check) || !empty($li_mpc_kicker) || !empty($li_mpc_wysiwyg) || !empty($li_mpc_link) || !empty($li_mpc_image)) { ?>
<div class="sticky-lft-block">
	<div class="row-flex">
		<?php echo !empty($li_mpc_image)  ? '<div class="col-left sticky-img"><div class="sticky-image-stick">' . wp_get_attachment_image($li_mpc_image, 'thumb_1400') . '</div></div>' : ''; ?>
		<div class="cl-right">
			<div class="gl-s156"></div>
			<?php echo !empty($li_mpc_kicker)  ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_mpc_kicker) . '</div><div class="gl-s12"></div>' : '';  ?>
			<?php echo !empty($li_mpc_headline_check) ? BaseTheme::headline($li_mpc_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_mpc_headline_check) || !empty($li_mpc_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_mpc_wysiwyg)  ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_mpc_wysiwyg) . '</div>' : ''; ?>
			<?php echo (!empty($li_mpc_wysiwyg) && !empty($li_mpc_link)) ? '<div class="gl-s52"></div>' : ''; ?>
			<?php echo !empty($li_mpc_link) ? '<div class="block-btn">' . BaseTheme::button($li_mpc_link, 'site-btn xsm-btn') . '</div>' : ''; ?>
			<div class="gl-s156"></div>
		</div>
	</div>
</div>
<?php } ?>