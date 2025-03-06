import { overlayMenuDropdownsRemoveActiveState } from "./dropdown";
import { activeClass } from "./helpers";
export function isOverlayMenu() {
	const overlayMenuBreakpoint =
		parseInt(window.getComputedStyle(document.documentElement).getPropertyValue("--overlay-menu-breakpoint")) ||
		false;
	return typeof overlayMenuBreakpoint === "number" ? window.innerWidth < overlayMenuBreakpoint : true;
}

export function overlayMenu() {
	const overlayMenu = document.querySelector("[data-overlay-menu]");
	if (!overlayMenu) return;
	const overlayMenuBody = document.querySelector("[data-overlay-menu-body]");
	const overlayMenuTogglers = document.querySelectorAll("[data-overlay-menu-toggler]");
	const overlayMenuCustomLinks = overlayMenu.querySelectorAll(".menu-item-type-custom:not(.main-menu__dropdown) > a");

	const changingClass = "changing";

	const isOverlayMenuActive = () => {
		return isOverlayMenu() && overlayMenu.classList.contains(activeClass);
	};

	const overlayMenuToggleActiveState = () => {
		overlayMenu.classList.toggle(activeClass);
		overlayMenu.classList.add(changingClass);
		overlayMenu.addEventListener("transitionend", () => {
			overlayMenu.classList.remove(changingClass);
		});
		if (!isOverlayMenuActive()) {
			overlayMenuDropdownsRemoveActiveState();
		}
	};

	// Force scroll up when vertical scrollbar exists in overlay menu
	const mainMenus = document.querySelectorAll("[data-main-menu]");
	mainMenus.forEach((mainMenu) => {
		const dropdownTogglers = mainMenu?.querySelectorAll("[data-dropdown-toggler]");
		dropdownTogglers.forEach((dropdownToggler) => {
			dropdownToggler.addEventListener("click", () => {
				if (isOverlayMenu()) {
					const currentDropdownMenu = dropdownToggler.closest("[data-dropdown-menu]");
					const childDropdownMenu = dropdownToggler
						.closest("[data-dropdown]")
						.querySelector("[data-dropdown-menu]");
					const scrollTopElements = [overlayMenuBody, childDropdownMenu, currentDropdownMenu];
					scrollTopElements.forEach((scrollTopElement) => {
						scrollTopElement?.scrollTo(0, 0);
					});
				}
			});
		});
	});

	//Toggler Click
	overlayMenuTogglers.forEach((toggler) => {
		toggler.addEventListener("click", (e) => {
			overlayMenuToggleActiveState();
		});
	});

	//Custom Link Click
	overlayMenuCustomLinks.forEach((link) =>
		link.addEventListener("click", (e) => {
			const target = document.getElementById(e.target.hash?.substring(1));
			if (isOverlayMenuActive() && target) overlayMenuToggleActiveState();
		})
	);

	//Escape Click
	document.addEventListener("keydown", (e) => {
		if (e.key == "Escape" && isOverlayMenuActive()) {
			overlayMenuToggleActiveState();
		}
	});
}
