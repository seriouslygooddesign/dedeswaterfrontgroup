import { isOverlayMenu } from "./overlay-menu";
import { isTouchDevice, activeClass } from "./helpers";

function getActiveDropdowns() {
  return document.querySelectorAll("[data-dropdown]." + activeClass);
}

function dropdownToggleActiveState(dropdown) {
  dropdown.classList.toggle(activeClass);
}

export function overlayMenuDropdownsRemoveActiveState() {
  getActiveDropdowns().forEach((activeDropdown) => {
    if (isOverlayMenuDropdown(activeDropdown)) {
      dropdownToggleActiveState(activeDropdown);
    }
  });
}

function isOverlayMenuDropdown(dropdown) {
  return isOverlayMenu() && dropdown.getAttribute("data-dropdown-location") === "overlay-menu";
}

export function dropdown() {
  const dropdowns = document.querySelectorAll("[data-dropdown]");
  dropdowns.forEach((dropdown) => {
    const dropdownToggler = dropdown.querySelector("[data-dropdown-toggler]");
    const dropdownTogglerBack = dropdown.querySelector("[data-dropdown-toggler-back]");
    const dropdownTogglers = [dropdownToggler, dropdownTogglerBack];
    dropdownTogglers.forEach((dropdownToggler) => {
      dropdownToggler?.addEventListener("click", (e) => {
        if (isTouchDevice() || isOverlayMenuDropdown(dropdown)) {
          e.preventDefault();
          dropdownToggleActiveState(dropdown);
        }
      });
    });
  });

  //Document Click
  document.addEventListener("click", (e) => {
    getActiveDropdowns().forEach((activeDropdown) => {
      if (!isOverlayMenuDropdown(activeDropdown) && !activeDropdown.contains(e.target)) {
        dropdownToggleActiveState(activeDropdown);
      }
    });
  });

  //Escape Click
  document.addEventListener("keydown", (e) => {
    if (e.key == "Escape") {
      getActiveDropdowns().forEach((activeDropdown) => {
        dropdownToggleActiveState(activeDropdown);
      });
    }
  });
}
