<div class="image-gallery-block <?php echo esc_attr($border_options); ?>">
	<div class="custom-cursor"></div>
	<div class="gallery-block">
		<div class="bg-lines">
			<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/bg-lines2x-scaled.png"
				width="" height="" alt="" />
		</div>
		<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'block-heading ui-128-78-bold white_text') : ''; ?>
		<?php if (!empty($li_ig_repeater)) : ?>
		<div class="gallery-grid">
			<div class="gallery-image">
			<?php foreach ($li_ig_repeater as $li_ig_rep) :
			$image = $li_ig_rep['image'] ?? '';
			if(!empty($image)): ?>
				<?php echo !empty($image) ? '<div class="card-img">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
				<?php endif; endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>

<script>
	const galleryGrid = document.querySelector(".gallery-grid");
	const galleryBlock = document.querySelector(".gallery-block");
	const customCursor = document.querySelector(".custom-cursor");

	let isDragging = false;
	let startX = 0,
		startY = 0;
	let targetX = 0,
		targetY = 0;
	let hasDragged = false;
	let tween = null;

	let maxX = 0;
	let maxY = 0;

	function calculateBounds() {
		const isMobile = window.innerWidth <= 767;

		if (isMobile) {
			maxX = galleryBlock.clientWidth / 0.6;
			maxY = galleryBlock.clientHeight / 1.5;
		} else {
			maxX = galleryBlock.clientWidth / 2;
			maxY = galleryBlock.clientHeight / 1.5;
		}
	}

	calculateBounds();

	window.addEventListener("resize", () => {
		calculateBounds();
		targetX = Math.max(-maxX, Math.min(targetX, maxX));
		targetY = Math.max(-maxY, Math.min(targetY, maxY));
		updateTransform();
	});

	document.querySelectorAll(".gallery-grid img").forEach((img) => {
		img.setAttribute("draggable", "false");
		img.style.userSelect = "none";
		img.style.pointerEvents = "none";
	});

	function updateTransform() {
		if (tween) {
			tween.kill();
		}
		tween = gsap.to(galleryGrid, {
			x: targetX,
			y: targetY,
			duration: 0.1,
			ease: "power1.out",
		});
	}

	function getEventPosition(e) {
		if (e.type.startsWith("touch")) {
			const touch = e.touches[0] || e.changedTouches[0];
			return { x: touch.clientX, y: touch.clientY };
		}
		return { x: e.clientX, y: e.clientY };
	}

	function startDrag(e) {
		isDragging = true;
		hasDragged = false;
		const pos = getEventPosition(e);
		startX = pos.x;
		startY = pos.y;
		galleryBlock.style.cursor = "grabbing";
		document.body.style.userSelect = "none";
		customCursor.classList.add("dragging");
	}

	function moveDrag(e) {
		if (!isDragging) {
			return;
		}

		const pos = getEventPosition(e);
		const dx = pos.x - startX;
		const dy = pos.y - startY;

		if (Math.abs(dx) > 2 || Math.abs(dy) > 2) {
			hasDragged = true;
		}

		targetX += dx;
		targetY += dy;

		targetX = Math.max(-maxX, Math.min(targetX, maxX));
		targetY = Math.max(-maxY, Math.min(targetY, maxY));

		updateTransform();

		startX = pos.x;
		startY = pos.y;

		// Move custom cursor on drag
		updateCursorPosition(e);
	}

	function endDrag() {
		if (!isDragging) {
			return;
		}
		isDragging = false;
		galleryBlock.style.cursor = "grab";
		document.body.style.userSelect = "";
		customCursor.classList.remove("dragging");
	}

	// Mouse events
	galleryBlock.addEventListener("mousedown", startDrag);
	window.addEventListener("mousemove", moveDrag);
	window.addEventListener("mouseup", endDrag);
	window.addEventListener("mouseleave", endDrag);

	// Touch events
	galleryBlock.addEventListener("touchstart", startDrag, { passive: false });
	window.addEventListener("touchmove", moveDrag, { passive: false });
	window.addEventListener("touchend", endDrag);
	window.addEventListener("touchcancel", endDrag);

	// Reset on click/tap if not dragged
	galleryBlock.addEventListener("click", () => {
		if (hasDragged) {
			hasDragged = false;
			return;
		}
		targetX = 0;
		targetY = 0;
		updateTransform();
	});

	// Initial cursor style
	galleryBlock.style.cursor = "grab";

	// ----------------------------
	// CUSTOM CURSOR HANDLING
	// ----------------------------

	// Follow mouse or touch
	function updateCursorPosition(e) {
		const pos = getEventPosition(e);
		customCursor.style.left = `${pos.x}px`;
		customCursor.style.top = `${pos.y}px`;
	}

	// Show cursor
	function showCursor() {
		customCursor.style.opacity = "1";
	}

	// Hide cursor
	function hideCursor() {
		customCursor.style.opacity = "0";
		customCursor.classList.remove("dragging");
	}

	// Mouse movement for cursor
	galleryBlock.addEventListener("mousemove", updateCursorPosition);
	galleryBlock.addEventListener("mouseenter", showCursor);
	galleryBlock.addEventListener("mouseleave", hideCursor);

	// Touch movement for cursor
	galleryBlock.addEventListener(
		"touchstart",
		(e) => {
			updateCursorPosition(e);
			showCursor();
		},
		{ passive: false },
	);

	galleryBlock.addEventListener("touchmove", updateCursorPosition, {
		passive: false,
	});
	galleryBlock.addEventListener("touchend", hideCursor);
	galleryBlock.addEventListener("touchcancel", hideCursor);
</script>