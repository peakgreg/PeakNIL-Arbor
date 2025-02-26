<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeakNIL Compliance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .drop-zone {
            border: 2px dashed #dee2e6;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        .drop-zone:hover {
            border-color: #6c757d;
        }
        .spinner {
            width: 3rem;
            height: 3rem;
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
<body class="bg-light">
    <div class="container-fluid p-4">
        <!-- Header -->
        <header class="mb-5">
            <h1 class="display-5 fw-light text-dark">PeakNIL Compliance</h1>
            <p class="text-muted">Control panel & data output</p>
        </header>

        <!-- Main content -->
        <div class="row g-4">
            <!-- Left column - File Upload -->
            <div class="col-lg-3">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Settings</h2>
                        <div class="drop-zone mb-3" id="dropZone">
                            <input type="file" id="fileInput" accept=".pdf" class="d-none">
                            <span id="dropText">Drop PDF here or click to upload</span>
                        </div>
                        <button id="analyzeBtn" class="btn btn-dark w-100 py-2" disabled>
                            Analyze
                        </button>
                    </div>
                </div>
            </div>

            <!-- Middle column - Output -->
            <div class="col-lg-5">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Output</h2>
                        <div id="outputContent" class="font-monospace small">
                            <div class="text-muted text-center p-4">
                                Upload a document and click Analyze to begin
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column - Analysis Details -->
            <div class="col-lg-4">
                <div class="card border-light shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title h4 mb-4">Analysis Details</h2>
                        <div id="analysisContent">
                            <div class="text-muted text-center p-4">
                                Analysis results will appear here
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sampleOutput = {
            data: [
                {
                    id: "001",
                    title: "Lorem ipsum dolor sit amet",
                    description: "Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.",
                    status: "active",
                    metrics: {
                        views: 1234,
                        engagement: 89.5
                    }
                },
                {
                    id: "002",
                    title: "Sed ut perspiciatis unde omnis",
                    description: "Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.",
                    status: "pending",
                    metrics: {
                        views: 842,
                        engagement: 76.2
                    }
                },
                {
                    id: "003",
                    title: "Ut enim ad minima veniam",
                    description: "Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse.",
                    status: "completed",
                    metrics: {
                        views: 2156,
                        engagement: 92.8
                    }
                }
            ],
            metadata: {
                total_records: 3,
                processed_at: "2024-02-04T12:00:00Z",
                status: "success"
            }
        };

        let analysisCount = 0;
        
        // Elements
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const dropText = document.getElementById('dropText');
        const analyzeBtn = document.getElementById('analyzeBtn');
        const outputContent = document.getElementById('outputContent');
        const analysisContent = document.getElementById('analysisContent');

        // Drag and drop handlers
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#6c757d';
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            const file = e.dataTransfer.files[0];
            handleFile(file);
        });

        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (file && file.type === 'application/pdf') {
                dropText.textContent = file.name;
                analyzeBtn.disabled = false;
            }
        }

        // Loading sequence
        async function runLoadingSequence() {
            const messages = [
                { text: 'Scanning NIL Documents', duration: 2000 },
                { text: 'Getting Current NIL Regulations', duration: 2000 },
                { text: 'Analyzing for Compliance', duration: 2000 },
                { text: 'Generating Results', duration: 2000 }
            ];

            outputContent.innerHTML = `
                <div class="text-center p-4">
                    <div class="spinner-border spinner text-dark mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="loadingMessage" class="text-muted"></div>
                </div>
            `;

            const loadingMessage = document.getElementById('loadingMessage');
            
            for (const message of messages) {
                loadingMessage.textContent = message.text;
                await new Promise(resolve => setTimeout(resolve, message.duration));
            }
        }

        function showResults() {
            // Update output
            outputContent.innerHTML = `
                <pre class="m-0"><code>${JSON.stringify(sampleOutput, null, 2)}</code></pre>
            `;

            // Update analysis details
            const isCompliant = analysisCount % 2 === 0;
            const statusClass = isCompliant ? 'success' : 'danger';
            const statusText = isCompliant ? 'COMPLIANT' : 'NON-COMPLIANT';

            analysisContent.innerHTML = `
                <div class="alert alert-${statusClass} d-flex align-items-center mb-4" role="alert">
                    <div class="fw-semibold">
                        Status: ${statusText}
                    </div>
                </div>

                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="h6 text-muted mb-0">Confidence Score:</h5>
                            <span class="h4 mb-0 fw-bold">95%</span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-${statusClass}" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="h6 text-muted mb-3">Description</h5>
                    <p>${isCompliant ? 
                        'All NIL activities are properly documented and fall within current regulatory guidelines. The compensation structure aligns with fair market value assessments and proper disclosure requirements are met.' : 
                        'Several NIL activities require immediate attention. Documentation gaps and potential regulatory misalignments have been identified. Compensation structures may need review for fair market value compliance.'}</p>
                </div>

                <div class="mb-4">
                    <h5 class="h6 text-muted mb-3">Additional Notes</h5>
                    <p>${isCompliant ? 
                        'Regular monitoring and documentation processes are effective. Continue maintaining current compliance standards and stay updated with regulatory changes.' : 
                        'Immediate action required. Schedule compliance review meeting to address documentation gaps and develop remediation plan. Consider legal counsel review of current agreements.'}</p>
                </div>

                <div class="text-muted small">
                    Last updated: ${new Date().toUTCString()}
                </div>
            `;
        }

        // Analyze button handler
        analyzeBtn.addEventListener('click', async () => {
            analyzeBtn.disabled = true;
            await runLoadingSequence();
            showResults();
            analysisCount++;
            
            // Reset file input
            fileInput.value = '';
            dropText.textContent = 'Drop PDF here or click to upload';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>