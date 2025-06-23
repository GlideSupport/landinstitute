<?php if(!empty($li_faq_headline_check) || !empty($li_faq_details)): ?>
	<div class="faq-block-column <?php echo esc_attr($border_options); ?>">
	<div class="heading-max">
		<?php echo !empty($li_faq_headline_check)  ? BaseTheme::headline($li_faq_headline, 'heading-2 mb-0 block-title') . '' : ''; ?>
		<?php echo !empty($li_faq_wysiwyg) ? '<div class="gl-s30"></div> <div class="block-content body-20-18-regular">' . html_entity_decode($li_faq_wysiwyg) . '</div><div class="gl-s30"></div>' : ''; ?>
	</div>
	
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
<?php endif; ?>