import { toggleVisibility, activeClass } from "./helpers";

export function accordion() {
  const accordionHandler = (accordion) => {
    const accordionAriaControls = accordion.getAttribute("aria-controls");
    const accordionItem = accordion.closest("[data-accordion-item]");
    toggleVisibility(document.getElementById(accordionAriaControls));
    accordionItem.classList.toggle(activeClass);

    accordion.setAttribute("aria-expanded", accordion.getAttribute("aria-expanded") === "false" ? "true" : "false");
  };

  const accordionTogglers = document.querySelectorAll("[data-accordion-toggler]");
  accordionTogglers.forEach((accordionToggler) => {
    accordionToggler.addEventListener("click", () => {
      accordionHandler(accordionToggler);
    });
  });
}
