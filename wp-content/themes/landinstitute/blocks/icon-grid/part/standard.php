<?php 
if($aot_ig_headline_check OR  $aot_ig_sub_heading OR $aot_ig_items OR $aot_ig_button1 OR $aot_ig_button2):


	$aot_ig_jump_link_variation = $bst_block_fields['aot_ig_jump_link_variation'] ?? null;
$aot_ig_jump_link_text = $bst_block_fields['aot_ig_jump_link_text'] ?? null;
$aot_ig_jump_link_link = $bst_block_fields['aot_ig_jump_link_link'] ?? null;
?>
<div class="icon-grid">
    <div class="top-lft-heading max-full">
        <?php 
		echo (!empty($aot_ig_headline_check)) ? BaseTheme::headline($aot_ig_headline, 'heading-2 block-title text-yellow') : '';
		
		echo (!empty($aot_ig_headline_check) AND ( $aot_ig_sub_heading OR $aot_ig_button1 OR $aot_ig_button2)) ? '<div class="gl-s24"></div>' : '';

		echo ($aot_ig_sub_heading) ? '<div class="block-sub-content label-4xl-med text-yellow">'.html_entity_decode($aot_ig_sub_heading).'</div>' : '';
		
		echo ($aot_ig_sub_heading AND ($aot_ig_button1 OR $aot_ig_button2)) ? '<div class="gl-s48"></div>' : '';
		
		if ($aot_ig_button1 OR $aot_ig_button2 OR $aot_ig_jump_link_text OR $aot_ig_jump_link_link) :
			echo '<div class="two-btn">';

			if($aot_ig_jump_link_variation == 'link'):
				if( isset ($aot_ig_jump_link_link['url'] )):
					$link = $aot_ig_jump_link_link['url'];
					$target =  $aot_ig_jump_link_link['target'] ? $aot_ig_jump_link_link['target'] : '_self';
					$title =  $aot_ig_jump_link_link['title'] ? $aot_ig_jump_link_link['title'] : 'WHAT WE DO';
					echo '<div class="hero-btn md-d-none">';
					echo '<a href="' . esc_url($link) . '" target="' . esc_attr($target) . '" class="text-link white-link icon-btn-left" title="' . esc_attr($title) . '" role="button" aria-label="' . esc_attr($title) . '" data-text="' . esc_attr($title) . '" tabindex="0">' . esc_html($title) . '</a>';
					echo '</div>';
				endif;
			else:
				$title =  $aot_ig_jump_link_text ? $aot_ig_jump_link_text : null;
				if($title){
					echo '<div class="hero-btn md-d-none">';
					echo '<div class="text-link white-link icon-btn-left">' . esc_html($title) . '</div>';
					echo '</div>';
				}
			endif;


			echo ($aot_ig_button1) ?  BaseTheme::button($aot_ig_button1, 'site-btn') : '';
			echo ($aot_ig_button2) ? BaseTheme::button($aot_ig_button2, 'site-btn white-btn') : '';
			echo '</div>';
		endif;

		?>
    </div>
    <?php 
	if (!empty($aot_ig_items) AND ($aot_ig_headline_check OR  $aot_ig_content OR $aot_ig_button1 OR $aot_ig_button2)):
		echo '<div class="gl-s72"></div>';
	endif;
	if (!empty($aot_ig_items)):
	?>
    <div class="icon-grid-standard">
        <?php 
		foreach ($aot_ig_items as $key => $item) :
			if($item['icon'] OR $item['title'] OR $item['content'] ):
				?>
        <div class="icon-standard-column">
            <?php 
					if($item['icon'] OR $item['title']):
					?>
            <div class="card-top">
                <?php
				echo ($item['icon']) ? '<div class="card-icon">' . wp_get_attachment_image($item['icon'], 'thumb_100') . '</div>' : '';

				echo ($item['title']) ? '<div class="card-title label-xl-sbold" role="heading" aria-level="2">' . html_entity_decode($item['title']) . '</div>' : '';
				?>
            </div>
            <?php
			endif;
			echo $item['content'] ? '<div class="text-s-reg block-content">'.html_entity_decode($item['content']).'</div>' :'';
			?>
        </div>
        <?php 	
			endif;
		endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>