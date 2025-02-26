<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compliance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #6c757d;
        }
        pre {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <!-- Header -->
        <header class="mb-5">
            <h1 class="display-5 fw-light text-dark">PeakNIL Compliance</h1>
            <p class="text-muted">Control panel & data output</p>
        </header>

        <!-- Main content -->
        <div class="row g-4">
            <!-- Left column - Form -->
            <div class="col-lg-3">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Settings</h2>
                        <form>
                            <div class="mb-4">
                                <label class="form-label small text-muted">Name</label>
                                <input type="text" class="form-control bg-light" placeholder="Enter name">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small text-muted">Category</label>
                                <select class="form-select bg-light">
                                    <option>Select category</option>
                                    <option>Analytics</option>
                                    <option>Reports</option>
                                    <option>Settings</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small text-muted">Description</label>
                                <textarea class="form-control bg-light" rows="4" placeholder="Enter description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2">
                                Process Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Middle column - Output -->
            <div class="col-lg-5">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Output</h2>
                        <div class="font-monospace small">
                            <pre class="m-0"><code>{
  "data": [
    {
      "id": "001",
      "title": "Lorem ipsum dolor sit amet",
      "description": "Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.",
      "status": "active",
      "metrics": {
        "views": 1234,
        "engagement": 89.5
      }
    },
    {
      "id": "002",
      "title": "Sed ut perspiciatis unde omnis",
      "description": "Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.",
      "status": "pending",
      "metrics": {
        "views": 842,
        "engagement": 76.2
      }
    },
    {
      "id": "003",
      "title": "Ut enim ad minima veniam",
      "description": "Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse.",
      "status": "completed",
      "metrics": {
        "views": 2156,
        "engagement": 92.8
      }
    }
  ],
  "metadata": {
    "total_records": 3,
    "processed_at": "2024-02-04T12:00:00Z",
    "status": "success"
  }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column - Description & Status -->
            <div class="col-lg-4">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Analysis Details</h2>
                        
                        <!-- Compliance Status -->
                        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                            <div class="fw-semibold">
                                Status: COMPLIANT
                            </div>
                        </div>

                        <!-- Confidence Score -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="h6 text-muted mb-0">Confidence Score:</h5>
                                    <span class="h4 mb-0 fw-bold">95%</span>
                                </div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5 class="h6 text-muted mb-3">Description</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>

                        <!-- Additional Details -->
                        <div class="mb-4">
                            <h5 class="h6 text-muted mb-3">Additional Notes</h5>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
                        </div>

                        <!-- Timestamp -->
                        <div class="text-muted small">
                            Last updated: 2024-02-04 12:00:00 UTC
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>