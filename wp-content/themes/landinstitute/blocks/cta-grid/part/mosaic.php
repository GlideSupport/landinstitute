<?php if (!empty($li_cg_headline_check) || !empty($li_cg_repeater_mosaic)): ?>
	<div class="cta-grid-mosaic-block">
		<?php echo !empty($li_cg_headline_check) ? BaseTheme::headline($li_cg_headline, 'heading-2 mb-0 block-title') : ''; ?>
		<div class="gl-s44"></div>
		<div class="cta-grid-box-row">
			<?php 
			$index_words = ['one', 'two', 'three', 'four', 'five', 'six'];
			foreach ($li_cg_repeater_mosaic as $index => $item) :
				$title = $item['title'] ?? '';
				$text = $item['text'] ?? '';
				$link = $item['link'] ?? [];
				$image = $item['image'] ?? '';
				$vector_icon = $item['vector_icon'] ?? '';
				$url = $link['url'];
				$target = $link['target'] ?? '_self';
				$item_class = '';
				// Optional: Define CSS class based on index (0 = item-one, etc.)
				$item_class = 'item-' . ($index_words[$index] ?? ('num-' . ($index + 1)));
				// Optional: Assign size class manually (e.g., every third = big-box)
				$box_size_class = in_array($index, [0, 5]) ? 'big-box' : 'sm-box'; ?>
				<div class="cta-grid-box-col <?php echo esc_attr("$box_size_class $item_class"); ?>">
					<?php echo !empty($link) ? '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '" class="cta-grid-click">' : '<div class="cta-grid-click">'; ?>
						<div class="cta-contents">
							<?php echo $title ? '<div class="ui-26-23-bold box-title">' . esc_html($title) . '</div><div class="gl-s4"></div>' : ''; ?>
							<?php echo $text ? '<div class="box-content body-20-18-regular">' . esc_html($text) . '</div>' : ''; ?>
						</div>
						<?php echo !empty($image) ? '<div class="cta-image">' . (in_array($index, [2, 3]) ? '<div class="raidus-mask">' . wp_get_attachment_image($image, 'thumb_500') . '</div><div class="vector-icon">' . wp_get_attachment_image($vector_icon, 'thumb_200') . '</div>' : wp_get_attachment_image($image, 'thumb_900')) . '</div>' : ''; ?>
					<?php echo !empty($link) ? '</a>' : '</div>'; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
