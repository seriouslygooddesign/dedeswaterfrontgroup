export function preload() {
  if (document.readyState === "interactive") {
    document.body.classList.remove("preload");
  }
}
