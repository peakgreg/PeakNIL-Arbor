  const menuIcon = document.querySelector('#menu-icon');
  const sidebar = document.querySelector('.sidebar');
  const content = document.querySelector('.content');
  const pinButton = document.querySelector('.pin-button');
  const mobileSearchIcon = document.querySelector('.mobile-search-icon');
  const searchForm = document.querySelector('.search-form');

  let isPinned = localStorage.getItem('menuPinned') === 'true';
  if (isPinned) {
    // Force synchronous layout and disable transitions
    sidebar.style.transition = 'none';
    content.style.transition = 'none';
    void sidebar.offsetHeight; // Trigger reflow
    
    // Apply pinned state without 'open' class
    pinButton.classList.add('active');
    sidebar.classList.add('pinned');
    content.classList.add('pushed');
    
    // Re-enable transitions after next paint cycle
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        sidebar.style.transition = '';
        content.style.transition = '';
      });
    });
  }
  let isMobileSearchVisible = false;

    menuIcon.addEventListener('click', () => {
    if (isPinned) {
      // Close menu and unpin when clicking X
      menuIcon.classList.remove('open');
      sidebar.classList.remove('open');
      isPinned = false;
      pinButton.classList.remove('active');
      sidebar.classList.remove('pinned');
      content.classList.remove('pushed');
      localStorage.setItem('menuPinned', 'false');
      return;
    }
    
    const isOpen = menuIcon.classList.contains('open');
    menuIcon.classList.toggle('open');
    sidebar.classList.toggle('open');
  });

    pinButton.addEventListener('click', () => {
    isPinned = !isPinned;
    pinButton.classList.toggle('active');
    sidebar.classList.toggle('pinned');
    content.classList.toggle('pushed');
    localStorage.setItem('menuPinned', isPinned);
    
    // When pinning, ensure menu is open without transitions
    if (isPinned) {
      sidebar.style.transition = 'none';
      menuIcon.classList.add('open');
      sidebar.classList.add('open');
      void sidebar.offsetHeight; // Trigger reflow
      sidebar.style.transition = '';
    }
  });

    // Mobile search functionality
    mobileSearchIcon.addEventListener('click', () => {
    isMobileSearchVisible = !isMobileSearchVisible;

  if (isMobileSearchVisible) {
        // Create and show temporary search input
        const tempSearch = document.createElement('div');
  tempSearch.className = 'search-form';
  tempSearch.style.display = 'block';
  tempSearch.style.position = 'absolute';
  tempSearch.style.top = '60px';
  tempSearch.style.left = '0';
  tempSearch.style.right = '0';
  tempSearch.style.padding = '10px';
  tempSearch.style.background = 'white';
  tempSearch.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
  tempSearch.innerHTML = `<input type="search" class="search-input" placeholder="Search...">`;

    document.body.appendChild(tempSearch);
    tempSearch.querySelector('input').focus();

        // Close search on click outside
        const closeSearch = (e) => {
          if (!tempSearch.contains(e.target) && e.target !== mobileSearchIcon) {
      tempSearch.remove();
    isMobileSearchVisible = false;
    document.removeEventListener('click', closeSearch);
          }
        };

        setTimeout(() => {
      document.addEventListener('click', closeSearch);
        }, 100);
      }
    });

    // Close menu when clicking outside (only if not pinned)
    document.addEventListener('click', (e) => {
      if (!isPinned &&
          !sidebar.contains(e.target) &&
          !menuIcon.contains(e.target) &&
          sidebar.classList.contains('open')) {
        sidebar.classList.remove('open');
        menuIcon.classList.remove('open');
      }
    });
