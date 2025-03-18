import lax from "lax.js";
lax.init();

lax.addDriver(
	"scrollY", // Driver name
	function () {
		return window.scrollY; // Value method
	},
	{ inertiaEnabled: true } // Options
);

const handlerLax = () => {
	lax.addElements("[data-lax-effect-bands]", {
		scrollY: {
			style: [
				["elInY", "elOutY - screenHeight"],
				[0, 1],
				{
					cssFn: (val, el) => {
						const items = el.querySelectorAll(".layout-overlap__item");
						const step = 1 / items.length;
						const scale = 1.3 - 0.3 * val;

						el.style.setProperty("--_overlap-scale", scale.toFixed(3));

						let lastActiveIndex = -1;
						items.forEach((item, index) => {
							let currentVal = (val - index * step) / step;

							if (currentVal < 0) currentVal = 0;
							if (currentVal > 1) currentVal = 1;

							if (currentVal > 0.5) {
								lastActiveIndex = index;
							}
						});
						items.forEach((item, index) => {
							item.classList.toggle(
								"active",
								lastActiveIndex === -1 ? index === 0 : index === lastActiveIndex
							);
						});
					},
				},
			],
		},
	});

	lax.addElements("[data-lax-slider]", {
		scrollY: {
			style: [
				["elInY + screenHeight", "elOutY - screenHeight"],
				[0, 1],
				{
					cssFn: (val, el) => {
						el.querySelector(".layout-overflow__body").style.setProperty(`--_translate`, `${val * 100}%`);
					},
				},
			],
		},
	});

	lax.addElements("[data-lax-bg-img]", {
		scrollY: {
			translateY: [
				["elInY", "elOutY"],
				[0, "-400"],
			],
		},
	});
	lax.addElements("[data-lax-translate-easy]", {
		scrollY: {
			translateY: [
				["elInY", "elOutY"],
				["100", "-100"],
			],
		},
	});
};

window.addEventListener("resize", handlerLax);
handlerLax();

function generateGradient(progress, numBands = 30) {
	const step = 100 / numBands;

	const delay = 0.04;

	let gradient = "linear-gradient(0deg, ";

	for (let i = 0; i < numBands; i++) {
		let localProgress = progress * (1 + (numBands - 1) * delay) - i * delay;

		if (localProgress < 0) localProgress = 0;
		if (localProgress > 1) localProgress = 1;

		const bandStart = i * step;
		const blackEnd = bandStart + localProgress * step;

		gradient += `black ${bandStart.toFixed(2)}% ${blackEnd.toFixed(2)}%, `;
		gradient += `transparent ${blackEnd.toFixed(2)}% ${(bandStart + step).toFixed(2)}%`;

		if (i < numBands - 1) gradient += ", ";
	}

	gradient += ")";
	return gradient;
}
