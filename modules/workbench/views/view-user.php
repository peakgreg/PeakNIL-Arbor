<?php
/**
 * User Management Tool
 * 
 * Allows administrators to manage users, roles, and permissions
 */

// Check permissions (placeholder - implement actual permission checking)
// In a real implementation, this would check if the user has the required permissions
$has_permission = true; // Placeholder

// If the user doesn't have permission, redirect to the workbench
if (!$has_permission) {
    header('Location: /workbench?action=overview');
    exit;
}

// Include header
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<?php require_once __DIR__ . '/view.workbench-nav.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile - Internal Platform</title>
  <!-- Bootstrap 5.4 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    .profile-header {
      padding: 20px 0;
      border-bottom: 1px solid #dee2e6;
    }
    .profile-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: #6c757d;
    }
    .tab-content {
      padding-top: 25px;
    }
    .status-badge {
      font-size: 0.8rem;
    }
    .nav-tabs .nav-link {
      padding: 12px 20px;
    }
    .nav-tabs .nav-link.active {
      font-weight: 500;
      border-bottom: 3px solid #0d6efd;
    }
    .activity-timeline {
      position: relative;
      padding-left: 30px;
    }
    .activity-timeline::before {
      content: '';
      position: absolute;
      left: 15px;
      top: 0;
      height: 100%;
      width: 2px;
      background-color: #dee2e6;
    }
    .timeline-item {
      position: relative;
      margin-bottom: 20px;
    }
    .timeline-dot {
      position: absolute;
      left: -30px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: #0d6efd;
      top: 6px;
    }
    .card-hover:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }
  </style>
</head>
<body>
  <!-- Main Container -->
  <div class="container-fluid p-0">
    
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Internal Platform</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-house"></i> Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#"><i class="bi bi-people"></i> Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Reports</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    
    <!-- Breadcrumb Navigation -->
    <div class="container-fluid py-2 px-4 bg-light border-bottom">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Users</a></li>
          <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
      </nav>
    </div>
    
    <!-- Profile Header -->
    <div class="container-fluid profile-header">
      <div class="row align-items-center px-4">
        <div class="col-md-2 col-lg-1 text-center text-md-start mb-3 mb-md-0">
          <div class="profile-avatar mx-auto mx-md-0">
            <i class="bi bi-person"></i>
          </div>
        </div>
        <div class="col-md-6 col-lg-7 text-center text-md-start">
          <div class="d-flex flex-column flex-md-row align-items-center align-items-md-baseline">
            <h2 class="mb-1">John Doe</h2>
            <span class="badge bg-success ms-md-2 status-badge">Active</span>
          </div>
          <p class="text-muted mb-2">ID: USR-29381</p>
          <p class="mb-1"><i class="bi bi-envelope me-2"></i>john.doe@example.com</p>
          <p class="mb-1"><i class="bi bi-telephone me-2"></i>(555) 123-4567</p>
        </div>
        <div class="col-md-4 col-lg-4 text-center text-md-end mt-3 mt-md-0">
          <button class="btn btn-primary me-2"><i class="bi bi-pencil me-1"></i> Edit</button>
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Actions
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
            <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i>Send Message</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2"></i>Flag Account</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-lock me-2"></i>Suspend Account</a></li>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Tab Navigation -->
    <div class="container-fluid px-4">
      <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
            <i class="bi bi-grid me-1"></i> Overview
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="communication-tab" data-bs-toggle="tab" data-bs-target="#communication" type="button" role="tab" aria-controls="communication" aria-selected="false">
            <i class="bi bi-chat me-1"></i> Communication
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="deal-history-tab" data-bs-toggle="tab" data-bs-target="#deal-history" type="button" role="tab" aria-controls="deal-history" aria-selected="false">
            <i class="bi bi-file-earmark-text me-1"></i> Deal History
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">
            <i class="bi bi-activity me-1"></i> Activity
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet" type="button" role="tab" aria-controls="wallet" aria-selected="false">
            <i class="bi bi-wallet2 me-1"></i> Wallet
          </button>
        </li>
      </ul>
      
      <!-- Tab Content -->
      <div class="tab-content" id="profileTabsContent">
        
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
          <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Personal Information</h5>
                  <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Full Name</div>
                    <div class="col-sm-8">John Edward Doe</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Date of Birth</div>
                    <div class="col-sm-8">April 12, 1985</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Address</div>
                    <div class="col-sm-8">123 Main Street, Apt 4B<br>New York, NY 10001</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Email</div>
                    <div class="col-sm-8">john.doe@example.com</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Phone</div>
                    <div class="col-sm-8">(555) 123-4567</div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 text-muted">Registration Date</div>
                    <div class="col-sm-8">June 15, 2023</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Account Summary -->
            <div class="col-lg-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header">
                  <h5 class="mb-0">Account Summary</h5>
                </div>
                <div class="card-body">
                  <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-primary bg-opacity-25 p-3">
                            <i class="bi bi-briefcase text-primary fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Total Deals</h6>
                          <h4 class="mb-0">24</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-success bg-opacity-25 p-3">
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Total Value</h6>
                          <h4 class="mb-0">$158,432</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-info bg-opacity-25 p-3">
                            <i class="bi bi-chat-dots text-info fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Total Messages</h6>
                          <h4 class="mb-0">87</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-warning bg-opacity-25 p-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Last Activity</h6>
                          <h4 class="mb-0">2 days ago</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <h6 class="text-muted mb-3">Account Status</h6>
                  <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="d-flex justify-content-between">
                    <small>Profile Completion</small>
                    <small class="text-success">85%</small>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Recent Deals -->
            <div class="col-lg-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Recent Deals</h5>
                  <a href="#" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover align-middle">
                      <thead>
                        <tr>
                          <th>Deal ID</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5832</a></td>
                          <td>Feb 20, 2025</td>
                          <td>$12,500</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5789</a></td>
                          <td>Feb 15, 2025</td>
                          <td>$8,750</td>
                          <td><span class="badge bg-warning text-dark">Pending</span></td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5721</a></td>
                          <td>Feb 10, 2025</td>
                          <td>$5,300</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5698</a></td>
                          <td>Feb 5, 2025</td>
                          <td>$9,200</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Tags and Notes -->
            <div class="col-lg-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Tags and Notes</h5>
                  <button class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i> Add Note</button>
                </div>
                <div class="card-body">
                  <h6 class="text-muted mb-3">Tags</h6>
                  <div class="mb-4">
                    <span class="badge bg-primary me-1 mb-1 p-2">VIP Customer</span>
                    <span class="badge bg-secondary me-1 mb-1 p-2">High Value</span>
                    <span class="badge bg-info me-1 mb-1 p-2">Repeat Client</span>
                    <span class="badge bg-warning text-dark me-1 mb-1 p-2">Investment</span>
                    <span class="badge bg-light text-dark me-1 mb-1 p-2">East Coast</span>
                    <button class="btn btn-sm btn-outline-secondary mb-1"><i class="bi bi-plus"></i></button>
                  </div>
                  
                  <h6 class="text-muted mb-3">Notes</h6>
                  <div class="card mb-2 bg-light">
                    <div class="card-body py-2 px-3">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">Added by Sarah Johnson</small>
                        <small class="text-muted">Feb 18, 2025</small>
                      </div>
                      <p class="mb-0">Client expressed interest in our premium package offerings. Follow-up scheduled for next week.</p>
                    </div>
                  </div>
                  <div class="card mb-2 bg-light">
                    <div class="card-body py-2 px-3">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">Added by Michael Chen</small>
                        <small class="text-muted">Feb 10, 2025</small>
                      </div>
                      <p class="mb-0">Had a lengthy discussion about expansion plans for Q3. Very promising outlook.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Communication Tab -->
        <div class="tab-pane fade" id="communication" role="tabpanel" aria-labelledby="communication-tab">
          <div class="row">
            <!-- Recent Communication -->
            <div class="col-lg-8 mb-4">
              <div class="card card-hover">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Communication History</h5>
                  <div>
                    <button class="btn btn-primary me-2"><i class="bi bi-envelope me-1"></i> New Message</button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-telephone me-1"></i> Call</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                      <h6 class="mb-0"><i class="bi bi-envelope me-2 text-primary"></i> Email Conversation</h6>
                      <span class="text-muted">Feb 24, 2025 - 10:32 AM</span>
                    </div>
                    <p>Subject: <strong>Follow-up on Recent Deal</strong></p>
                    <p>Hello John,</p>
                    <p>I wanted to follow up regarding our recent conversation about the investment opportunities. We have some new options that might interest you.</p>
                    <p>Best regards,<br>Sarah Johnson</p>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-reply me-1"></i>Reply</button>
                      <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-forward me-1"></i>Forward</button>
                    </div>
                  </div>
                  
                  <div class="mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                      <h6 class="mb-0"><i class="bi bi-telephone me-2 text-success"></i> Phone Call</h6>
                      <span class="text-muted">Feb 22, 2025 - 2:15 PM</span>
                    </div>
                    <p>Duration: <strong>14 minutes</strong></p>
                    <p>Call Notes:</p>
                    <p>Discussed upcoming investment opportunities. Client expressed interest in our new premium portfolio. Scheduled follow-up call for next week.</p>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Edit Notes</button>
                      <button class="btn btn-sm btn-outline-success"><i class="bi bi-telephone me-1"></i>Call Back</button>
                    </div>
                  </div>
                  
                  <div class="mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                      <h6 class="mb-0"><i class="bi bi-chat-dots me-2 text-info"></i> Text Message</h6>
                      <span class="text-muted">Feb 20, 2025 - 9:45 AM</span>
                    </div>
                    <p>Hi John, this is a reminder about our meeting tomorrow at 11 AM to discuss your portfolio. Looking forward to seeing you. -Sarah</p>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-chat me-1"></i>Reply</button>
                    </div>
                  </div>
                  
                  <div class="mb-4 pb-3">
                    <div class="d-flex justify-content-between mb-2">
                      <h6 class="mb-0"><i class="bi bi-envelope me-2 text-primary"></i> Email Conversation</h6>
                      <span class="text-muted">Feb 18, 2025 - 3:20 PM</span>
                    </div>
                    <p>Subject: <strong>Quarterly Portfolio Review</strong></p>
                    <p>Dear John,</p>
                    <p>I'd like to schedule a time for us to review your portfolio performance for Q1. Please let me know when would be a good time for you.</p>
                    <p>Kind regards,<br>Michael Chen</p>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-reply me-1"></i>Reply</button>
                      <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-forward me-1"></i>Forward</button>
                    </div>
                  </div>
                  
                  <nav aria-label="Communication history pagination">
                    <ul class="pagination justify-content-center">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
            
            <!-- Communication Stats -->
            <div class="col-lg-4 mb-4">
              <div class="card card-hover mb-4">
                <div class="card-header">
                  <h5 class="mb-0">Communication Statistics</h5>
                </div>
                <div class="card-body">
                  <div class="mb-4">
                    <h6 class="text-muted mb-3">Communication Methods</h6>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">Email (45%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Phone (30%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Text (15%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">In-Person (10%)</div>
                    </div>
                  </div>
                  
                  <div>
                    <h6 class="text-muted mb-3">Response Time</h6>
                    <div class="d-flex align-items-center mb-3">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-success bg-opacity-25 p-2">
                          <i class="bi bi-envelope text-success"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Email Response</span>
                          <span>4 hours</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-primary bg-opacity-25 p-2">
                          <i class="bi bi-telephone text-primary"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Call Back</span>
                          <span>1 business day</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-info bg-opacity-25 p-2">
                          <i class="bi bi-chat-dots text-info"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Text Response</span>
                          <span>2 hours</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card card-hover">
                <div class="card-header">
                  <h5 class="mb-0">Contacts</h5>
                </div>
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                      <img src="/api/placeholder/40/40" class="rounded-circle" alt="Sarah Johnson">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-0">Sarah Johnson</h6>
                      <small class="text-muted">Account Manager</small>
                    </div>
                    <div class="flex-shrink-0">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-envelope"></i></button>
                    </div>
                  </div>
                  
                  <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                      <img src="/api/placeholder/40/40" class="rounded-circle" alt="Michael Chen">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-0">Michael Chen</h6>
                      <small class="text-muted">Financial Advisor</small>
                    </div>
                    <div class="flex-shrink-0">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-envelope"></i></button>
                    </div>
                  </div>
                  
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img src="/api/placeholder/40/40" class="rounded-circle" alt="Jessica Williams">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-0">Jessica Williams</h6>
                      <small class="text-muted">Customer Support</small>
                    </div>
                    <div class="flex-shrink-0">
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-envelope"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Deal History Tab -->
        <div class="tab-pane fade" id="deal-history" role="tabpanel" aria-labelledby="deal-history-tab">
          <div class="row">
            <!-- Deals Table -->
            <div class="col-12 mb-4">
              <div class="card card-hover">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Deal History</h5>
                  <div>
                    <button class="btn btn-outline-secondary me-2"><i class="bi bi-filter me-1"></i> Filter</button>
                    <button class="btn btn-outline-secondary me-2"><i class="bi bi-download me-1"></i> Export</button>
                    <button class="btn btn-primary"><i class="bi bi-plus me-1"></i> New Deal</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Deal ID</th>
                          <th>Type</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Agent</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5832</a></td>
                          <td>Investment</td>
                          <td>Feb 20, 2025</td>
                          <td>$12,500</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Sarah Johnson</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5789</a></td>
                          <td>Portfolio Review</td>
                          <td>Feb 15, 2025</td>
                          <td>$8,750</td>
                          <td><span class="badge bg-warning text-dark">Pending</span></td>
                          <td>Michael Chen</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5721</a></td>
                          <td>Investment</td>
                          <td>Feb 10, 2025</td>
                          <td>$5,300</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Sarah Johnson</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5698</a></td>
                          <td>Account Adjustment</td>
                          <td>Feb 5, 2025</td>
                          <td>$9,200</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Michael Chen</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5645</a></td>
                          <td>Portfolio Review</td>
                          <td>Jan 28, 2025</td>
                          <td>$7,800</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Sarah Johnson</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5612</a></td>
                          <td>Investment</td>
                          <td>Jan 20, 2025</td>
                          <td>$11,400</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Michael Chen</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="text-decoration-none">DEA-5598</a></td>
                          <td>Account Setup</td>
                          <td>Jan 15, 2025</td>
                          <td>$15,000</td>
                          <td><span class="badge bg-success">Completed</span></td>
                          <td>Sarah Johnson</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                              <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                              <button class="btn btn-sm btn-outline-info"><i class="bi bi-file-text"></i></button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <nav aria-label="Deal history pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
            
            <!-- Deal Statistics -->
            <div class="col-md-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header">
                  <h5 class="mb-0">Deal Statistics</h5>
                </div>
                <div class="card-body">
                  <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-primary bg-opacity-25 p-3">
                            <i class="bi bi-graph-up text-primary fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Avg. Deal Size</h6>
                          <h4 class="mb-0">$9,992</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                          <div class="rounded-circle bg-success bg-opacity-25 p-3">
                            <i class="bi bi-calendar-check text-success fs-4"></i>
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-1">Completion Rate</h6>
                          <h4 class="mb-0">94.3%</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <h6 class="text-muted mb-3">Deal Type Distribution</h6>
                  <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">Investments (45%)</div>
                  </div>
                  <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Portfolio Reviews (30%)</div>
                  </div>
                  <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Account Adjustments (15%)</div>
                  </div>
                  <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">Account Setup (10%)</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Monthly Trend -->
            <div class="col-md-6 mb-4">
              <div class="card card-hover h-100">
                <div class="card-header">
                  <h5 class="mb-0">Monthly Deal Trend</h5>
                </div>
                <div class="card-body">
                  <div class="text-center py-4">
                    <img src="/api/placeholder/500/250" alt="Monthly deal trend chart" class="img-fluid">
                    <p class="text-muted mt-3">Showing past 6 months of deal activity</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Activity Tab -->
        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
          <div class="row">
            <!-- Activity Timeline -->
            <div class="col-lg-8 mb-4">
              <div class="card card-hover">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Activity Timeline</h5>
                  <div>
                    <button class="btn btn-outline-secondary me-2"><i class="bi bi-filter me-1"></i> Filter</button>
                    <button class="btn btn-outline-primary"><i class="bi bi-calendar me-1"></i> Date Range</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="activity-timeline">
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Deal Completed</h6>
                        <span class="text-muted">Feb 20, 2025 - 2:45 PM</span>
                      </div>
                      <p>Investment deal DEA-5832 completed successfully for $12,500.</p>
                      <span class="badge bg-success mb-2">Deal</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Message Received</h6>
                        <span class="text-muted">Feb 18, 2025 - 10:32 AM</span>
                      </div>
                      <p>Email received from Sarah Johnson regarding quarterly portfolio review.</p>
                      <span class="badge bg-primary mb-2">Communication</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Profile Updated</h6>
                        <span class="text-muted">Feb 17, 2025 - 3:20 PM</span>
                      </div>
                      <p>User updated contact information and preferences.</p>
                      <span class="badge bg-info mb-2">Profile</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Deal Started</h6>
                        <span class="text-muted">Feb 15, 2025 - 11:10 AM</span>
                      </div>
                      <p>New portfolio review deal DEA-5789 initiated with Michael Chen for $8,750.</p>
                      <span class="badge bg-success mb-2">Deal</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Call Received</h6>
                        <span class="text-muted">Feb 12, 2025 - 9:45 AM</span>
                      </div>
                      <p>Incoming call from user to discuss investment opportunities, duration 12 minutes.</p>
                      <span class="badge bg-primary mb-2">Communication</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Document Signed</h6>
                        <span class="text-muted">Feb 10, 2025 - 4:30 PM</span>
                      </div>
                      <p>User electronically signed investment agreement for deal DEA-5721.</p>
                      <span class="badge bg-warning text-dark mb-2">Document</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Deal Completed</h6>
                        <span class="text-muted">Feb 10, 2025 - 2:15 PM</span>
                      </div>
                      <p>Investment deal DEA-5721 completed successfully for $5,300.</p>
                      <span class="badge bg-success mb-2">Deal</span>
                    </div>
                    
                    <div class="timeline-item">
                      <div class="timeline-dot"></div>
                      <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Login Detected</h6>
                        <span class="text-muted">Feb 8, 2025 - 8:05 AM</span>
                      </div>
                      <p>User logged in from new device (iPhone 18, San Francisco, CA).</p>
                      <span class="badge bg-secondary mb-2">Security</span>
                    </div>
                  </div>
                  
                  <nav aria-label="Activity pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
            
            <!-- Activity Stats -->
            <div class="col-lg-4 mb-4">
              <div class="card card-hover mb-4">
                <div class="card-header">
                  <h5 class="mb-0">Activity Summary</h5>
                </div>
                <div class="card-body">
                  <div class="mb-4">
                    <h6 class="text-muted mb-3">Activity by Type</h6>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Deals (35%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-primary" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Communication (30%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Profile (15%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 12%;" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">Documents (12%)</div>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                      <div class="progress-bar bg-secondary" role="progressbar" style="width: 8%;" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100">Security (8%)</div>
                    </div>
                  </div>
                  
                  <div class="mb-4">
                    <h6 class="text-muted mb-3">Recent Activity</h6>
                    <div class="d-flex align-items-center mb-3">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-success bg-opacity-25 p-2">
                          <i class="bi bi-check-circle text-success"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Deal Completion</span>
                          <span class="text-muted">2 days ago</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-primary bg-opacity-25 p-2">
                          <i class="bi bi-envelope text-primary"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Email Received</span>
                          <span class="text-muted">4 days ago</span>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-info bg-opacity-25 p-2">
                          <i class="bi bi-person-check text-info"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                          <span>Profile Update</span>
                          <span class="text-muted">5 days ago</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div>
                    <h6 class="text-muted mb-3">Activity Trend</h6>
                    <div class="text-center">
                      <img src="/api/placeholder/300/150" alt="Activity trend chart" class="img-fluid">
                      <p class="text-muted mt-2">Last 30 days activity</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card card-hover">
                <div class="card-header">
                  <h5 class="mb-0">Alerts</h5>
                </div>
                <div class="card-body">
                  <div class="alert alert-warning" role="alert">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle"></i>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading mb-1">Account Verification Needed</h6>
                        <p class="mb-0">User needs to verify new email address.</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="alert alert-info" role="alert">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <i class="bi bi-info-circle"></i>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading mb-1">Document Review</h6>
                        <p class="mb-0">User has pending documents to review.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Wallet Tab -->
        <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
          <div class="row">
            <!-- Wallet Overview -->
            <div class="col-lg-8 mb-4">
              <div class="card card-hover">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Wallet Overview</h5>
                  <div>
                    <button class="btn btn-primary me-2"><i class="bi bi-plus-circle me-1"></i> Add Funds</button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-arrow-left-right me-1"></i> Transfer</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <div class="card bg-primary text-white">
                        <div class="card-body">
                          <h5 class="card-title">Available Balance</h5>
                          <h2 class="display-5 mb-3">$42,587.32</h2>
                          <div class="d-flex justify-content-between">
                            <small>Last transaction: Feb 20, 2025</small>
                            <small><i class="bi bi-arrow-up-circle"></i> 4.2% this month</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card bg-light">
                        <div class="card-body">
                          <h5 class="card-title text-muted">Pending Transactions</h5>
                          <h2 class="display-5 mb-3">$8,750.00</h2>
                          <div class="d-flex justify-content-between text-muted">
                            <small>1 pending transaction</small>
                            <small>Expected: Feb 28, 2025</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <h6 class="mb-3">Recent Transactions</h6>
                  <div class="table-responsive">
                    <table class="table table-hover align-middle">
                      <thead>
                        <tr>
                          <th>Transaction ID</th>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><small class="text-muted">TRX-29384</small></td>
                          <td>Feb 20, 2025</td>
                          <td>Investment Deposit</td>
                          <td><span class="badge bg-success">Credit</span></td>
                          <td class="text-success">+ $12,500.00</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><small class="text-muted">TRX-29380</small></td>
                          <td>Feb 15, 2025</td>
                          <td>Portfolio Review Fee</td>
                          <td><span class="badge bg-danger">Debit</span></td>
                          <td class="text-danger">- $250.00</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><small class="text-muted">TRX-29375</small></td>
                          <td>Feb 10, 2025</td>
                          <td>Investment Deposit</td>
                          <td><span class="badge bg-success">Credit</span></td>
                          <td class="text-success">+ $5,300.00</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><small class="text-muted">TRX-29371</small></td>
                          <td>Feb 5, 2025</td>
                          <td>Account Adjustment</td>
                          <td><span class="badge bg-success">Credit</span></td>
                          <td class="text-success">+ $9,200.00</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                          <td><small class="text-muted">TRX-29365</small></td>
                          <td>Jan 28, 2025</td>
                          <td>Dividend Payment</td>
                          <td><span class="badge bg-success">Credit</span></td>
                          <td class="text-success">+ $675.50</td>
                          <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="text-center mt-3">
                    <button class="btn btn-outline-primary">View All Transactions</button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Wallet Stats -->
            <div class="col-lg-4 mb-4">
              <div class="row">
                <!-- Payment Methods -->
                <div class="col-12 mb-4">
                  <div class="card card-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Payment Methods</h5>
                      <button class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i> Add New</button>
                    </div>
                    <div class="card-body">
                      <div class="d-flex align-items-center p-2 border rounded mb-3">
                        <div class="flex-shrink-0">
                          <i class="bi bi-credit-card fs-3 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Visa ending in 4821</h6>
                            <span class="badge bg-success">Primary</span>
                          </div>
                          <small class="text-muted">Expires 09/28</small>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                          <button class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></button>
                          <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </div>
                      </div>
                      
                      <div class="d-flex align-items-center p-2 border rounded mb-3">
                        <div class="flex-shrink-0">
                          <i class="bi bi-credit-card fs-3 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-0">Mastercard ending in 2345</h6>
                          <small class="text-muted">Expires 11/27</small>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                          <button class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></button>
                          <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </div>
                      </div>
                      
                      <div class="d-flex align-items-center p-2 border rounded">
                        <div class="flex-shrink-0">
                          <i class="bi bi-bank fs-3 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h6 class="mb-0">Bank Account (ACH)</h6>
                          <small class="text-muted">Chase ****6789</small>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                          <button class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></button>
                          <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Wallet Distribution -->
                <div class="col-12 mb-4">
                  <div class="card card-hover">
                    <div class="card-header">
                      <h5 class="mb-0">Wallet Distribution</h5>
                    </div>
                    <div class="card-body">
                      <div class="text-center py-3">
                        <img src="/api/placeholder/300/200" alt="Wallet distribution chart" class="img-fluid">
                      </div>
                      <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                          <span><i class="bi bi-circle-fill text-primary me-2"></i> Stocks</span>
                          <span>45%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                          <span><i class="bi bi-circle-fill text-success me-2"></i> Bonds</span>
                          <span>25%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                          <span><i class="bi bi-circle-fill text-info me-2"></i> Cash</span>
                          <span>15%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <span><i class="bi bi-circle-fill text-warning me-2"></i> Alternative</span>
                          <span>15%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Upcoming Payments -->
                <div class="col-12">
                  <div class="card card-hover">
                    <div class="card-header">
                      <h5 class="mb-0">Upcoming Payments</h5>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                          <h6 class="mb-1">Portfolio Management Fee</h6>
                          <small class="text-muted">Quarterly payment</small>
                        </div>
                        <div class="text-end">
                          <h6 class="mb-1">$350.00</h6>
                          <small class="text-muted">Due: Mar 15, 2025</small>
                        </div>
                      </div>
                      
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <h6 class="mb-1">Account Maintenance</h6>
                          <small class="text-muted">Annual fee</small>
                        </div>
                        <div class="text-end">
                          <h6 class="mb-1">$125.00</h6>
                          <small class="text-muted">Due: Apr 10, 2025</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
