import "../scss/style.scss";

import { accordion } from "./modules/accordion";
import { tabs } from "./modules/tabs";
import { overlayMenu } from "./modules/overlay-menu";
import { animate } from "./modules/animate";
import { videoAutoplay } from "./modules/video-autoplay";
import { preload } from "./modules/preload";
import { pdfLinks } from "./modules/pdf-links";
import { dropdown } from "./modules/dropdown";
import { popup } from "./modules/popup";
import { sectionScroll } from "./modules/section-scroll";

overlayMenu();

dropdown();

pdfLinks();

preload();

animate();

videoAutoplay();

accordion();

tabs();

popup();

sectionScroll();

const allTextOffsets = document.querySelectorAll(".text-offset");

allTextOffsets.forEach((textOffset) => {
	const parent = textOffset.parentNode;

	const firstPart = document.createElement("span");
	firstPart.classList.add("text-offset-first-part");

	while (parent.firstChild && parent.firstChild !== textOffset) {
		firstPart.appendChild(parent.firstChild);
	}

	parent.insertBefore(firstPart, textOffset);

	function wrapTextInSpan(el) {
		const text = el.textContent;
		el.textContent = "";
		const newSpan = document.createElement("span");
		newSpan.classList.add("text-offset-content");
		newSpan.textContent = text;
		el.appendChild(newSpan);
	}

	wrapTextInSpan(firstPart);
	wrapTextInSpan(textOffset);

	parent.classList.add("text-offset-active");
});
