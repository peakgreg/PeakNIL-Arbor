<nav class="navbar navbar-expand-md fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center position-relative">
    <!-- Left Column -->
    <div class="d-flex">
      <div class="navbar-left">
        <a href="/">
          <div class="navbar-logo"></div>
        </a>
        <?php include MODULES_PATH . '/common/views/common/view.school-dropdown.php'; ?>
      </div>
    </div>
    <!-- Middle Column (Search Bar) -->
    <div class="navbar-middle position-absolute start-50 translate-middle-x d-none d-lg-block">
      <form class="search-form" style="width: 300px;">
        <input type="search" class="search-input w-100" placeholder="Search...">
      </form>
    </div>
    <!-- Right Column -->
    <div class="d-flex">
      <button class="button btn" data-bs-toggle="modal" data-bs-target="#login" style = "font-weight: 500;">Login</button>
      <a href="/register" class="button btn border border-2 border-dark rounded-4" style = "font-weight: 500;">Sign Up</a>
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
</style>