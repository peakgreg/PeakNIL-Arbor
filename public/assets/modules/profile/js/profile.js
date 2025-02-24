// Create a media query for screens 576px and below
const smallScreen = window.matchMedia('(max-width: 576px)');

window.addEventListener('scroll', function () {
  const scrollY = window.scrollY || window.pageYOffset;
  const profileNameElement = document.querySelector('.profile-name');
  const stickyImage = document.querySelector('.profile-image-sticky');
  const stickyTopFirst = document.querySelector('.sticky-top-first'); // <-- new

  // Decide the scroll threshold based on screen size
  const threshold = smallScreen.matches ? 198 : 404;

  if (scrollY >= threshold) {
    profileNameElement.classList.add('scrolled');
    stickyImage.classList.add('sticky-show');
    stickyTopFirst.classList.add('scrolled'); // <-- toggle it here
  } else {
    profileNameElement.classList.remove('scrolled');
    stickyImage.classList.remove('sticky-show');
    stickyTopFirst.classList.remove('scrolled'); // <-- remove it here
  }
});

document.querySelector('.read-more').addEventListener('click', function () {
  const container = document.querySelector('.description-container');
  container.classList.toggle('expanded');
  this.textContent = container.classList.contains('expanded') ? 'Hide' : '+ Read More';
});