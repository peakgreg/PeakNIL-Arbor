<div id="kbar" class="kbar-overlay" style = "z-index: 100000;">
    <div class="kbar-container">
        <div class="kbar-left">
            <div class="kbar-header">
                <h2 class="kbar-title">Bootstrap Breakpoints</h2>
                <button class="close-button" onclick="toggleKbar()">✕</button>
            </div>

            <div class="info-row">
                <span class="label">Current Width:</span>
                <span id="currentWidth">0px</span>
            </div>
            
            <div class="info-row">
                <span class="label">Current Breakpoint:</span>
                <span id="currentBreakpoint" class="current-breakpoint">col-xs</span>
            </div>

            <div class="breakpoints-list">
                <h3 class="label" style="margin-bottom: 0.5rem;">All Breakpoints:</h3>
                <div id="breakpointsList"></div>
            </div>
        </div>

        <div class="kbar-right">
            <h3 class="label">PHP Superglobals</h3>
            <div>
                <h4>$_GET Variables:</h4>
                <pre>
                    <?php echo htmlspecialchars(print_r($_GET, true)); ?>
                </pre>
            </div>
            <div>
                <h4>$_POST Variables:</h4>
                <pre>
                    <?php echo htmlspecialchars(print_r($_POST, true)); ?>
                </pre>
            </div>
            <div>
                <h4>$_SESSION Variables:</h4>
                <pre>
                    <?php 
                    session_start();
                    echo htmlspecialchars(print_r($_SESSION, true)); 
                    ?>
                </pre>
            </div>
        </div>
    </div>
</div>

<script>
    const breakpoints = {
        'col-xs': 0,
        'col-sm': 576,
        'col-md': 768,
        'col-lg': 992,
        'col-xl': 1200,
        'col-xxl': 1400
    };

    let isOpen = false;

    function toggleKbar() {
        isOpen = !isOpen;
        document.getElementById('kbar').classList.toggle('open', isOpen);
    }

    function updateBreakpoint() {
        const width = window.innerWidth;
        document.getElementById('currentWidth').textContent = `${width}px`;

        let currentBreakpoint = 'col-xs';
        const breakpointEntries = Object.entries(breakpoints);
        
        for (let i = breakpointEntries.length - 1; i >= 0; i--) {
            if (width >= breakpointEntries[i][1]) {
                currentBreakpoint = breakpointEntries[i][0];
                break;
            }
        }

        document.getElementById('currentBreakpoint').textContent = currentBreakpoint;

        // Update breakpoints list
        const breakpointsList = document.getElementById('breakpointsList');
        breakpointsList.innerHTML = Object.entries(breakpoints)
            .map(([name, minWidth]) => `
                <div class="breakpoint-row ${name === currentBreakpoint ? 'active' : ''}">
                    <span>${name}</span>
                    <span style="color: #4b5563;">≥${minWidth}px</span>
                </div>
            `).join('');
    }

    // Initialize breakpoints list
    updateBreakpoint();

    // Event Listeners
    window.addEventListener('resize', updateBreakpoint);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'k' && (event.metaKey || event.ctrlKey)) {
            event.preventDefault();
            toggleKbar();
        }
    });
</script>

<style>
    .kbar-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .kbar-overlay.open {
        display: flex;
    }

    .kbar-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 1000px;
        padding: 1.5rem;
        display: flex;
        gap: 1.5rem;
    }

    .kbar-left, .kbar-right {
        flex: 1;
    }

    .kbar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .kbar-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin: 0;
    }

    .close-button {
        padding: 0.25rem;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: 9999px;
    }

    .close-button:hover {
        background-color: #f3f4f6;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .label {
        font-weight: 500;
    }

    .current-breakpoint {
        background-color: #dbeafe;
        color: #1e40af;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }

    .breakpoints-list {
        border-top: 1px solid #e5e7eb;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .breakpoint-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        border-radius: 0.25rem;
    }

    .breakpoint-row.active {
        background-color: #dbeafe;
    }

    .php-variables pre {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        padding: 0.5rem;
        overflow-x: auto;
    }

    .shortcut-hint {
        text-align: center;
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 1rem;
    }
</style>
