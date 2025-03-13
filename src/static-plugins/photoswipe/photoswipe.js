const originPath = window.location.origin + "/wp-content/themes/dedeswaterfrontgroup/src/static-plugins/photoswipe/";
const photoSwipeLightboxPath = originPath + "photoswipe-lightbox.esm.js";
const photoSwipePath = originPath + "photoswipe.esm.js";

// Dynamically import modules using import()
import(photoSwipeLightboxPath)
	.then((module) => {
		const PhotoSwipeLightbox = module.default;

		import(photoSwipePath)
			.then((photoSwipeModule) => {
				const PhotoSwipe = photoSwipeModule.default;

				const lightbox = new PhotoSwipeLightbox({
					gallery: "[data-photoswipe]",
					children: "a",
					pswpModule: PhotoSwipe,
				});
				lightbox.init();
			})
			.catch((error) => {
				console.error("Error importing PhotoSwipe module:", error);
			});
	})
	.catch((error) => {
		console.error("Error importing PhotoSwipeLightbox module:", error);
	});
