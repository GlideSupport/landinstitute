<?php if(!empty($li_faq_headline_check) || !empty($li_faq_wysiwyg) || !empty($li_faq_button) || !empty($li_faq_details)): ?>
	<div class="faq-block-column faq-two-column has-border-bottom">
		<div class="row-flex">
			<div class="col-left">
				<div class="gl-s24"></div>
				<?php echo !empty($li_faq_headline_check)  ? BaseTheme::headline($li_faq_headline, 'heading-2 mb-0 block-title') . '<div class="gl-s30"></div>' : ''; ?>
				<?php echo !empty($li_faq_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_faq_wysiwyg) . '</div>' : ''; ?>
				<?php echo (!empty($li_faq_wysiwyg) && !empty($li_faq_button)) ? '<div class="gl-s30"></div>' : ''; ?>
				<?php echo !empty($li_faq_button) ? '<div class="block-btn">' . BaseTheme::button($li_faq_button, 'site-btn text-link') . '</div>' : ''; ?>
			</div>
			<div class="col-right">
			<div class="faq-block">
					<?php if(!empty($li_faq_details)): ?>
						<div class="faq_main_container">
						<?php  foreach($li_faq_details as $faq_details):
								$short_text = $faq_details['short_text'];
								$wysiwyg = $faq_details['wysiwyg'];
								if(!empty($short_text) && !empty($wysiwyg)): ?>
									<div class="faq_container">
										<?php echo !empty($short_text) 
										? '<div class="faq_question accordion-col">
											<div class="faq_question-text">
												<div class="faq-title mb-0 ui-24-21-bold">' . html_entity_decode($short_text) . '</div>
											</div>
											<div class="icon">
												<div class="icon-shape"></div>
											</div>
										</div>' 
										: ''; 
										echo !empty($wysiwyg) 
										? '<div class="answercont" style="max-height: 0px;">
											<div class="answer">
												<div class="body-20-18-regular faq-content">' . html_entity_decode($wysiwyg) . '</div>
											</div>
										</div>' 
										: ''; ?>
									</div>
								<?php endif;
							endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>