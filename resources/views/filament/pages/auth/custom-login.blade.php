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
            /* Sharp diagonal split */
            background: linear-gradient(110deg, var(--bg-card) 55%, var(--theme-red-dark) 55.1%, var(--theme-red) 100%);
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
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, var(--theme-red-dark), var(--theme-red));
        color: white;
    }
    @media (min-width: 768px) {
        .card-right {
            width: 45%;
            padding: 4rem 3rem;
            background: transparent; /* Rely on wrapper gradient */
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
    
    .footer-brand {
        font-size: 0.9rem;
        font-weight: bold;
        color: var(--theme-red);
    }

</style>

<div class="custom-login-wrapper" id="login-wrapper" data-theme="dark">
    
    <button id="theme-toggle" class="theme-switch" aria-label="Toggle Theme">
        <div class="theme-switch-thumb"></div>
        <svg class="sun-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 2.28a1 1 0 011.415 0l.708.708a1 1 0 01-1.414 1.414l-.708-.708a1 1 0 010-1.414zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zm-2.28 4.22a1 1 0 010 1.415l-.708.708a1 1 0 01-1.414-1.414l.708-.708a1 1 0 011.414 0zM10 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.22-2.28a1 1 0 01-1.415 0l-.708-.708a1 1 0 011.414-1.414l.708.708a1 1 0 010 1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm2.28-4.22a1 1 0 010-1.415l.708-.708a1 1 0 011.414 1.414l-.708.708a1 1 0 01-1.414 0zM10 5a5 5 0 100 10 5 5 0 000-10z" clip-rule="evenodd"></path></svg>
        <svg class="moon-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
    </button>

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
        const themeToggle = document.getElementById('theme-toggle');
        const wrapper = document.getElementById('login-wrapper');

        themeToggle.addEventListener('click', () => {
            const isDark = wrapper.getAttribute('data-theme') === 'dark';
            
            if (isDark) {
                // Switch to Light
                wrapper.removeAttribute('data-theme');
            } else {
                // Switch to Dark
                wrapper.setAttribute('data-theme', 'dark');
            }
        });
    });
</script>
</div>
