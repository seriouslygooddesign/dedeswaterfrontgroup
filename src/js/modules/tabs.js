import { toggleVisibility, visibleClass, activeClass } from "./helpers";

export function tabs() {
  function tabHandler(tab) {
    // Do nothing if the current tab has the .active class
    if (tab.classList.contains(activeClass)) {
      return;
    }

    const tabsParent = tab.closest("[data-tabs]");

    // Remove active item
    const activeTab = tabsParent.querySelector("[data-tab]." + activeClass);
    activeTab.classList.remove(activeClass);
    activeTab.setAttribute("aria-selected", "false");

    // Add active item
    tab.classList.add(activeClass);
    tab.setAttribute("aria-selected", "true");

    // Toggle tab panels visibility
    const visibleTabPanel = tabsParent.querySelector(`.${visibleClass}`);
    toggleVisibility(visibleTabPanel);
    const targetTabPanel = document.getElementById(tab.getAttribute("aria-controls"));
    toggleVisibility(targetTabPanel);

    // Scroll to tab on mobile within the scrollbar
    const tabList = tabsParent.querySelector("[data-tablist]");
    const tabListStyles = window.getComputedStyle(tabList);
    const tabListStylesLeftOffset = parseInt(tabListStyles.paddingLeft);
    const scrollLeft = tab.getBoundingClientRect().left - tabListStylesLeftOffset;
    tabList.scrollLeft += scrollLeft;
  }

  const tabs = document.querySelectorAll("[data-tab]");
  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      tabHandler(tab);
    });
  });
}
