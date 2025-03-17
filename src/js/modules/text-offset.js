export function textOffset() {
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
}
