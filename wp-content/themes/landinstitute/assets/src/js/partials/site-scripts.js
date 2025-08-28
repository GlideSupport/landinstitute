import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * Sticky Header
 * Adds a class to header on scroll
 */
document.addEventListener("scroll", () => {
	const header = document.querySelector("header");
	if (header) {
		if (document.documentElement.scrollTop > 0) {
			header.classList.add("shrink");
			document.body.classList.add("shrink");
		} else {
			header.classList.remove("shrink");
			document.body.classList.remove("shrink");
		}
	}
});

//blog detail and category detail page popup code start
document.addEventListener("click", function (event) {
	const lightboxElement = event.target.closest("[data-lightbox]");
	if (lightboxElement) {
		lity(event);
	}
});
//end

// Add span tag to multi-level accordion menu for mobile menus
const listItems = document.querySelectorAll("li.menu-item-has-children");
if (listItems.length > 0) {
	listItems.forEach(function (item) {
		const anchor = item.querySelector("a:first-child");
		if (anchor) {
			const span = document.createElement("span");
			span.className = "menu-expand";
			span.setAttribute("role", "none");
			anchor.insertAdjacentElement("afterend", span);
		}
	});
}

// Add hover effect to buttons start
const btns = document.querySelectorAll('.site-btn');

if (btns.length > 0) {
	btns.forEach(btn => {
		btn.addEventListener('mouseenter', () => {
			btn.classList.remove('animate-out');
			btn.classList.add('animate-in');
		});

		btn.addEventListener('mouseleave', () => {
			btn.classList.remove('animate-in');
			btn.classList.add('animate-out');
		});
	});
} 
// Add hover effect to buttons end

// Focus and blur events for menu items with sub-menus
document.querySelectorAll(".menu-item-has-children > a").forEach((anchor) => {
	anchor.addEventListener("focus", () => {
		const subMenu = anchor.nextElementSibling;
		if (subMenu && subMenu.classList.contains("sub-menu")) {
			subMenu.classList.add("focused");
		}
	});
	anchor.addEventListener("blur", () => {
		const subMenu = anchor.nextElementSibling;
		if (subMenu && subMenu.classList.contains("sub-menu")) {
			subMenu.classList.remove("focused");
		}
	});
});

// Toggle menu button functionality
const menuBtn = document.querySelector(".menu-btn");
const navOverlay = document.querySelector(".nav-overlay");
if (menuBtn && navOverlay) {
	menuBtn.addEventListener("click", () => {
		menuBtn.classList.toggle("active");
		navOverlay.classList.toggle("open");
		document.documentElement.classList.toggle("no-overflow");
		document.body.classList.toggle("no-overflow");

		// Reset active states for menu items and hide sub-menus
		document
			.querySelectorAll(".header-nav ul li.active")
			.forEach((item) => {
				item.classList.remove("active");
			});
		document
			.querySelectorAll(".header-nav ul.sub-menu")
			.forEach((subMenu) => {
				subMenu.style.display = "none"; // Equivalent to slideUp
			});
	});
}

//sticky image with scroll start
document.addEventListener("DOMContentLoaded", function () {
	const header = document.querySelector(".header-section");
	const stickyWrappers = document.querySelectorAll(".sticky-img");

	function getHeaderHeight() {
		return header?.offsetHeight || 0;
	}

	function updateStickyPosition() {
		if (window.innerWidth < 992) {
			// Reset all sticky styles for mobile
			stickyWrappers.forEach((wrapper) => {
				const inner = wrapper.querySelector(".sticky-image-stick");
				Object.assign(inner.style, {
					position: "relative",
					top: "0",
					left: "0",
					width: "100%",
				});
			});
			return;
		}

		const headerHeight = getHeaderHeight();

		stickyWrappers.forEach((wrapper) => {
			const container = wrapper.closest(".sticky-lft-block");
			const rightSide = container.querySelector(".cl-right");
			const inner = wrapper.querySelector(".sticky-image-stick");
			const image = inner.querySelector("img");

			const containerTop = container.offsetTop;
			const containerHeight = container.offsetHeight;
			const imageHeight = image.offsetHeight;
			const scrollY = window.scrollY;

			const wrapperRect = wrapper.getBoundingClientRect();
			const wrapperLeft = wrapperRect.left + window.scrollX;
			const wrapperWidth = wrapperRect.width;

			const rightSideBottom =
				rightSide.offsetTop + rightSide.offsetHeight;
			const stickyTop = scrollY + headerHeight;
			const stickyBottom = stickyTop + imageHeight;

			const maxFixedTop = rightSideBottom - imageHeight;

			// Stick the image while scrolling within container bounds
			if (stickyTop > containerTop && stickyBottom < rightSideBottom) {
				inner.style.position = "fixed";
				inner.style.top = `${headerHeight}px`;
				inner.style.left = `${wrapperLeft}px`;
				inner.style.width = `${wrapperWidth}px`;
				inner.style.bottom = "auto";
			}
			// Lock image at the bottom of container
			else if (stickyBottom >= rightSideBottom) {
				const offsetBottom =
					rightSideBottom - containerTop - imageHeight;
				inner.style.position = "absolute";
				inner.style.top = `${offsetBottom}px`;
				inner.style.left = `0`;
				inner.style.width = "100%";
				inner.style.bottom = "auto";
			}
			// Reset to top
			else {
				inner.style.position = "absolute";
				inner.style.top = "0";
				inner.style.left = "0";
				inner.style.width = "100%";
				inner.style.bottom = "auto";
			}
		});
	}

	window.addEventListener("scroll", updateStickyPosition);
	window.addEventListener("resize", updateStickyPosition);
	updateStickyPosition(); // Run once on load
});
//end

// Slide Up/Down internal sub-menu when mobile menu arrow clicked
document.addEventListener("click", (event) => {
	if (event.target.matches(".header-nav .menu-item span")) {
		const link = event.target.closest("li");
		if (link) {
			// Remove active class and slide up siblings
			link.parentElement
				.querySelectorAll(".active")
				.forEach((activeSibling) => {
					activeSibling.classList.remove("active");
					activeSibling.querySelectorAll("ul").forEach((ul) => {
						ul.style.display = "none"; // Equivalent to slideUp
					});
				});

			// Toggle active class and slide down the current sub-menu
			if (link.classList.contains("active")) {
				link.classList.remove("active");
				link.closest("ul").classList.remove("disabled-menu");
				link.querySelectorAll("ul").forEach((ul) => {
					ul.style.display = "none"; // Equivalent to slideUp
				});
			} else {
				link.classList.add("active");
				link.closest("ul").classList.add("disabled-menu");
				link.querySelectorAll("ul").forEach((ul) => {
					ul.style.display = "block"; // Equivalent to slideDown
				});
			}
		}
	}
});

// Tab DropDown
document.addEventListener("DOMContentLoaded", () => {
	const dropdowns = document.querySelectorAll(".tab-dropdown");

	document.addEventListener("click", (event) => {
		let clickedDropdown = null;

		dropdowns.forEach((dropdown) => {
			const toggle = dropdown.querySelector(".dropdown-toggle");

			// If clicked inside this dropdown
			if (dropdown.contains(event.target)) {
				if (event.target === toggle || toggle.contains(event.target)) {
					clickedDropdown = dropdown;
				}
			} else {
				// Close all other dropdowns
				toggle?.setAttribute("aria-expanded", "false");
				dropdown.classList.remove("open");
			}
		});

		// Toggle clicked dropdown
		if (clickedDropdown) {
			const toggle = clickedDropdown.querySelector(".dropdown-toggle");
			const menu = clickedDropdown.querySelector(".dropdown-menu");

			if (toggle && menu) {
				const isExpanded =
					toggle.getAttribute("aria-expanded") === "true";
				toggle.setAttribute("aria-expanded", String(!isExpanded));
				clickedDropdown.classList.toggle("open", !isExpanded);

				// Optional: add staggered animation delay to menu items
				if (!isExpanded) {
					menu.querySelectorAll("li").forEach((item, index) => {
						item.style.animationDelay = `${index * 0.1}s`;
					});
				}
			}
		}
	});

	// Close dropdown when a menu <li> is clicked
	document.querySelectorAll(".dropdown-menu li").forEach((item) => {
		item.addEventListener("click", () => {
			const dropdown = item.closest(".tab-dropdown");
			if (dropdown) {
				dropdown.classList.remove("open");
				const toggle = dropdown.querySelector(".dropdown-toggle");
				if (toggle) {
					toggle.setAttribute("aria-expanded", "false");
				}
			}
		});
	});
});

// Sticky Social Start
document.addEventListener("DOMContentLoaded", () => {
	if (document.body.classList.contains("single-post")) {
		const stickySocial = document.querySelector(".sticky-social");

		// Function to update sticky-social top position
		const updateStickySocial = () => {
			if (stickySocial) {
				stickySocial.style.position = "sticky";
				stickySocial.style.top = "25px"; // Fixed top position
			}
		};

		// Initial update on DOMContentLoaded
		updateStickySocial();

		// Apply style to body tag
		document.body.style.overflowX = "unset";
		document.body.style.setProperty("overflow-x", "unset", "important");
	}
});

// Counter js start
document.addEventListener("DOMContentLoaded", function () {
	const counters = document.querySelectorAll(".counter-number .count");
	const speed = 3000; // Duration for all counters to finish counting (in milliseconds)

	const getMaxTarget = () => {
		return Math.max(
			...Array.from(counters).map(
				(counter) =>
					+counter
						.closest(".counter-number")
						.getAttribute("data-target"),
			),
		);
	};

	const maxTarget = getMaxTarget(); // Find the highest target value

	const countUp = (counter) => {
		const target = +counter
			.closest(".counter-number")
			.getAttribute("data-target");
		const startTime = performance.now();

		const updateCount = (currentTime) => {
			const elapsedTime = currentTime - startTime;
			const progress = Math.min(elapsedTime / speed, 1); // Progress from 0 to 1 over the speed duration
			const currentCount = Math.ceil(progress * target);

			counter.innerText = currentCount.toLocaleString();

			if (progress < 1) {
				requestAnimationFrame(updateCount);
			} else {
				counter.innerText = target.toLocaleString(); // Ensure the final value is the target
			}
		};

		requestAnimationFrame(updateCount);
	};

	const options = {
		threshold: 0.1,
	};

	const observer = new IntersectionObserver((entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				const counter = entry.target.querySelector(".count");
				countUp(counter);
				observer.unobserve(entry.target);
			}
		});
	}, options);

	counters.forEach((counter) => {
		observer.observe(counter.closest(".counter-number"));
	});
});
//counter js end

// Header Mega menu append js start
const HeadermenuAppend = [
	{ dropdownId: "#mega-dropdown-our-work", menuClass: "our-work" },
	{ dropdownId: "#mega-dropdown-learn", menuClass: "learn" },
];

HeadermenuAppend.forEach(({ dropdownId, menuClass }) => {
	const dropdown = document.querySelector(dropdownId);
	const menuItem = document.querySelector(`.header-nav ul.menu li.${menuClass}`);
	const triggerLink = menuItem?.querySelector('a');

	if (dropdown && menuItem) {
		menuItem.appendChild(dropdown);

		const currentUrl = window.location.href;
		const links = dropdown.querySelectorAll("a");

		links.forEach(link => {
			if (link.href === currentUrl) {
				const iconCol = link.closest(".icon-content-col");
				if (iconCol) {
					iconCol.classList.add("active");
				}
			}
		});

		// Set ARIA attributes
		if (triggerLink) {
			triggerLink.setAttribute("aria-haspopup", "true");
			triggerLink.setAttribute("aria-expanded", "false");
		}

		// Show on hover
		const showDropdown = () => {
			dropdown.style.display = "block";
			dropdown.style.opacity = "1";
			dropdown.style.overflow = "visible";
			dropdown.style.visibility = "visible";
			document.body.classList.add("megamenu-hover-active");

			if (triggerLink) {
				triggerLink.setAttribute("aria-expanded", "true");
			}
		};

		// Hide when leaving dropdown or menu item
		const hideDropdown = () => {
			dropdown.style.display = "none";
			dropdown.style.opacity = "0";
			dropdown.style.overflow = "hidden";
			dropdown.style.visibility = "hidden";
			document.body.classList.remove("megamenu-hover-active");

			if (triggerLink) {
				triggerLink.setAttribute("aria-expanded", "false");
			}
		};

		if (window.innerWidth > 1200) {
			menuItem.addEventListener("mouseover", showDropdown);
			menuItem.addEventListener("mouseleave", hideDropdown);
			menuItem.addEventListener("focusin", showDropdown);
			menuItem.addEventListener("focusout", hideDropdown);

			// Also hide when mouse leaves the inner container
			const inner = dropdown.querySelector(".mega-dropdown-inner");
			if (inner) {
			inner.addEventListener("mouseleave", hideDropdown);
			}
		}
	}
});
// Close mega menu on scroll
window.addEventListener("scroll", () => {
	HeadermenuAppend.forEach(({ dropdownId, menuClass }) => {
		const dropdown = document.querySelector(dropdownId);
		const menuItem = document.querySelector(`.header-nav ul.menu li.${menuClass}`);
		const triggerLink = menuItem?.querySelector('a');

		if (dropdown && menuItem) {
			dropdown.style.display = "none";
			dropdown.style.opacity = "0";
			//dropdown.style.overflow = "hidden";
			//dropdown.style.visibility = "hidden";
			document.body.classList.remove("megamenu-hover-active");

			if (triggerLink) {
				triggerLink.setAttribute("aria-expanded", "false");
			}
		}
	});
});
// Header Mega menu append js End


function applyCardSpacing() {
	const rowFlex = document.querySelector(
		".two-column-text.text-featured-block .row-flex",
	);
	const cards = rowFlex?.querySelectorAll(".text-card-col");

	if (!rowFlex || !cards.length) {
		return;
	}

	// Clear all margin-related classes first
	cards.forEach((card) => {
		card.classList.remove("no-margin-top", "no-margin-bottom");
	});

	// Only apply logic above 991px (2-column layout)
	if (window.innerWidth > 991) {
		const columnCount = 2;
		const totalRows = Math.ceil(cards.length / columnCount);

		cards.forEach((card, index) => {
			const currentRow = Math.floor(index / columnCount);

			// Add margin-top reset to every card in each row
			card.classList.add("no-margin-top");

			// Remove margin-bottom from all but the last row
			if (currentRow < totalRows - 1) {
				card.classList.add("no-margin-bottom");
			}
		});
	}
}

// Run on page load and on window resize
document.addEventListener("DOMContentLoaded", applyCardSpacing);
window.addEventListener("resize", applyCardSpacing);

document.addEventListener("DOMContentLoaded", function () {
	// Search button click search popup js start
	const searchBtn = document.querySelector(".search-btn");
	const searchPopup = document.querySelector(".search-drop");
	const searchContainer = document.querySelector(".search-mega-dropdown");

	if (searchBtn && searchPopup) {
		searchBtn.addEventListener("click", function (e) {
			e.preventDefault(); // prevent default anchor link behavior
			searchPopup.classList.toggle("active-search");
		});

		// Close search popup if clicking outside search elements
		document.addEventListener("click", function (e) {
			const isInsideSearch =
				searchPopup.contains(e.target) ||
				searchBtn.contains(e.target) ||
				searchContainer?.contains(e.target);

			if (!isInsideSearch) {
				searchPopup.classList.remove("active-search");
			}
		});
	}

	// Search button click search popup js End

	//hover add class in menu js start
	/**
	 * Adds hover behavior on items:
	 * When hovering one item, add class to all others;
	 * remove class on mouse leave.
	 *
	 * @param {string} selector   - CSS selector for items
	 * @param {string} hoverClass - class to toggle on other items
	 */
	function addHoverEffect(selector, hoverClass) {
		const items = document.querySelectorAll(selector);

		items.forEach((item) => {
			item.addEventListener("mouseenter", () => {
				items.forEach((otherItem) => {
					if (otherItem !== item) {
						otherItem.classList.add(hoverClass);
					}
				});
			});

			item.addEventListener("mouseleave", () => {
				items.forEach((otherItem) => {
					otherItem.classList.remove(hoverClass);
				});
			});
		});
	}

	addHoverEffect(".header-nav .menu > li", "hover-active");
	addHoverEffect(".mega-two .icon-content-col", "active-hover");
	addHoverEffect( ".mega-bottom-menu ul#menu-sub-nav-issues > li","hover-active");
	addHoverEffect(".social-icons a", "active-hover");
	addHoverEffect(".legal-nav nav .menu > li", "active-hover");

	//hover add class in menu js end

	// Tab Content js start
	const tabContainers = document.querySelectorAll(".tabbed-block-content");
	if (!tabContainers.length) {
		return;
	} // Exit early if no tab blocks on the page
	tabContainers.forEach((container) => {
		const tabs = container.querySelectorAll("ul.tabs li");
		const contents = container.querySelectorAll(".tab-content");

		// Skip if either tabs or contents are missing in this container
		if (!tabs.length || !contents.length) {
			return;
		}

		tabs.forEach((tab) => {
			tab.addEventListener("click", function () {
				const tabId = this.getAttribute("data-tab");

				tabs.forEach((t) => t.classList.remove("current"));
				contents.forEach((content) => {
					content.classList.remove("current", "fade-in");
					content.style.opacity = 0;
				});

				this.classList.add("current");

				const activeContent = container.querySelector("#" + tabId);
				if (activeContent) {
					activeContent.classList.add("current");

					// Trigger reflow
					void activeContent.offsetWidth;

					activeContent.classList.add("fade-in");
					activeContent.style.opacity = 1;
				}
			});
		});
	});
	// Tab Content js end
});
function initDropdownMenus() {
	const tabDropdowns = document.querySelectorAll(".menu-dropdown");

	if (!tabDropdowns.length) {
		return;
	}

	tabDropdowns.forEach((tabDropdown) => {
		if (!tabDropdown) {
			return;
		}

		const toggleButton = tabDropdown.querySelector(".menu-dropdown .dropdown-toggle");
		const dropdownMenu = tabDropdown.querySelector(".menu-dropdown .dropdown-menu");

		if (!toggleButton || !dropdownMenu) {
			return;
		}

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft =
				window.pageXOffset || document.documentElement.scrollLeft;

			dropdownMenu.style.position = "absolute";
			dropdownMenu.style.top = `${rect.top + rect.height + scrollTop}px`;
			dropdownMenu.style.left = `${rect.left + scrollLeft}px`;
			dropdownMenu.style.width = `${rect.width}px`; // match width to toggle button
		}

		function closeDropdown() {
			toggleButton.setAttribute("aria-expanded", "false");
			dropdownMenu.style.display = "none";
			tabDropdown.classList.remove("open");
			dropdownMenu.classList.remove("open");
		}

		// Toggle dropdown on button click
		toggleButton.addEventListener("click", (event) => {
			event.stopPropagation();

			const isExpanded =
				toggleButton.getAttribute("aria-expanded") === "true";
			toggleButton.setAttribute("aria-expanded", !isExpanded);

			if (!isExpanded) {
				dropdownMenu.style.display = "block";
				tabDropdown.classList.add("open");
				dropdownMenu.classList.add("open");
				positionDropdown();

				const listItems = dropdownMenu.querySelectorAll("li");
				if (listItems.length) {
					listItems.forEach((item, index) => {
						if (item) {
							item.style.animationDelay = `${index * 0.1}s`;
						}
					});
				}
			} else {
				closeDropdown();
			}
		});

		// Close dropdown when clicking outside
		document.addEventListener("click", (event) => {
			if (!tabDropdown.contains(event.target)) {
				closeDropdown();
			}
		});

		// Reposition on window resize
		window.addEventListener("resize", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				positionDropdown();
			}
		});
		window.addEventListener("scroll", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				closeDropdown();
			}
		});
	});
}

// Run on DOM ready
document.addEventListener("DOMContentLoaded", initDropdownMenus);

// For ACF block preview / dynamic load
if (typeof window.acf !== "undefined") {
	window.acf.addAction("render_block_preview", initDropdownMenus);
}

//dropdown menu js start
document.addEventListener("DOMContentLoaded", () => {
	// Wait a bit for all DOM elements to load
	setTimeout(() => {
		initDropdowns();
	}, 100);
});

function initDropdowns() {
	const tabDropdowns = document.querySelectorAll(".tab-dropdown");

	tabDropdowns.forEach((tabDropdown) => {
		const toggleButton = tabDropdown.querySelector(".dropdown-toggle");
		if (!toggleButton) {
			return;
		}

		const menuId = toggleButton.getAttribute("aria-controls");

		// Try to find the dropdown menu - it might be outside the tabDropdown
		const dropdownMenu = document.querySelector(
			`ul#${menuId}.dropdown-menu`,
		);

		// If not found, skip this dropdown for now - it might load later
		if (!dropdownMenu) {
			console.warn(`Dropdown menu with ID ${menuId} not found yet`);
			return;
		}

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

			dropdownMenu.style.position = "absolute";
			dropdownMenu.style.zIndex = "1";
			const insideHeaderSearchMenu = toggleButton.closest('.header-search-menu') !== null;
			    if (!insideHeaderSearchMenu) {
			        dropdownMenu.style.top = `${rect.top + rect.height + scrollTop}px`;
			        dropdownMenu.style.left = `${rect.left + scrollLeft}px`;
			        dropdownMenu.style.width = `${rect.width}px`;
			    }
		}

		function closeDropdown() {
			toggleButton.setAttribute("aria-expanded", "false");
			dropdownMenu.style.display = "none";
			tabDropdown.classList.remove("open");
			dropdownMenu.classList.remove("open");
		}

		function closeAllDropdowns() {
			document.querySelectorAll(".dropdown-menu").forEach((menu) => {
				menu.style.display = "none";
				menu.classList.remove("open");
			});
			document.querySelectorAll(".tab-dropdown").forEach((drop) => {
				drop.classList.remove("open");
			});
			document.querySelectorAll(".dropdown-toggle").forEach((btn) => {
				btn.setAttribute("aria-expanded", "false");
			});
		}

		function updateButtonText(selectedText) {
			const buttonTextNode = toggleButton.childNodes[0];
			if (buttonTextNode && buttonTextNode.nodeType === Node.TEXT_NODE) {
				// Get the original button text to extract the prefix
				const originalText = buttonTextNode.textContent;

				// Find the colon to split prefix from current value
				const colonIndex = originalText.indexOf(":");

				if (colonIndex !== -1) {
					// Extract the prefix (everything before and including the colon + space)
					const prefix =
						originalText.substring(0, colonIndex + 1) + " ";
					buttonTextNode.textContent = prefix + selectedText;
				} else {
					// Fallback: if no colon found, just replace the entire text
					buttonTextNode.textContent = selectedText;
				}
			}
		}

		// Toggle dropdown on button click
		toggleButton.addEventListener("click", (event) => {
			event.preventDefault();
			event.stopPropagation();

			const isExpanded =
				toggleButton.getAttribute("aria-expanded") === "true";

			// Close all dropdowns first
			closeAllDropdowns();

			// If this dropdown wasn't expanded, open it
			if (!isExpanded) {
				toggleButton.setAttribute("aria-expanded", "true");
				dropdownMenu.style.display = "block";
				dropdownMenu.classList.add("open");
				tabDropdown.classList.add("open");
				positionDropdown();

				// Add staggered animation delay
				dropdownMenu.querySelectorAll("li").forEach((li, index) => {
					li.style.animationDelay = `${index * 0.1}s`;
				});
			}
		});

		// Handle dropdown item selection - This is the key fix!
		dropdownMenu.addEventListener("click", (event) => {
			// Check if clicked element is a link or inside a link
			const clickedLink = event.target.closest("a");
			if (!clickedLink) {
				return;
			}

			const href = clickedLink.getAttribute("href");
			const selectedTerm = clickedLink.getAttribute("data-term");
			const selectedText = clickedLink.textContent.trim();

			// Check if this is a filter dropdown (has data-term) or a navigation menu
			const isFilterDropdown =
				selectedTerm !== null && selectedTerm !== undefined;
			const isJavascriptVoid =
				href === "javascript:void(0)" || href === "#" || href === "";

			// If it's a real URL and not a filter, update button text then navigate
			if (
				!isJavascriptVoid &&
				!isFilterDropdown &&
				href &&
				href.length > 0
			) {
				// Prevent immediate navigation to show the update first
				event.preventDefault();
				event.stopPropagation();

				// Update button text to show selection
				updateButtonText(selectedText);

				// Close the dropdown
				closeDropdown();

				// Navigate after a short delay to show the text update
				setTimeout(() => {
					window.location.href = href;
				}, 300); // 300ms delay to show the text change

				return;
			}

			// If it's a filter dropdown or javascript:void(0), handle as filter
			if (isFilterDropdown || isJavascriptVoid) {
				event.preventDefault();
				event.stopPropagation();

				// Only update UI if it's a filter dropdown
				if (isFilterDropdown) {
					// Remove active class from all items in this dropdown
					dropdownMenu
						.querySelectorAll("li")
						.forEach((li) => li.classList.remove("active"));

					// Add active class to selected item
					const selectedLi = clickedLink.closest("li");
					if (selectedLi) {
						selectedLi.classList.add("active");
					}

					// Update button text
					updateButtonText(selectedText);
				}

				// Close the dropdown FIRST
				closeDropdown();

				// Only trigger filtering if it's actually a filter dropdown
				if (isFilterDropdown) {
					// Add your AJAX filtering logic here
					if (typeof filterContent === "function") {
						filterContent(toggleButton.id, selectedTerm);
					}

					// Or trigger a custom event for your AJAX handler
					const filterEvent = new CustomEvent(
						"dropdownFilterChanged",
						{
							detail: {
								filterType: toggleButton.id,
								selectedTerm,
								selectedText,
							},
						},
					);
					document.dispatchEvent(filterEvent);
				}
			}
		});

		// Close dropdown when clicking outside
		document.addEventListener("click", (event) => {
			if (
				!tabDropdown.contains(event.target) &&
				!dropdownMenu.contains(event.target)
			) {
				closeDropdown();
			}
		});

		// Reposition on window resize
		window.addEventListener("resize", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				positionDropdown();
			}
		});
	});
}
//dropdown menu js end

//Scrolling Text block js start
document.addEventListener("DOMContentLoaded", function () {
	// Find all sticky elements and their related components
	const stickyElements = document.querySelectorAll(".sticky-top-touch");

	if (!stickyElements.length) {
		return;
	}

	stickyElements.forEach(function (subNav) {
		const headerSection = document.querySelector(".header-section");
		const wpAdminBar = document.getElementById("wpadminbar");
		const parentSection = subNav.closest(".sticky-parent")?.parentElement?.parentElement;
		const stickyParent = subNav.closest(".sticky-parent");

		if (!headerSection || !parentSection || !stickyParent) {
			return;
		}

		let headerHeight = headerSection.offsetHeight;
		let wpAdminBarHeight = wpAdminBar ? wpAdminBar.offsetHeight : 0;

		function updateStickyWidth() {
			const stickyParentWidth = stickyParent.offsetWidth;
			subNav.style.width = stickyParentWidth + "px";
		}
		function updateParentHeight() {
			const stickyHeight = subNav.offsetHeight;
			stickyParent.style.height = stickyHeight + "px";
		}

		function onScroll() {
	if (window.innerWidth <= 991) {
		// Reset styles on smaller screens
		subNav.classList.remove("scrolled");
		subNav.style.position = "";
		subNav.style.top = "";
		subNav.style.bottom = "";
		subNav.style.width = "";
		return;
	}

	// ✅ Recalculate every scroll
	const headerHeight = headerSection.offsetHeight;
	const wpAdminBarHeight = wpAdminBar ? wpAdminBar.offsetHeight : 0;
	const totalOffset = headerHeight + wpAdminBarHeight;

	const scrollY = window.scrollY || window.pageYOffset;
	const parentTop = parentSection.offsetTop;
	const parentHeight = parentSection.offsetHeight;
	const parentBottom = parentTop + parentHeight;

	const stickyHeight = subNav.offsetHeight;
	updateParentHeight();

	if (scrollY + totalOffset >= parentTop && scrollY + totalOffset < parentBottom - stickyHeight) {
		subNav.classList.add("scrolled");
		subNav.style.position = "fixed";
		subNav.style.top = totalOffset + "px"; // ✅ always fresh
		updateStickyWidth();
		subNav.style.bottom = "";
	} else if (scrollY + totalOffset >= parentBottom - stickyHeight) {
		subNav.classList.remove("scrolled");
		subNav.style.position = "absolute";
		subNav.style.top = "";
		subNav.style.bottom = "0";
		updateStickyWidth();
	} else {
		subNav.classList.remove("scrolled");
		subNav.style.position = "";
		subNav.style.top = "";
		subNav.style.bottom = "";
		subNav.style.width = "";
	}
}

		window.addEventListener("scroll", onScroll);

		// Only add one resize listener that handles all instances
		if (!window.stickyResizeHandlerAdded) {
			window.addEventListener("resize", function () {
				headerHeight = headerSection.offsetHeight;

				stickyElements.forEach(function (nav) {
					if (window.innerWidth > 991 && (nav.style.position === "fixed" || nav.style.position === "absolute")) {
						const navStickyParent = nav.closest(".sticky-parent");
						if (navStickyParent) {
							nav.style.width =
								navStickyParent.offsetWidth + "px";
						}
						if (navStickyParent) {
						    navStickyParent.style.height = nav.offsetHeight + "px";
						}
					} else {
						nav.style.width = "";
						nav.style.position = "";
						nav.style.top = "";
						nav.style.bottom = "";
						nav.classList.remove("scrolled");
					}

					// Trigger the scroll handler for each element
					const scrollHandler = nav.onScrollHandler;
					if (scrollHandler) {
						scrollHandler();
					}
				});
			});

			window.stickyResizeHandlerAdded = true;
		}

		// Store the onScroll function reference on the element
		subNav.onScrollHandler = onScroll;

		onScroll();
	});
});

//Scrolling Text block js end

document.addEventListener("DOMContentLoaded", () => {
	const galleryGrid = document.querySelector(".gallery-grid");
	const galleryBlock = document.querySelector(".gallery-block");
	const customCursor = document.querySelector(".custom-cursor");

	if (!galleryGrid || !galleryBlock || !customCursor) {
		return;
	}

	calculateBounds(galleryBlock);
});

function calculateBounds(galleryBlock) {
	if (!galleryBlock) {
		return;
	}
	const isMobile = window.innerWidth <= 767;

	let maxX, maxY;

	if (isMobile) {
		maxX = galleryBlock.clientWidth / 0.6;
		maxY = galleryBlock.clientHeight / 1.5;
	} else {
		maxX = galleryBlock.clientWidth / 2;
		maxY = galleryBlock.clientHeight / 1.5;
	}
}


document.addEventListener("DOMContentLoaded", () => {

	// Image Gallery js start
	const button = document.getElementById('followBtn');

	if(button) {
		// Find the closest parent <section> to the button
		const parentSection = button.closest('section');

		// Show button when mouse enters section
		parentSection.addEventListener('mouseenter', function() {
		  button.style.opacity = '1';
		});

		// Move button with cursor inside section
		parentSection.addEventListener('mousemove', function(e) {
		  const rect = parentSection.getBoundingClientRect();
		  let x = e.clientX - rect.left;
		  let y = e.clientY - rect.top;
		  x -= button.offsetWidth / 2;
		  y -= button.offsetHeight / 2;
		  x = Math.max(0, Math.min(x, rect.width - button.offsetWidth));
		  y = Math.max(0, Math.min(y, rect.height - button.offsetHeight));
		  button.style.left = x + 'px';
		  button.style.top = y + 'px';
		});

		// Hide and reset button when mouse leaves section
		parentSection.addEventListener('mouseleave', function() {
		  button.style.left = '0px';
		  button.style.top = '0px';
		  button.style.opacity = '0';
		});
	}
				
    const galleryGrid = document.querySelector(".gallery-grid");
    const galleryBlock = document.querySelector(".gallery-block");
    const customCursor = document.querySelector(".custom-cursor");
    const expandBtn = document.querySelector(".gallery-expand-btn");
    const closeBtn = document.querySelector(".gallery-close-btn");
    const imageGalleryBlock = document.querySelector(".image-gallery-block");
    const GalleryBlock = document.querySelector(".gallery-block");
	//const dragIndicators = document.querySelectorAll(".cursor-static");
 
    
    // Check if required elements exist before proceeding
    if (!galleryGrid || !galleryBlock || !customCursor || !expandBtn || !closeBtn || !imageGalleryBlock) {
        return;
    }

	

    // Initially hide the close button and all drag indicators
    closeBtn.style.display = "none";
	// dragIndicators.forEach(indicator => {
    //     indicator.style.display = "none";
    // });
   
    // Show only the first drag indicator (if any exist)
    // if (dragIndicators.length > 0) {
    //     dragIndicators[0].style.display = "block";
    // }

    let isDragging = false;
    let startX = 0,
        startY = 0;
    let targetX = 0,
        targetY = 0;
    let hasDragged = false;
    let tween = null;

    let maxX = 0;
    let maxY = 0;

    // Expand gallery function
    function expandGallery() {
        imageGalleryBlock.classList.add("expanded");
		//GalleryBlock.style.height = "100vh";
        document.body.style.overflow = "hidden";
		const header = document.getElementById("header-section");
	    const headerHeight = header ? header.offsetHeight : 0;
	    const sectionTop = GalleryBlock.getBoundingClientRect().top + window.scrollY;
	    window.scrollTo({
	        top: sectionTop - headerHeight,
	        behavior: "smooth"
	    });

		GalleryBlock.style.removeProperty('max-height');
		console.log("Remove max height");

        
        // Show the close button when expanded
        closeBtn.style.display = "block";
		// Show drag indicator when expanded
        // if (dragIndicators.length > 0) {
        //     dragIndicators[0].style.display = "block";
        // }
		if (window.innerWidth < 992) {
	        expandBtn.style.opacity = "0";
	        expandBtn.style.pointerEvents = "none";
	    } else {
	        expandBtn.style.display = "none"; // desktop → just hide
	    }
        // Hide the expand button when expanded
        expandBtn.style.display = "none";
        
        // Enable dragging
        //enableDragging();
        calculateBounds();
		setGalleryBlockHeights();
    }

    // Close gallery function
    function closeGallery() {
        imageGalleryBlock.classList.remove("expanded");
		GalleryBlock.style.height = "";
        document.body.style.overflow = "";
        
        // Hide the close button when not expanded
        closeBtn.style.display = "none";
		 // Hide drag indicator when not expanded
        // dragIndicators.forEach(indicator => {
        //     indicator.style.display = "none";
        // });
  
        // Show the expand button when not expanded
        expandBtn.style.display = "block";
        
        // Disable dragging
        //disableDragging();
        
        // Reset position when closing
        targetX = 0;
        targetY = 0;
        updateTransform();
		setGalleryMaxHeight();
    }

    // Enable dragging functionality
    function enableDragging() {
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

        // Enable cursor
        galleryBlock.style.cursor = "grab";
        
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
    }

    // Disable dragging functionality
    function disableDragging() {
        // Remove mouse events
        galleryBlock.removeEventListener("mousedown", startDrag);
        window.removeEventListener("mousemove", moveDrag);
        window.removeEventListener("mouseup", endDrag);
        window.removeEventListener("mouseleave", endDrag);

        // Remove touch events
        galleryBlock.removeEventListener("touchstart", startDrag);
        window.removeEventListener("touchmove", moveDrag);
        window.removeEventListener("touchend", endDrag);
        window.removeEventListener("touchcancel", endDrag);

        // Remove cursor events
        galleryBlock.removeEventListener("mousemove", updateCursorPosition);
        galleryBlock.removeEventListener("mouseenter", showCursor);
        galleryBlock.removeEventListener("mouseleave", hideCursor);
        galleryBlock.removeEventListener("touchstart", updateCursorPosition);
        galleryBlock.removeEventListener("touchmove", updateCursorPosition);
        galleryBlock.removeEventListener("touchend", hideCursor);
        galleryBlock.removeEventListener("touchcancel", hideCursor);

        // Reset cursor style
        galleryBlock.style.cursor = "default";
        hideCursor();
    }

    // Add event listeners for expand/close buttons
    expandBtn.addEventListener("click", expandGallery);
    closeBtn.addEventListener("click", closeGallery);

    function calculateBounds() {
        // Additional safety check inside the function
        if (!galleryBlock) {
            return;
        }

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
        if (customCursor) customCursor.classList.add("dragging");
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
        if (customCursor) customCursor.classList.remove("dragging");
    }

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


function setGalleryMaxHeight() {
  const header = document.querySelector('.header-section');
  const galleries = document.querySelectorAll('.image-gallery-block .gallery-block');

  if (header && galleries.length > 0) {
    const headerHeight = header.offsetHeight;
    const screenHeight = window.innerHeight;
    const height = (screenHeight - headerHeight) + "px";

    galleries.forEach(gallery => {
      gallery.style.height = height;
      // gallery.style.overflowY = "auto"; // optional, add scroll if needed
    });
  }
}

function setGalleryBlockHeights() {
  const blocks = document.querySelectorAll('.gallery-block');
  if (!blocks.length) {
    console.log('No .gallery-block found');
    return;
  }

  blocks.forEach((block, i) => {
    const grid = block.querySelector('.gallery-grid');
    if (!grid) {
      console.log(`[${i}] No .gallery-grid inside .gallery-block`);
      return;
    }

    // get first and last img separately
    const firstImg = grid.querySelector('.customheighgal .card-img.firstimg img');
    const lastImg  = grid.querySelector('.customheighgal .card-img.lastimg img');

    if (!firstImg || !lastImg) {
      console.log(`[${i}] Missing first or last image`);
      return;
    }

    const blockRect = block.getBoundingClientRect();
    const firstRect = firstImg.getBoundingClientRect();
    const lastRect  = lastImg.getBoundingClientRect();

    const minTop    = firstRect.top - blockRect.top;
    const maxBottom = lastRect.bottom - blockRect.top;

    const height = Math.ceil(maxBottom - minTop);

    block.style.height = height + 'px';
    console.log(`.gallery-block[${i}] height set to: ${height}px`);
  });
}


//window.addEventListener('load', setGalleryBlockHeights);


// // Run on load and on resize
window.addEventListener('load', setGalleryMaxHeight);
//window.addEventListener('resize', setGalleryMaxHeight);


    // ----------------------------
    // CUSTOM CURSOR HANDLING
    // ----------------------------

    // Follow mouse or touch
    function updateCursorPosition(e) {
        const pos = getEventPosition(e);
        if (customCursor) {
            customCursor.style.left = `${pos.x}px`;
            customCursor.style.top = `${pos.y}px`;
        }
    }

    // Show cursor
    function showCursor() {
        if (customCursor) customCursor.style.opacity = "1";
    }

    // Hide cursor
    function hideCursor() {
        if (customCursor) {
            customCursor.style.opacity = "0";
            customCursor.classList.remove("dragging");
        }
    }

    // Initially disable dragging
    disableDragging();
	//Image Gallery js end
	
	
	//staff tab js
	const tabs = document.querySelectorAll("ul.tabs li");
	const contents = document.querySelectorAll(".tab-content");

	tabs.forEach(function (tab) {
		tab.addEventListener("click", function () {
			const tab_id = this.getAttribute("data-tab");

			tabs.forEach((t) => t.classList.remove("current"));

			contents.forEach((content) => {
				content.classList.remove("current", "fade-in");
				content.style.opacity = 0;
			});

			this.classList.add("current");

			const activeContent = document.getElementById(tab_id);
			if (activeContent) {
				activeContent.classList.add("current");

				// Trigger reflow to enable transition
				void activeContent.offsetWidth;

				activeContent.classList.add("fade-in");
				activeContent.style.opacity = 1;
			}
		});
	});
	//staff js end
});

document.addEventListener("DOMContentLoaded", function () {
	const container = document.querySelector(".wpgmza-standalone-component");
	const filter = container?.querySelector(
		".wpgmza-marker-listing-category-filter",
	);
	const mapWrapper = document.querySelector(
		".international-Initiative-map-filter",
	);

	if (!container || !filter || !mapWrapper) return;

	// Hide filter initially
	filter.style.display = "none";

	// Create toggle button
	const toggleBtn = document.createElement("div");
	toggleBtn.className = "map-filter-toggle";
	toggleBtn.textContent = "Show Map Filter";
	toggleBtn.style.cursor = "pointer";

	// Insert toggle above filter
	container.insertBefore(toggleBtn, container.firstChild);

	// Toggle logic
	toggleBtn.addEventListener("click", () => {
		const isHidden = filter.style.display === "none";
		filter.style.display = isHidden ? "block" : "none";
		toggleBtn.textContent = isHidden
			? "Hide Map Filter"
			: "Show Map Filter";
		container.classList.toggle("filter-visible", isHidden);
	});

	// Set map height based on viewport and header/footer
	function setMapHeight() {
		const adminBar = document.getElementById("wpadminbar");
		const header = document.querySelector(".header-section");
		const footer = document.querySelector(".footer-sub-nav-sticky");

		if (!header || !footer) return;

		const adminHeight = adminBar?.offsetHeight || 0;
		const headerHeight = header.offsetHeight;
		const footerHeight = footer.offsetHeight;
		const viewportHeight = window.innerHeight;

		const mapHeight =
			viewportHeight - headerHeight - footerHeight - adminHeight;
		mapWrapper.style.height = `${mapHeight}px`;
	}

	// Initial + responsive resize handling
	setMapHeight();
	window.addEventListener("resize", setMapHeight);
});

document.addEventListener("DOMContentLoaded", function () {
	const tabLinks = document.querySelectorAll(".staff-list .tab-link");
	const staffMembers = document.querySelectorAll(".staff-list .staff-member");
	const noStaffMessage = document.querySelector(
		".staff-list .no-staff-message",
	);

	function filterStaff(categoryId, bgColor) {
		let visibleCount = 0;

		staffMembers.forEach(function (member) {
			const memberCategories = member
				.getAttribute("data-categories")
				.split(",");
			const shouldShow =
				categoryId === "all" || memberCategories.includes(categoryId);

			if (shouldShow) {
				member.style.display = "flex";
				member.classList.add("fade-in");
				// Remove all classes that start with 'bg-'
				member.classList.forEach((cls) => {
					if (cls.startsWith("bg-")) {
						member.classList.remove(cls);
					}
				});
				member.classList.add(bgColor);

				visibleCount++;
			} else {
				member.style.display = "none";
				member.classList.remove("fade-in");
			}
		});

		// Show/hide no staff message
		if (noStaffMessage) {
			if (visibleCount === 0) {
				noStaffMessage.style.display = "block";
			} else {
				noStaffMessage.style.display = "none";
			}
		}
	}

	// Tab click handlers
	tabLinks.forEach(function (link) {
		link.addEventListener("click", function (e) {
			e.preventDefault();

			// Remove active class from all tabs
			tabLinks.forEach(function (tab) {
				tab.classList.remove("current");
			});

			// Add active class to clicked tab
			this.classList.add("current");

			// Get category ID and filter
			const categoryId = this.getAttribute("data-category");
			const bgColor = this.getAttribute("data-bg-color");
			filterStaff(categoryId, bgColor);
		});
	});

	// Initialize with first tab active
	if (tabLinks.length > 0) {
		const firstTab = tabLinks[0];
		const initialCategory = firstTab.getAttribute("data-category");
		const bgColor = firstTab.getAttribute("data-bg-color");
		filterStaff(initialCategory, bgColor);
	}
});

// mobile filter dropdown open and close
document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.querySelector('.filter-mobile-dropdown');
  const dropdownRow = document.querySelector('.filter-dropdown-row');

  if (toggleBtn && dropdownRow) {
    toggleBtn.addEventListener('click', function () {
      const isActive = dropdownRow.classList.contains('active');

      dropdownRow.classList.toggle('active');
      toggleBtn.classList.toggle('active');
    });
  }
});

// Header Mega menu append js Start
document.addEventListener("DOMContentLoaded", function () {
	const currentPath = window.location.pathname;
	document.querySelectorAll(".mega-btns a.site-btn").forEach((btn) => {
		const href = btn.getAttribute("href");

		if (!href || href.startsWith("#")) return;

		const btnPath = new URL(href, window.location.origin).pathname;

		if (btnPath === currentPath) {
			btn.classList.add("btn-lilac");
			btn.classList.remove("btn-lime-green");
		}
	});
});
// Header Mega menu append js End

document.addEventListener('DOMContentLoaded', function () {
	const isMobileView = () => window.innerWidth >= 1200;
	if (!isMobileView()) return;
	const logoImg = document.querySelector('.site-logo img');
	if (!logoImg) return;

	const maxHeight = 88;
	const minHeight = 54;
	const maxScroll = 120; // adjust based on your design

	window.addEventListener('scroll', function () {
		const scrollY = Math.min(window.scrollY, maxScroll);
		const scale = 1 - ((scrollY / maxScroll) * (1 - (minHeight / maxHeight)));
		const size = maxHeight * scale;

		logoImg.style.width = `${size}px`;
		logoImg.style.height = `${size}px`;
	});
});

//Footer Menu accordion js start
document.querySelectorAll(".footer-nav-title").forEach((title) => {
	title.addEventListener("click", () => {
		if (window.innerWidth <= 991) {
			const parent = title.closest(".footer-nav");

			// Close all others
			document.querySelectorAll(".footer-nav").forEach((nav) => {
				if (nav !== parent) {
					nav.classList.remove("active");
				}
			});

			// Toggle the clicked one
			parent.classList.toggle("active");
		}
	});
});

window.addEventListener("resize", () => {
	if (window.innerWidth > 991) {
		document.querySelectorAll(".footer-nav").forEach((nav) => {
			nav.classList.remove("active");
		});
	}
});
//Footer Menu accordion end start