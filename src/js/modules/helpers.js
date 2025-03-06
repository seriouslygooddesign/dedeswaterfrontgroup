export function isTouchDevice() {
  return window.matchMedia("(pointer: coarse)").matches;
}

export function isOverlayMenu() {
  const overlayMenuBreakpoint = parseInt(window.getComputedStyle(document.documentElement).getPropertyValue("--overlay-menu-breakpoint")) || false;
  return typeof overlayMenuBreakpoint === "number" ? window.innerWidth < overlayMenuBreakpoint : true;
}

export const activeClass = "active";

export const visibleClass = "element-visible";

export function toggleVisibility(element) {
  element.classList.toggle(visibleClass);
}
