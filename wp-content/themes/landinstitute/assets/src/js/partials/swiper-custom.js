import Swiper from 'swiper/bundle';

document.addEventListener( 'DOMContentLoaded', function() {
	
	//Post Teaser start
	var swiper = new Swiper('.variable-slide-preview', {
		slidesPerView: 'auto',
		spaceBetween: 0,
	});
	
	const customCursor = document.createElement("div");
	customCursor.classList.add("custom-cursor");
	document.body.appendChild(customCursor);
	
	const swiperContainer = document.querySelector(".cursor-drag-icon");
	
	// Check if swiperContainer exists before adding event listeners
	if (swiperContainer) {
		swiperContainer.addEventListener("pointerenter", () => {
			customCursor.classList.add("visible");
		});
	
		swiperContainer.addEventListener("pointerleave", () => {
			customCursor.classList.remove("visible");
		});
	
		swiperContainer.addEventListener("pointermove", (e) => {
			customCursor.style.left = `${e.clientX}px`;
			customCursor.style.top = `${e.clientY}px`;
		});
	} 
	//Post Teaser end
	

	// map slider with counter start
		const speed = 2000;
		const countUp = (mapCounter) => {
			const container = mapCounter.closest(".map-counter");
			if (container.dataset.counted === "true") return;

			const targetStr = container.getAttribute("data-target");
			const target = Number(targetStr);

			// Proper empty condition check: skip if no target or invalid/negative number
			if (!targetStr || isNaN(target) || target <= 0) {
				mapCounter.innerText = '0';  // Optionally show 0 if invalid target
				container.dataset.counted = "true";
				return;
			}

			const startTime = performance.now();

			const updateCount = (currentTime) => {
				const elapsedTime = currentTime - startTime;
				const progress = Math.min(elapsedTime / speed, 1);
				const currentCount = Math.ceil(progress * target);

				mapCounter.innerText = currentCount.toLocaleString();

				if (progress < 1) {
					requestAnimationFrame(updateCount);
				} else {
					mapCounter.innerText = target.toLocaleString();
					container.dataset.counted = "true";
				}
			};

			requestAnimationFrame(updateCount);
		};

		const galleryTop = new Swiper('.map-slides', {
			spaceBetween: 0,
			speed: 1000,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev'
			},
			effect: "fade",
			fadeEffect: { crossFade: true },
			on: {
				slideChangeTransitionEnd: function () {
					const activeSlide = this.slides[this.activeIndex];
					const mapCounters = activeSlide.querySelectorAll('.map-counter .count');
					mapCounters.forEach((mapCounter) => countUp(mapCounter));
				}
			}
		});

		const galleryThumbs = new Swiper('.map-years', {
			spaceBetween: 0,
			slidesPerView: 'auto',
			slideToClickedSlide: true,
			speed: 1000,
			centeredSlides: true,
		});

		galleryTop.controller.control = galleryThumbs;
		galleryThumbs.controller.control = galleryTop;

		// Trigger counter on initial slide
		const initialSlide = galleryTop.slides[galleryTop.activeIndex];
		const initialMapCounters = initialSlide.querySelectorAll('.map-counter .count');
		initialMapCounters.forEach((mapCounter) => countUp(mapCounter));
	
	// map slider with counter end

	


} );
