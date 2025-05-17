<?php
global $db;

// Conditional header
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.header.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.header.php';
}
// -------------------------------------------------------------------------------------------------------------------//
?>

<?php
$profile = getUserProfileData($conn);
?>

<link rel="stylesheet" href="/assets/modules/profile/css/profile.css">

    <style>
        /* Custom CSS */
        
        .cover-container {
            position: relative;
            height: 300px;
            background-color: #0d6efd;
            background-image: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            overflow: hidden;
        }
        
        .cover-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-container {
            position: relative;
        }
        
        .profile-img-container {
            position: absolute;
            top: -85px;
            left: 50px;
            z-index: 2;
        }
        
        .profile-img {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }
        
        .profile-info {
            padding-left: 240px;
            padding-top: 20px;
        }
        
        .deal-card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        
        .deal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .badge-verified {
            background-color: #198754;
            color: white;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50rem;
            margin-left: 0.5rem;
        }
        
        .social-icons a {
            color: #6c757d;
            margin-right: 15px;
            font-size: 1.2rem;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: #0d6efd;
        }
        
        .stats-container {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .stat-item {
            text-align: center;
            padding: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        @media (max-width: 767.98px) {
            .profile-img-container {
                position: relative;
                top: -85px;
                left: 50%;
                transform: translateX(-50%);
                margin-bottom: -60px;
            }
            
            .profile-info {
                padding-left: 1rem;
                padding-top: 0;
                text-align: center;
            }
        }
    </style>

    <div class="container-fluid p-0">
        <!-- Cover Image -->
        <div class="cover-container">
            <img src="/api/placeholder/1200/300" alt="Cover Image" class="cover-img">
        </div>
        
        <!-- Profile Section -->
        <div class="container profile-container">
            <div class="profile-img-container">
                <img src="/api/placeholder/170/170" alt="Profile Image" class="profile-img">
            </div>
            
            <div class="row mt-4 pt-3">
                <div class="col-md-8">
                    <div class="profile-info">
                        <h1 class="display-5 fw-bold"><?= $profile['first_name'] ?> <?= $profile['last_name'] ?> <span class="badge badge-verified"><i class="fas fa-check"></i> Verified</span></h1>
                        <p class="lead text-muted"><?= $profile['sport_name'] ?> | <?= $profile['position'] ?> | UCLA Bruins</p>
                        <div class="social-icons mt-2 mb-4">
                            <?php if (!empty($profile['social_media']['instagram_username'])): ?>
                                <a href="https://www.instagram.com/<?= $profile['social_media']['instagram_username'] ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($profile['social_media']['x_username'])): ?>
                                <a href="https://twitter.com/<?= $profile['social_media']['x_username'] ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($profile['social_media']['tiktok_username'])): ?>
                                <a href="https://www.tiktok.com/@<?= $profile['social_media']['tiktok_username'] ?>" target="_blank"><i class="fab fa-tiktok"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($profile['social_media']['youtube_username'])): ?>
                                <a href="https://www.youtube.com/user/<?= $profile['social_media']['youtube_username'] ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="stats-container mt-4">
                        <div class="row">
                            <?php if (!empty($profile['social_media']['instagram_username']) && isset($profile['instagram_stats']['instagram_follower_count'])): ?>
                                <div class="col-4 stat-item">
                                    <div class="stat-value"><?= number_format($profile['instagram_stats']['instagram_follower_count']) ?></div>
                                    <div class="stat-label">Instagram Followers</div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($profile['social_media']['x_username']) && isset($profile['x_stats']['x_follower_count'])): ?>
                                <div class="col-4 stat-item">
                                    <div class="stat-value"><?= number_format($profile['x_stats']['x_follower_count']) ?></div>
                                    <div class="stat-label">Twitter Followers</div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($profile['social_media']['tiktok_username']) && isset($profile['tiktok_stats']['tiktok_follower_count'])): ?>
                                <div class="col-4 stat-item">
                                    <div class="stat-value"><?= number_format($profile['tiktok_stats']['tiktok_follower_count']) ?></div>
                                    <div class="stat-label">TikTok Followers</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <h3 class="mb-4">About Me</h3>
                    <p>Senior at UCLA, 3-time All-Conference player with a passion for community service and youth development. Looking for brand partnerships that align with my values of hard work, excellence, and giving back.</p>
                    
                    <div class="d-flex flex-wrap mt-4">
                        <span class="badge bg-primary me-2 mb-2 p-2">Basketball</span>
                        <span class="badge bg-primary me-2 mb-2 p-2">Fitness</span>
                        <span class="badge bg-primary me-2 mb-2 p-2">Fashion</span>
                        <span class="badge bg-primary me-2 mb-2 p-2">Lifestyle</span>
                        <span class="badge bg-primary me-2 mb-2 p-2">Nutrition</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- NIL Deals Section -->
        <div class="container mt-5">
            <h2 class="mb-4">NIL Deal Opportunities</h2>
            <div class="row g-4">
                <!-- Deal Card 1 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Social Media Promotion</h5>
                                <span class="badge bg-success">$500</span>
                            </div>
                            <p class="card-text">Promote our athletic wear on your Instagram with 3 posts over 1 month.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 1 month</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deal Card 2 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Autograph Session</h5>
                                <span class="badge bg-success">$300</span>
                            </div>
                            <p class="card-text">2-hour autograph signing session at our downtown store location.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 1 day</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deal Card 3 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Youth Clinic Appearance</h5>
                                <span class="badge bg-success">$750</span>
                            </div>
                            <p class="card-text">Lead a 3-hour basketball clinic for youth ages 10-14 at community center.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 1 day</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deal Card 4 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Product Ambassador</h5>
                                <span class="badge bg-success">$1,200</span>
                            </div>
                            <p class="card-text">Become a product ambassador for our new basketball shoe line.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 3 months</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deal Card 5 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Video Content Creation</h5>
                                <span class="badge bg-success">$800</span>
                            </div>
                            <p class="card-text">Create 5 training tip videos using our equipment for our social channels.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 2 months</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deal Card 6 -->
                <div class="col-md-4">
                    <div class="card deal-card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Deal Image">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">Podcast Interview</h5>
                                <span class="badge bg-success">$250</span>
                            </div>
                            <p class="card-text">Guest appearance on our sports podcast discussing your athletic journey.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Duration: 1 day</small>
                                <button class="btn btn-sm btn-outline-primary">Contact</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
        

    </div>

<script type="text/javascript" src="/assets/modules/profile/js/profile.js"></script>
<?php 
// -------------------------------------------------------------------------------------------------------------------//
// Conditional footer
if (isset($_SESSION['uuid'])) {
    require_once MODULES_PATH . '/common/views/auth/view.footer.php';
} else {
    require_once MODULES_PATH . '/common/views/public/view.footer.php';
}
?>
