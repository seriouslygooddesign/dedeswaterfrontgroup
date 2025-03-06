export function pdfLinks() {
  const pdfLinks = document.querySelectorAll('a[href$=".pdf"]');
  if (pdfLinks.length) {
    pdfLinks.forEach((link) => {
      link.setAttribute("target", "_blank");
      link.setAttribute("rel", "noopener noreferrer");
    });
  }
}
