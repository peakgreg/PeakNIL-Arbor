function fixNavbarPadding() {
  let safeTop = parseFloat(window.getComputedStyle(document.documentElement)
    .getPropertyValue("env(safe-area-inset-top)")) || 10;

  document.documentElement.style.setProperty('--safe-area-inset-top', safeTop + "px");
}

window.addEventListener("load", fixNavbarPadding);
window.addEventListener("resize", fixNavbarPadding);
