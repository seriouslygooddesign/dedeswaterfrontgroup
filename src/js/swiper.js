import "../scss/plugins/_swiper.scss";

import Swiper from "swiper";
import { Navigation, Pagination, A11y, EffectFade } from "swiper/modules";

const defaultParameters = (slider) => {
	const paginationSelector = "[data-swiper-pagination]";
	const prevSelector = "[data-swiper-button-prev]";
	const nextSelector = "[data-swiper-button-next]";
	const pagination = slider.querySelector(paginationSelector);
	const prev = slider.querySelector(prevSelector);
	const next = slider.querySelector(nextSelector);
	return {
		modules: [Navigation, Pagination, A11y, EffectFade],
		pagination: pagination
			? {
					el: paginationSelector,
					type: "fraction",
			  }
			: false,
		navigation: {
			nextEl: next ? nextSelector : false,
			prevEl: prev ? prevSelector : false,
		},
	};
};

const sliders = document.querySelectorAll("[data-swiper]");
if (sliders.length) {
	sliders.forEach((slider) => {
		const customParametersJson = slider.dataset.swiper;
		const customParameters = customParametersJson ? JSON.parse(customParametersJson) : {};
		const parameters = { ...defaultParameters(slider), ...customParameters };
		new Swiper(slider, parameters);
	});
}
