<?php if(!empty($li_s_headline_check) || !empty($li_s_wysiwyg) || !empty($li_s_button) ): ?>
	<div class="stats-with-text has-border-bottom">
		<div class="row-flex">
		<?php if (!empty($li_s_repeater_one)) : ?>	
			<div class="col-left">
				<?php foreach ($li_s_repeater_one as $repeater_one) : 
					$li_s_prefix_one  = $repeater_one['li_s_prefix_one'] ?? '';
					$li_s_number_one  = $repeater_one['li_s_number_one'] ?? '';
					$li_s_postfix_one = $repeater_one['li_s_postfix_one'] ?? '';
					$li_s_label_one   = $repeater_one['li_s_label_one'] ?? '';
				?>
					<div class="state-group">
						<div class="ui-128-78-bold head-bold mb-0 counter-number" data-target="<?php echo esc_attr($li_s_number_one); ?>">
							<?php echo esc_html($li_s_prefix_one); ?><span class="count">0</span><?php echo esc_html($li_s_postfix_one); ?>
						</div>
						<div class="ui-24-21-bold counter-content">
							<?php echo esc_html($li_s_label_one); ?>
						</div>
					</div>
					<div class="gl-s44"></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
			<div class="col-right">
			<?php echo !empty($li_s_headline_check) ? BaseTheme::headline($li_s_headline, 'heading-2 block-title mb-0') : ''; ?>
			<?php echo (!empty($li_s_headline_check) || !empty($li_s_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_s_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_s_wysiwyg) . '</div><div class="gl-s30"></div>' : ''; ?>	
			<?php echo !empty($li_s_button) ? '<div class="block-btn">' . BaseTheme::button($li_s_button, 'site-btn text-link') . '</div>' : ''; ?>
			</div>
		</div>
	</div>
<?php endif; ?>