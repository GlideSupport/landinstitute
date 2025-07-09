<?php 
$query = get_query_var('learn_query');
$paged = get_query_var('paged_var');

if ($query->max_num_pages > 1):
 ?>
<div class="fillter-bottom">
	<div class="pagination-container">
		<!-- Desktop Pagination -->
		<div class="desktop-pages">
			<div class="arrow-btn prev">
				<?php if ($paged > 1): ?>
					<a href="<?php echo get_pagenum_link($paged - 1); ?>" class="site-btn">Previous</a>
				<?php endif; ?>
			</div>

			<div class="pagination-list">
				<?php
				echo str_replace(
					['<ul class=\'page-numbers\'>', '</ul>', '<li>', '</li>', 'page-numbers'],
					['', '', '', '', 'page-btn'],
					paginate_links([
						'total'   => $query->max_num_pages,
						'current' => $paged,
						'type'    => 'list',
						'prev_next' => false,
					])
				);
				?>
			</div>

			<div class="arrow-btn next">
				<?php if ($paged < $query->max_num_pages): ?>
					<a href="<?php echo get_pagenum_link($paged + 1); ?>" class="site-btn">Next</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Mobile Pagination -->
		<div class="mobile-pagination">
			<a id="prevBtn" class="arrow-btn <?php if ($paged <= 1) echo 'disabled'; ?>" href="<?php echo ($paged > 1) ? get_pagenum_link($paged - 1) : '#'; ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Previous">
			</a>

			<span id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo $paged . '/' . $query->max_num_pages; ?></span>

			<a id="nextBtn" class="arrow-btn <?php if ($paged >= $query->max_num_pages) echo 'disabled'; ?>" href="<?php echo ($paged < $query->max_num_pages) ? get_pagenum_link($paged + 1) : '#'; ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Next">
			</a>
		</div>

		<!-- Mobile Popup -->
		<div id="paginationPopup" class="pagination-popup">
			<div class="popup-body">
				<div id="popupGrid" class="popup-grid">
					<?php for ($i = 1; $i <= $query->max_num_pages; $i++) : ?>
						<a href="<?php echo get_pagenum_link($i); ?>" class="page-btn <?php echo ($paged == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
					<?php endfor; ?>
				</div>
				<button id="popupPrev" class="arrow-btn"></button>
				<button id="popupNext" class="arrow-btn"></button>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
