<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}
?>
<link rel="stylesheet" href="/assets/modules/profile/css/profile.css">

  <div class="container-fluid" style = "max-width: 1400px;">
    <!-- Cover Image -->
    <div class="cover-image bg-secondary" style="background-image: url('<?= $profile['cover_image_path'] ?>'); z-index: 1030;">
        <!-- Profile Image -->
        <div class="profile-image" style="background-image: url('<?= $profile['profile_image_path'] ?>');"></div>
    </div>

    <!-- Name sticky box -->
    <div class="sticky-top-first">
      <div class="profile-image-sticky" style="background-image: url('<?= $profile['profile_image_path'] ?>');"></div>
      <div class = "profile-name"><?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?></div>
    </div>

    <div class = "button-container">
      <a href="" class = "btn btn-light btn-sm fw-medium border border-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#0e0e0e" fill="none" style = "margin-top: -2px;">
            <path d="M13.5 16.0001V14.0623C15.2808 12.6685 16.5 11 16.5 7.41681C16.5 5.09719 16.0769 3 13.5385 3C13.5385 3 12.6433 2 10.4923 2C7.45474 2 5.5 3.82696 5.5 7.41681C5.5 11 6.71916 12.6686 8.5 14.0623V16.0001L4.78401 17.1179C3.39659 17.5424 2.36593 18.6554 2.02375 20.0101C1.88845 20.5457 2.35107 21.0001 2.90639 21.0001H13.0936" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M18.5 22L18.5 15M15 18.5H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Follow
      </a>
      <a href="" class = "btn btn-light btn-sm fw-medium border border-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#0e0e0e" fill="none" style = "margin-top: -2px;">
            <path d="M2 6L8.91302 9.91697C11.4616 11.361 12.5384 11.361 15.087 9.91697L22 6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            <path d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        </svg>
        Message
      </a>
      <a href="" class = "btn btn-sm fw-medium">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#0e0e0e" fill="none" style = "margin-top: -2px;">
            <path d="M21 12C21 11.1716 20.3284 10.5 19.5 10.5C18.6716 10.5 18 11.1716 18 12C18 12.8284 18.6716 13.5 19.5 13.5C20.3284 13.5 21 12.8284 21 12Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M13.5 12C13.5 11.1716 12.8284 10.5 12 10.5C11.1716 10.5 10.5 11.1716 10.5 12C10.5 12.8284 11.1716 13.5 12 13.5C12.8284 13.5 13.5 12.8284 13.5 12Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M6 12C6 11.1716 5.32843 10.5 4.5 10.5C3.67157 10.5 3 11.1716 3 12C3 12.8284 3.67157 13.5 4.5 13.5C5.32843 13.5 6 12.8284 6 12Z" stroke="currentColor" stroke-width="1.5" />
        </svg>
        More
      </a>
    </div>

    <div class = "team-container">
      <?= $profile['position'] ?> - <?= $profile['school_name'] ?>
    </div>

    <div class = "social-container">
      <div class = "row">
        <div class="col">
          <div class = "social-data">Instagram: 1,000</div>
          <div class = "social-data">TikTok: 1,440</div>
          <div class = "social-data">X: 1,000</div>
        </div>
      </div>
    </div>

<div class="description-container">
  <p><?= $profile['profile_description'] ?></p>
  <div class="fade-overlay"></div>
  <button class="read-more">+ Read More</button>
</div>

    <!-- Tab sticky -->
    <div class="sticky-top-second">
        <div class=" bg-white">
          <div class="nav-tabs-scrollable">
            <ul class="nav nav-underline nav-fill mt-4" id="profileTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="nil-tab" data-bs-toggle="tab" href="#nil" role="tab">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.5523 1 13 1.44772 13 2V3.04549C14.5502 3.18762 15.9696 3.65724 17.0802 4.37517C18.4156 5.2385 19.4167 6.54973 19.4167 8.14815C19.4167 8.70043 18.969 9.14815 18.4167 9.14815C17.8644 9.14815 17.4167 8.70043 17.4167 8.14815C17.4167 7.45561 16.9813 6.69276 15.9944 6.05476C15.226 5.55802 14.1899 5.19012 13 5.05573V10.7226C14.932 10.7989 16.5472 11.1133 17.7461 11.7984C18.4666 12.2101 19.0458 12.7608 19.4377 13.47C19.8275 14.1752 20 14.979 20 15.8519C20 17.7763 18.9421 19.1185 17.4155 19.922C16.1904 20.5667 14.6434 20.8852 13 20.9737V22C13 22.5523 12.5523 23 12 23C11.4477 23 11 22.5523 11 22V20.9613C9.30461 20.829 7.75183 20.3632 6.54045 19.6453C5.11627 18.8014 4 17.4928 4 15.8519C4 15.2996 4.44772 14.8519 5 14.8519C5.55228 14.8519 6 15.2996 6 15.8519C6 16.5019 6.45074 17.2674 7.56005 17.9247C8.43919 18.4457 9.63204 18.8271 11 18.9541V12.6835C9.09913 12.6034 7.60805 12.2805 6.53338 11.6462C5.88559 11.2639 5.38266 10.7644 5.04894 10.1438C4.71768 9.52773 4.58333 8.84872 4.58333 8.14815C4.58333 6.54973 5.58436 5.2385 6.91983 4.37517C8.03038 3.65724 9.44975 3.18762 11 3.04549V2C11 1.44772 11.4477 1 12 1ZM11 5.05573C9.81011 5.19012 8.77403 5.55802 8.00563 6.05476C7.01873 6.69276 6.58333 7.45561 6.58333 8.14815C6.58333 8.59305 6.66774 8.93123 6.81044 9.19662C6.95067 9.45743 7.17691 9.70367 7.54996 9.92385C8.2131 10.3153 9.30242 10.6018 11 10.6814V5.05573ZM13 12.7245V18.9704C14.4191 18.8838 15.6183 18.6077 16.484 18.1521C17.4909 17.6222 18 16.8904 18 15.8519C18 15.2433 17.8809 14.7877 17.6873 14.4374C17.4959 14.0911 17.2001 13.7899 16.7539 13.5349C15.9639 13.0835 14.7447 12.8006 13 12.7245Z" fill="currentColor" />
                      </svg>
                      NIL Services
                    </a>
                </li>
                <?php /* ?>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                          <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="1.5" />
                          <path d="M14 14H10C7.23858 14 5 16.2386 5 19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19C19 16.2386 16.7614 14 14 14Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                      </svg>
                      Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                          <path d="M6 17.9745C6.1287 19.2829 6.41956 20.1636 7.07691 20.8209C8.25596 22 10.1536 22 13.9489 22C17.7442 22 19.6419 22 20.8209 20.8209C22 19.6419 22 17.7442 22 13.9489C22 10.1536 22 8.25596 20.8209 7.07691C20.1636 6.41956 19.2829 6.1287 17.9745 6" stroke="currentColor" stroke-width="1.5" />
                          <path d="M2 10C2 6.22876 2 4.34315 3.17157 3.17157C4.34315 2 6.22876 2 10 2C13.7712 2 15.6569 2 16.8284 3.17157C18 4.34315 18 6.22876 18 10C18 13.7712 18 15.6569 16.8284 16.8284C15.6569 18 13.7712 18 10 18C6.22876 18 4.34315 18 3.17157 16.8284C2 15.6569 2 13.7712 2 10Z" stroke="currentColor" stroke-width="1.5" />
                          <path d="M5 18C8.42061 13.2487 12.2647 6.9475 18 11.6734" stroke="currentColor" stroke-width="1.5" />
                      </svg>
                      Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="merch-tab" data-bs-toggle="tab" href="#merch" role="tab">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                          <path d="M6 9V16.6841C6 18.4952 6 19.4008 6.58579 19.9635C7.89989 21.2257 15.8558 21.4604 17.4142 19.9635C18 19.4008 18 18.4952 18 16.6841V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                          <path d="M5.74073 12L3.04321 9.38915C2.34774 8.71602 2 8.37946 2 7.96123C2 7.543 2.34774 7.20644 3.04321 6.53331L5.04418 4.59664C5.39088 4.26107 5.56423 4.09329 5.77088 3.96968C5.97753 3.84607 6.21011 3.77103 6.67526 3.62096L8.32112 3.08997C8.56177 3.01233 8.68209 2.97351 8.76391 3.02018C8.84573 3.06686 8.87157 3.2013 8.92324 3.47018C9.19358 4.87684 10.4683 5.94185 12 5.94185C13.5317 5.94185 14.8064 4.87684 15.0768 3.47018C15.1284 3.2013 15.1543 3.06686 15.2361 3.02018C15.3179 2.97351 15.4382 3.01233 15.6789 3.08997L17.3247 3.62096C17.7899 3.77103 18.0225 3.84607 18.2291 3.96968C18.4358 4.09329 18.6091 4.26107 18.9558 4.59664L20.9568 6.53331C21.6523 7.20644 22 7.543 22 7.96123C22 8.37946 21.6523 8.71602 20.9568 9.38915L18.2593 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Merch
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sponsors-tab" data-bs-toggle="tab" href="#sponsors" role="tab">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                          <path d="M22 6.75003H19.2111C18.61 6.75003 18.3094 6.75003 18.026 6.66421C17.7426 6.5784 17.4925 6.41168 16.9923 6.07823C16.2421 5.57806 15.3862 5.00748 14.961 4.87875C14.5359 4.75003 14.085 4.75003 13.1833 4.75003C11.9571 4.75003 11.1667 4.75003 10.6154 4.97839C10.0641 5.20675 9.63056 5.6403 8.76347 6.50739L8.00039 7.27047C7.80498 7.46588 7.70727 7.56359 7.64695 7.66005C7.42335 8.01764 7.44813 8.47708 7.70889 8.80854C7.77924 8.89796 7.88689 8.98459 8.10218 9.15785C8.89796 9.79827 10.0452 9.73435 10.7658 9.00945L12 7.76789H13L19 13.8036C19.5523 14.3592 19.5523 15.2599 19 15.8155C18.4477 16.3711 17.5523 16.3711 17 15.8155L16.5 15.3125M13.5 12.2947L16.5 15.3125M16.5 15.3125C17.0523 15.8681 17.0523 16.7689 16.5 17.3244C15.9477 17.88 15.0523 17.88 14.5 17.3244L13.5 16.3185M13.5 16.3185C14.0523 16.874 14.0523 17.7748 13.5 18.3304C12.9477 18.8859 12.0523 18.8859 11.5 18.3304L10 16.8214M13.5 16.3185L11.5 14.3185M9.5 16.3185L10 16.8214M10 16.8214C10.5523 17.377 10.5523 18.2778 10 18.8334C9.44772 19.3889 8.55229 19.3889 8 18.8334L5.17637 15.9509C4.59615 15.3586 4.30604 15.0625 3.93435 14.9062C3.56266 14.75 3.14808 14.75 2.31894 14.75H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M22 14.75H19.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                          <path d="M8.5 6.75003L2 6.75003" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                      </svg>     
                      Sponsors
                    </a>
                </li>
                <?php */ ?>
            </ul>
          </div>
        </div>
    </div>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="profileTabsContent">
            <!-- NIL Tab -->
            <div class="tab-pane fade show active" id="nil" role="tabpanel">
                <?php
                  include MODULES_PATH . '/profile/views/view.tab.nil.php';
                ?>
            </div>

            <!-- Profile Tab -->
            <div class="tab-pane fade show" id="profile" role="tabpanel">
              <?php
                include MODULES_PATH . '/profile/views/view.tab.profile.php';
              ?>
            </div>


            <!-- Posts Tab -->
            <div class="tab-pane fade" id="posts" role="tabpanel">
                <?php
                  include MODULES_PATH . '/profile/views/view.tab.posts.php';
                ?>
            </div>

            <!-- Merch Tab -->
            <div class="tab-pane fade" id="merch" role="tabpanel">
                <?php
                  include MODULES_PATH . '/profile/views/view.tab.merch.php';
                ?>
            </div>

            <!-- Sponsors Tab -->
            <div class="tab-pane fade" id="sponsors" role="tabpanel">
                <?php
                  include MODULES_PATH . '/profile/views/view.tab.sponsors.php';
                ?>
            </div>

        </div>
  </div>


<div style = "height: 2000px;"></div>

<pre>
<?php
print_r($profile);
?>
</pre>
<script type="text/javascript" src="/assets/modules/profile/js/profile.js"></script>
<?php 
// Conditional footer
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.footer.php';
}
?>
