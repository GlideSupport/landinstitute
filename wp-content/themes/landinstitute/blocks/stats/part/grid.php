<?php if (!empty($li_s_kicker) || !empty($li_s_repeater_two)): ?>
	<div class="state-grid-block <?php echo esc_attr($border_options); ?>">
		<div class="ui-20-18-bold-uc sub-titile"><?php echo esc_html($li_s_kicker); ?></div>
		<div class="gl-s52"></div>
		<?php if (!empty($li_s_repeater_two)) : ?>
			<div class="state-grid-row">
				<?php foreach ($li_s_repeater_two as $repeater_two) :
					$li_s_prefix_two  = $repeater_two['li_s_prefix_two'] ?? '';
					$li_s_number_two  = $repeater_two['li_s_number_two'] ?? '';
					$li_s_postfix_two = $repeater_two['li_s_postfix_two'] ?? '';
					$li_s_label_two   = $repeater_two['li_s_label_two'] ?? '';
					$li_s_description_two   = $repeater_two['li_s_description_two'] ?? '';

					if (!empty($li_s_prefix_two) || !empty($li_s_number_two) || !empty($li_s_postfix_two) || !empty($li_s_label_two) || !empty($li_s_description_two)): ?>
						<div class="state-grid-col">
								<div class="ui-72-52-bold head-bold mb-0 counter-number" data-target="<?php echo esc_attr($li_s_number_two); ?>">
									<?php echo esc_html($li_s_prefix_two); ?>
									<span class="count">0</span><?php echo esc_html($li_s_postfix_two); ?>
								</div>
							<?php if ($li_s_label_two): ?>
								<div class="ui-24-21-bold block-sub-head">
									<?php echo esc_html($li_s_label_two); ?>
								</div>
								<div class="gl-s44"></div>
							<?php endif; ?>
							<?php if ($li_s_description_two): ?>
								<div class="body-20-18-regular block-content">
									<?php echo esc_html($li_s_description_two); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>