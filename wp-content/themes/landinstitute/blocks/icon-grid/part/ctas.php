<?php 
if($aot_ig_headline_check OR  $aot_ig_content OR !empty($aot_ig_items) ):
?>

<div class="icon-grid">
    <?php 
	if (!empty($aot_ig_headline_check) OR $aot_ig_content ) :
	?>

    <div class="top-lft-heading">
        <?php 
		if (!empty($aot_ig_headline_check)) :
			echo BaseTheme::headline($aot_ig_headline, 'heading-2 block-title');
		endif;
		
		if (!empty($aot_ig_headline_check) AND $aot_ig_content ) :
			echo '<div class="gl-s48"></div>';	
		endif;

		if ($aot_ig_content ) :
			echo '<div class="block-sub-content text-9xl text-yellow child-text-bold" role="heading">'.html_entity_decode($aot_ig_content).'</div>';
		endif;
		?>
    </div>
    <?php 
	endif;
	if (!empty($aot_ig_items) AND ($aot_ig_headline_check OR  $aot_ig_content)):
		echo '<div class="gl-s96"></div>';
	
	endif;
	if (!empty($aot_ig_items)):
	?>

    <div class="icon-grid-cards">
        <?php 
		foreach ($aot_ig_items as $key => $item) :
			if($item['icon'] OR $item['title'] OR $item['link']):
				$link_start = '<div class="icon-grid-group">';
				$link_end = '</div>';
				if($item['link']):
					$link_title = $item['link']['title'] ? $item['link']['title'] : wp_strip_all_tags(html_entity_decode($item['title']));
					$link_start = '<a href="'.$item['link']['url'].'" target="'.$item['link']['target'].'"  role="'.'button'.'" aria-label="'.$link_title.'" data-text="'.$link_title.'" class="icon-grid-group">';
					$link_end = '</a>';
				endif;
				?>
        <div class="icon-grid-column">
            <?php 
					echo $link_start;
					if($item['icon'] OR $item['title']):
					?>
            <div class="icon-content-img">
                <?php 
							echo wp_get_attachment_image($item['icon'], 'thumb_100'); 

							echo $item['title'] ? '<div class="label-4xl-sbold icon-title">'.html_entity_decode($item["title"]).'</div>' : '';
							?>
            </div>
            <div class="gl-s36"></div>
            <?php endif; 
					echo ($item['link']) ? '<div class="arrow-round-icon"></div>' : '';
					echo $link_end;
					?>
        </div>
        <?php
			endif;
		endforeach;
		?>

    </div>
    <?php endif; ?>
</div>
<?php endif; ?>