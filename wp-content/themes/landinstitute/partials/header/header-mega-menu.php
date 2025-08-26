<?php
	if (!empty($landinstitute_header_main_menu) && is_array($landinstitute_header_main_menu) && !empty($landinstitute_header_main_menu['slug'])) {
		wp_nav_menu(
			array(
				'menu'             => $landinstitute_header_main_menu['slug'],
				'fallback_cb'      => 'BaseTheme::nav_fallback',
				'container'   => false,
				'items_wrap'   => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
			)
		);
	}
?>

<!-- Our Work Mega Menu Start -->
<div class="mega-dropdown our-work-mega-dropdown" id="mega-dropdown-our-work" style="display: none;">
	<div class="mega-dropdown-card">
		<div class="col-left">
			<?php echo !empty($landinstitute_nav_button) ? '<div class="mega-btns desktop-none">' . BaseTheme::button($landinstitute_nav_button, 'site-btn btn-lime-green') . '</div>' : ''; ?>
			<div class="group-content mega-one">
				<?php if (!empty($landinstitute_nav_menu_title_1)): ?>
					<div class="gl-s36"></div>
						<div class="ui-24-21-bold mega-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_1); ?></div>
					<div class="gl-s20"></div>
				<?php endif; ?>
				<?php
				if (!empty($landinstitute_select_nav_menu_1) && is_array($landinstitute_select_nav_menu_1) && !empty($landinstitute_select_nav_menu_1['slug']) ) {
					wp_nav_menu(
						array(
							'menu'           => $landinstitute_select_nav_menu_1['slug'],
							'fallback_cb'    => 'BaseTheme::nav_fallback',
							'container'      => false,
							'menu_class'     => 'dot-hover',
							'depth'          => 1,
						)
					);
				}
				?>
				<div class="gl-s36"></div>
			</div>
		</div>
		<div class="col-right">
			<div class="mega-menu-row">
				<div class="mega-col mega-two">
					<?php if (!empty($landinstitute_nav_menu_title_2)): ?>
						<div class="ui-24-21-bold mega-menu-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_2); ?></div>
						<div class="gl-s20"></div>
					<?php endif; ?>
					<div class="icon-content-list-block">
						<div class="icon-content-row">
						<?php
						$landinstitute_select_nav_menu_2 = wp_get_nav_menu_items($landinstitute_select_nav_menu_2['slug']);
						if ($landinstitute_select_nav_menu_2) :
							foreach ($landinstitute_select_nav_menu_2 as $li_select_nav_menu_2) :
								$icon = get_field('landinstitute_menu_icon', $li_select_nav_menu_2->ID);
								$description = get_field('landinstitute_menu_description', $li_select_nav_menu_2->ID);
						?>
							<div class="icon-content-col">
								<!-- Add class when hover on this on other element not same "active-hover" -->
								<a class="icon-group-card" href="<?php echo esc_url($li_select_nav_menu_2->url); ?>">
									<?php if(!empty($icon)): ?>	
										<div class="icon-left">
											<?php echo wp_get_attachment_image($icon, 'thumb_100'); ?>
										</div>
									<?php endif;  ?>
									<div class="icon-content-right">
										<div class="ui-18-16-bold icon-title"><?php echo esc_html($li_select_nav_menu_2->title); ?></div>
										<?php if(!empty($description)): ?>	
											<div class="gl-s2"></div>
											<div class="ui-16-15-regular icon-content"><?php echo esc_html($description); ?></div>
										<?php endif;  ?>
									</div>
								</a>
							</div>
					<?php endforeach;
						endif; ?>
						</div>
					</div>
				</div>
				<div class="mega-col mega-three">
				<?php if (!empty($landinstitute_nav_menu_title_3)): ?>
					<div class="ui-24-21-bold mega-menu-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_3); ?></div>
					<div class="gl-s20"></div>
				<?php endif; ?>
				<?php
					if (!empty($landinstitute_select_nav_menu_3) && is_array($landinstitute_select_nav_menu_3) && !empty($landinstitute_select_nav_menu_3['slug'])) {
						wp_nav_menu(
							array(
								'menu'           => $landinstitute_select_nav_menu_3['slug'],
								'fallback_cb'    => 'BaseTheme::nav_fallback',
								'container'      => false,
								'menu_class'     => 'dot-hover',
								'depth'          => 1,
							)
						);
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mega-bottom-menu">
		<?php if (!empty($landinstitute_nav_menu_title_4)): ?>
			<span class="ui-18-16-bold sub-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_4); ?></span>
		<?php endif; ?>
		<?php
			if (!empty($landinstitute_select_nav_menu_4) && is_array($landinstitute_select_nav_menu_4) && !empty($landinstitute_select_nav_menu_4['slug'])) {
				wp_nav_menu(
					array(
						'menu'           => $landinstitute_select_nav_menu_4['slug'],
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
<!-- Our Work Mega Menu End -->

<!-- learn Mega Menu Start -->
<div class="mega-dropdown learn-mega-dropdown" id="mega-dropdown-learn" style="display: none;">
	<div class="mega-dropdown-card">
		<div class="col-left">
			<?php echo !empty($landinstitute_nav_button_two) ? '<div class="mega-btns desktop-none">' . BaseTheme::button($landinstitute_nav_button_two, 'site-btn btn-lime-green') . '</div>' : ''; ?>
			<div class="group-content">
				<?php if (!empty($landinstitute_title_two)): ?>
					<div class="gl-s36"></div>
						<div class="ui-24-21-bold mega-title"><?php echo html_entity_decode($landinstitute_title_two); ?></div>
					<div class="gl-s16"></div>
				<?php endif; ?>
				<?php if (!empty($landinstitute_text_two)): ?>
					<div class="body-18-16-regular mega-content"><?php echo html_entity_decode($landinstitute_text_two); ?></div>
					<div class="gl-s36"></div>
				<?php endif; ?>
			</div>
			<div class="mega-btns">
				<?php if (!empty($landinstitute_button_one)): ?>
					<?php echo BaseTheme::button($landinstitute_button_one, 'site-btn btn-lime-green'); ?>
				<?php endif; ?>
				<?php if (!empty($landinstitute_button_two) && !empty($landinstitute_button_three)): ?>	
					<div class="two-btn-row">
						<?php if (!empty($landinstitute_button_two)): ?>
							<?php echo BaseTheme::button($landinstitute_button_two, 'site-btn btn-lime-green'); ?>
						<?php endif; ?>
						<?php if (!empty($landinstitute_button_three)): ?>
							<?php echo BaseTheme::button($landinstitute_button_three, 'site-btn btn-lime-green'); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-right">
			<div class="mega-menu-row">
				<div class="mega-col">
				<?php if (!empty($landinstitute_nav_menu_title_mega_two_1)): ?>
					<div class="ui-24-21-bold mega-menu-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_mega_two_1); ?></div>
					<div class="gl-s16"></div>
				<?php endif; ?>
				<?php
				if (!empty($landinstitute_select_nav_menu_mega_two_1) && is_array($landinstitute_select_nav_menu_mega_two_1) && !empty($landinstitute_select_nav_menu_mega_two_1['slug']) ) {
					wp_nav_menu(
						array(
							'menu'           => $landinstitute_select_nav_menu_mega_two_1['slug'],
							'fallback_cb'    => 'BaseTheme::nav_fallback',
							'container'      => false,
							'menu_class'     => 'dot-hover',
							'depth'          => 1,
						)
					);
				}
				?>
				</div>
				<div class="mega-col">
				<?php if (!empty($landinstitute_nav_menu_title_mega_two_2)): ?>
					<div class="ui-24-21-bold mega-menu-title"><?php echo html_entity_decode($landinstitute_nav_menu_title_mega_two_2); ?></div>
					<div class="gl-s16"></div>
				<?php endif; ?>
				<?php
				if (!empty($landinstitute_select_nav_menu_mega_two_2) && is_array($landinstitute_select_nav_menu_mega_two_2) && !empty($landinstitute_select_nav_menu_mega_two_2['slug']) ) {
					wp_nav_menu(
						array(
							'menu'           => $landinstitute_select_nav_menu_mega_two_2['slug'],
							'fallback_cb'    => 'BaseTheme::nav_fallback',
							'container'      => false,
							'menu_class'     => 'dot-hover',
							'depth'          => 1,
						)
					);
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- learn Mega Menu End -->
