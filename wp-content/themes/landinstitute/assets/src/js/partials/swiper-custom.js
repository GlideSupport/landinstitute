import Swiper from "swiper/bundle";

document.addEventListener("DOMContentLoaded", function () {

	// Initialize multiple timeline fancy sliders
	document.querySelectorAll('.timeline-slider-fancy').forEach((el) => {
        new Swiper(el, {
            loop: false,
            initialSlide: 0,
            observer: true,
            observeParents: true,
            updateOnWindowResize: true,
            centeredSlides: false,
            slidesPerView: 1.2,
            spaceBetween: 0,
            navigation: {
                nextEl: el.closest('.swiper-container-wrapper')?.querySelector('.swiper-button-next'),
                prevEl: el.closest('.swiper-container-wrapper')?.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                640: {
                    slidesPerView: 2.285,
                    spaceBetween: 0,
                    centeredSlides: false,
                },
                1028: {
                    slidesPerView: 2.285,
                    spaceBetween: 0,
                    centeredSlides: false,
                },
                1920: {
                    slidesPerView: 2.285,
                    spaceBetween: 0,
                    centeredSlides: false,
                },
            },
        });
    });

	// Initialize multiple post teaser sliders
	document.querySelectorAll(".variable-slide-preview").forEach((el) => {
		new Swiper(el, {
			slidesPerView: "auto",
			spaceBetween: 0,
		});
	});

	// Create one global custom cursor element
	let customCursor = document.querySelector(".custom-cursor");
	if (!customCursor) {
		customCursor = document.createElement("div");
		customCursor.classList.add("custom-cursor");
		document.body.appendChild(customCursor);
	}

	// Add cursor behavior for all drag-icon zones
	document.querySelectorAll(".cursor-drag-icon").forEach((container) => {
		container.addEventListener("pointerenter", () => {
			customCursor.classList.add("visible");
		});
		container.addEventListener("pointerleave", () => {
			customCursor.classList.remove("visible");
		});
		container.addEventListener("pointermove", (e) => {
			customCursor.style.left = `${e.clientX}px`;
			customCursor.style.top = `${e.clientY}px`;
		});
	});

	// Remove custom cursor when hovering over border-text-btn elements
	document.querySelectorAll(".border-text-btn").forEach((btn) => {
		btn.addEventListener("pointerenter", () => {
			customCursor.classList.remove("visible");
		});
		btn.addEventListener("pointerleave", () => {
			// Check if we're still inside a cursor-drag-icon container
			const dragContainer = btn.closest(".cursor-drag-icon");
			if (dragContainer) {
				customCursor.classList.add("visible");
			}
		});
	});
	//end

	// CTA Slider JS start
	document.querySelectorAll(".cta-slider-box").forEach((wrapper, index) => {
		const swiperContainer = wrapper.querySelector(".cta-work-slider");
		const counterEl = wrapper.querySelector(".slide-counter");
		const nextBtn = wrapper.querySelector(".swiper-button-next");
		const prevBtn = wrapper.querySelector(".swiper-button-prev");
		const arrowBtns = wrapper.querySelectorAll(".slider-btn");

		if (!swiperContainer || !nextBtn || !prevBtn) return;

		const slides = swiperContainer.querySelectorAll(".swiper-slide");
		const totalSlides = slides.length;

		if (totalSlides <= 1) {
			if (counterEl) {
				counterEl.style.display = "none";
			}
			// Hide navigation buttons
			arrowBtns.forEach((btn) => {
				btn.style.display = "none";
			});
			return; // Don't initialize Swiper for single slide
		}

		// Add unique classes to avoid cross-slider control conflicts
		const uniqueClass = `cta-work-slider-${index}`;
		swiperContainer.classList.add(uniqueClass);
		nextBtn.classList.add(`next-${index}`);
		prevBtn.classList.add(`prev-${index}`);

		// Initialize Swiper
		const swiper = new Swiper(`.${uniqueClass}`, {
			loop: false,
			effect: "fade",
			autoHeight: true,
			fadeEffect: { crossFade: true },
			slidesPerView: 1,
			spaceBetween: 0,
			navigation: {
				nextEl: `.next-${index}`,
				prevEl: `.prev-${index}`,
			},
			on: {
				init: function () {
					updateCounter(this);
					updateArrowPosition();
				},
				slideChangeTransitionEnd: function () {
					updateCounter(this);
					updateArrowPosition();
				},
			},
		});

		function updateCounter(swiperInstance) {
			if (!counterEl) return;

			// Ensure correct nested div is selected
			const realSlides = swiperInstance.slides.filter(
				(slide) => !slide.classList.contains("swiper-slide-duplicate"),
			);
			const totalSlides = realSlides.length;

			if (totalSlides <= 1) {
				counterEl.style.display = "none";
			} else {
				const currentIndex = swiperInstance.realIndex + 1;
				const formattedCurrent = String(currentIndex).padStart(2, "0");
				const formattedTotal = String(totalSlides).padStart(2, "0");
				counterEl.textContent = `${formattedCurrent} / ${formattedTotal}`;
				counterEl.style.display = "block";
			}
		}

			function updateArrowPosition() {
				const activeSlide = wrapper.querySelector(".swiper-slide-active");
				if (!activeSlide) return;

				const currentContent = activeSlide.querySelector(".cl-left .slide-content");
				if (!currentContent) return;

				const height = currentContent.offsetHeight;
				const offset = 26;
				const arrowTop = `${height + offset}px`;

				arrowBtns.forEach((btn) => {
					btn.style.top = arrowTop;
				});
			}


		// Make sure arrow position adjusts on window resize
		window.addEventListener("resize", updateArrowPosition);
	});
	// CTA Slider JS end
	

	// Map slider with counter start
	document.querySelectorAll(".impact-map-block").forEach((blockWrapper) => {
		const speed = 2000;

		const countUp = (mapCounter) => {
			const container = mapCounter.closest(".map-counter");
			if (!container || container.dataset.counted === "true") return;

			const startStr = container.getAttribute("data-start");
			const endStr = container.getAttribute("data-end");
			const start = Number(startStr);
			const end = Number(endStr);

			if (
				!startStr || !endStr ||
				isNaN(start) || isNaN(end) ||
				start === end
			) {
				mapCounter.innerText = end.toLocaleString();
				container.dataset.counted = "true";
				return;
			}

			const startTime = performance.now();

			const updateCount = (currentTime) => {
				const elapsedTime = currentTime - startTime;
				const progress = Math.min(elapsedTime / speed, 1);
				const currentCount = Math.floor(start + (end - start) * progress);
				mapCounter.innerText = currentCount.toLocaleString();

				if (progress < 1) {
					requestAnimationFrame(updateCount);
				} else {
					mapCounter.innerText = end.toLocaleString();
					container.dataset.counted = "true";
				}
			};

			requestAnimationFrame(updateCount);
		};

		const mapSlides = blockWrapper.querySelector(".map-slides");
		const mapYears = blockWrapper.querySelector(".map-years");
		const nextBtn = blockWrapper.querySelector(".swiper-button-next");
		const prevBtn = blockWrapper.querySelector(".swiper-button-prev");

		if (!mapSlides) return;

		// Swiper main
		const galleryTop = new Swiper(mapSlides, {
			spaceBetween: 0,
			speed: 1000,
			navigation:
				nextBtn && prevBtn
					? {
							nextEl: nextBtn,
							prevEl: prevBtn,
					  }
					: false,
			effect: "fade",
			fadeEffect: { crossFade: true },
			touchRatio: 1,
            simulateTouch: true,
            allowTouchMove: true,
			on: {
				slideChangeTransitionEnd: function () {
					const activeSlide = this.slides[this.activeIndex];
					const mapCounters = activeSlide.querySelectorAll(
						".map-counter .count"
					);
					mapCounters.forEach((mapCounter) => {
						observer.observe(mapCounter.closest(".map-counter"));
					});
				},
			},
		});

		// Swiper thumbs
		if (mapYears) {
			const galleryThumbs = new Swiper(mapYears, {
				spaceBetween: 0,
				slidesPerView: "auto",
				slideToClickedSlide: true,
				speed: 1000,
				centeredSlides: true,
			});

			galleryTop.controller.control = galleryThumbs;
			galleryThumbs.controller.control = galleryTop;
		}

		// IntersectionObserver for countUp
		const observerOptions = { threshold: 0.3 };
		const observer = new IntersectionObserver((entries, observer) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const mapCounter = entry.target.querySelector(".count");
					if (mapCounter) {
						countUp(mapCounter);
						observer.unobserve(entry.target);
					}
				}
			});
		}, observerOptions);

		// Trigger observer on initial slide
		const initialSlide = galleryTop.slides[galleryTop.activeIndex];
		if (initialSlide) {
			const initialMapCounters = initialSlide.querySelectorAll(".map-counter");
			initialMapCounters.forEach((counterContainer) =>
				observer.observe(counterContainer)
			);
		}
	});
	// Map slider with counter end

	// Timeline js start
	const timelineBlocks = document.querySelectorAll(".timeline-block"); timelineBlocks.forEach((block, index) => {
		const slider = block.querySelector(".timeline-slider");
		const nextBtn = block.querySelector(".swiper-button-next");
		const prevBtn = block.querySelector(".swiper-button-prev");

		// Skip if essential elements are missing
		if (!slider || !nextBtn || !prevBtn) return;

		// Generate unique class names
		const nextClass = `swiper-button-next-${index}`;
		const prevClass = `swiper-button-prev-${index}`;

		// Assign unique classes to nav buttons
		nextBtn.classList.add(nextClass);
		prevBtn.classList.add(prevClass);

		// Initialize Swiper for each instance
		new Swiper(slider, {
			loop: false,
			slidesPerView: 1.28,
			spaceBetween: 0,
			navigation: {
				nextEl: `.${nextClass}`,
				prevEl: `.${prevClass}`,
			},
			breakpoints: {
				480: {
					slidesPerView: 1.8,
					spaceBetween: 0,
				},
				767: {
					slidesPerView: 2.2,
					spaceBetween: 0,
				},
				1028: {
					slidesPerView: 2.43,
					spaceBetween: 0,
				},
				1920: {
					slidesPerView: 2.43,
					spaceBetween: 0,
				},
			},
			on: {
				init(swiper) {
					swiper.slideTo(0, 0); // Scroll to slide index 3 on init
				}
			},
		});
	});
	// Timeline js end

	// Testimonial Traditional js start
	const sliderWrappers = document.querySelectorAll( ".testimonial-traditional-block");
	sliderWrappers.forEach((wrapper, index) => {
		const swiperContainer = wrapper.querySelector(".traditional-slide");
		const swiperWrapper = swiperContainer?.querySelector(".swiper-wrapper");
		const slides = swiperWrapper?.querySelectorAll(".swiper-slide");

		// Use wrapper class as unique ID (e.g., "tslider_xxxxx")
		const wrapperClass = [...wrapper.classList].find((cls) =>
			cls.startsWith("tslider_"),
		);

		// Skip if container or slides are missing or less than 1 slide
		if (
			!swiperContainer ||
			!swiperWrapper ||
			!slides ||
			slides.length < 1 ||
			!wrapperClass
		)
			return;

		// Add unique class to swiper container
		swiperContainer.classList.add(wrapperClass + "-container");

		const nextBtn = wrapper.querySelector(`.next-${wrapperClass}`);
		const prevBtn = wrapper.querySelector(`.prev-${wrapperClass}`);

		new Swiper(`.${wrapperClass}-container`, {
			loop: false,
			slidesPerView: 1,
			spaceBetween: 20,
			navigation: {
				nextEl: nextBtn || null,
				prevEl: prevBtn || null,
			},
		});
	});
	// Testimonial Traditional js end

	// Testimonial Single View Slider start
	const testimonial_single_view_Sliders = document.querySelectorAll( ".testimonial-single-view-slider");
	testimonial_single_view_Sliders.forEach((sliderWrapper, index) => {
		const slider = sliderWrapper.querySelector(".single-view-slide");
		if (!slider) return; // Skip if the slider container is missing

		const slideElements = slider.querySelectorAll(".swiper-slide");
		if (!slideElements.length) return; // Skip if there are no slides

		const nextBtn = sliderWrapper.querySelector(".swiper-button-next");
		const prevBtn = sliderWrapper.querySelector(".swiper-button-prev");

		// Generate unique class names
		const nextClass = `swiper-button-next-${index}`;
		const prevClass = `swiper-button-prev-${index}`;

		// Assign unique classes to nav buttons
		if (nextBtn) nextBtn.classList.add(nextClass);
		if (prevBtn) prevBtn.classList.add(prevClass);

		// Hide arrows if only one slide
		if (slideElements.length <= 1) {
			if (nextBtn) nextBtn.style.display = "none";
			if (prevBtn) prevBtn.style.display = "none";
		}

		// Initialize Swiper
		new Swiper(slider, {
			loop: false,
			slidesPerView: 1,
			spaceBetween: 10,
			navigation: {
				nextEl: nextBtn ? `.${nextClass}` : null,
				prevEl: prevBtn ? `.${prevClass}` : null,
			},
		});
	});
	// Testimonial Single View Slider end

	// CTA Card Slide js start
	const ctaSliders = document.querySelectorAll(".cta-card-slide");

	ctaSliders.forEach((slider, index) => {
		if (!slider) return;

		// Optional: Add unique class for debugging or styling
		slider.classList.add(`cta-card-slide-${index}`);

		new Swiper(slider, {
			loop: false,
			slidesPerView: 1,
			spaceBetween: 0,
			breakpoints: {
				375: {
					slidesPerView: 1.5,
					spaceBetween: 0,
				},
				580: {
					slidesPerView: 2.5,
					spaceBetween: 0,
				},
				641: {
					slidesPerView: 3,
					spaceBetween: 0,
				},
				1028: {
					slidesPerView: 4,
					spaceBetween: 0,
				},
				1920: {
					slidesPerView: 4,
					spaceBetween: 0,
				},
			},
		});
	});
	// CTA Card Slide js end


	// New Page slider start
	const logolistslider = document.querySelector('.logolist-wrapp');

	if (logolistslider) {
		new Swiper(logolistslider, {
			loop: false,
			navigation: false,
			slidesPerView: 1.26,
			spaceBetween: 32,
			breakpoints: {
				1024: {
					slidesPerView: 4,
					spaceBetween: 44,
				},
				768: {
					slidesPerView: 2.5,
				},
				480: {
					slidesPerView: 2.2,
				}
			}
		});
	}
	// New Page slider end

	//Event detail page js code start
	const swiperEl = document.querySelector('.read-slide-preview');
	if (swiperEl) {
		const swiper = new Swiper(swiperEl, {
			slidesPerView: 1,
			spaceBetween: 0,
			breakpoints: {
				480: {
					slidesPerView: 2,
					spaceBetween: 0
				},
				1028: {
					slidesPerView: 3,
					spaceBetween: 0
				},
				1920: {
					slidesPerView: 3,
					spaceBetween: 0
				}
			}
		});
	}

	// Custom cursor logic if .cursor-drag-icon exists
	const swiperContainer = document.querySelector(".cursor-drag-icon");

	if (swiperContainer) {
		const customCursor = document.createElement("div");
		customCursor.classList.add("custom-cursor");
		document.body.appendChild(customCursor);

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
	//Event detail page js code end

	//Image gallery slider code start
		document.querySelectorAll('.image-gallery-slider').forEach((sliderEl, index) => {
			new Swiper(sliderEl, {
				loop: true,
				navigation: {
					nextEl: sliderEl.parentElement.querySelector('.swiper-button-next'),
					prevEl: sliderEl.parentElement.querySelector('.swiper-button-prev'),
				},
				centeredSlides: false,
				slidesPerView: 1.5,
				spaceBetween: 16,
				breakpoints: {
					375: {
						slidesPerView: 1.27,
						spaceBetween: 16,
					},
					641: {
						slidesPerView: 2.5,
						spaceBetween: 16,
					},
					1440: {
						slidesPerView: 2.97,
						spaceBetween: 20,
					},
					1920: {
						slidesPerView: 3.7,
						spaceBetween: 20,
					}
				},
			});
		});
	//Image gallery slider code end
	
	
});
