<?php 
$ch_hero_home = $bst_block_fields['ch_hero_home'] ?? null;
$animation_text = $ch_hero_home['animation_text'] ?? null;
$image = $ch_hero_home['image'] ?? null;
$google_review = $ch_hero_home['google_review'] ?? null;
$google_review_icon = $google_review['icon'] ?? null;
$google_review_text = $google_review['text'] ?? null;
$graphic_image = $ch_hero_home['graphic_image'] ?? 'one';
$button = $ch_hero_home['button'] ?? null;

if(!empty($ch_hero_headline_check) OR !empty($animation_text) OR $image OR $google_review_icon OR $google_review_text OR $button['button_link']):
?>

<section class="container-1180 home-banner <?php echo ($graphic_image == 'two') ? 'variation-home-employers' : "";  ?>">
	<div class="wrapper">
		<div class="site-banner <?php echo ($graphic_image == 'two') ? 'with-top-shape' : "with-top-shape";  ?>">
			<div class="row-flex">
				<div class="col-left">
					<div class="gl-s72"></div>
					<?php 
					if($google_review_icon OR $google_review_text):
					?>
					<div class="google-eyebrow">
						<?php 
							echo wp_get_attachment_image($google_review_icon, 'thumb_100');
							echo $google_review_text ? '<div class="google-content">'.html_entity_decode($google_review_text).'</div>' : '';
						?>
					</div>
					<div class="gl-s24"></div>
					<?php
					endif;
					?>
					<div class="col-content">
						<?php 
						if(!empty($ch_hero_headline_check)):
							
							$tag = $ch_hero_headline['ch_hero_headline_title_tag'];
							$title = $ch_hero_headline['ch_hero_headline_title'];
							?>
							<<?php echo esc_html($tag); ?> class="heading-1 mb-0 block-heading words-wrapper heading-bold">
							<?php 
							echo html_entity_decode($title);
							if(!empty($animation_text)):
								echo '<span class="animate-text">';
								foreach ($animation_text as $key => $data) :
									echo ($data['text'] != '') ? '<span class="title">'.esc_html($data['text']).'</span>' : '';
								endforeach;
								echo '</span>';
							endif; ?>
							</<?php echo esc_html($tag); ?>>
							<?php
						endif;
						?>
					</div>
					<div class="gl-s48"></div>
					<div class="two-btn-row">
						<?php 
						if($graphic_image == 'one'):
							echo do_shortcode('[job-search]');
						endif;
						if($graphic_image == 'two'):
							if(!empty($button['button_link'])):
								echo BaseTheme::render_button($button);
							endif;
						endif;

						?>
					</div>
				</div>
				<div class="col-right">
				<?php 
				if($image):
					?>
					<div class="circle-shape"></div>
					<div class="vector-shape">
						<div class="shape1"></div>
						<div class="shape2"></div>
					</div>
						<?php echo wp_get_attachment_image($image, 'thumb_800')  ?>
					<?php 
					else:
						echo '<picture>';
                        $thumbnail = esc_url(get_stylesheet_directory_uri().'/assets/src/images/default-image.webp');
                        echo '<img src="'.esc_attr($thumbnail).' " alt="Hero Section" width="662" height="662">';
                        echo '</picture>';	
				endif;

				?>
				</div>
			</div>
			<?php 
			if($graphic_image == 'one'):
			$parsed_url = parse_url(get_stylesheet_directory_uri().'/assets/src/images/animation-image/home-animation.svg');
			endif;
			if($graphic_image == 'two'):
			$parsed_url = parse_url(get_stylesheet_directory_uri().'/assets/src/images/animation-image/home-animation-2.svg');
			endif;
			$img_url = isset( $parsed_url['path'] ) ? ltrim( $parsed_url['path'], '/' ) : '';
			echo '<div class="vector-animation-image relative-z">'.file_get_contents($img_url).'</div>';
			?>
		</div>
	</div>
</section>
<?php endif; ?>