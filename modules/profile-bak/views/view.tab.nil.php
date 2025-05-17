<div class="row">

<!-- NIL Services -->
<div class="row">
  <!-- Mobile Filter Button -->
  <div class="d-md-none fixed-bottom pb-3" style="z-index: 1000;">
    <div class="container">
      <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel"></i> Filter & Sort
      </button>
    </div>
  </div>

  <!-- Desktop Filters -->
  <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 d-none d-md-block">
    <style>
      .slider-container {
        position: relative;
        height: 4px;
        background: #ddd;
        margin: 20px 0;
      }
      .slider-thumb {
        position: absolute;
        width: 16px;
        height: 16px;
        background: #007bff;
        border-radius: 50%;
        top: -6px;
        cursor: pointer;
        transform: translateX(-50%);
      }
      .price-range-values {
        text-align: center;
        margin-top: 10px;
      }
    </style>

    <!-- Sort Dropdown -->
    <div class="filter-section mb-4">
      <h5>Sort By</h5>
      <select class="form-select" id="sortSelect">
        <option value="default">Default</option>
        <option value="price_asc">Price: Low to High</option>
        <option value="price_desc">Price: High to Low</option>
      </select>
    </div>

    <!-- Price Range Filter -->
    <div class="filter-section">
      <div class="price-range-slider mb-4">
        <h5>Price Range</h5>
        <div class="slider-container">
          <div class="slider-track"></div>
          <div class="slider-thumb min" id="minThumb"></div>
          <div class="slider-thumb max" id="maxThumb"></div>
        </div>
        <div class="price-range-values">
          <span id="minPriceValue">$<?= $formattedMinPrice ?></span> - 
          <span id="maxPriceValue">$<?= $formattedMaxPrice ?></span>
        </div>
      </div>
    </div>

    <!-- Social Media Filter -->
    <div class="filter-section">
      <h5>Social Media</h5>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="instagram" id="instagramCheck" data-group="platform">
        <label class="form-check-label" for="instagramCheck">Instagram</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="tiktok" id="tiktokCheck" data-group="platform">
        <label class="form-check-label" for="tiktokCheck">TikTok</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="x" id="xCheck" data-group="platform">
        <label class="form-check-label" for="xCheck">X</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="facebook" id="facebookCheck" data-group="platform">
        <label class="form-check-label" for="facebookCheck">Facebook</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="linkedin" id="linkedinCheck" data-group="platform">
        <label class="form-check-label" for="linkedinCheck">LinkedIn</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="youtube" id="youtubeCheck" data-group="platform">
        <label class="form-check-label" for="youtubeCheck">YouTube</label>
      </div>
    </div>

    <!-- Type Filter -->
    <div class="filter-section">
      <h5>Type</h5>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="social-media" id="socialMediaCheck" data-group="type">
        <label class="form-check-label" for="socialMediaCheck">Social Media</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="in-person" id="inPersonCheck" data-group="type">
        <label class="form-check-label" for="inPersonCheck">In-Person</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="digital" id="digitalCheck" data-group="type">
        <label class="form-check-label" for="digitalCheck">Digital</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="other" id="otherCheck" data-group="type">
        <label class="form-check-label" for="otherCheck">Other</label>
      </div>
    </div>
  </div>

  <!-- Mobile Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Filter & Sort</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Sort Dropdown -->
          <div class="filter-section mb-4">
            <h5>Sort By</h5>
            <select class="form-select" id="mobileSortSelect">
              <option value="default">Default</option>
              <option value="price_asc">Price: Low to High</option>
              <option value="price_desc">Price: High to Low</option>
            </select>
          </div>

          <!-- Price Range Filter -->
          <div class="filter-section">
            <div class="price-range-slider mb-4">
              <h5>Price Range</h5>
              <div class="slider-container">
                <div class="slider-track"></div>
                <div class="slider-thumb min" id="mobileMinThumb"></div>
                <div class="slider-thumb max" id="mobileMaxThumb"></div>
              </div>
              <div class="price-range-values">
                <span id="mobileMinPriceValue">$<?= $formattedMinPrice ?></span> - 
                <span id="mobileMaxPriceValue">$<?= $formattedMaxPrice ?></span>
              </div>
            </div>
          </div>

          <!-- Social Media Filter -->
          <div class="filter-section">
            <h5>Social Media</h5>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="instagram" id="mobileInstagramCheck" data-group="platform">
              <label class="form-check-label" for="mobileInstagramCheck">Instagram</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="tiktok" id="mobileTiktokCheck" data-group="platform">
              <label class="form-check-label" for="mobileTiktokCheck">TikTok</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="x" id="mobileXCheck" data-group="platform">
              <label class="form-check-label" for="mobileXCheck">X</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="facebook" id="mobileFacebookCheck" data-group="platform">
              <label class="form-check-label" for="mobileFacebookCheck">Facebook</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="linkedin" id="mobileLinkedinCheck" data-group="platform">
              <label class="form-check-label" for="mobileLinkedinCheck">LinkedIn</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="youtube" id="mobileYoutubeCheck" data-group="platform">
              <label class="form-check-label" for="mobileYoutubeCheck">YouTube</label>
            </div>
          </div>

          <!-- Type Filter -->
          <div class="filter-section">
            <h5>Type</h5>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="social-media" id="mobileSocialMediaCheck" data-group="type">
              <label class="form-check-label" for="mobileSocialMediaCheck">Social Media</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="in-person" id="mobileInPersonCheck" data-group="type">
              <label class="form-check-label" for="mobileInPersonCheck">In-Person</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="digital" id="mobileDigitalCheck" data-group="type">
              <label class="form-check-label" for="mobileDigitalCheck">Digital</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="other" id="mobileOtherCheck" data-group="type">
              <label class="form-check-label" for="mobileOtherCheck">Other</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Apply Filters</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Service Cards Column -->
  <div class="col">
    <div class="container-fluid">
      <div class="row" id="servicesContainer">
        <?php foreach ($services as $service): ?>
        <div class="col-xxl-3 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-4 mb-4 service-card" 
             data-category="<?= strtolower($service['service_tags'] . ' ' . $service['service_category']) ?>" 
             data-price="<?= removeLastTwoDigits($service['service_price']) ?>">
          <a href="service1-details.html" class="card h-100">
            <img src="<?= $service['service_image_thumbnail'] ?>" class="card-img-top p-2" alt="<?= $service['service_name'] ?>">
            <div class="card-body">
              <h5 class="card-title fs-6"><?= $service['service_name'] ?></h5>
              <p class="card-text">$<?= formatPrice($service['service_price']) ?></p>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Element References
  const cards = document.querySelectorAll('.service-card');
  const checkboxes = document.querySelectorAll('.form-check-input');
  const sortSelect = document.getElementById('sortSelect');
  const mobileSortSelect = document.getElementById('mobileSortSelect');
  const servicesContainer = document.getElementById('servicesContainer');
  
  // Slider Elements
  const sliders = {
    desktop: {
      minThumb: document.getElementById('minThumb'),
      maxThumb: document.getElementById('maxThumb'),
      minPrice: document.getElementById('minPriceValue'),
      maxPrice: document.getElementById('maxPriceValue'),
      container: document.querySelector('.slider-container')
    },
    mobile: {
      minThumb: document.getElementById('mobileMinThumb'),
      maxThumb: document.getElementById('mobileMaxThumb'),
      minPrice: document.getElementById('mobileMinPriceValue'),
      maxPrice: document.getElementById('mobileMaxPriceValue'),
      container: document.querySelector('#filterModal .slider-container')
    }
  };

  // State Variables
  let minPrice = 0;
  let maxPrice = 200;
  let originalOrder = Array.from(cards);

  // Initialize Sliders
  function initSlider(sliderType) {
    const slider = sliders[sliderType];
    let isDragging = false;

    function updatePrices() {
      slider.minPrice.textContent = `$${minPrice}`;
      slider.maxPrice.textContent = `$${maxPrice}`;
      sliders.desktop.minPrice.textContent = `$${minPrice}`;
      sliders.desktop.maxPrice.textContent = `$${maxPrice}`;
      sliders.mobile.minPrice.textContent = `$${minPrice}`;
      sliders.mobile.maxPrice.textContent = `$${maxPrice}`;
      filterAndSortCards();
    }

    function setupThumb(thumb, isMin) {
      thumb.addEventListener('mousedown', (e) => {
        e.preventDefault();
        isDragging = true;
        document.addEventListener('mousemove', moveHandler);
        document.addEventListener('mouseup', stopHandler);

        function moveHandler(e) {
          if (!isDragging) return;
          const rect = slider.container.getBoundingClientRect();
          let offsetX = e.clientX - rect.left;
          offsetX = Math.max(0, Math.min(offsetX, rect.width));

          if (isMin) {
            const maxPos = parseFloat(slider.maxThumb.style.left);
            offsetX = Math.min(offsetX, maxPos);
            minPrice = Math.round((offsetX / rect.width) * 200);
          } else {
            const minPos = parseFloat(slider.minThumb.style.left);
            offsetX = Math.max(offsetX, minPos);
            maxPrice = Math.round((offsetX / rect.width) * 200);
          }

          thumb.style.left = `${offsetX}px`;
          updatePrices();
        }

        function stopHandler() {
          isDragging = false;
          document.removeEventListener('mousemove', moveHandler);
          document.removeEventListener('mouseup', stopHandler);
        }
      });
    }

    setupThumb(slider.minThumb, true);
    setupThumb(slider.maxThumb, false);
  }

  // Initialize both sliders
  initSlider('desktop');
  initSlider('mobile');

  // Sync Sorting
  [sortSelect, mobileSortSelect].forEach(select => {
    select.addEventListener('change', () => {
      const value = select.value;
      sortSelect.value = value;
      mobileSortSelect.value = value;
      filterAndSortCards();
    });
  });

  // Sync Checkboxes
  document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const group = checkbox.dataset.group;
      const value = checkbox.value;
      
      // Sync all matching checkboxes
      document.querySelectorAll(`input[data-group="${group}"][value="${value}"]`).forEach(cb => {
        cb.checked = checkbox.checked;
      });
      
      filterAndSortCards();
    });
  });

  // Filter and Sort Logic
  function filterAndSortCards() {
    // Filter Cards
    const selected = { platform: [], type: [] };
    checkboxes.forEach(checkbox => {
      if (checkbox.checked) {
        selected[checkbox.dataset.group].push(checkbox.value);
      }
    });

    cards.forEach(card => {
      const categories = card.dataset.category.split(' ');
      const price = parseInt(card.dataset.price, 10);
      
      const platformMatch = selected.platform.length === 0 || 
        selected.platform.some(v => categories.includes(v));
      
      const typeMatch = selected.type.length === 0 || 
        selected.type.some(v => categories.includes(v));
      
      const priceMatch = price >= minPrice && price <= maxPrice;

      card.style.display = platformMatch && typeMatch && priceMatch ? 'block' : 'none';
    });

    // Sort Cards
    const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
    const sortValue = sortSelect.value;

    let sortedCards;
    switch(sortValue) {
      case 'price_asc':
        sortedCards = visibleCards.sort((a, b) => 
          parseInt(a.dataset.price) - parseInt(b.dataset.price));
        break;
      case 'price_desc':
        sortedCards = visibleCards.sort((a, b) => 
          parseInt(b.dataset.price) - parseInt(a.dataset.price));
        break;
      default:
        sortedCards = originalOrder.filter(card => card.style.display !== 'none');
    }

    // Re-insert sorted cards
    sortedCards.forEach(card => servicesContainer.appendChild(card));
  }

  // Initial Setup
  filterAndSortCards();
  window.addEventListener('resize', () => {
    sliders.desktop.container = document.querySelector('.slider-container');
    sliders.mobile.container = document.querySelector('#filterModal .slider-container');
  });
});
</script>
<!-- END: NIL Services -->


  <?php /* ?>
  <div class = "col">

    <!-- Begin Social Media -->
    <div class="widget-container p-4 mt-3">
        <!-- Social Media Count Section -->
        <div class="d-flex align-items-center mb-3">
            <h6 class="text-secondary mb-0 me-2">Social Media</h6>
        </div>
        
        <!-- Social Media List -->
        <div class="social-list">
            <div class="social-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="social-name">Instagram</span>
                    <span class="social-count">12.5K</span>
                </div>
            </div>
            <div class="social-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="social-name">Twitter</span>
                    <span class="social-count">8.2K</span>
                </div>
            </div>
            <div class="social-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="social-name">LinkedIn</span>
                    <span class="social-count">5.7K</span>
                </div>
            </div>
            <div class="social-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="social-name">Facebook</span>
                    <span class="social-count">15.3K</span>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Social Media -->


    <!-- Begin Ultra Fan -->
    <div class="widget-container ultra-fan mt-4">
        <div class="ultra-fan-content">
            <!-- Ultra Fan Count Section -->
            <div class="d-flex align-items-center mb-2">
                <h6 class="mb-0 me-2" style = "color: #C87B00;">Ultra Fans</h6>
                <h6 class="mb-0">(1,234)</h6>
            </div>
            
            <!-- Ultra Fan Grid -->
            <div class="follower-grid">
                <div class="row row-cols-3 g-0">
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 1">
                            <div class="follower-name">John Doe</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 2">
                            <div class="follower-name">Jane Smith</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 3">
                            <div class="follower-name">Mike Johnson</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 4">
                            <div class="follower-name">Sarah Wilson</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 5">
                            <div class="follower-name">David Brown</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 6">
                            <div class="follower-name">Emma Davis</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 7">
                            <div class="follower-name">Alex Turner</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 8">
                            <div class="follower-name">Lisa Chen</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="follower-item">
                            <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 9">
                            <div class="follower-name">Chris Lee</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- View All Button -->
            <button class="view-all-btn">View All Ultra Fans</button>
        </div>
    </div>
    <!-- END: Ultra Fan -->

    <!-- Begin Followers -->
    <div class="widget-container p-4 mt-4">
        <!-- Followers Count Section -->
        <div class="d-flex align-items-center mb-2">
            <h6 class="text-secondary mb-0 me-2">Followers</h6>
            <h6 class="mb-0">(1,234)</h6>
        </div>
        
        <!-- Followers Grid -->
        <div class="follower-grid">
            <div class="row row-cols-3 g-0">
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 1">
                        <div class="follower-name">John Doe</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 2">
                        <div class="follower-name">Jane Smith</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 3">
                        <div class="follower-name">Mike Johnson</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 4">
                        <div class="follower-name">Sarah Wilson</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 5">
                        <div class="follower-name">David Brown</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 6">
                        <div class="follower-name">Emma Davis</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 7">
                        <div class="follower-name">Alex Turner</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 8">
                        <div class="follower-name">Lisa Chen</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 9">
                        <div class="follower-name">Chris Lee</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Button -->
        <button class="view-all-btn">View All Followers</button>
    </div>
    <!-- END: Followers -->


    <!-- Begin Following -->
    <div class="widget-container p-4 mt-4">
        <!-- Following Count Section -->
        <div class="d-flex align-items-center mb-2">
            <h6 class="text-secondary mb-0 me-2">Following</h6>
            <h6 class="mb-0">(1,234)</h6>
        </div>
        
        <!-- Following Grid -->
        <div class="follower-grid">
            <div class="row row-cols-3 g-0">
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 1">
                        <div class="follower-name">John Doe</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 2">
                        <div class="follower-name">Jane Smith</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 3">
                        <div class="follower-name">Mike Johnson</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 4">
                        <div class="follower-name">Sarah Wilson</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 5">
                        <div class="follower-name">David Brown</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 6">
                        <div class="follower-name">Emma Davis</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 7">
                        <div class="follower-name">Alex Turner</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 8">
                        <div class="follower-name">Lisa Chen</div>
                    </div>
                </div>
                <div class="col">
                    <div class="follower-item">
                        <img src="https://cdn.peaknil.com/public/default-profile-image.png" alt="Follower 9">
                        <div class="follower-name">Chris Lee</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Button -->
        <button class="view-all-btn">View All Followers</button>
    </div>
    <!-- END: Following -->
  </div>
  <?php */ ?>


</div>