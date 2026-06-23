<x-filament-panels::page>
    <style>
        /* Base / Light Mode */
        .custom-profile-wrapper {
            font-family: 'Inter', sans-serif;
            color: #111827;
        }
        [x-cloak] { display: none !important; }
        
        .profile-header-card {
            position: relative;
            background: #ffffff; /* White background */
            border-radius: 16px;
            padding: 40px 20px 120px; /* Extra padding at bottom for the bigger wave */
            text-align: center;
            overflow: hidden;
            border: 1px solid #ef4444;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            color: #111827; /* Dark text */
        }
        .profile-header-card p { color: #6b7280; }
        .header-wave {
            position: absolute;
            bottom: 0; left: 0; width: 100%;
            line-height: 0;
            z-index: 1;
        }
        .waves {
            position: relative;
            width: 100%;
            height: 120px;
            margin-bottom: -7px; 
            min-height: 120px;
            max-height: 160px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; fill: rgba(239, 68, 68, 0.3); }
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; fill: rgba(239, 68, 68, 0.5); }
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; fill: rgba(239, 68, 68, 0.7); }
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; fill: #ef4444; }
        
        @keyframes move-forever {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .profile-avatar-container {
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: center;
        }
        
        /* Apply red border to Filament's avatar container */
        .profile-avatar-container .fi-fo-file-upload {
            border: 4px solid #ef4444 !important;
            padding: 4px !important;
            background: white !important;
            border-radius: 50% !important;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2) !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }

        .profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #ef4444;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 12px;
        }
        
        .profile-section-card {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1);
            position: relative;
        }
        .profile-section-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .section-icon-box {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
        }
        .section-subtitle {
            font-size: 0.8rem;
            color: #6b7280;
            margin: 0;
        }
        
        .custom-input-group {
            position: relative;
            margin-bottom: 16px;
        }
        .custom-input-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        .custom-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #111827;
            border-radius: 8px;
            padding: 10px 12px 10px 42px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .custom-input:focus {
            outline: none;
            border-color: #ef4444;
            box-shadow: 0 0 0 1px #ef4444;
        }
        .input-icon-left {
            position: absolute;
            left: 12px; top: 36px;
            color: #ef4444;
            width: 18px; height: 18px;
            pointer-events: none;
        }
        .input-icon-right {
            position: absolute;
            right: 12px; top: 36px;
            color: #6b7280;
            width: 18px; height: 18px;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #fee2e2;
            color: #ef4444;
            border: 1px solid #fca5a5;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: #fecaca;
        }
        
        .custom-table { width: 100%; border-collapse: collapse; }
        .custom-table th {
            text-align: left; padding: 12px 16px;
            color: #6b7280; font-weight: 500; font-size: 0.8rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .custom-table td {
            padding: 14px 16px; border-bottom: 1px solid #e5e7eb;
            color: #111827; font-size: 0.85rem;
        }
        .custom-table tr:last-child td { border-bottom: none; }
        
        .status-pill {
            background: #fee2e2; color: #ef4444;
            padding: 4px 12px; border-radius: 999px;
            font-size: 0.7rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #ef4444; box-shadow: 0 0 5px #ef4444;
        }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .half-width { max-width: calc(50% - 10px); }
        @media (max-width: 768px) {
            .grid-2 { grid-template-columns: 1fr; gap: 0; }
            .half-width { max-width: 100%; }
        }

        /* Dark Mode Overrides */
        .dark .custom-profile-wrapper { color: #fff; }
        .dark .profile-header-card {
            background: #18181b;
            color: #fff;
            border-color: rgba(220, 38, 38, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .dark .profile-header-card p { color: #cbd5e1; }
        .dark .parallax > use:nth-child(1) { fill: rgba(220, 38, 38, 0.1); }
        .dark .parallax > use:nth-child(2) { fill: rgba(220, 38, 38, 0.2); }
        .dark .parallax > use:nth-child(3) { fill: rgba(220, 38, 38, 0.3); }
        .dark .parallax > use:nth-child(4) { fill: rgba(220, 38, 38, 0.5); }
        .dark .profile-role-badge {
            background: rgba(127, 29, 29, 0.6);
            color: #fca5a5; border-color: rgba(220, 38, 38, 0.4);
        }
        .dark .profile-section-card {
            background: #18181b; border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .dark .section-icon-box {
            background: rgba(220, 38, 38, 0.1); border-color: rgba(220, 38, 38, 0.2);
        }
        .dark .section-title { color: #f3f4f6; }
        .dark .section-subtitle { color: #9ca3af; }
        .dark .custom-input-label { color: #d1d5db; }
        .dark .custom-input {
            background: #0f0f11; border-color: #27272a; color: #f3f4f6;
        }
        .dark .custom-input:focus { border-color: #dc2626; box-shadow: 0 0 0 1px rgba(220, 38, 38, 0.5); }
        .dark .btn-primary { background: rgba(220, 38, 38, 0.1); border-color: rgba(220, 38, 38, 0.3); }
        .dark .btn-primary:hover { background: rgba(220, 38, 38, 0.2); border-color: rgba(220, 38, 38, 0.5); }
        .dark .custom-table th { color: #9ca3af; border-color: #27272a; }
        .dark .custom-table td { color: #e5e7eb; border-color: #27272a; }
        .dark .status-pill { background: rgba(220, 38, 38, 0.1); }
    </style>

    <div class="custom-profile-wrapper">
        <form wire:submit="save">
            <!-- Header Card -->
            <div class="profile-header-card">
                <div class="header-wave">
                    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" />
                            <use xlink:href="#gentle-wave" x="48" y="3" />
                            <use xlink:href="#gentle-wave" x="48" y="5" />
                            <use xlink:href="#gentle-wave" x="48" y="7" />
                        </g>
                    </svg>
                </div>
                <div class="header-content">
                    <div class="profile-avatar-container">
                        {{ $this->form }}
                    </div>
                    
                    @php $user = auth()->user(); @endphp
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin: 0 0 4px 0;">{{ $user->name }}</h2>
                    <p style="margin: 0; font-size: 0.9rem;">{{ $user->email }}</p>
                    
                    <div class="profile-role-badge">
                        <x-heroicon-o-shield-check style="width: 14px; height: 14px;" />
                        {{ implode(', ', $user->roles->pluck('name')->toArray() ?? ['Super Admin']) }}
                    </div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <div class="section-icon-box">
                        <x-heroicon-s-user style="width: 20px; height: 20px;" />
                    </div>
                    <div>
                        <h3 class="section-title">Informasi Akun</h3>
                        <p class="section-subtitle">Kelola informasi dasar akun Anda</p>
                    </div>
                </div>
                
                <div class="grid-2">
                    <div class="custom-input-group">
                        <label class="custom-input-label">Nama</label>
                        <x-heroicon-o-user class="input-icon-left" />
                        <input type="text" wire:model="name" class="custom-input" required>
                    </div>
                    <div class="custom-input-group">
                        <label class="custom-input-label">Email</label>
                        <x-heroicon-o-envelope class="input-icon-left" />
                        <input type="email" wire:model="email" class="custom-input" required>
                    </div>
                </div>
                
                <div class="custom-input-group half-width">
                    <label class="custom-input-label">Nomor HP</label>
                    <x-heroicon-o-phone class="input-icon-left" />
                    <input type="text" wire:model="no_hp" class="custom-input">
                </div>
            </div>

            <!-- Keamanan -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <div class="section-icon-box">
                        <x-heroicon-s-shield-check style="width: 20px; height: 20px;" />
                    </div>
                    <div>
                        <h3 class="section-title">Keamanan</h3>
                        <p class="section-subtitle">Ubah password akun Anda secara berkala untuk keamanan akun</p>
                    </div>
                </div>
                
                <div class="grid-2">
                    <div class="custom-input-group" x-data="{ show: false }">
                        <label class="custom-input-label">Password Saat Ini</label>
                        <x-heroicon-o-lock-closed class="input-icon-left" />
                        <input x-bind:type="show ? 'text' : 'password'" wire:model="current_password" class="custom-input" placeholder="Masukkan password saat ini">
                        <div @click="show = !show" class="input-icon-right flex items-center justify-center">
                            <x-heroicon-o-eye x-show="!show" style="width: 18px; height: 18px;" />
                            <x-heroicon-o-eye-slash x-show="show" style="width: 18px; height: 18px;" x-cloak />
                        </div>
                    </div>
                    <div class="custom-input-group" x-data="{ show: false }">
                        <label class="custom-input-label">Password Baru</label>
                        <x-heroicon-o-lock-closed class="input-icon-left" />
                        <input x-bind:type="show ? 'text' : 'password'" wire:model="password" class="custom-input" placeholder="Masukkan password baru">
                        <div @click="show = !show" class="input-icon-right flex items-center justify-center">
                            <x-heroicon-o-eye x-show="!show" style="width: 18px; height: 18px;" />
                            <x-heroicon-o-eye-slash x-show="show" style="width: 18px; height: 18px;" x-cloak />
                        </div>
                    </div>
                </div>
                
                <div class="custom-input-group half-width" x-data="{ show: false }">
                    <label class="custom-input-label">Konfirmasi Password Baru</label>
                    <x-heroicon-o-lock-closed class="input-icon-left" />
                    <input x-bind:type="show ? 'text' : 'password'" wire:model="password_confirmation" class="custom-input" placeholder="Konfirmasi password baru">
                    <div @click="show = !show" class="input-icon-right flex items-center justify-center">
                        <x-heroicon-o-eye x-show="!show" style="width: 18px; height: 18px;" />
                        <x-heroicon-o-eye-slash x-show="show" style="width: 18px; height: 18px;" x-cloak />
                    </div>
                </div>
                
                <div style="margin-top: 24px;">
                    <button type="submit" class="btn-primary">
                        <x-heroicon-o-document-check style="width: 16px; height: 16px;" />
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            <!-- Sesi Perangkat -->
            <div class="profile-section-card">
                <div class="profile-section-header">
                    <div class="section-icon-box">
                        <x-heroicon-s-computer-desktop style="width: 20px; height: 20px;" />
                    </div>
                    <div>
                        <h3 class="section-title">Sesi Perangkat</h3>
                        <p class="section-subtitle">Kelola perangkat yang login di akun Anda</p>
                    </div>
                </div>
                
                <div style="overflow-x: auto; margin-bottom: 24px;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Perangkat</th>
                                <th>IP Address</th>
                                <th>Aktivitas Terakhir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this->getSessions() as $session)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if(str_contains($session['browser'], 'Chrome'))
                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e5e7eb;">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/Google_Chrome_icon_%282011%29.png" style="width: 20px; height: 20px;">
                                            </div>
                                        @else
                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #f3f4f6; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                                <x-heroicon-o-globe-alt style="width: 16px; height: 16px;" />
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <div style="font-weight: 600;" class="text-gray-900 dark:text-gray-100">{{ $session['browser'] }} pada {{ $session['device'] }}</div>
                                            @if($session['is_current'])
                                                <div style="font-size: 0.7rem; color: #10b981; font-weight: 500;">Perangkat Ini</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $session['ip_address'] }}</td>
                                <td>
                                    @if($session['is_active_now'])
                                        <div style="display: flex; align-items: center; gap: 6px; color: #ef4444; font-weight: 500;">
                                            <div class="status-dot"></div>
                                            Sedang Aktif
                                        </div>
                                    @else
                                        {{ $session['last_active'] }}
                                    @endif
                                </td>
                                <td>
                                    @if($session['is_active_now'])
                                        <div class="status-pill">Aktif</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <button type="button" wire:click="logoutOtherSessions" class="btn-primary">
                    <x-heroicon-o-arrow-right-on-rectangle style="width: 16px; height: 16px;" />
                    Keluar dari perangkat lain
                </button>
            </div>
            
        </form>
    </div>
</x-filament-panels::page>
