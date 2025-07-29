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

	//if has children then add triangle div on nav js start
		const menuItems = document.querySelectorAll("li.menu-item-has-children");
		menuItems.forEach(function (item) {
			const link = item.querySelector("a");
			// Only wrap if not already wrapped
			if (link && !link.closest(".child-triangle")) {
				const wrapper = document.createElement("div");
				wrapper.classList.add("child-triangle");

				// Move the <a> tag into the new wrapper
				link.parentNode.insertBefore(wrapper, link);
				wrapper.appendChild(link);
			}
		});
	//end

	
});

// resposive mega menu js start
document.addEventListener('DOMContentLoaded', function () {
	const menuExpandBtns = document.querySelectorAll('.menu-expand');
	const headerLogo = document.querySelector('.header-logo');
	const backLink = document.querySelector('.mp-back');
	const siteLogo = headerLogo?.querySelector('.site-logo');
	const menuBtn = document.querySelector('.menu-btn');
	const allDropdowns = document.querySelectorAll('.mega-dropdown');

	if (!menuExpandBtns.length || !headerLogo || !backLink || !menuBtn) return;

	let activeDropdown = null;
	allDropdowns.forEach(dd => {
		dd.style.display = 'none';
		dd.style.opacity = '0';
		dd.style.overflow = 'hidden';
		dd.style.visibility = 'hidden';
	});

	// Toggle mega menu on expand click
	menuExpandBtns.forEach((btn) => {
		btn.addEventListener('click', function (e) {
			e.preventDefault();

			const parentMenuItem = btn.closest('.menu-item');
			const dropdown = parentMenuItem?.querySelector('.mega-dropdown');

			// Hide other open dropdowns
			allDropdowns.forEach(dd => {
				dd.classList.remove('mp-level-open');
				dd.style.display = 'none';
				dd.style.opacity = '0';
				dd.style.overflow = 'hidden';
				dd.style.visibility = 'hidden';
			});

			if (dropdown) {
				const isOpen = dropdown.classList.contains('mp-level-open');

				if (!isOpen) {
					dropdown.classList.add('mp-level-open');
					dropdown.style.display = 'block';
					dropdown.style.opacity = '1';
					dropdown.style.overflow = 'visible';
					dropdown.style.visibility = 'visible';

					backLink.style.display = 'flex';
					if (siteLogo) siteLogo.style.display = 'none';
					headerLogo.classList.add('active');

					activeDropdown = dropdown;
				} else {
					dropdown.classList.remove('mp-level-open');
					dropdown.style.display = 'none';
					dropdown.style.opacity = '0';
					dropdown.style.overflow = 'hidden';
					dropdown.style.visibility = 'hidden';

					backLink.style.display = 'none';
					if (siteLogo) siteLogo.style.display = '';
					headerLogo.classList.remove('active');
					activeDropdown = null;
				}
			}
		});
	});

	// Back button resets mega menu
	backLink.addEventListener('click', function (e) {
		e.preventDefault();
		resetMegaMenus();
	});

	// Menu button resets everything
	menuBtn.addEventListener('click', function (e) {
		e.preventDefault();
		resetMegaMenus();
	});

	// Function to close all mega menus and reset header
	function resetMegaMenus() {
		allDropdowns.forEach(dd => {
			dd.classList.remove('mp-level-open');
			dd.style.display = 'none';
			dd.style.opacity = '0';
			dd.style.overflow = 'hidden';
			dd.style.visibility = 'hidden';
		});

		backLink.style.display = 'none';
		if (siteLogo) siteLogo.style.display = '';
		headerLogo.classList.remove('active');
		activeDropdown = null;
	}
});
// responsive mega menu js end