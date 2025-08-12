document.addEventListener("DOMContentLoaded", function () {
	const mainSection = document.querySelector(".main-section");
	const herofullSection = document.querySelector(".hero-section");
	const headerSection = document.querySelector(".header-section");
	const navContainer = document.querySelector(".nav-container");
	const topBarCross = document.querySelector(".top-bar-cross");
	let lastScrollTop = 0;

	const adminBarHeight = document.getElementById("wpadminbar")?.offsetHeight || 0;
	// hero banner min-height set
	const herobanner = document.querySelector(".header-section");
	const heroBlock = document.querySelector(
		".variation-equal .hero-alongside-block",
	);

	if (herobanner && heroBlock) {
		const heroHeight = herobanner.offsetHeight;
		heroBlock.style.minHeight = `calc(100vh - ${heroHeight}px - 2px)`;
	}
	//end
	let headerInitialSectionHeight = 0;

	// Set padding top based on header height
	function setInitialPadding() {
		if (herofullSection) {
			herofullSection.style.paddingTop =
				headerInitialSectionHeight + "px";
		} else if (mainSection) {
			mainSection.style.paddingTop = headerInitialSectionHeight + "px";
		}

		if (navContainer) {
			if (window.innerWidth < 1024) {
				navContainer.style.paddingTop = "";
			} else {
				navContainer.style.paddingTop = "";
			}
		}
	}

	// Adjust header on scroll
	function adjustHeader() {
		if (!headerSection) return;

		const scrollTop = window.scrollY || document.documentElement.scrollTop;
		const headerHeight = headerSection.offsetHeight;
		const header_nav = document.querySelector(".bottom-head");
		const header_nav_height = header_nav.offsetHeight;
		
		if (scrollTop > header_nav_height) {
			headerSection.classList.add("shrink");
			document.body.classList.add("shrink");
		} else {
			headerSection.classList.remove("shrink");
			document.body.classList.remove("shrink");
		}
		lastScrollTop = Math.max(0, scrollTop);
		setInitialPadding();
	}

	// Resize event
	function handleResize() {
		headerInitialSectionHeight = adminBarHeight + (headerSection?.offsetHeight || 0);
		setInitialPadding();
		adjustHeader();
	}

	// Hide top bar
	function hideTopBar() {
		const topBar = document.querySelector('.top-bar');
		if (!topBar || !headerSection) return;

		topBar.classList.add('hide-top-bar');

		// Update header height after top bar is hidden
		headerInitialSectionHeight = headerSection.offsetHeight;

		// Adjust spacing
		if (herofullSection) {
			herofullSection.style.paddingTop = headerInitialSectionHeight + 'px';
		} else if (mainSection) {
			mainSection.style.paddingTop = headerInitialSectionHeight + 'px';
		}

		if (navContainer && window.innerWidth < 1024) {
			navContainer.style.paddingTop = headerInitialSectionHeight + 'px';
		}

		headerSection.style.top = '0';
	}

	// Bind top bar close button
	if (topBarCross) {
		topBarCross.addEventListener("click", hideTopBar);
	}

	// Run only when all assets (images/fonts) are loaded
	window.addEventListener("load", function () {
		headerInitialSectionHeight = (headerSection?.offsetHeight || 0);
		setInitialPadding();
		adjustHeader();
		adjustContentMinHeight();
	});
	document.addEventListener('DOMContentLoaded', () => {
		setInitialPadding();
	});

	// Event listeners
	window.addEventListener("scroll", adjustHeader);
	window.addEventListener("resize", handleResize);

	// Function to set a cookie
	function setCookie(name, value, days) {
		const date = new Date();
		date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // Set expiration to dynamic days
		document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
	}

	// Function to get a cookie
	function getCookie(name) {
		const nameEQ = `${name}=`;
		const cookies = document.cookie.split(";");
		for (let cookie of cookies) {
			cookie = cookie.trim();
			if (cookie.indexOf(nameEQ) === 0) {
				return cookie.substring(nameEQ.length);
			}
		}
		return null;
	}
	//Home Hero banner js start
	function adjustContentMinHeight() {
		const header = document.querySelector(".header-section");
		const contentElements = document.querySelectorAll(`
		.hero-section.hero-alongside-pattern,
		.hero-section.hero-alongside-pattern .hero-default,
		.hero-section.hero-alongside-pattern .hero-default .wrapper,
		.hero-section.hero-alongside-pattern .hero-alongside-block
		`);

		const headerHeight = header.offsetHeight;

		contentElements.forEach((el) => {
			el.style.minHeight = `calc(100vh - ${headerHeight}px - 2px)`;
		});
	}
	//Home Hero banner js end

	// Hide hello bar if cookie exists
	const helloBar = document.querySelector(".top-bar");
	if (helloBar) {
		const cookieDays = parseInt(
			helloBar.getAttribute("data-cookie-days"),
			10,
		); // Convert data-cookie-days to integer

		if (getCookie("helloBarClosed")) {
			helloBar.style.display = "none"; // Hide the hello bar if cookie exists
		} else {
			helloBar.style.display = "flex"; // Show the hello bar if cookie does not exist
		}
		// Add event listener to the close button
		const closeButton = helloBar.querySelector(".top-bar-cross");
		if (closeButton) {
			closeButton.addEventListener("click", (e) => {
				e.preventDefault();
				helloBar.style.display = "none"; // Hide the hello bar
				document.body.classList.remove("hello-bar-appear"); // Remove class from body
				document.body.classList.add("hello-bar-remove"); // Remove class from body
				setCookie("helloBarClosed", "true", cookieDays); // Use dynamic value from the data attribute
			});
		}
	}

	// Accessibility: Add aria-label to links that open in a new tab
	document.querySelectorAll('a[target="_blank"]').forEach((link) => {
		// Check if the link already has an aria-label
		if (!link.hasAttribute("aria-label")) {
			// Add aria-label if it's not already present
			link.setAttribute("aria-label", "Opens in a new tab");
		}
	});

	// Add wrapper + accessibility attributes
	const menuItems = document.querySelectorAll("li.menu-item-has-children");
	menuItems.forEach(function (item) {
	    const link = item.querySelector("a");

	    if (link && !link.closest(".child-triangle")) {
	        const wrapper = document.createElement("div");
	        wrapper.classList.add("child-triangle");

	        // Accessibility attributes
	        link.setAttribute("aria-haspopup", "true");
	        link.setAttribute("aria-expanded", "false");

	        // Move the <a> tag into the new wrapper
	        link.parentNode.insertBefore(wrapper, link);
	        wrapper.appendChild(link);

	        // Toggle aria-expanded on click
	        link.addEventListener("click", function (e) {
	            const expanded = this.getAttribute("aria-expanded") === "true";
	            this.setAttribute("aria-expanded", expanded ? "false" : "true");

	            // If your dropdown uses a class to show/hide
	            item.classList.toggle("open", !expanded);
	            e.preventDefault(); // prevent navigation if it's just a toggle
	        });

	        // Optional: close dropdown when clicking outside
	        document.addEventListener("click", function (e) {
	            if (!item.contains(e.target)) {
	                link.setAttribute("aria-expanded", "false");
	                item.classList.remove("open");
	            }
	        });
	    }
	});

	
});

// resposive mega menu js start
document.addEventListener('DOMContentLoaded', function () {
	const isMobileView = () => window.innerWidth <= 1200;

	if (!isMobileView()) return;

	const headerLogo = document.querySelector('.header-logo');
	const backLink = document.querySelector('.mp-back');
	const siteLogo = headerLogo?.querySelector('.site-logo');
	const menuBtn = document.querySelector('.menu-btn');
	const allDropdowns = document.querySelectorAll('.mega-dropdown');
	let menuExpandBtns = document.querySelectorAll('.menu-expand');

	if (!menuExpandBtns.length || !headerLogo || !backLink || !menuBtn) return;

	let activeDropdown = null;

	function updateMegaMenuPosition() {
		const headerLogoHeight = headerLogo.getBoundingClientRect().height;
		const viewportHeight = window.innerHeight;

		let footerHeight = 0;
		const footerSticky = document.querySelector('.footer-sub-nav-sticky');
		if (footerSticky) {
			footerHeight = footerSticky.offsetHeight;
		}

		const availableHeight = viewportHeight - headerLogoHeight - footerHeight;

		allDropdowns.forEach(dd => {
			dd.style.top = `${headerLogoHeight}px`;
			dd.style.height = `${availableHeight}px`;
		});
	}

	function resetMegaMenus() {
		allDropdowns.forEach(dd => {
			dd.classList.remove('mp-level-open');
			dd.style.display = 'none';
			dd.style.opacity = '0';
		});
		backLink.style.display = 'none';
		if (siteLogo) siteLogo.style.display = '';
		headerLogo.classList.remove('active');
		activeDropdown = null;
	}

	// Run once
	updateMegaMenuPosition();
	allDropdowns.forEach(dd => {
		dd.style.display = 'none';
		dd.style.opacity = '0';
	});

	// Resize listener
	window.addEventListener('resize', function () {
		if (isMobileView()) updateMegaMenuPosition();
	});

	// Expand click
	menuExpandBtns.forEach((btn) => {
		btn.addEventListener('click', function (e) {
			e.preventDefault();

			const parentMenuItem = btn.closest('.menu-item');
			const dropdown = parentMenuItem?.querySelector('.mega-dropdown');

			if (!dropdown) return;

			const isOpen = dropdown.classList.contains('mp-level-open');

			allDropdowns.forEach(dd => {
				dd.classList.remove('mp-level-open');
				dd.style.display = 'none';
				dd.style.opacity = '0';
			});

			if (!isOpen) {
				dropdown.classList.add('mp-level-open');
				dropdown.style.display = 'block';
				dropdown.style.opacity = '1';

				backLink.style.display = 'flex';
				headerLogo.classList.add('active');
				activeDropdown = dropdown;
			} else {
				resetMegaMenus();
			}
		});
	});

	backLink.addEventListener('click', resetMegaMenus);
	menuBtn.addEventListener('click', resetMegaMenus);
});

// responsive mega menu js end

//Donate page js start
document.addEventListener('DOMContentLoaded', function () {
    const subNav = document.querySelector('.top-sticky-top-touch');
    const stickyParent = document.querySelector('.top-sticky-parent');

    // Guard
    if (!subNav || !stickyParent) return;

    // parentSection as two-level parent as you had before (safe fallback)
    const parentSection = subNav.parentElement?.parentElement || subNav.parentElement;

    let ticking = false;

    function getParentBounds() {
        const rect = parentSection.getBoundingClientRect();
        const top = rect.top + window.pageYOffset;
        const height = rect.height;
        const bottom = top + height;
        return { top, height, bottom };
    }

    function updateStickyWidth() {
        // Use stickyParent width (matching header layout)
        const stickyParentWidth = stickyParent.offsetWidth;
        subNav.style.width = stickyParentWidth + 'px';
    }

    function resetStyles() {
        subNav.classList.remove('scrolled');
        subNav.style.position = '';
        subNav.style.top = '';
        subNav.style.bottom = '';
        subNav.style.width = '';
    }

    function onScroll() {
        // throttle with rAF
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(function () {
            ticking = false;

            // Do nothing on small screens
            if (window.innerWidth <= 991) {
                resetStyles();
                return;
            }

            const scrollY = window.scrollY || window.pageYOffset;
            const { top: parentTop, bottom: parentBottom } = getParentBounds();
            const stickyHeight = subNav.offsetHeight;

            // When we are between top of parent and the bottom minus stickyHeight -> fixed at top
            if (scrollY > parentTop && scrollY < (parentBottom - stickyHeight)) {
                // Fixed to top
                subNav.classList.add('scrolled');
                subNav.style.position = 'fixed';
                subNav.style.top = '0';
                subNav.style.bottom = '';
                updateStickyWidth();
            }
            // Only make it absolute when we've actually scrolled past (strict greater)
            else if (scrollY > (parentBottom - stickyHeight)) {
                subNav.classList.remove('scrolled');
                subNav.style.position = 'absolute';
                subNav.style.top = '';
                subNav.style.bottom = '0';
                updateStickyWidth();
            } else {
                // Before parentTop
                resetStyles();
            }
        });
    }

    // Resize handler: update width if sticky, else reset
    function onResize() {
        // throttle using rAF as well
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(function () {
            ticking = false;
            if (window.innerWidth > 991 && (subNav.style.position === 'fixed' || subNav.style.position === 'absolute')) {
                updateStickyWidth();
            } else {
                resetStyles();
            }
            // Re-evaluate scroll state after resize
            onScroll();
        });
    }

    // Run on load (after images/fonts/layout settled) to avoid incorrect initial absolute
    window.addEventListener('load', function () {
        // small timeout to let layout settle on some browsers
        setTimeout(onScroll, 20);
    });

    // Also run initial check on DOMContentLoaded (in case load already fired)
    onScroll();

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onResize);
});
