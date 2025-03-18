import Headroom from "headroom.js";
export function headroom() {
	const headerSelector = "main-header";
	var options = {
		// css classes to apply
		classes: {
			// when element is initialised
			initial: `${headerSelector}`,
			// when scrolling up
			pinned: `${headerSelector}--pinned`,
			// when scrolling down
			unpinned: `${headerSelector}--unpinned`,
			// when above offset
			top: `${headerSelector}--top`,
			// when below offset
			notTop: `${headerSelector}--not-top`,
			// when at bottom of scroll area
			bottom: `${headerSelector}--bottom`,
			// when not at bottom of scroll area
			notBottom: `${headerSelector}--not-bottom`,
			// when frozen method has been called
			frozen: `${headerSelector}--frozen`,
			// multiple classes are also supported with a space-separated list
			pinned: `${headerSelector}--pinned foo bar`,
		},
	};

	// grab an element
	var header = document.querySelector(`.${headerSelector}`);
	// construct an instance of Headroom, passing the element
	var headroom = new Headroom(header, options);
	// initialise
	headroom.init();
}
