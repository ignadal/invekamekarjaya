<x-filament-widgets::widget>
    <style>
        .sales-stats-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }
        @media (min-width: 640px) { .sales-stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .sales-stats-grid { grid-template-columns: repeat(4, 1fr); } }

        .sales-stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 140px;
        }
        .sales-stat-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .sales-stat-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sales-stat-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }
        .sales-stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
            line-height: 1.2;
        }
        .sales-stat-sublabel {
            font-size: 0.75rem;
            color: #9ca3af;
            margin: 0;
        }
        .sales-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
            flex: 1;
            display: flex;
            align-items: flex-end;
        }
        .sales-stat-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.5rem;
        }
        .sales-stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .sales-stat-trend-up { color: #22c55e; }
        .sales-stat-trend-down { color: #ef4444; }
        .sales-stat-trend-icon {
            width: 0.625rem;
            height: 0.625rem;
        }
        .sales-stat-chart-icon {
            color: #ef4444;
            opacity: 0.3;
        }
        .sales-stat-chart-icon svg {
            width: 2rem;
            height: 2rem;
        }
    </style>

    <div class="sales-stats-grid">
        @foreach ($this->getCustomStats() as $stat)
            <div class="sales-stat-card">
                <div class="sales-stat-card-header">
                    <div class="sales-stat-icon" style="background-color: {{ $stat['icon_bg'] }};">
                        @if($stat['icon'] === 'users')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        @elseif($stat['icon'] === 'banknotes')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                        @elseif($stat['icon'] === 'credit-card')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Zm16.5 7.5h-21v6a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-6ZM6.75 15a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Zm0 0h3"/></svg>
                        @elseif($stat['icon'] === 'receipt-percent')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path fill-rule="evenodd" d="M12 1.5c-1.921 0-3.816.111-5.68.327-1.497.174-2.57 1.46-2.57 2.93V21.75a.75.75 0 0 0 1.029.696l3.471-1.388 3.472 1.388a.75.75 0 0 0 .556 0l3.472-1.388 3.471 1.388a.75.75 0 0 0 1.029-.696V4.757c0-1.47-1.073-2.756-2.57-2.93A49.255 49.255 0 0 0 12 1.5Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6ZM8.625 9a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm5.25 3.375a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd"/></svg>
                        @elseif($stat['icon'] === 'shopping-bag')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd"/></svg>
                        @elseif($stat['icon'] === 'document-text')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $stat['icon_color'] }}"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM10.5 18.5a.75.75 0 0 0 0-1.5h-4.5a.75.75 0 0 0 0 1.5h4.5Zm2.25-3a.75.75 0 0 0 0-1.5h-6.75a.75.75 0 0 0 0 1.5h6.75Zm0-3a.75.75 0 0 0 0-1.5h-6.75a.75.75 0 0 0 0 1.5h6.75Z" clip-rule="evenodd"/><path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963 5.23 5.23 0 0 0-3.434-1.279h-2.25Z"/></svg>
                        @endif
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                        <div>
                            <p class="sales-stat-label">{{ $stat['label'] }}</p>
                            <p class="sales-stat-sublabel">Bulan Ini</p>
                        </div>
                        @if(isset($stat['explanation']))
                            <div x-data="{ open: false }" style="position: relative; display: inline-flex; align-items: center;">
                                <button type="button" @click.stop="open = !open" style="outline: none; background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width: 1.25rem; height: 1.25rem;">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; z-index: 9999; width: 220px; background-color: #1f2937; color: #f9fafb; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: normal; line-height: 1.4; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); top: 125%; right: 0; white-space: normal;">
                                    <div style="position: absolute; top: -5px; right: 8px; width: 10px; height: 10px; background-color: #1f2937; transform: rotate(45deg);"></div>
                                    {{ $stat['explanation'] }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="sales-stat-footer">
                    <div>
                        <p class="sales-stat-value">{{ $stat['value'] }}</p>
                        <div class="sales-stat-trend {{ $stat['trend_up'] ? 'sales-stat-trend-up' : 'sales-stat-trend-down' }}" style="margin-top: 0.375rem;">
                            @if($stat['trend_up'])
                                <svg class="sales-stat-trend-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd"/></svg>
                            @else
                                <svg class="sales-stat-trend-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd"/></svg>
                            @endif
                            <span>{{ $stat['trend'] }}</span>
                        </div>
                    </div>
                    {{-- Decorative trend line --}}
                    <div class="sales-stat-chart-icon">
                        <svg viewBox="0 0 64 32" fill="none" stroke="{{ $stat['trend_up'] ? '#22c55e' : '#ef4444' }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;">
                            <polyline points="2,28 12,22 22,26 32,14 42,18 52,8 62,4"/>
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
