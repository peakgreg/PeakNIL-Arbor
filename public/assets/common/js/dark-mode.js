// On load, check saved theme
const savedTheme = localStorage.getItem('theme');
const darkThemeLink = document.getElementById('dark-theme');

// If user has a saved preference, apply it
if (savedTheme) {
  // 'all' => dark; 'not all' => light
  darkThemeLink.media = savedTheme === 'dark' ? 'all' : 'not all';
  document.documentElement.classList.toggle('dark-mode', savedTheme === 'dark');
  document.documentElement.classList.toggle('light-mode', savedTheme === 'light');
}

function toggleTheme() {
  const isDark = darkThemeLink.media === 'all';
  // Toggle link's media
  darkThemeLink.media = isDark ? 'not all' : 'all';

  // Update classes
  document.documentElement.classList.toggle('dark-mode', !isDark);
  document.documentElement.classList.toggle('light-mode', isDark);

  // Save preference
  localStorage.setItem('theme', isDark ? 'light' : 'dark');
}

// Optional: Listen for system changes if no local preference is set
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
  if (!localStorage.getItem('theme')) { // Only if user hasn't set a preference
    darkThemeLink.media = e.matches ? 'all' : 'not all';
    document.documentElement.classList.toggle('dark-mode', e.matches);
    document.documentElement.classList.toggle('light-mode', !e.matches);
  }
});