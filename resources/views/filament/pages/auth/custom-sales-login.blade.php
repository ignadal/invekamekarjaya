<div>
<style>
    /* Theme Variables */
    :root {
        --bg-body: #f3f4f6;
        --bg-card: #ffffff;
        --text-primary: #1f2937;
        --text-secondary: #4b5563;
        --input-border: #d1d5db;
        --theme-red: #ef4444;
        --theme-red-dark: #b91c1c;
        --theme-red-glow: rgba(220, 38, 38, 0.4);
        --neon-bg: #e5e7eb;
        --card-shadow: 0 0 25px rgba(220, 38, 38, 0.3), 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    [data-theme="dark"] {
        --bg-body: #0a0a0a;
        --bg-card: #13131a;
        --text-primary: #ffffff;
        --text-secondary: #9ca3af;
        --input-border: #374151;
        --theme-red: #ef4444;
        --theme-red-dark: #991b1b;
        --theme-red-glow: rgba(239, 68, 68, 0.8);
        --neon-bg: #000000;
        --card-shadow: 0 0 25px rgba(239, 68, 68, 0.6), 0 0 50px rgba(0, 0, 0, 0.5);
    }

    /* Reset & Base Settings */
    .custom-login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        background-color: var(--bg-body);
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        padding: 1rem;
        transition: background-color 0.3s ease;
        position: relative;
    }
    
    main.fi-main {
        padding: 0 !important;
        max-width: 100% !important;
        margin: 0 !important;
        width: 100% !important;
    }
    .fi-main > .fi-page {
        max-width: 100% !important;
    }

    /* Theme Toggle Switch */
    .theme-switch {
        position: absolute;
        top: 2rem;
        right: 2rem;
        width: 76px;
        height: 38px;
        background-color: #f1f5f9; /* Light gray pill */
        border-radius: 9999px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        z-index: 50;
        border: none;
        transition: background-color 0.3s ease;
    }
    
    [data-theme="dark"] .theme-switch {
        background-color: #1f2937; /* Darker pill in dark mode */
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }

    .theme-switch-thumb {
        position: absolute;
        top: 4px;
        left: 4px;
        width: 30px;
        height: 30px;
        background-color: #ffffff;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        z-index: 1;
    }

    [data-theme="dark"] .theme-switch-thumb {
        transform: translateX(38px);
        background-color: #374151; /* Match dark theme */
    }

    .theme-switch svg {
        width: 18px;
        height: 18px;
        z-index: 2;
        transition: color 0.3s ease;
    }

    /* Sun Icon Colors */
    .theme-switch .sun-icon {
        color: var(--theme-red); /* Active red color */
    }
    [data-theme="dark"] .theme-switch .sun-icon {
        color: #6b7280; /* Inactive gray */
    }

    /* Moon Icon Colors */
    .theme-switch .moon-icon {
        color: #9ca3af; /* Inactive gray */
    }
    [data-theme="dark"] .theme-switch .moon-icon {
        color: var(--theme-red); /* Active red color */
    }
    
    /* Neon Border Wrapper */
    .neon-wrapper {
        position: relative;
        width: 100%;
        max-width: 900px;
        border-radius: 16px;
        padding: 3px; /* Border thickness */
        background: var(--neon-bg);
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }

    /* Rotating Neon Border Effect */
    .neon-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(
            transparent 0%, 
            var(--theme-red) 15%, 
            transparent 30%, 
            transparent 50%, 
            var(--theme-red) 65%, 
            transparent 80%, 
            transparent 100%
        );
        animation: rotate 4s linear infinite;
        z-index: 0;
        border-radius: 50%;
    }
    @keyframes rotate {
        100% { transform: rotate(360deg); }
    }

    /* Main Card Inside Neon Border */
    .login-card {
        position: relative;
        z-index: 1;
        width: 100%;
        background: var(--bg-card);
        border-radius: 13px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .login-card {
            flex-direction: row;
            min-height: 550px;
            background: var(--bg-card); /* Match theme */
        }
    }

    /* Left Side: Form */
    .card-left {
        width: 100%;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .card-left {
            width: 55%;
            padding: 4rem;
        }
    }

    .login-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 2rem;
        text-align: center;
        letter-spacing: -0.025em;
    }

    /* Filament Form Customizations */
    .form-container {
        width: 100%;
        color: var(--text-primary);
    }
    .form-container label,
    .form-container input,
    .form-container span,
    .form-container p {
        color: var(--text-primary) !important;
    }
    
    .form-container input,
    .form-container input[type="password"],
    .form-container .fi-input {
        caret-color: var(--theme-red) !important;
    }
    .form-container .fi-input-wrp {
        background-color: var(--bg-card) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
        border: 1px solid var(--input-border) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border-radius: 10px !important;
    }

    /* Input Focus Animation */
    .form-container .fi-input-wrp:focus-within {
        border-color: var(--theme-red) !important;
        box-shadow: 0 0 0 4px var(--theme-red-glow), 0 6px 12px rgba(0,0,0,0.08) !important;
        transform: translateY(-2px);
    }
    
    /* Fix Browser Autofill Background */
    .form-container input:-webkit-autofill,
    .form-container input:-webkit-autofill:hover, 
    .form-container input:-webkit-autofill:focus, 
    .form-container input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px var(--bg-card) inset !important;
        -webkit-text-fill-color: var(--text-primary) !important;
        caret-color: var(--theme-red) !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    .custom-login-btn {
        width: 100%;
        margin-top: 2rem;
        background: linear-gradient(90deg, var(--theme-red-dark), var(--theme-red));
        color: white;
        padding: 0.75rem 0;
        border-radius: 9999px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px var(--theme-red-glow);
    }
    .custom-login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px var(--theme-red-glow);
    }

    /* Divider */
    .neon-divider {
        display: none;
    }
    
    @media (min-width: 768px) {
        .neon-divider {
            display: block;
            position: absolute;
            left: 58%;
            top: -20%;
            height: 140%;
            width: 2px;
            background: rgba(239, 68, 68, 0.15); /* Faint red track */
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.1);
            transform: rotate(20deg);
            z-index: 2;
            overflow: hidden;
            border-radius: 0;
            margin: 0;
        }
        
        .neon-divider-glow {
            position: absolute;
            top: -50%;
            left: -1px;
            width: 4px;
            height: 50%;
            background: var(--theme-red);
            box-shadow: 0 0 20px 4px var(--theme-red), 0 0 40px 8px var(--theme-red);
            animation: scanline 3s linear infinite alternate;
            border-radius: 4px;
        }
    }
    
    @keyframes scanline {
        0% { top: -20%; }
        100% { top: 80%; }
    }

    /* Right Side: Welcome Text */
    .card-right {
        width: 100%;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: transparent;
        color: var(--text-primary);
    }
    @media (min-width: 768px) {
        .card-right {
            width: 45%;
            padding: 4rem 3rem;
            align-items: center;
            text-align: center;
        }
    }

    .brand-logo {
        height: 7rem;
        margin-bottom: 1.5rem;
        object-fit: contain;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        transition: all 0.3s ease;
    }

    .welcome-title {
        font-size: 2.5rem;
        line-height: 1.1;
        font-weight: 900;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--theme-red);
        text-shadow: 0 0 15px var(--theme-red-glow), 0 0 30px var(--theme-red-glow);
    }

    .welcome-text {
        font-size: 1rem;
        color: var(--text-secondary);
        line-height: 1.5;
        max-width: 300px;
    }
    
    .footer-presented {
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .presented-text {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .footer-logo {
        height: 1.5rem;
        width: auto;
        object-fit: contain;
    }
    
    .form-container span.footer-brand {
        font-size: 0.9rem;
        font-weight: bold;
        color: var(--theme-red-dark) !important;
    }

    /* Background Neon Chart */
    .bg-chart-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80vh;
        z-index: 0;
        opacity: 0.8;
        pointer-events: none;
        overflow: hidden;
        mask-image: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
        -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
    }

    [data-theme="dark"] .bg-chart-container {
        opacity: 1;
    }

    .bg-chart {
        width: 100%;
        height: 100%;
    }

    .chart-line {
        stroke-dasharray: 2000;
        stroke-dashoffset: 2000;
    }
    
    .chart-line.main {
        animation: drawLine 2.5s ease-in-out forwards infinite alternate;
    }
    
    .chart-line.fast {
        stroke-dasharray: 1000;
        animation: drawLine 1.5s linear forwards infinite alternate;
    }

    .chart-area {
        opacity: 0;
        animation: fadeInArea 2.5s ease-in-out forwards infinite alternate;
    }

    .chart-node {
        opacity: 0;
        animation: pulseNode 1s ease-in-out forwards infinite alternate;
    }
    
    .bar-anim {
        transform-origin: bottom;
        animation: scaleBar 2s ease-in-out forwards infinite alternate;
    }

    @keyframes drawLine {
        0% { stroke-dashoffset: 2000; }
        100% { stroke-dashoffset: 0; }
    }

    @keyframes fadeInArea {
        0%, 30% { opacity: 0; }
        100% { opacity: 1; }
    }

    @keyframes pulseNode {
        0% { opacity: 0.2; transform: scale(0.5); }
        100% { opacity: 1; transform: scale(1.5); }
    }
    
    @keyframes scaleBar {
        0% { transform: scaleY(0.3); opacity: 0.1; }
        100% { transform: scaleY(1); opacity: 0.5; }
    }

</style>

<div class="custom-login-wrapper" id="login-wrapper" data-theme="dark">
    
    <button id="theme-toggle" class="theme-switch" aria-label="Toggle Theme">
        <div class="theme-switch-thumb"></div>
        <svg class="sun-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" /></svg>
        <svg class="moon-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
    </button>

    <!-- Background Animated Neon Chart -->
    <div class="bg-chart-container">
        <svg class="bg-chart" viewBox="0 0 1000 400" preserveAspectRatio="none">
            <defs>
                <linearGradient id="chartGradient1" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="var(--theme-red)" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="var(--theme-red)" stop-opacity="0" />
                </linearGradient>
                <filter id="neonGlowHeavy" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="12" result="blur" />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>
            
            <!-- Grid lines -->
            <g class="chart-grid" stroke="var(--text-secondary)" stroke-opacity="0.25" stroke-width="1.5">
                <line x1="0" y1="50" x2="1000" y2="50" />
                <line x1="0" y1="150" x2="1000" y2="150" />
                <line x1="0" y1="250" x2="1000" y2="250" />
                <line x1="0" y1="350" x2="1000" y2="350" />
            </g>

            <!-- Floating Bars (Bar Chart) -->
            <g class="chart-bars" fill="var(--theme-red)" filter="url(#neonGlowHeavy)">
                <rect x="50" y="200" width="30" height="200" class="bar-anim" style="animation-delay: 0.1s" />
                <rect x="250" y="120" width="30" height="280" class="bar-anim" style="animation-delay: 0.4s" />
                <rect x="450" y="80" width="30" height="320" class="bar-anim" style="animation-delay: 0.2s" />
                <rect x="650" y="160" width="30" height="240" class="bar-anim" style="animation-delay: 0.7s" />
                <rect x="850" y="60" width="30" height="340" class="bar-anim" style="animation-delay: 0.5s" />
            </g>

            <!-- Background Line (Fast curve) -->
            <path class="chart-line fast" d="M0,300 Q100,200 200,320 T400,250 T600,100 T800,280 T1000,150" fill="none" stroke="#ff6b6b" stroke-width="2" filter="url(#neonGlowHeavy)" opacity="0.6" />

            <!-- Area under Main Line -->
            <path class="chart-area" d="M0,400 L0,250 L150,180 L300,260 L500,120 L700,160 L850,50 L1000,90 L1000,400 Z" fill="url(#chartGradient1)" />

            <!-- Main Glowing Line -->
            <path class="chart-line main" d="M0,250 L150,180 L300,260 L500,120 L700,160 L850,50 L1000,90" fill="none" stroke="var(--theme-red)" stroke-width="6" filter="url(#neonGlowHeavy)" />
            
            <!-- Nodes on Main Line -->
            <g fill="white" filter="url(#neonGlowHeavy)">
                <circle cx="150" cy="180" r="8" class="chart-node" style="animation-delay: 0.2s; transform-origin: 150px 180px;" />
                <circle cx="300" cy="260" r="8" class="chart-node" style="animation-delay: 0.4s; transform-origin: 300px 260px;" />
                <circle cx="500" cy="120" r="8" class="chart-node" style="animation-delay: 0.6s; transform-origin: 500px 120px;" />
                <circle cx="700" cy="160" r="8" class="chart-node" style="animation-delay: 0.8s; transform-origin: 700px 160px;" />
                <circle cx="850" cy="50" r="8" class="chart-node" style="animation-delay: 1.0s; transform-origin: 850px 50px;" />
            </g>
        </svg>
    </div>

    <div class="neon-wrapper">
        <div class="login-card">
            
            <!-- Left Side: Form -->
            <div class="card-left">
                <h2 class="login-title">Login Sales</h2>

                <div class="form-container">
                    <form wire:submit="authenticate">
                        {{ $this->form }}

                        <button type="submit" class="custom-login-btn">
                            Login
                        </button>
                    </form>
                    
                    <div class="footer-presented">
                        <span class="presented-text">presented by</span>
                        <img src="{{ asset('images/logo_red.png') }}" alt="UD. Mekar Jaya" class="footer-logo">
                        <span class="footer-brand">UD. Mekar Jaya</span>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="neon-divider">
                <div class="neon-divider-glow"></div>
            </div>

            <!-- Right Side: Graphic/Text -->
            <div class="card-right">
                <img id="dynamic-logo" src="{{ asset('images/logo_no_wm.png') }}" alt="INVEKA" class="brand-logo">
                <h3 class="welcome-title">INVEKA</h3>
                <p class="welcome-text"><strong>Inventori Mekar Jaya</strong><br><br>Sistem Informasi Manajemen Toko Besi UD. Mekar Jaya.</p>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const wrapper = document.getElementById('login-wrapper');
        const dynamicLogo = document.getElementById('dynamic-logo');

        themeToggle.addEventListener('click', () => {
            const isDark = wrapper.getAttribute('data-theme') === 'dark';
            
            if (isDark) {
                // Switch to Light
                wrapper.removeAttribute('data-theme');
                if (dynamicLogo) dynamicLogo.src = "{{ asset('images/logo_red.png') }}";
            } else {
                // Switch to Dark
                wrapper.setAttribute('data-theme', 'dark');
                if (dynamicLogo) dynamicLogo.src = "{{ asset('images/logo_no_wm.png') }}";
            }
        });
    });
</script>
</div>
