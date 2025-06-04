<?php
$header_logo = $bst_option_fields['bst_var_header_logo'] ?? null;
$li_land_header_button  = $bst_fields['li_land_header_button'] ?? null;
?>
<div class="header-wrapper header-inner <?php if (is_page_template('templates/template-landing.php')) { ?> header-cta-variation d-flex <?php  } ?>">
<div class="header-logo logo">
		<a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" role="button" aria-label="Site URL" data-text="Site URL">
			<?php echo wp_get_attachment_image($header_logo, 'admin-landscape') ?>
		</a>
	</div>
	<div class="right-header header-navigation">
		<?php include get_template_directory() . '/partials/header/hello-bar.php'; ?>
		<?php echo !empty($li_land_header_button) ? '<div class="bottom-head"><div class="header-btns">' . BaseTheme::button($li_land_header_button, 'site-btn btn-sunflower-yellow sm-btn arrow-heart-symbol') . '</div></div>' : ''; ?>
	</div>
</div>

