<?php
//Theme options fields
$li_hero_to_choose_video_type = $bst_option_fields['li_hero_to_choose_video_type'] ?? null;
$li_hero_to_image_video_thumbnail = $bst_option_fields['li_hero_to_image_video_thumbnail'] ?? null;
$video_thumb_url = esc_url(wp_get_attachment_url($li_hero_to_image_video_thumbnail));
$youtube_id = $bst_option_fields['li_hero_to_youtube_video_embed_id'] ?? null;
$vimeo_id = $bst_option_fields['li_hero_to_vimeo_video_embed_id'] ?? null;
$video_file = $bst_option_fields['li_hero_to_video_file'] ?? null;
$li_hero_to_title = $bst_option_fields['li_hero_to_title'] ?? null;
$li_hero_to_text = $bst_option_fields['li_hero_to_text'] ?? null;


//Block Fields
$li_hero_home = $bst_block_fields['li_hero_home'] ?? null;
$button = $li_hero_home['button'] ?? null;
$image = $li_hero_home['image'] ?? null;
$bg_image = $li_hero_home['bg_image'] ?? null;
$show_hide_announcement = $li_hero_home['show_hide_announcement'] ?? null;


if (!empty($li_hero_headline_check) || !empty($button) || !empty($image) || !empty($bg_image)): ?>
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-pattern">
		<?php echo !empty($bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
		<div class="hero-default <?php echo esc_attr($border_options); ?>">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left <?php echo esc_attr($bg_color); ?>">
						<div class="left-content">
							<?php echo !empty($li_hero_headline_check) ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
							<?php echo (!empty($li_hero_headline_check) && !empty($button)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($button) ? '<div class="block-btn">' . BaseTheme::button($button, 'site-btn text-link') . '</div>' : ''; ?>
							<?php if (!empty($button) || !empty($li_hero_to_image_video_thumbnail) || !empty($li_hero_to_choose_video_type) || !empty($li_hero_to_title) || !empty($li_hero_to_text)) : ?>
								<div class="gl-s64"></div>
							<?php endif; ?>
							<?php if (!empty($li_hero_to_image_video_thumbnail) || !empty($li_hero_to_choose_video_type) || !empty($li_hero_to_title) || !empty($li_hero_to_text)) :?>
								<?php if($show_hide_announcement == '1'): ?>
									<div class="announcement-toggle">
										<?php if (!empty($li_hero_to_choose_video_type)) : ?>
										<div class="announcement-left">
												<div class="announcement-image">
												<?php if (!empty($li_hero_to_image_video_thumbnail)) : ?>
													<div class="video-mask"></div>
														<?php echo wp_get_attachment_image($li_hero_to_image_video_thumbnail, "thumb_200"); ?>
												<?php else : ?>
														<?php
														$thumbnail = esc_url(BASETHEME_DEFAULT_IMAGE);
														if ($li_hero_to_choose_video_type === 'youtube') {
															$thumbnail = "https://img.youtube.com/vi/" . esc_attr($youtube_id) . "/sddefault.jpg";
														}
														if ($li_hero_to_choose_video_type === 'vimeo') {
															$thumbnail = BaseTheme::getVimeoThumbnail($vimeo_id);
														}
														?>
														<img src="<?php echo esc_url($thumbnail); ?>" width="129" height="85" alt="video-thumb" />
												<?php endif; ?>
													<div class="video-play">
														<!-- TO DO -->
														<?php
														if ($li_hero_to_choose_video_type === 'image') {
															echo wp_get_attachment_image($video_thumb, 'thumb_200', false, array('class' => 'videos'));
														} elseif ($li_hero_to_choose_video_type === 'youtube' && !empty($youtube_id)) { ?>
															<iframe class="videos youtube" width="100%" height="100%" loading="lazy"
																src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?&autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($youtube_id); ?>&color=white&controls=0&modestbranding=1&playsinline=1&rel=0&enablejsapi=1"
																allowfullscreen></iframe>
															<?php
														} elseif ($li_hero_to_choose_video_type === 'vimeo' && !empty($vimeo_id)) { ?>
															<iframe class="videos vimeo" width="100%" height="100%" loading="lazy"
																src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_id); ?>?&background=1&title=0&byline=0&portrait=0&sidedock=0&controls=0"></iframe>
															<?php
														} elseif ($li_hero_to_choose_video_type === 'upload' && !empty($video_file)) { ?>
															<video class="videos" playsinline="playsinline" muted="muted" preload="none"
																autoplay="autoplay" loop="loop" poster="<?php echo $video_thumb_url; ?>"
																data-video-init="">
																<source src="<?php echo esc_url(wp_get_attachment_url($video_file)); ?>"
																	type="video/mp4">
															</video>
															<?php
														} elseif (!empty($video_thumb)) { ?>
															<video class="videos" playsinline="playsinline" muted="muted" preload="metadata"
																autoplay="autoplay" loop="loop" poster="<?php echo $video_thumb_url; ?>"
																data-video-init="">
															</video>
														<?php } ?>
													</div>
												</div>
											</div>
										<?php endif; ?>
										<?php if (!empty($li_hero_to_title) || !empty($li_hero_to_text)): ?>
											<div class="announcement-right">
												<?php echo !empty($li_hero_to_title) ? '<div class="ui-18-16-bold cta-title">' . esc_html($li_hero_to_title) . '</div>' : ''; ?>
												<?php echo (!empty($li_hero_to_title) || !empty($li_hero_to_text)) ? '<div class="gl-s4"></div>' : ''; ?>
												<?php echo !empty($li_hero_to_text) ? '<div class="ui-18-16-regular cta-content">' . esc_html($li_hero_to_text) . '</div>' : ''; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-right">
						<?php echo !empty($image) ? '<div class="block-image-center">' . wp_get_attachment_image($image, 'thumb_900') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>