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

		if (scrollTop > 0) {
			headerSection.classList.add("shrink");
			document.body.classList.add("shrink");
		} else {
			headerSection.classList.remove("shrink");
			document.body.classList.remove("shrink");
		}
		lastScrollTop = Math.max(0, scrollTop);
	}

	// Resize event
	function handleResize() {
		headerInitialSectionHeight = adminBarHeight + (headerSection?.offsetHeight || 0);
		setInitialPadding();
	}

	// Hide top bar
	function hideTopBar() {
		const topBar = document.querySelector(".top-bar");
		if (!topBar || !headerSection) return;

		topBar.classList.add("hide-top-bar");

		// Update header height after top bar is hidden
		headerInitialSectionHeight =
			headerSection.offsetHeight - topBar.offsetHeight;

		// Adjust spacing
		setInitialPadding();
		headerSection.style.top = "0";
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
				setCookie("helloBarClosed", "true", cookieDays); // Use dynamic value from the data attribute
			});
		}
	}
});
