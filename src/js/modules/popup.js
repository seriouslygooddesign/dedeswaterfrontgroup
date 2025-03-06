export function popup() {
  const popupSelector = "[data-sgd-popup]";

  class MainPopup {
    static popupOpenedBy = undefined;
    constructor(popup) {
      this.popup = popup;
      this.togglerOpenSelectors = this.popup.dataset.sgdPopupTriggerSelector;
      this.togglersOpen = this.togglerOpenSelectors && this.isValidSelector(this.togglerOpenSelectors) ? document.querySelectorAll(this.togglerOpenSelectors) : [];
      this.togglersClose = this.popup.querySelectorAll("[data-sgd-popup-toggler-close]");
      this.focusableElements = this.getFocusableElements();
      this.firstFocusableElement = this.focusableElements[0];
      this.lastFocusableElement = this.focusableElements[this.focusableElements.length - 1];
      this.activeClass = "active";

      const windowLocationHash = window.location.hash;
      if (windowLocationHash) {
        this.togglersOpen.forEach((toggler) => {
          const togglerHash = toggler.hash;
          if (togglerHash && togglerHash === windowLocationHash) {
            this.popupShow();
          }
        });
      }

      this.togglersOpen?.forEach((togglerOpen) => {
        togglerOpen.addEventListener("click", (e) => {
          e.preventDefault();
          this.popupShow();

          //define popupOpenedBy if togglerOpen is not inside popup
          if (!togglerOpen.closest(popupSelector)) {
            MainPopup.popupOpenedBy = togglerOpen;
          }
        });
      });

      this.togglersClose?.forEach((togglerClose) => {
        togglerClose.addEventListener("click", (e) => {
          e.preventDefault();
          this.popupClose();
        });
      });

      document.addEventListener("keydown", (e) => {
        if (e.code === "Escape") {
          this.popupClose();
        }
      });
    }

    isValidSelector(selector) {
      try {
        document.querySelectorAll(selector);
      } catch (e) {
        if (e instanceof DOMException) {
          console.error("Not valid popup trigger selector: " + selector);
          return false;
        }
      }
      return true;
    }

    isActive(popup = this.popup) {
      return popup.classList.contains(this.activeClass);
    }

    focusTrap(parent = this.popup) {
      parent.addEventListener("keydown", (event) => {
        if (event.key === "Tab" || event.keyCode === 9) {
          if (event.shiftKey) {
            // if shift key pressed for shift + tab combination
            if (document.activeElement === this.firstFocusableElement) {
              event.preventDefault();
              this.lastFocusableElement.focus();
            }
          } else {
            // if tab key is pressed
            if (document.activeElement === this.lastFocusableElement) {
              event.preventDefault();
              this.firstFocusableElement.focus();
            }
          }
        }
      });
    }

    getFocusableElements(parent = this.popup) {
      return Array.from(parent.querySelectorAll('a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])')).filter(
        (el) => !el.hasAttribute("disabled") && !el.getAttribute("aria-hidden") && el.type !== "hidden"
      );
    }

    popupShow(popup = this.popup) {
      const activePopups = document.querySelectorAll(`${popupSelector}.${this.activeClass}`);
      activePopups?.forEach((activePopup) => {
        if (activePopup !== this.popup) {
          this.popupClose(activePopup);
        }
      });

      popup.classList.add(this.activeClass);
      popup.addEventListener("transitionend", (event) => {
        if (event.target === popup && this.isActive()) {
          this.firstFocusableElement.focus({
            preventScroll: true,
          });
        }
      });
      this.focusTrap();
    }

    popupClose(popup = this.popup) {
      if (!this.isActive(popup)) return;
      popup.classList.remove(this.activeClass);
      MainPopup.popupOpenedBy?.focus({
        preventScroll: true,
      });
    }
  }

  const popups = document.querySelectorAll(popupSelector);
  popups.forEach((popup) => {
    new MainPopup(popup);
  });
}
