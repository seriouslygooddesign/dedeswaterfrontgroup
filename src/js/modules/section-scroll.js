export function sectionScroll() {
	// Get all navigation links
	const scrollIdSelector = "data-section-scroll-section";
	const scrollTriggers = document.querySelectorAll("[data-section-scroll-trigger]");

	if (!scrollTriggers.length) return;
	// Smooth scroll on link click + set active class on click
	scrollTriggers.forEach((trigger) => {
		trigger.addEventListener("click", (event) => {
			event.preventDefault();

			// Remove active class from all links and add active class to the clicked link
			scrollTriggers.forEach((s) => s.classList.remove("active"));
			trigger.classList.add("active");

			// Smooth scroll to the corresponding section
			const targetId = trigger.getAttribute("href").substring(1);
			const targetElement = document.getElementById(targetId);
			if (targetElement) {
				targetElement.scrollIntoView({ behavior: "smooth" });
			}

			// Scroll to link on mobile within the scrollbar
			const container = trigger.closest(".section-navigation__list");
			const scrollLeft = trigger.getBoundingClientRect().left - container.getBoundingClientRect().x;
			container.scrollLeft += scrollLeft;
		});
	});

	// Intersection Observer to add 'active' class based on visible section
	const options = {
		root: null,
		rootMargin: "-50% 0px",
		threshold: 0,
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				const visibleSectionId = entry.target.getAttribute("id");
				scrollTriggers.forEach((link) => {
					link.classList.toggle("active", link.getAttribute("href").substring(1) === visibleSectionId);
				});
			}
		});
	}, options);

	// Observe all elements with data-section-scroll-section
	const sections = document.querySelectorAll(`[${scrollIdSelector}]`);
	sections.forEach((section) => observer.observe(section));
}
