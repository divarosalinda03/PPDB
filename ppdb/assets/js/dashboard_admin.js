document.addEventListener('DOMContentLoaded', () => {
  const menuBar = document.getElementById('menuBar');
  const hamburger = document.querySelector('.hamburger');

  // Create overlay div dynamically
  let overlay = document.createElement('div');
  overlay.classList.add('menu-overlay');
  document.body.appendChild(overlay);

  function closeMenu() {
    menuBar.classList.remove('active');
    overlay.classList.remove('active');
  }

  hamburger.addEventListener('click', () => {
    const isActive = menuBar.classList.contains('active');
    if (isActive) {
      closeMenu();
    } else {
      menuBar.classList.add('active');
      overlay.classList.add('active');
    }
  });

  overlay.addEventListener('click', closeMenu);

  // Close menu when any menu link clicked
  menuBar.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', closeMenu);
  });

  // Close menu on escape key press for accessibility
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && menuBar.classList.contains('active')) {
      closeMenu();
    }
  });
});
