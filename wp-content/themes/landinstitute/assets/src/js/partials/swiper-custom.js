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
	if (initialSlide) {
		const initialMapCounters = initialSlide.querySelectorAll('.map-counter');
		initialMapCounters.forEach((counterContainer) => observer.observe(counterContainer));
	}

	// map slider with counter end

	//Timeline js start

	const timelineBlocks = document.querySelectorAll(".timeline-block");
	timelineBlocks.forEach((block, index) => {
		const slider = block.querySelector(".timeline-slider");
		const nextBtn = block.querySelector(".swiper-button-next");
		const prevBtn = block.querySelector(".swiper-button-prev");

		// Generate unique class names
		const nextClass = `swiper-button-next-${index}`;
		const prevClass = `swiper-button-prev-${index}`;

		// Assign unique classes to nav buttons
		nextBtn.classList.add(nextClass);
		prevBtn.classList.add(prevClass);

		// Initialize Swiper for each instance
		new Swiper(slider, {
			loop: true,
			centeredSlides: true,
			slidesPerView: 1,
			spaceBetween: 0,
			navigation: {
				nextEl: `.${nextClass}`,
				prevEl: `.${prevClass}`,
			},
			breakpoints: {
				640: {
					slidesPerView: 2,
					centeredSlides: false,
				},
				1028: {
					slidesPerView: 2,
					centeredSlides: false,
				},
				1920: {
					slidesPerView: 2,
					centeredSlides: false,
				},
			},
		});
	});
	
	//Timeline js end

	//CTA Card Slide js start
	const ctaSliders = document.querySelectorAll('.cta-card-slide');
	if (!ctaSliders.length) return;
	ctaSliders.forEach((slider, index) => {
		slider.classList.add(`cta-card-slide-${index}`);

		new Swiper(slider, {
			loop: false,
			slidesPerView: 1,
			spaceBetween: 0,
			breakpoints: {
				1920: {
					slidesPerView: 4,
					spaceBetween: 0
				},
				1028: {
					slidesPerView: 4,
					spaceBetween: 0
				},
				641: {
					slidesPerView: 3,
					spaceBetween: 0
				},
				580: {
					slidesPerView: 2.5,
					spaceBetween: 0
				},
				375: {
					slidesPerView: 1.5,
					spaceBetween: 0
				}
			}
		});
	});
	//CTA Card Slide js end

	
	// Testimonial Single View Slider start
	const testimonial_single_view_Sliders = document.querySelectorAll(".testimonial-single-view-slider");

	testimonial_single_view_Sliders.forEach((sliderWrapper, index) => {
		const slider = sliderWrapper.querySelector(".single-view-slide");
		const nextBtn = sliderWrapper.querySelector(".swiper-button-next");
		const prevBtn = sliderWrapper.querySelector(".swiper-button-prev");

		// Generate unique class names
		const nextClass = `swiper-button-next-${index}`;
		const prevClass = `swiper-button-prev-${index}`;

		// Assign unique classes to nav buttons (only if they exist)
		if (nextBtn) nextBtn.classList.add(nextClass);
		if (prevBtn) prevBtn.classList.add(prevClass);

		// Count slides
		const slidesCount = slider.querySelectorAll(".swiper-slide").length;

		// Hide arrows if only one slide
		if (slidesCount <= 1) {
			if (nextBtn) nextBtn.style.display = 'none';
			if (prevBtn) prevBtn.style.display = 'none';
		}

		// Initialize Swiper
		new Swiper(slider, {
			loop: slidesCount > 1,
			slidesPerView: 1,
			spaceBetween: 10,
			navigation: {
				nextEl: nextBtn ? `.${nextClass}` : null,
				prevEl: prevBtn ? `.${prevClass}` : null,
			},
		});
	});
	// Testimonial Single View Slider end


	


} );
