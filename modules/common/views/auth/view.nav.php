<?php
// Check if user is logged in
if (isset($_SESSION['uuid'])) : ?>
<!-- Navbar -->
<nav class="navbar navbar-expand-md fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <!-- Left Column -->
    <div class="d-flex">
      <div class="navbar-left">
        <div id="menu-icon" class = "d-none d-lg-block">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <a href="/">
          <div class="navbar-logo" style = "margin-left: -6px;"></div>
        </a>

        <?php
        include MODULES_PATH . '/common/views/common/view.school-dropdown.php';
        ?>

      </div>
    </div>
    <!-- Middle Column (Hidden on md and smaller) -->
    <div class="navbar-middle position-absolute start-50 translate-middle-x d-none d-lg-block">
      <form class="search-form">
        <input type="search" class="search-input" placeholder="Search...">
      </form>
    </div>
    <!-- Right Column -->
    <div class="d-flex">
      <div class="dropdown">
        <button class="button btn btn-light border border-1 rounded-4 dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <?= $_SESSION['username'] ?>
        </button>
        <ul class="dropdown-menu rounded-4 dropdown-menu-end pt-3 pb-3" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="/settings">Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="/logout">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<style>
    .navbar-middle {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      width: 300px; /* Fixed width for the search bar */
    }

    .sidebar {
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding-bottom: 60px;
    }

    .scrollable-menu {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .menu-title {
      font-size: 0.8rem;
      font-weight: 600;
      color: #4b5563;
    }

  .menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.5rem 1rem;
    color: #4b5563;
    text-decoration: none;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.2s ease;
    background: transparent;
  }

  .menu-link:hover {
    background: #f3f4f6;
    color: #1f2937;
  }

  .menu-link.active {
    color: #1f2937;
    font-weight: 600;
    background: #e5e7eb;
  }

  .menu-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
  }

  .menu-link.text-danger {
    color: #dc2626 !important;
  }

  .menu-link.text-danger:hover {
    background: #fee2e2;
  }

  .menu-link:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(209, 213, 219, 0.5);
  }
</style>

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
      color="red" fill="none">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M10 2.25C8.48122 2.25 7.25 3.48122 7.25 5V5.38197C7.25 6.04482 7.6245 6.65078 8.21738 6.94721L9.15222 7.41464L8.38515 11.25H8C6.48122 11.25 5.25 12.4812 5.25 14V16C5.25 16.4142 5.58579 16.75 6 16.75H11V20.75C11 21.3023 11.4477 21.75 12 21.75C12.5523 21.75 13 21.3023 13 20.75V16.75H18C18.4142 16.75 18.75 16.4142 18.75 16V14C18.75 12.4812 17.5188 11.25 16 11.25H15.6149L14.8478 7.41464L15.7826 6.94721C16.3755 6.65078 16.75 6.04482 16.75 5.38197V5C16.75 3.48122 15.5188 2.25 14 2.25H10Z"
        fill="currentColor" />
    </svg>
  </button>

  <div class="scrollable-menu p-3">
    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
      <li>
        <a class="menu-link <?= $_SERVER['REQUEST_URI'] === '/marketplace' ? 'active' : '' ?>" href="/marketplace">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M7.5 17C9.8317 14.5578 14.1432 14.4428 16.5 17M14.4951 9.5C14.4951 10.8807 13.3742 12 11.9915 12C10.6089 12 9.48797 10.8807 9.48797 9.5C9.48797 8.11929 10.6089 7 11.9915 7C13.3742 7 14.4951 8.11929 14.4951 9.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Marketplace
        </a>
      </li>

      <li>
        <a class="menu-link <?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>" href="/dashboard">
          <!-- Your custom dashboard icon -->
          <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
            <path d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V8C10 9.88562 10 10.8284 9.41421 11.4142C8.82843 12 7.88562 12 6 12C4.11438 12 3.17157 12 2.58579 11.4142C2 10.8284 2 9.88562 2 8V6Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M2 19C2 18.0681 2 17.6022 2.15224 17.2346C2.35523 16.7446 2.74458 16.3552 3.23463 16.1522C3.60218 16 4.06812 16 5 16H7C7.93188 16 8.39782 16 8.76537 16.1522C9.25542 16.3552 9.64477 16.7446 9.84776 17.2346C10 17.6022 10 18.0681 10 19C10 19.9319 10 20.3978 9.84776 20.7654C9.64477 21.2554 9.25542 21.6448 8.76537 21.8478C8.39782 22 7.93188 22 7 22H5C4.06812 22 3.60218 22 3.23463 21.8478C2.74458 21.6448 2.35523 21.2554 2.15224 20.7654C2 20.3978 2 19.9319 2 19Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M14 16C14 14.1144 14 13.1716 14.5858 12.5858C15.1716 12 16.1144 12 18 12C19.8856 12 20.8284 12 21.4142 12.5858C22 13.1716 22 14.1144 22 16V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V16Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M14 5C14 4.06812 14 3.60218 14.1522 3.23463C14.3552 2.74458 14.7446 2.35523 15.2346 2.15224C15.6022 2 16.0681 2 17 2H19C19.9319 2 20.3978 2 20.7654 2.15224C21.2554 2.35523 21.6448 2.74458 21.8478 3.23463C22 3.60218 22 4.06812 22 5C22 5.93188 22 6.39782 21.8478 6.76537C21.6448 7.25542 21.2554 7.64477 20.7654 7.84776C20.3978 8 19.9319 8 19 8H17C16.0681 8 15.6022 8 15.2346 7.84776C14.7446 7.64477 14.3552 7.25542 14.1522 6.76537C14 6.39782 14 5.93188 14 5Z" stroke="currentColor" stroke-width="1.5" />
          </svg>
          Dashboard
        </a>
      </li>
      <li>
        <a class="menu-link <?= $_SERVER['REQUEST_URI'] === '/deals' ? 'active' : '' ?>" href="/deals">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M22 6.75H18L15.7558 5.25685C15.263 4.92636 14.6839 4.75 14.0917 4.75H11.7426C10.947 4.75 10.1839 5.06795 9.62132 5.63391L7 8.27083L8.10218 9.15782C8.89796 9.79823 10.0452 9.73432 10.7658 9.00942L12 7.76785H13L19 13.8036C19.5523 14.3591 19.5523 15.2599 19 15.8155C18.4477 16.371 17.5523 16.371 17 15.8155L16.5 15.3125M13.5 12.2946L16.5 15.3125M16.5 15.3125C17.0523 15.8681 17.0523 16.7688 16.5 17.3244C15.9477 17.88 15.0523 17.88 14.5 17.3244L13.5 16.3184M13.5 16.3184C14.0523 16.874 14.0523 17.7748 13.5 18.3303C12.9477 18.8859 12.0523 18.8859 11.5 18.3303L10 16.8214M13.5 16.3184L11.5 14.3184M9.5 16.3184L10 16.8214M10 16.8214C10.5523 17.377 10.5523 18.2777 10 18.8333C9.44772 19.3889 8.55229 19.3889 8 18.8333L4 14.75H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M22 14.75H19.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
              <path d="M8.5 6.75L2 6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Deals
        </a>
      </li>


      <div class = "menu-title">FINANCIAL</div>
      <li>
        <a class="menu-link <?= $_SERVER['REQUEST_URI'] === '/wallet' ? 'active' : '' ?>" href="/wallet">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M3 8.5H15C17.8284 8.5 19.2426 8.5 20.1213 9.37868C21 10.2574 21 11.6716 21 14.5V15.5C21 18.3284 21 19.7426 20.1213 20.6213C19.2426 21.5 17.8284 21.5 15 21.5H9C6.17157 21.5 4.75736 21.5 3.87868 20.6213C3 19.7426 3 18.3284 3 15.5V8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
              <path d="M15 8.49833V4.1103C15 3.22096 14.279 2.5 13.3897 2.5C13.1336 2.5 12.8812 2.56108 12.6534 2.67818L3.7623 7.24927C3.29424 7.48991 3 7.97203 3 8.49833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Wallet
        </a>
      </li>


      <li>
        <a class="menu-link <?= $_SERVER['REQUEST_URI'] === '/settings' ? 'active' : '' ?>" href="/settings">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M21.011 14.0965C21.5329 13.9558 21.7939 13.8854 21.8969 13.7508C22 13.6163 22 13.3998 22 12.9669V11.0332C22 10.6003 22 10.3838 21.8969 10.2493C21.7938 10.1147 21.5329 10.0443 21.011 9.90358C19.0606 9.37759 17.8399 7.33851 18.3433 5.40087C18.4817 4.86799 18.5509 4.60156 18.4848 4.44529C18.4187 4.28902 18.2291 4.18134 17.8497 3.96596L16.125 2.98673C15.7528 2.77539 15.5667 2.66972 15.3997 2.69222C15.2326 2.71472 15.0442 2.90273 14.6672 3.27873C13.208 4.73448 10.7936 4.73442 9.33434 3.27864C8.95743 2.90263 8.76898 2.71463 8.60193 2.69212C8.43489 2.66962 8.24877 2.77529 7.87653 2.98663L6.15184 3.96587C5.77253 4.18123 5.58287 4.28891 5.51678 4.44515C5.45068 4.6014 5.51987 4.86787 5.65825 5.4008C6.16137 7.3385 4.93972 9.37763 2.98902 9.9036C2.46712 10.0443 2.20617 10.1147 2.10308 10.2492C2 10.3838 2 10.6003 2 11.0332V12.9669C2 13.3998 2 13.6163 2.10308 13.7508C2.20615 13.8854 2.46711 13.9558 2.98902 14.0965C4.9394 14.6225 6.16008 16.6616 5.65672 18.5992C5.51829 19.1321 5.44907 19.3985 5.51516 19.5548C5.58126 19.7111 5.77092 19.8188 6.15025 20.0341L7.87495 21.0134C8.24721 21.2247 8.43334 21.3304 8.6004 21.3079C8.76746 21.2854 8.95588 21.0973 9.33271 20.7213C10.7927 19.2644 13.2088 19.2643 14.6689 20.7212C15.0457 21.0973 15.2341 21.2853 15.4012 21.3078C15.5682 21.3303 15.7544 21.2246 16.1266 21.0133L17.8513 20.034C18.2307 19.8187 18.4204 19.711 18.4864 19.5547C18.5525 19.3984 18.4833 19.132 18.3448 18.5991C17.8412 16.6616 19.0609 14.6226 21.011 14.0965Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Settings
        </a>
      </li>

<?php
if (isset($_SESSION['experimental_access']) && $_SESSION['experimental_access'] == '1') {
?>
      <div class = "menu-title">EXPERIMENTAL</div>

      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/school-manager' ? 'active' : '' ?>" href="/school-manager">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M3.12759 16.6114C1.16104 12.8506 1.76719 8.09708 4.94283 4.93254C8.6204 1.26784 14.4364 1.037 18.3673 4.24499L15.8897 5.3039M20.8724 7.3886C22.839 11.1494 22.2328 15.9029 19.0572 19.0675C15.3796 22.7322 9.56364 22.963 5.63272 19.755L8.10753 18.6989" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
              <path d="M18.0607 13.4759L17.989 9.99982M17.989 9.99982L11.966 7.01959C11.9632 7.01821 11.9599 7.01821 11.9571 7.0196L6.03094 9.96224C6.02363 9.96587 6.02352 9.97627 6.03075 9.98006L8.53385 11.2903M17.989 9.99982L15.4656 11.2903M15.4656 11.2903L11.9616 12.9836L8.53385 11.2903M15.4656 11.2903V15.0478L11.9666 17.0176C11.9635 17.0194 11.9597 17.0193 11.9566 17.0175L8.53385 14.986V11.2903" stroke="currentColor" stroke-width="1.5" />
          </svg>
          School Manager
        </a>
      </li>

      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/parents' ? 'active' : '' ?>" href="/parents">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M15 11C17.2091 11 19 9.20914 19 7C19 4.79086 17.2091 3 15 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M11 14H7C4.23858 14 2 16.2386 2 19C2 20.1046 2.89543 21 4 21H14C15.1046 21 16 20.1046 16 19C16 16.2386 13.7614 14 11 14Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
              <path d="M17 14C19.7614 14 22 16.2386 22 19C22 20.1046 21.1046 21 20 21H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Parent Portal
        </a>
      </li>

      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/data-services' ? 'active' : '' ?>" href="/data-services">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M17.4776 10.0001C17.485 10 17.4925 10 17.5 10C19.9853 10 22 12.0147 22 14.5C22 16.9853 19.9853 19 17.5 19H7C4.23858 19 2 16.7614 2 14C2 11.4003 3.98398 9.26407 6.52042 9.0227M17.4776 10.0001C17.4924 9.83536 17.5 9.66856 17.5 9.5C17.5 6.46243 15.0376 4 12 4C9.12324 4 6.76233 6.20862 6.52042 9.0227M17.4776 10.0001C17.3753 11.1345 16.9286 12.1696 16.2428 13M6.52042 9.0227C6.67826 9.00768 6.83823 9 7 9C8.12582 9 9.16474 9.37209 10.0005 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Data Services
        </a>
      </li>

      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/collectives' ? 'active' : '' ?>" href="/collectives">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
            <path d="M15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16 4C17.6569 4 19 5.34315 19 7C19 8.22309 18.2681 9.27523 17.2183 9.7423" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M14 14H10C7.79086 14 6 15.7909 6 18V20H18V18C18 15.7909 16.2091 14 14 14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M18 13C20.2091 13 22 14.7909 22 17V19H20.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 4C6.34315 4 5 5.34315 5 7C5 8.22309 5.73193 9.27523 6.78168 9.7423" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6 13C3.79086 13 2 14.7909 2 17V19H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
          Collectives
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/deal-builder' ? 'active' : '' ?>" href="/deal-builder">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M14 4H10C6.22876 4 4.34315 4 3.17157 5.17157C2 6.34315 2 8.22876 2 12C2 15.7712 2 17.6569 3.17157 18.8284C4.34315 20 6.22876 20 10 20H14C16.8089 20 18.2134 20 19.2223 19.3259C19.659 19.034 20.034 18.659 20.3259 18.2223C21 17.2134 21 15.8089 21 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M2 12.0168L4.5 9.6005C5.32843 8.79983 6.67157 8.79983 7.5 9.60051C8.32843 10.4012 8.32843 11.6993 7.5 12.5C6.67157 13.3007 6.67157 14.5988 7.5 15.3995C8.32843 16.2002 9.67157 16.2002 10.5 15.3995L11 14.9162" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M14.6716 13H13V11.3284C13 10.798 13.2107 10.2893 13.5858 9.91421L19.0616 4.43934C19.6474 3.85355 20.5972 3.85355 21.183 4.43934L21.5616 4.81802C22.1474 5.40381 22.1474 6.35355 21.5616 6.93934L16.0858 12.4142C15.7107 12.7893 15.202 13 14.6716 13Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
          </svg>
          Deal Builder
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/campaign-builder' ? 'active' : '' ?>" href="/campaign-builder">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M7 9V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M7 9H6C5.06812 9 4.60218 9 4.23463 9.15224C3.74458 9.35523 3.35523 9.74458 3.15224 10.2346C3 10.6022 3 11.0681 3 12C3 12.9319 3 13.3978 3.15224 13.7654C3.35523 14.2554 3.74458 14.6448 4.23463 14.8478C4.60218 15 5.06812 15 6 15H7L15.0796 17.4239C16.0291 17.7087 16.5039 17.8512 16.9257 18.1014L16.9459 18.1135C17.3663 18.3663 17.7167 18.7167 18.4177 19.4177L18.5858 19.5858C18.7051 19.7051 18.7647 19.7647 18.831 19.8123C18.9561 19.9021 19.1003 19.9619 19.2523 19.9868C19.3327 20 19.4171 20 19.5858 20C19.9713 20 20.1641 20 20.3196 19.9475C20.6155 19.8477 20.8477 19.6155 20.9475 19.3196C21 19.1641 21 18.9713 21 18.5858V5.41421C21 5.02866 21 4.83589 20.9475 4.68039C20.8477 4.38452 20.6155 4.15225 20.3196 4.05245C20.1641 4 19.9713 4 19.5858 4C19.4171 4 19.3327 4 19.2523 4.0132C19.1003 4.03815 18.9561 4.09787 18.831 4.18771C18.7647 4.23526 18.7051 4.29491 18.5858 4.41421L18.4177 4.5823C17.7167 5.28326 17.3663 5.63374 16.9459 5.88649L16.9257 5.89856C16.5039 6.14884 16.0291 6.29126 15.0796 6.57611L7 9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M8 15.5V18.0458C8 19.1251 8.87491 20 9.95416 20C10.6075 20 11.2177 19.6735 11.5801 19.1298L13 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Campaign Builder
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/recruiting' ? 'active' : '' ?>" href="/recruiting">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M2 8.5C2 5.68353 2 4.2753 2.76359 3.31779C2.92699 3.11289 3.11289 2.92699 3.31779 2.76359C4.2753 2 5.68353 2 8.5 2C11.3165 2 12.7247 2 13.6822 2.76359C13.8871 2.92699 14.073 3.11289 14.2364 3.31779C15 4.2753 15 5.68353 15 8.5C15 11.3165 15 12.7247 14.2364 13.6822C14.073 13.8871 13.8871 14.073 13.6822 14.2364C12.7247 15 11.3165 15 8.5 15C5.68353 15 4.2753 15 3.31779 14.2364C3.11289 14.073 2.92699 13.8871 2.76359 13.6822C2 12.7247 2 11.3165 2 8.5Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M9 15.5C9 12.6835 9 11.2753 9.76359 10.3178C9.92699 10.1129 10.1129 9.92699 10.3178 9.76359C11.2753 9 12.6835 9 15.5 9C18.3165 9 19.7247 9 20.6822 9.76359C20.8871 9.92699 21.073 10.1129 21.2364 10.3178C22 11.2753 22 12.6835 22 15.5C22 18.3165 22 19.7247 21.2364 20.6822C21.073 20.8871 20.8871 21.073 20.6822 21.2364C19.7247 22 18.3165 22 15.5 22C12.6835 22 11.2753 22 10.3178 21.2364C10.1129 21.073 9.92699 20.8871 9.76359 20.6822C9 19.7247 9 18.3165 9 15.5Z" stroke="currentColor" stroke-width="1.5" />
          </svg>
          Recruiting
        </a>
      </li>

      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/agency' ? 'active' : '' ?>" href="/agency">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M2 14C2 10.4934 2 8.74003 2.90796 7.55992C3.07418 7.34388 3.25989 7.14579 3.46243 6.96849C4.56878 6 6.21252 6 9.5 6H14.5C17.7875 6 19.4312 6 20.5376 6.96849C20.7401 7.14579 20.9258 7.34388 21.092 7.55992C22 8.74003 22 10.4934 22 14C22 17.5066 22 19.26 21.092 20.4401C20.9258 20.6561 20.7401 20.8542 20.5376 21.0315C19.4312 22 17.7875 22 14.5 22H9.5C6.21252 22 4.56878 22 3.46243 21.0315C3.25989 20.8542 3.07418 20.6561 2.90796 20.4401C2 19.26 2 17.5066 2 14Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M16 6C16 4.11438 16 3.17157 15.4142 2.58579C14.8284 2 13.8856 2 12 2C10.1144 2 9.17157 2 8.58579 2.58579C8 3.17157 8 4.11438 8 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M12 11C10.8954 11 10 11.6716 10 12.5C10 13.3284 10.8954 14 12 14C13.1046 14 14 14.6716 14 15.5C14 16.3284 13.1046 17 12 17M12 11C12.8708 11 13.6116 11.4174 13.8862 12M12 11V10M12 17C11.1292 17 10.3884 16.5826 10.1138 16M12 17V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
              <path d="M6 12H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
              <path d="M22 12L18 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Agency
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/financial-literacy' ? 'active' : '' ?>" href="/financial-literacy">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M12 9C10.8954 9 10 9.67157 10 10.5C10 11.3284 10.8954 12 12 12C13.1046 12 14 12.6716 14 13.5C14 14.3284 13.1046 15 12 15M12 9C12.8708 9 13.6116 9.4174 13.8862 10M12 9V8M12 15C11.1292 15 10.3884 14.5826 10.1138 14M12 15V16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
              <path d="M21 11.1833V8.28029C21 6.64029 21 5.82028 20.5959 5.28529C20.1918 4.75029 19.2781 4.49056 17.4507 3.9711C16.2022 3.6162 15.1016 3.18863 14.2223 2.79829C13.0234 2.2661 12.424 2 12 2C11.576 2 10.9766 2.2661 9.77771 2.79829C8.89839 3.18863 7.79784 3.61619 6.54933 3.9711C4.72193 4.49056 3.80822 4.75029 3.40411 5.28529C3 5.82028 3 6.64029 3 8.28029V11.1833C3 16.8085 8.06277 20.1835 10.594 21.5194C11.2011 21.8398 11.5046 22 12 22C12.4954 22 12.7989 21.8398 13.406 21.5194C15.9372 20.1835 21 16.8085 21 11.1833Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Financial Literacy
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/messenger' ? 'active' : '' ?>" href="/messenger">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M7.5 14.4738H16.5M7.5 9.48462H13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
              <path d="M2.00989 21.4487L6.58552 19.9807C8.08688 20.8109 9.78899 20.9937 11.6746 20.9937C18.1751 21.4487 21.9977 17.2443 21.9977 12.2602C22.1047 7.30419 19.9149 2.0807 11.5775 2.46969C4.30503 2.59894 2.00391 7.03781 2.00391 12.0219C2.00391 13.7262 2.35123 15.8127 3.60536 17.452L2.00989 21.4487ZM2.00989 21.4487C2.0025 21.4505 2.0079 21.4554 2.00989 21.4487Z" stroke="currentColor" stroke-width="1.5" />
          </svg>
          Messenger
        </a>
      </li>
      <li>
        <a class="menu-link text-primary text-opacity-50<?= $_SERVER['REQUEST_URI'] === '/favorites' ? 'active' : '' ?>" href="/favorites">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
              <path d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.221721 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Favorites
        </a>
      </li>

      <li>
        <a class="menu-link text-primary <?= $_SERVER['REQUEST_URI'] === '/workbench' ? 'active' : '' ?>" href="/workbench">
          <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
              <path d="M20.3584 13.3567C19.1689 14.546 16.9308 14.4998 13.4992 14.4998C11.2914 14.4998 9.50138 12.7071 9.50024 10.4993C9.50024 7.07001 9.454 4.83065 10.6435 3.64138C11.8329 2.45212 12.3583 2.50027 17.6274 2.50027C18.1366 2.49809 18.3929 3.11389 18.0329 3.47394L15.3199 6.18714C14.6313 6.87582 14.6294 7.99233 15.3181 8.68092C16.0068 9.36952 17.1234 9.36959 17.8122 8.68109L20.5259 5.96855C20.886 5.60859 21.5019 5.86483 21.4997 6.37395C21.4997 11.6422 21.5479 12.1675 20.3584 13.3567Z" stroke="currentColor" stroke-width="1.5" />
              <path d="M13.5 14.5L7.32842 20.6716C6.22386 21.7761 4.433 21.7761 3.32843 20.6716C2.22386 19.567 2.22386 17.7761 3.32843 16.6716L9.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
              <path d="M5.50896 18.5H5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Workbench
        </a>
      </li>

<?php
}
?>
      <div class = "menu-title">LOGOUT</div>
      <li>
        <a class="menu-link text-danger <?= $_SERVER['REQUEST_URI'] === '/logout' ? 'active' : '' ?>" href="/logout">
          <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
            <path d="M15 16.5V17C15 18.6569 13.6569 20 12 20H7C5.34315 20 4 18.6569 4 17V7C4 5.34315 5.34315 4 7 4H12C13.6569 4 15 5.34315 15 7V7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M21 12H10M21 12C21 11.2998 19.0057 9.99153 18.5 9.5M21 12C21 12.7002 19.0057 14.0085 18.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Logout
        </a>
      </li>
    </ul>
  </div>

</div>
<!-- END: Menu -->
<?php endif; ?>
