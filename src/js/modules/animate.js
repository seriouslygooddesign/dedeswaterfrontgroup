export function animate() {
	const els = document.querySelectorAll("[data-animate]");
	// const titles = Array.from(document.querySelectorAll("*")).filter((el) => el.querySelector(":scope > .text-offset"));
	const titles = document.querySelectorAll(":has(> .text-offset)");

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add("animate-show");
					observer.unobserve(entry.target);
				}
			});
		},
		{
			rootMargin: "-100px",
		}
	);
	els.forEach((el) => {
		observer.observe(el);
	});
	titles.forEach((el) => {
		observer.observe(el);
	});
}
