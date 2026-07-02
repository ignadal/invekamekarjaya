<div>
<style>
    /* Theme Variables */
    :root {
        --bg-body: #f87171;
        --bg-card: #ffffff;
        --text-primary: #1f2937;
        --text-secondary: #4b5563;
        --input-border: #d1d5db;
        --theme-red: #ef4444;
        --theme-red-dark: #b91c1c;
        --theme-red-glow: rgba(220, 38, 38, 0.4);
        --neon-bg: #e5e7eb;
        --card-shadow: 0 0 25px rgba(220, 38, 38, 0.3), 0 10px 30px rgba(0, 0, 0, 0.1);
        --anim-color: #ffffff;
    }

    [data-theme="dark"] {
        --bg-body: #0f172a;
        --bg-card: #1e293b;
        --text-primary: #f8fafc;
        --text-secondary: #94a3b8;
        --input-border: #334155;
        --theme-red: #a855f7; /* Neon Purple */
        --theme-red-dark: #7e22ce; /* Dark Purple */
        --theme-red-glow: rgba(168, 85, 247, 0.8);
        --neon-bg: #0f172a;
        --card-shadow: 0 0 25px rgba(168, 85, 247, 0.6), 0 0 50px rgba(0, 0, 0, 0.5);
        --anim-color: var(--theme-red);
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

    /* Theme Switcher */
    .theme-switcher {
        position: absolute;
        top: 2rem;
        right: 2rem;
        display: flex;
        background-color: #f1f5f9;
        border-radius: 0.75rem;
        padding: 0.25rem;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        z-index: 50;
        gap: 0.25rem;
    }
    
    [data-theme="dark"] .theme-switcher {
        background-color: #1f2937;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }

    .theme-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: none;
        background: transparent;
        cursor: pointer;
        color: #9ca3af;
        transition: all 0.2s ease;
    }

    .theme-btn:hover {
        color: #6b7280;
    }

    [data-theme="dark"] .theme-btn:hover {
        color: #d1d5db;
    }

    .theme-btn.active {
        background-color: #ffffff;
        color: var(--theme-red);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    [data-theme="dark"] .theme-btn.active {
        background-color: #374151;
        color: var(--theme-red);
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .theme-btn svg {
        width: 20px;
        height: 20px;
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
        flex-direction: column-reverse;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .login-card {
            flex-direction: row;
            min-height: 550px;
            /* Sharp diagonal split */
            background: linear-gradient(110deg, var(--bg-card) 55%, var(--theme-red-dark) 55.1%, var(--theme-red) 100%);
        }
    }

    .card-left {
        width: 100%;
        padding: 2.5rem 1.5rem;
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
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        text-align: center;
        letter-spacing: -0.025em;
    }
    @media (min-width: 768px) {
        .login-title {
            font-size: 2rem;
            margin-bottom: 2rem;
        }
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

    /* Right Side: Welcome Text */
    .card-right {
        width: 100%;
        padding: 2.5rem 1.5rem;
        padding-bottom: 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, var(--theme-red-dark), var(--theme-red));
        color: white;
        border-bottom-left-radius: 50% 35px;
        border-bottom-right-radius: 50% 35px;
        box-shadow: 0 10px 20px -10px rgba(0,0,0,0.3);
    }
    @media (min-width: 768px) {
        .card-right {
            width: 45%;
            padding: 4rem 3rem;
            background: transparent; /* Rely on wrapper gradient */
            align-items: center;
            text-align: center;
            border-radius: 0;
            box-shadow: none;
            padding-bottom: 4rem;
        }
    }

    .brand-logo {
        height: 5rem;
        margin-bottom: 1rem;
        object-fit: contain;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        transition: all 0.3s ease;
    }
    @media (min-width: 768px) {
        .brand-logo {
            height: 7rem;
            margin-bottom: 1.5rem;
        }
    }

    .welcome-title {
        font-size: 1.75rem;
        line-height: 1.1;
        font-weight: 900;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    @media (min-width: 768px) {
        .welcome-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    }

    .welcome-text {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
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

    /* Elegant Wind/Breeze Animation */
    .breeze-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
        opacity: 1;
    }

    [data-theme="dark"] .breeze-container {
        opacity: 0.7;
    }

    .wind-line {
        position: absolute;
        background: linear-gradient(to right, transparent, var(--anim-color), transparent);
        height: 2px;
        border-radius: 100%;
        animation: windBlowing linear infinite;
        opacity: 0;
    }

    /* Adding multiple wind lines with different positions, sizes, and animation durations */
    .wind-line:nth-child(1) { top: 15%; width: 20%; animation-duration: 8s; animation-delay: 0s; }
    .wind-line:nth-child(2) { top: 35%; width: 35%; animation-duration: 12s; animation-delay: 2s; height: 1px; }
    .wind-line:nth-child(3) { top: 55%; width: 25%; animation-duration: 9s; animation-delay: 5s; }
    .wind-line:nth-child(4) { top: 75%; width: 40%; animation-duration: 15s; animation-delay: 1s; height: 3px; filter: blur(2px); }
    .wind-line:nth-child(5) { top: 85%; width: 30%; animation-duration: 11s; animation-delay: 7s; height: 1px; }
    .wind-line:nth-child(6) { top: 25%; width: 20%; animation-duration: 10s; animation-delay: 4s; filter: blur(1px); }
    .wind-line:nth-child(7) { top: 65%; width: 15%; animation-duration: 14s; animation-delay: 3s; height: 2px; }

    @keyframes windBlowing {
        0% { left: -50%; opacity: 0; transform: scaleX(0.5); }
        20% { opacity: 0.6; transform: scaleX(1); }
        80% { opacity: 0.6; transform: scaleX(1.2); }
        100% { left: 120%; opacity: 0; transform: scaleX(0.5); }
    }

    /* Dust Particles */
    .dust-particle {
        position: absolute;
        background: var(--anim-color);
        border-radius: 50%;
        opacity: 0;
        animation: blowDust linear infinite;
        box-shadow: 0 0 5px 1px var(--anim-color);
    }
    
    .dust-1 { top: 20%; width: 4px; height: 4px; animation-duration: 7s; animation-delay: 1s; }
    .dust-2 { top: 50%; width: 3px; height: 3px; animation-duration: 10s; animation-delay: 4s; }
    .dust-3 { top: 80%; width: 5px; height: 5px; animation-duration: 8s; animation-delay: 2s; }
    .dust-4 { top: 35%; width: 3px; height: 3px; animation-duration: 9s; animation-delay: 6s; }
    .dust-5 { top: 65%; width: 4px; height: 4px; animation-duration: 12s; animation-delay: 3s; }
    .dust-6 { top: 10%; width: 2px; height: 2px; animation-duration: 11s; animation-delay: 5s; }
    .dust-7 { top: 90%; width: 3px; height: 3px; animation-duration: 14s; animation-delay: 0s; }

    @keyframes blowDust {
        0% { left: -10%; opacity: 0; transform: translateY(0); }
        20% { opacity: 0.8; }
        80% { opacity: 0.8; }
        100% { left: 110%; opacity: 0; transform: translateY(-40px); }
    }

    /* Moving Wave Effect */
    .wave-wrapper {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 300px;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        animation: wave-animation 12s linear infinite;
    }

    .wave-1 {
        opacity: 0.3;
    }

    .wave-2 {
        animation-duration: 18s;
        opacity: 0.15;
        animation-direction: reverse;
        bottom: -10px;
    }

    @keyframes wave-animation {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

</style>

<div class="custom-login-wrapper" id="login-wrapper" data-theme="dark">
    
    <div class="theme-switcher">
        <button class="theme-btn" data-theme-value="light" aria-label="Light mode">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" /></svg>
        </button>
        <button class="theme-btn" data-theme-value="dark" aria-label="Dark mode">
            <svg fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
        </button>
        <button class="theme-btn" data-theme-value="system" aria-label="System mode">
            <svg viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 5.25a3 3 0 013-3h13.5a3 3 0 013 3V15a3 3 0 01-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 01-.53 1.28h-9a.75.75 0 01-.53-1.28l.621-.622a2.25 2.25 0 00.659-1.59V18h-3a3 3 0 01-3-3V5.25zm1.5 0v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5z" clip-rule="evenodd" /></svg>
        </button>
    </div>

    <!-- Background Animated Wind/Breeze -->
    <div class="breeze-container">
        <!-- Wind Lines -->
        <div class="wind-line"></div>
        <div class="wind-line"></div>
        <div class="wind-line"></div>
        <div class="wind-line"></div>
        <div class="wind-line"></div>
        <div class="wind-line"></div>
        <div class="wind-line"></div>

        <!-- Flying Dust Particles -->
        <div class="dust-particle dust-1"></div>
        <div class="dust-particle dust-2"></div>
        <div class="dust-particle dust-3"></div>
        <div class="dust-particle dust-4"></div>
        <div class="dust-particle dust-5"></div>
        <div class="dust-particle dust-6"></div>
        <div class="dust-particle dust-7"></div>

        <!-- Moving Wave Effect -->
        <div class="wave-wrapper">
            <svg class="wave wave-1" viewBox="0 0 2000 100" preserveAspectRatio="none">
                <path d="M0,50 C250,100 250,0 500,50 C750,100 750,0 1000,50 C1250,100 1250,0 1500,50 C1750,100 1750,0 2000,50 L2000,150 L0,150 Z" fill="var(--anim-color)"></path>
            </svg>
            <svg class="wave wave-2" viewBox="0 0 2000 100" preserveAspectRatio="none">
                <path d="M0,50 C250,0 250,100 500,50 C750,0 750,100 1000,50 C1250,0 1250,100 1500,50 C1750,0 1750,100 2000,50 L2000,150 L0,150 Z" fill="var(--anim-color)"></path>
            </svg>
        </div>
    </div>

    <div class="neon-wrapper">
        <div class="login-card">
            
            <!-- Left Side: Form -->
            <div class="card-left">
                <h2 class="login-title">Login Admin</h2>

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
        const wrapper = document.getElementById('login-wrapper');
        const themeBtns = document.querySelectorAll('.theme-btn');

        // Check local storage for theme
        let currentTheme = localStorage.getItem('theme') || 'system';

        function applyTheme(theme) {
            let isDarkMode = true; // Default

            if (theme === 'light') {
                isDarkMode = false;
            } else if (theme === 'dark') {
                isDarkMode = true;
            } else if (theme === 'system') {
                isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            // Apply theme
            if (isDarkMode) {
                wrapper.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
            } else {
                wrapper.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
            }

            // Update button states
            themeBtns.forEach(btn => {
                if (btn.getAttribute('data-theme-value') === theme) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        // Initialize theme
        applyTheme(currentTheme);

        // Handle button clicks
        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const selectedTheme = btn.getAttribute('data-theme-value');
                localStorage.setItem('theme', selectedTheme);
                applyTheme(selectedTheme);
            });
        });

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (localStorage.getItem('theme') === 'system' || !localStorage.getItem('theme')) {
                applyTheme('system');
            }
        });
    });
</script>
</div>
