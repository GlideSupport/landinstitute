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
document.addEventListener( 'click', function( event ) {
	const lightboxElement = event.target.closest( '[data-lightbox]' );
	if ( lightboxElement ) {
		lity( event );
	}
} );
//end


// Accessibility: Add aria-label to links that open in a new tab
document.querySelectorAll('a[target="_blank"]').forEach((link) => {
	// Check if the link already has an aria-label
	if (!link.hasAttribute("aria-label")) {
		// Add aria-label if it's not already present
		link.setAttribute("aria-label", "Opens in a new tab");
	}
});

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

			// Check if click is inside this dropdown
			if (dropdown.contains(event.target)) {
				if (event.target === toggle || toggle.contains(event.target)) {
					clickedDropdown = dropdown;
				}
			} else {
				// Close other dropdowns
				toggle?.setAttribute("aria-expanded", "false");
				dropdown.classList.remove("open");
			}
		});

		// Handle toggle for clicked dropdown
		if (clickedDropdown) {
			const toggle = clickedDropdown.querySelector(".dropdown-toggle");
			const menu = clickedDropdown.querySelector(".dropdown-menu");

			if (toggle && menu) {
				const isExpanded = toggle.getAttribute("aria-expanded") === "true";
				toggle.setAttribute("aria-expanded", String(!isExpanded));
				clickedDropdown.classList.toggle("open", !isExpanded);

				if (!isExpanded) {
					menu.querySelectorAll("li").forEach((item, index) => {
						item.style.animationDelay = `${index * 0.1}s`;
					});
				}
			}
		}
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

	if (dropdown && menuItem) {
		menuItem.appendChild(dropdown);

		// Show on hover
		menuItem.addEventListener("mouseenter", () => {
			dropdown.style.display = "block";
			dropdown.style.opacity = "1";
			dropdown.style.overflow = "visible";
			dropdown.style.visibility = "visible";
			document.body.classList.add('megamenu-hover-active');
		});

		// Hide when leaving dropdown or menu item
		const hideDropdown = () => {
			dropdown.style.display = "none";
			dropdown.style.opacity = "0";
			dropdown.style.overflow = "hidden";
			dropdown.style.visibility = "hidden";
			document.body.classList.remove('megamenu-hover-active');
		};

		menuItem.addEventListener("mouseleave", hideDropdown);

		// Also hide when mouse leaves the inner container
		const inner = dropdown.querySelector(".mega-dropdown-inner");
		if (inner) {
			inner.addEventListener("mouseleave", hideDropdown);
		}
	}
});
// Header Mega menu append js End


document.addEventListener('DOMContentLoaded', function () {

	// Search button click search popup js start
		const searchBtn = document.querySelector('.search-btn');
		const searchPopup = document.querySelector('.search-drop');
	  
		if (searchBtn && searchPopup) {
		  searchBtn.addEventListener('click', function (e) {
			e.preventDefault(); // prevent default anchor link behavior
			searchPopup.classList.toggle('active-search');
		  });
		}

	// Search button click search popup js End

	//hover add class in menu js start
	/**
	 * Adds hover behavior on items: 
	 * When hovering one item, add class to all others; 
	 * remove class on mouse leave.
	 * 
	 * @param {string} selector - CSS selector for items
	 * @param {string} hoverClass - class to toggle on other items
	 */
	function addHoverEffect(selector, hoverClass) {
	  const items = document.querySelectorAll(selector);
  
	  items.forEach(item => {
		item.addEventListener('mouseenter', () => {
		  items.forEach(otherItem => {
			if (otherItem !== item) {
			  otherItem.classList.add(hoverClass);
			}
		  });
		});
  
		item.addEventListener('mouseleave', () => {
		  items.forEach(otherItem => {
			otherItem.classList.remove(hoverClass);
		  });
		});
	  });
	}
  
	addHoverEffect('.header-nav .menu > li', 'hover-active');
	addHoverEffect('.mega-two .icon-content-col', 'active-hover');
	addHoverEffect('.mega-bottom-menu ul#menu-issue > li', 'hover-active');
	addHoverEffect('.social-icons a', 'active-hover');
	
	//hover add class in menu js end

	// Tab Content js start
		const tabContainers = document.querySelectorAll('.tabbed-block-content');
		if (!tabContainers.length) return; // Exit early if no tab blocks on the page
		tabContainers.forEach(container => {
			const tabs = container.querySelectorAll('ul.tabs li');
			const contents = container.querySelectorAll('.tab-content');

			// Skip if either tabs or contents are missing in this container
			if (!tabs.length || !contents.length) return;

			tabs.forEach(tab => {
				tab.addEventListener('click', function () {
					const tabId = this.getAttribute('data-tab');

					tabs.forEach(t => t.classList.remove('current'));
					contents.forEach(content => {
						content.classList.remove('current', 'fade-in');
						content.style.opacity = 0;
					});

					this.classList.add('current');

					const activeContent = container.querySelector('#' + tabId);
					if (activeContent) {
						activeContent.classList.add('current');

						// Trigger reflow
						void activeContent.offsetWidth;

						activeContent.classList.add('fade-in');
						activeContent.style.opacity = 1;
					}
				});
			});
		});
	// Tab Content js end


});
function initDropdownMenus() {
	const tabDropdowns = document.querySelectorAll(".tab-dropdown");

	if (!tabDropdowns.length) return;

	tabDropdowns.forEach((tabDropdown) => {
		if (!tabDropdown) return;

		const toggleButton = tabDropdown.querySelector(".dropdown-toggle");
		const dropdownMenu = tabDropdown.querySelector(".dropdown-menu");

		if (!toggleButton || !dropdownMenu) return;

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

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

			const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";
			toggleButton.setAttribute("aria-expanded", !isExpanded);

			if (!isExpanded) {
				dropdownMenu.style.display = "block";
				tabDropdown.classList.add("open");
				dropdownMenu.classList.add("open");
				positionDropdown();

				const listItems = dropdownMenu.querySelectorAll("li");
				if (listItems.length) {
					listItems.forEach((item, index) => {
						if (item) item.style.animationDelay = `${index * 0.1}s`;
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
	});
}

// Run on DOM ready
document.addEventListener("DOMContentLoaded", initDropdownMenus);

// For ACF block preview / dynamic load
if (typeof window.acf !== 'undefined') {
	window.acf.addAction('render_block_preview', initDropdownMenus);
}

//dropdown menu js start
document.addEventListener("DOMContentLoaded", () => {
	const tabDropdowns = document.querySelectorAll(".tab-dropdown");

	tabDropdowns.forEach((tabDropdown) => {
		const toggleButton = tabDropdown.querySelector(".dropdown-toggle");
		if (!toggleButton) return;

		const menuId = toggleButton.getAttribute("aria-controls");
		const dropdownMenu = document.querySelector(`ul#${menuId}.dropdown-menu`);
		if (!dropdownMenu) return;

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

			dropdownMenu.style.position = "absolute";
			dropdownMenu.style.top = `${rect.top + rect.height + scrollTop}px`;
			dropdownMenu.style.left = `${rect.left + scrollLeft}px`;
			dropdownMenu.style.width = `${rect.width}px`;
		}

		function closeDropdown() {
			toggleButton.setAttribute("aria-expanded", false);
			dropdownMenu.style.display = "none";
			tabDropdown.classList.remove("open");
			dropdownMenu.classList.remove("open");
		}

		toggleButton.addEventListener("click", (event) => {
			event.stopPropagation();

			const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";

			// Close all open dropdowns first
			document.querySelectorAll(".dropdown-menu.open").forEach((menu) => {
				menu.style.display = "none";
				menu.classList.remove("open");
			});
			document.querySelectorAll(".tab-dropdown.open").forEach((drop) => {
				drop.classList.remove("open");
			});
			document.querySelectorAll(".dropdown-toggle").forEach((btn) => {
				btn.setAttribute("aria-expanded", false);
			});

			if (!isExpanded) {
				toggleButton.setAttribute("aria-expanded", true);
				dropdownMenu.style.display = "block";
				dropdownMenu.classList.add("open");
				tabDropdown.classList.add("open");
				positionDropdown();

				// ➕ Add animation-delay to each li
				dropdownMenu.querySelectorAll("li").forEach((li, index) => {
					li.style.animationDelay = `${index * 0.1}s`;
				});
			} else {
				closeDropdown();
			}
		});

		document.addEventListener("click", (e) => {
			if (!tabDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
				closeDropdown();
			}
		});

		window.addEventListener("resize", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				positionDropdown();
			}
		});
	});
});

//dropdown menu js end

//Scrolling Text block js start
document.addEventListener('DOMContentLoaded', function () {
    // Find all sticky elements and their related components
    const stickyElements = document.querySelectorAll('.sticky-top-touch');
    
    if (!stickyElements.length) return;

    stickyElements.forEach(function(subNav) {
        const headerSection = document.querySelector('.header-section');
        const parentSection = subNav.closest('.sticky-parent')?.parentElement?.parentElement;
        const stickyParent = subNav.closest('.sticky-parent');

        if (!headerSection || !parentSection || !stickyParent) return;

        let headerHeight = headerSection.offsetHeight;

        function updateStickyWidth() {
            const stickyParentWidth = stickyParent.offsetWidth;
            subNav.style.width = stickyParentWidth + 'px';
        }

        function onScroll() {
            if (window.innerWidth <= 991) {
                // Reset styles on smaller screens
                subNav.classList.remove('scrolled');
                subNav.style.position = '';
                subNav.style.top = '';
                subNav.style.bottom = '';
                subNav.style.width = '';
                return;
            }

            const scrollY = window.scrollY || window.pageYOffset;

            const parentTop = parentSection.offsetTop;
            const parentHeight = parentSection.offsetHeight;
            const parentBottom = parentTop + parentHeight;

            const stickyHeight = subNav.offsetHeight;

            if (scrollY + headerHeight >= parentTop && scrollY + headerHeight < parentBottom - stickyHeight) {
                subNav.classList.add('scrolled');
                subNav.style.position = 'fixed';
                subNav.style.top = headerHeight + 'px';
                updateStickyWidth();
                subNav.style.bottom = '';
            } else if (scrollY + headerHeight >= parentBottom - stickyHeight) {
                subNav.classList.remove('scrolled');
                subNav.style.position = 'absolute';
                subNav.style.top = '';
                subNav.style.bottom = '0';
                updateStickyWidth();
            } else {
                subNav.classList.remove('scrolled');
                subNav.style.position = '';
                subNav.style.top = '';
                subNav.style.bottom = '';
                subNav.style.width = '';
            }
        }

        window.addEventListener('scroll', onScroll);

        // Only add one resize listener that handles all instances
        if (!window.stickyResizeHandlerAdded) {
            window.addEventListener('resize', function() {
                headerHeight = headerSection.offsetHeight;
                
                stickyElements.forEach(function(nav) {
                    if (window.innerWidth > 991 && (nav.style.position === 'fixed' || nav.style.position === 'absolute')) {
                        const navStickyParent = nav.closest('.sticky-parent');
                        if (navStickyParent) {
                            nav.style.width = navStickyParent.offsetWidth + 'px';
                        }
                    } else {
                        nav.style.width = '';
                        nav.style.position = '';
                        nav.style.top = '';
                        nav.style.bottom = '';
                        nav.classList.remove('scrolled');
                    }
                    
                    // Trigger the scroll handler for each element
                    const scrollHandler = nav.onScrollHandler;
                    if (scrollHandler) scrollHandler();
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