<!-- Navbar -->
<nav class="navbar">
  <div class="navbar-left">
    <div id="menu-icon">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    <a href="/" class="navbar-logo-link">
      <div class="navbar-logo"></div>
    </a>
  </div>

  <div class="navbar-center" style = "margin-top: 14px;">
    <form class="search-form">
      <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
        color="#0e0e0e" fill="none" style = "margin-top: -8px;">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M16.7929 16.7929C17.1834 16.4024 17.8166 16.4024 18.2071 16.7929L22.7071 21.2929C23.0976 21.6834 23.0976 22.3166 22.7071 22.7071C22.3166 23.0976 21.6834 23.0976 21.2929 22.7071L16.7929 18.2071C16.4024 17.8166 16.4024 17.1834 16.7929 16.7929Z"
          fill="currentColor" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M1 11C1 5.47715 5.47715 1 11 1C16.5228 1 21 5.47715 21 11C21 16.5228 16.5228 21 11 21C5.47715 21 1 16.5228 1 11ZM11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3Z"
          fill="currentColor" />
      </svg>
      <input type="search" class="search-input" placeholder="Search...">
    </form>
  </div>

  <div class="navbar-right">
    <svg class="mobile-search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
      fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8"></circle>
      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>

    <!-- Dark Mode Toggle -->
    <button id="theme-toggle-btn" class = "toggle-dark-mode" aria-label="Toggle theme" onclick="toggleTheme()">
      <!-- Sun icon -->
      <span id="sun-icon" class="theme-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class = "sun-icon" fill="none">
          <path d="M17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12Z" stroke="currentColor" stroke-width="1.5"/>
          <path d="M12 2V3.5M12 20.5V22M19.0708 19.0713L18.0101 18.0106M5.98926 5.98926L4.9286 4.9286M22 12H20.5M3.5 12H2M19.0713 4.92871L18.0106 5.98937M5.98975 18.0107L4.92909 19.0714" 
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </span>
      
      <!-- Moon icon -->
      <span id="moon-icon" class="theme-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class = "moon-icon" fill="none">
          <path d="M21.5 14.0784C20.3003 14.7189 18.9301 15.0821 17.4751 15.0821C12.7491 15.0821 8.91792 11.2509 8.91792 6.52485C8.91792 5.06986 9.28105 3.69968 9.92163 2.5C5.66765 3.49698 2.5 7.31513 2.5 11.8731C2.5 17.1899 6.8101 21.5 12.1269 21.5C16.6849 21.5 20.503 18.3324 21.5 14.0784Z"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
    </button>
    <!-- END: Dark Mode Toggle -->

    <a class="button btn btn-outline-default" href="#login">Login</a>
    <a class="button btn btn-outline-default" href="#signup">Signup</a>
  </div>
</nav>

<div class="sidebar">
  <button class="pin-button">
    <svg class="unpinned-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
      color="#9b9b9b" fill="none">
      <path d="M12 16V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      <path
        d="M8 5.2918C8 5.02079 8 4.88529 8.01312 4.77132C8.1194 3.84789 8.84789 3.1194 9.77133 3.01312C9.88529 3 10.0208 3 10.2918 3H13.7082C13.9792 3 14.1147 3 14.2287 3.01312C15.1521 3.1194 15.8806 3.84789 15.9869 4.77132C16 4.88529 16 5.02079 16 5.2918C16 5.37885 16 5.42237 15.9967 5.46264C15.9708 5.78281 15.7927 6.07104 15.5179 6.2374C15.4834 6.25832 15.4444 6.27779 15.3666 6.31672L15.1055 6.44726C14.7021 6.64897 14.5003 6.74983 14.3681 6.90564C14.26 7.03286 14.1856 7.18509 14.1515 7.34846C14.1097 7.54854 14.1539 7.76968 14.2424 8.21197L15 12H15.3333C15.9533 12 16.2633 12 16.5176 12.0681C17.2078 12.2531 17.7469 12.7922 17.9319 13.4824C18 13.7367 18 14.0467 18 14.6667C18 14.9767 18 15.1317 17.9659 15.2588C17.8735 15.6039 17.6039 15.8735 17.2588 15.9659C17.1317 16 16.9767 16 16.6667 16H7.33333C7.02334 16 6.86835 16 6.74118 15.9659C6.39609 15.8735 6.12654 15.6039 6.03407 15.2588C6 15.1317 6 14.9767 6 14.6667C6 14.0467 6 13.7367 6.06815 13.4824C6.25308 12.7922 6.79218 12.2531 7.48236 12.0681C7.73669 12 8.04669 12 8.66667 12H9L9.75761 8.21197C9.84606 7.76968 9.89029 7.54854 9.84852 7.34846C9.81441 7.18509 9.73995 7.03286 9.63194 6.90564C9.49965 6.74983 9.29794 6.64897 8.89452 6.44726L8.63344 6.31672C8.55558 6.27779 8.51665 6.25832 8.48208 6.2374C8.20731 6.07104 8.02917 5.78281 8.00326 5.46264C8 5.42237 8 5.37885 8 5.2918Z"
        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    <svg class="pinned-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
      color="#000000" fill="none">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M10 2.25C8.48122 2.25 7.25 3.48122 7.25 5V5.38197C7.25 6.04482 7.6245 6.65078 8.21738 6.94721L9.15222 7.41464L8.38515 11.25H8C6.48122 11.25 5.25 12.4812 5.25 14V16C5.25 16.4142 5.58579 16.75 6 16.75H11V20.75C11 21.3023 11.4477 21.75 12 21.75C12.5523 21.75 13 21.3023 13 20.75V16.75H18C18.4142 16.75 18.75 16.4142 18.75 16V14C18.75 12.4812 17.5188 11.25 16 11.25H15.6149L14.8478 7.41464L15.7826 6.94721C16.3755 6.65078 16.75 6.04482 16.75 5.38197V5C16.75 3.48122 15.5188 2.25 14 2.25H10Z"
        fill="currentColor" />
    </svg>
  </button>
  <ul class="menu-items">
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Services</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</div>
<!-- END: Menu -->