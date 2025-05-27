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
		if (!container || container.dataset.counted === "true") return;

		const targetStr = container.getAttribute("data-target");
		const target = Number(targetStr);

		if (!targetStr || isNaN(target) || target <= 0) {
			mapCounter.innerText = '0';
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

	// Swiper main
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

				mapCounters.forEach((mapCounter) => {
					observer.observe(mapCounter.closest('.map-counter'));
				});
			}
		}
	});

	// Swiper thumbs
	const galleryThumbs = new Swiper('.map-years', {
		spaceBetween: 0,
		slidesPerView: 'auto',
		slideToClickedSlide: true,
		speed: 1000,
		centeredSlides: true,
	});

	galleryTop.controller.control = galleryThumbs;
	galleryThumbs.controller.control = galleryTop;

	// IntersectionObserver to trigger countUp only when in view
	const observerOptions = {
		threshold: 0.3, // Trigger when 30% of the element is in view
	};

	const observer = new IntersectionObserver((entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				const mapCounter = entry.target.querySelector('.count');
				if (mapCounter) {
					countUp(mapCounter);
					observer.unobserve(entry.target); // Stop observing once counted
				}
			}
		});
	}, observerOptions);

	// Trigger for initial slide
	const initialSlide = galleryTop.slides[galleryTop.activeIndex];
	const initialMapCounters = initialSlide.querySelectorAll('.map-counter');
	initialMapCounters.forEach((counterContainer) => observer.observe(counterContainer));

	// map slider with counter end


	


} );
