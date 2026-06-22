<x-filament-widgets::widget>
    <x-filament::section class="red-gradient-filter w-full border-none shadow-none !max-w-full">
        <div style="margin-bottom: 1rem;">
            <h3 class="text-base leading-6" style="color: white !important; font-weight: bold !important;">Filter</h3>
            <p class="mt-1 text-sm" style="color: white !important;">Filter data berdasarkan periode</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: flex-end;">
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="bulan" class="w-full" style="width: 100%;">
                        <option value="">Semua Bulan</option>
                        @foreach($this->getBulanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="tahun" class="w-full" style="width: 100%;">
                        <option value="">Semua Tahun</option>
                        @foreach($this->getTahunOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div style="display: flex; align-items: flex-end;">
                <x-filament::button wire:click="resetFilter" class="reset-filter-btn">
                    Reset
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
