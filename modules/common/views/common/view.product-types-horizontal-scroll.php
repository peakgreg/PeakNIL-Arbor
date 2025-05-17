<div class="container-fluid" style = "margin-left: -4px;">
  <div class="row page-title">
    <div class="col m-0 p-0">
      <div class="scroll-wrapper">
        <div class="scroll-container">
          <div class="scroll-content">

  <style>
    .video-container {
      position: relative;
      width: 250px;
      height: 170px;
      background-size: cover;
      background-position: center;
      overflow: hidden;
      cursor: pointer;
      border-radius: 12px;
      margin-right: 10px; /* space between items, adjust as needed */
      flex: 0 0 auto; /* ensures fixed width and no wrapping */
    }

    .video-container video {
      position: absolute;
      top: 0; 
      left: 0;
      width: 100%; 
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
      pointer-events: none;
      border-radius: 12px;
    }

    .video-container:hover {
      border: 2px solid #3C3C3C;
      box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, 
                  rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
    }

    .video-container:hover video {
      opacity: 1;
    }

    .overlay-product {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-shadow: 0px 0px 30px #000;
      font-size: 17px;
      padding: 0 10px;
      box-sizing: border-box;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
    }
  </style>

<div class="container-fluid mt-3">
  <!-- Flex container to hold multiple video-containers side by side -->
  <div class="d-flex flex-nowrap">

    <!-- First video-container -->
    <a href="?page=marketplace<?php echo isset($_GET['school']) ? '&school=' . $_GET['school'] : ''; ?>&type=18" style="text-decoration: none;">
      <div class="video-container" style="background-image: url('https://cdn.peaknil.com/public/site/services/a_college_athlete_woman_player_holding_a.jpeg');">
        <video class="hover-video" muted loop preload="auto">
          <source src="https://cdn.peaknil.com/public/site/services/a_college_athlete_woman_player_holding_a-2.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="overlay-product">
          <span style="font-weight: 600;">Product Endorsement</span>
        </div>
      </div>
    </a>

    <a href="?page=marketplace<?php echo isset($_GET['school']) ? '&school=' . $_GET['school'] : ''; ?>&type=28" style="text-decoration: none;">
      <div class="video-container" style="background-image: url('https://cdn.peaknil.com/public/site/services/a_football_player_coaching_a_kid_at.jpeg');">
        <video class="hover-video" muted loop preload="auto">
          <source src="https://cdn.peaknil.com/public/site/services/a_football_player_coaching_a_kid_at.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="overlay-product">
          <span style="font-weight: 600;">Coaching Lessons</span>
        </div>
      </div>
    </a>

    <a href="?page=marketplace<?php echo isset($_GET['school']) ? '&school=' . $_GET['school'] : ''; ?>&type=32" style="text-decoration: none;">
      <div class="video-container" style="background-image: url('https://cdn.peaknil.com/public/site/services/a_woman_sitting_on_a_couch_on.jpeg');">
        <video class="hover-video" muted loop preload="auto">
          <source src="https://cdn.peaknil.com/public/site/services/a_woman_sitting_on_a_couch_on.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="overlay-product">
          <span style="font-weight: 600;">Inspirational Video</span>
        </div>
      </div>
    </a>

    <a href="?page=marketplace<?php echo isset($_GET['school']) ? '&school=' . $_GET['school'] : ''; ?>&type=14" style="text-decoration: none;">
      <div class="video-container" style="background-image: url('https://cdn.peaknil.com/public/site/services/a_woman_sitting_at_a_table_signing.jpeg');">
        <video class="hover-video" muted loop preload="auto">
          <source src="https://cdn.peaknil.com/public/site/services/a_woman_sitting_at_a_table_signing.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="overlay-product">
          <span style="font-weight: 600;">Autograph Signings</span>
        </div>
      </div>
    </a>

    <a href="?page=marketplace<?php echo isset($_GET['school']) ? '&school=' . $_GET['school'] : ''; ?>&type=20" style="text-decoration: none;">
      <div class="video-container" style="background-image: url('https://cdn.peaknil.com/public/site/services/a_young_man_talking_on_a_podcast.jpeg');">
        <video class="hover-video" muted loop preload="auto">
          <source src="https://cdn.peaknil.com/public/site/services/a_young_man_talking_on_a_podcast.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="overlay-product">
          <span style="font-weight: 600;">Podcast Interview</span>
        </div>
      </div>
    </a>

    <!-- Add as many more .video-container divs as you want here -->
  </div>
</div>

<script>
  // Select all containers and add hover events
  const containers = document.querySelectorAll('.video-container');
  containers.forEach(container => {
    const video = container.querySelector('video');
    container.addEventListener('mouseenter', () => {
      video.play();
    });
    container.addEventListener('mouseleave', () => {
      video.pause();
      video.currentTime = 0; // reset to start if desired
    });
  });
</script>


          </div>
        </div>
        <div class="scroll-gradient"></div>
      </div>
    </div>
  </div>
</div>