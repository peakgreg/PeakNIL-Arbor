<?php
//MARK: Sports Menu
?>

<div class="mt-3" style = "margin-left: -4px;">
  <div class="row page-title m-0">
    <div class="col">
      <div class="scroll-wrapper d-flex">
        
        <div class="static-div" style = "border-right: 1px solid #eee;">
          <button 
              type="button" 
              class="btn btn-custom d-flex align-items-center me-2 rounded-4" 
              data-bs-toggle="dropdown" 
              aria-expanded="false" 
              style="height: 75px; text-decoration: none; border: 1px solid #ccc !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              <?php
              if (!isset($_GET['type'])) { ?>
                NIL Deals
              <?php } else { ?>
                <?php if (!empty($service['img'])): ?>
                    <img src="<?= $service['img']; ?>" style="height: 30px;" class="me-2">
                <?php endif; ?>
                <?= $service['name']; ?>
              <?php } ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-start w-100 p-3" style = "z-index: 10000;">
            <div class="container-fluid">
              <a href = "/marketplace<?php echo buildQuery($getParameters); ?>" type="button" class="btn btn-soft-dark btn-sm d-inline-flex align-items-center mb-3" style = "margin-left: -20px; margin-top: -6px;">
                  <i class="hgi-solid hgi-arrow-move-up-left me-2"></i>Back To <?= isset($school['name']) ? $school['name'] : 'PeakNIL'; ?> Marketplace
              </a>
              <div class="row">
                <div class = "col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icons/nil-deals/240x240/instagram-logo.png" 
                        alt="Instagram Logo" 
                        style="height: 18px; margin-right: 8px;">
                    <span class = "fw-semibold">Instagram</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=6" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Instagram Image</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=7" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Instagram Reel</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=8" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Instagram Story</a>
                  </div>
                </div>

                <div class = "col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icons/nil-deals/240x240/tiktok-logo.png" 
                        alt="TikTok Logo" 
                        style="height: 18px; margin-right: 8px;">
                    <span class = "fw-semibold">TikTok</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=5" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">TikTok Post</a>
                  </div>
                </div>

                <div class = "col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icons/nil-deals/240x240/x-logo.png" 
                        alt="X Logo" 
                        style="height: 18px; margin-right: 8px;">
                    <span class = "fw-semibold">X</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=29" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">X Image Post</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=30" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">X Video Post</a>
                  </div>
                </div>

                <div class = "col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icons/nil-deals/240x240/facebook-logo.png" 
                        alt="Facebook Logo" 
                        style="height: 18px; margin-right: 8px;">
                    <span class = "fw-semibold">Facebook</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=1" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Facebook Post</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=2" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Facebook Story</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=3" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Facebook Live</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=4" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Facebook Follow</a>
                  </div>
                </div>

                <div class = "col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/icons/nil-deals/240x240/linkedin-logo.png" 
                        alt="LinkedIn Logo" 
                        style="height: 18px; margin-right: 8px;">
                    <span class = "fw-semibold">LinkedIn</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=11" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">LinkedIn Post</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=12" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">LinkedIn Follow</a>
                  </div>
                </div>

                <div class = "col-xxl-2 col-xl-3 col-lg-5 col-md-5 col-sm-6 col-8 mb-4">
                  <div class="col-12 d-flex align-items-center mb-1">
                    <img src="" 
                        alt="" 
                        style="height: 18px; margin-right: 0px;">
                    <span class = "fw-semibold">All NIL Deals</span>
                  </div>
                  <div>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=13" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Public Appearance</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=14" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Autograph Signing</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=15" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Photo/Video Shoot</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=16" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">In-Person Interview</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=17" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Speech/Lecture</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=18" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Product Endorsement</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=19" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Brand Endorsement</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=20" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Podcast Appearance</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=21" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Press Interview</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=22" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Video Message</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=24" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Ad Campaign</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=27" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">1:1 Sports Coaching</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=28" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Coaching Camp/Lessons</a>
                    <a href = "/marketplace<?php echo buildQuery($getParameters); ?><?php echo isset($_GET['sport']) ? '&sport=' . $_GET['sport'] : ''; ?>&type=32" type="button" class="btn btn-ghost-dark btn-sm ps-2 p-1 m-0 d-block w-auto text-start">Inspirational Video</a>
                  </div>
                </div>

              </div>

              <a href = "" type="button" class="btn btn-soft-primary w-100">View All NIL Deals</a>

            </div>
          </ul>
        </div>


      
        <div class="scroll-container">
          <div class="scroll-content">

            <style>
            .icon-text-link {
              text-align: center;
              margin: 0 8px;
              text-decoration: none;
              color: inherit;
              padding: 4px; /* Add padding to create space between the border and the content */
              border-radius: 14px; /* Optional: Adds rounded corners to the border */
              border: 2px solid transparent; /* Transparent border to prevent shifting */
              opacity: 60%;
            }

            .icon-text-link:hover {
              border: 2px solid #007bff; /* Change the color to your desired border color */
              background-color: #f8f9fa; /* Optional: Change background color on hover */
              opacity: 100%;
            }

            .icon-size {
              font-size: 28px;
            }

            .text-below-icon {
              font-size: 0.8rem;
              font-weight: 500;
              margin-top: 2px;
            }

            .icon-selected {
              background-color: #EFF0F1;
              opacity: 100%;
            }
            </style>

            <div class="d-flex justify-content-around align-items-center scroll-content mt-2">
              <a href="/marketplace<?php echo isset($_GET['school']) ? '?school=' . $_GET['school'] : ''; ?><?php echo isset($_GET['type']) ? '&type=' . $_GET['type'] : ''; ?>" 
                class="icon-text-link first-link <?php if (!isset($_GET['sport'])) echo 'icon-selected'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="<?= $icon_size ?>" height="<?= $icon_size ?>" color="<?= $icon_size ?>" fill="none">
                    <path opacity="0.4" d="M20 8L15 13C14.1174 13.8826 13.6762 14.3238 13.1346 14.3726C13.045 14.3807 12.955 14.3807 12.8654 14.3726C12.3238 14.3238 11.8826 13.8826 11 13C10.1174 12.1174 9.67615 11.6762 9.13457 11.6274C9.04504 11.6193 8.95496 11.6193 8.86543 11.6274C8.32385 11.6762 7.88256 12.1174 7 13L4 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 13V8H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-below-icon">Trending</div>
              </a>

              <?php
              if (isset($display_school) && $display_school == "no") {
              /*
              ?>
              <a href="?page=collection&col=blake" 
                class="icon-text-link first-link <?php if (isset($_GET['collection']) && $_GET['collection'] == 'blake') echo "icon-selected"; ?>">
                <img style = "height: 30px; margin-bottom: 4px;" src = "https://peaknil.s3.us-east-2.amazonaws.com/assets/images/site/blake.png">
                <div class="text-below-icon">Blake's 22</div>
              </a>
              <?php
              */
              }
              ?>

            <?php
            // Display sports of the individual school

            if (isset($_GET['school'])) {
              while ($row = mysqli_fetch_assoc($result)) { ?>
              <a href="/marketplace?school=<?= $_GET['school']; ?>&sport=<?php echo $row['id']; ?><?php echo isset($_GET['type']) ? '&type=' . $_GET['type'] : ''; ?>" class="icon-text-link <?php if (isset($_GET['sport']) && $_GET['sport'] == $row['id']) echo "icon-selected"; ?>">
                <?php
                $svg_content = $row['icon_svg'];
                $svg_content = str_replace(
                    ['{$icon_size}', '{$icon_color}'], // Placeholders to replace
                    [$icon_size, $icon_color],         // Values to insert
                    $svg_content                       // SVG content from the database
                );

                // Output the modified SVG content
                echo $svg_content;
                ?>
                <div class="text-below-icon"><?php echo $row['sport_name']; ?></div>
              </a>
            <?php  }
            // Display all sports for PeakNIL Marketplace
            } else {
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
              <a href="/marketplace?sport=<?php echo $row['id']; ?><?php echo isset($_GET['type']) ? '&type=' . $_GET['type'] : ''; ?>" class="icon-text-link <?php if (isset($_GET['sport']) && $_GET['sport'] == $row['id']) echo "icon-selected"; ?>">
                <?php
                $svg_content = $row['icon_svg'];
                $svg_content = str_replace(
                    ['{$icon_size}', '{$icon_color}'], // Placeholders to replace
                    [$icon_size, $icon_color],         // Values to insert
                    $svg_content                       // SVG content from the database
                );

                // Output the modified SVG content
                echo $svg_content;
                ?>
                <div class="text-below-icon"><?php echo $row['sport_name']; ?></div>
              </a>
            <?php }
              }
             ?>
            </div>

          </div>
        </div>
        <div class="scroll-gradient"></div>
      </div>
    </div>
  </div>
</div>