<?php
$total_pages   = $news->max_num_pages;

$current_page = isset($_POST['paged']) ? intval($_POST['paged']) : 1;


//$current_page  = max(1, get_query_var('paged') ? get_query_var('paged') : 1);

$base_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($total_pages > 1): ?>
<div class="fillter-bottom">
    <div class="pagination-container news-pagination-append-container">

        <!-- Desktop Pagination -->
        <div class="desktop-pages">
            <!-- Prev -->
            <div class="arrow-btn prev <?php echo $current_page === 1 ? 'disabled' : ''; ?>">
                <?php if ($current_page > 1): ?>
                    <a class="site-btn" href="<?php echo trailingslashit($base_url) . 'page/' . ($current_page - 1); ?>" rel="prev" data-page="<?php echo $current_page - 1; ?>">Previous</a>
                <?php else: ?>
                    <span class="site-btn">Previous</span>
                <?php endif; ?>
            </div>

            <!-- Page Numbers -->
            <div class="pagination-list">
                <?php
                $range = 2;
                $dots_shown = false;
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) {
                        $page_url = ($i === 1) ? trailingslashit($base_url) : trailingslashit($base_url) . 'page/' . $i;
                        echo '<a class="page-btn' . ($i === $current_page ? ' active' : '') . '" href="' . esc_url($page_url) . '" data-page="' . $i . '">' . $i . '</a>';
                        $dots_shown = false;
                    } elseif (!$dots_shown) {
                        echo '<span class="dots">...</span>';
                        $dots_shown = true;
                    }
                }
                ?>
            </div>

            <!-- Next -->
            <div class="arrow-btn next <?php echo $current_page === $total_pages ? 'disabled' : ''; ?>">
                <?php if ($current_page < $total_pages): ?>
                    <a class="site-btn" href="<?php echo trailingslashit($base_url) . 'page/' . ($current_page + 1); ?>" rel="next" data-page="<?php echo $current_page + 1; ?>">Next</a>
                <?php else: ?>
                    <span class="site-btn">Next</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Pagination -->
        <div class="mobile-pagination">
            <a id="prevBtn" class="arrow-btn <?php echo $current_page === 1 ? 'disabled' : ''; ?>"
               href="<?php echo $current_page > 1 ? trailingslashit($base_url) . 'page/' . ($current_page - 1) : '#'; ?>"
               rel="prev" data-page="<?php echo max(1, $current_page - 1); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Previous" />
            </a>

            <span id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo $current_page . '/' . $total_pages; ?></span>

            <a id="nextBtn" class="arrow-btn <?php echo $current_page === $total_pages ? 'disabled' : ''; ?>"
               href="<?php echo $current_page < $total_pages ? trailingslashit($base_url) . 'page/' . ($current_page + 1) : '#'; ?>"
               rel="next" data-page="<?php echo min($total_pages, $current_page + 1); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" alt="Next" />
            </a>
        </div>

        <!-- Mobile Popup -->
        <div id="paginationPopup" class="pagination-popup">
            <div class="popup-body">
                <div id="popupGrid" class="popup-grid">
                    <?php for ($i = 1; $i <= $total_pages; $i++) :
                        $page_url = ($i === 1) ? trailingslashit($base_url) : trailingslashit($base_url) . 'page/' . $i; ?>
                        <a class="page-btn <?php echo $i === $current_page ? 'active' : ''; ?>" href="<?php echo esc_url($page_url); ?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
                <button id="popupPrev" class="arrow-btn" data-page="<?php echo max(1, $current_page - 1); ?>"></button>
                <button id="popupNext" class="arrow-btn" data-page="<?php echo min($total_pages, $current_page + 1); ?>"></button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
