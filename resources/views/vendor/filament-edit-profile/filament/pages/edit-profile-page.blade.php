<x-filament-panels::page>
    <style>
        /* WhatsApp-style Flat Design CSS Overrides */
        
        /* Remove default page max-width to allow centering */
        .fi-main > .fi-page {
            max-width: 100% !important;
            padding: 0 !important;
            background-color: #f0f2f5; /* WA Web background */
        }
        html.dark .fi-main > .fi-page {
            background-color: #111b21;
        }

        /* Container for the profile simulating a mobile screen or WA sidebar */
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        html.dark .profile-container {
            background-color: #111b21;
            box-shadow: none;
            border-left: 1px solid #222e35;
            border-right: 1px solid #222e35;
        }

        /* Make Filament Cards flat inside this container */
        .profile-container .fi-sc {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            border-bottom: 8px solid #f0f2f5 !important;
            border-radius: 0 !important;
            padding: 1.5rem !important;
        }
        html.dark .profile-container .fi-sc {
            border-bottom: 8px solid #0b141a !important;
        }

        /* Remove border from the last section */
        .profile-container > div:last-child .fi-sc {
            border-bottom: none !important;
        }

        /* Style the Headings to look like WA green labels (we use Red for Mekar Jaya) */
        .profile-container .fi-sc-heading {
            color: #b91c1c !important;
            font-size: 0.875rem !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            letter-spacing: 0.05em;
        }
        html.dark .profile-container .fi-sc-heading {
            color: #f87171 !important;
        }

        /* Hide card header borders and descriptions to keep it minimal */
        .profile-container .fi-sc-header {
            border-bottom: none !important;
            padding-bottom: 0 !important;
            margin-bottom: 1rem !important;
        }
        .profile-container .fi-sc-description {
            display: none !important;
        }

        /* Input styling: border bottom only */
        .profile-container .fi-input-wrapper {
            box-shadow: none !important;
            border-radius: 0 !important;
            border: none !important;
            border-bottom: 2px solid #e9edef !important;
            background: transparent !important;
        }
        html.dark .profile-container .fi-input-wrapper {
            border-bottom: 2px solid #222e35 !important;
        }
        .profile-container .fi-input-wrapper:focus-within {
            border-bottom-color: #b91c1c !important;
            ring: 0 !important;
        }
        .profile-container .fi-input {
            padding-left: 0 !important;
            font-size: 1rem !important;
        }

        /* Buttons styling */
        .profile-container .fi-btn {
            border-radius: 9999px !important; /* Pill shape */
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }
    </style>

    <div class="profile-container">
        {{-- Custom Header --}}
        <div class="flex flex-col items-center justify-center pt-10 pb-6">
            @php
                $user = filament()->auth()->user();
                $avatarUrl = $user->getFilamentAvatarUrl() ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=FFFFFF&background=b91c1c&size=200';
            @endphp
            <div class="w-48 h-48 rounded-full overflow-hidden mb-6 shadow-lg border-4 border-white dark:border-gray-800">
                <img src="{{ $avatarUrl }}" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <h2 class="text-3xl font-light text-gray-900 dark:text-gray-100 mb-1">{{ $user->name }}</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium">{{ $user->email }}</p>
        </div>

        {{-- Form Components --}}
        <div class="space-y-0">
            @foreach ($this->getRegisteredCustomProfileComponents() as $component)
                @unless(is_null($component))
                    @livewire($component)
                @endunless
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
