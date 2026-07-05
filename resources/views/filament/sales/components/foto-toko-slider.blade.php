@php
    $fotoToko = $getRecord()?->foto_toko;
    $images = [];
    
    if ($fotoToko) {
        if (is_array($fotoToko)) {
            foreach (array_values($fotoToko) as $path) {
                $images[] = asset('storage/' . str_replace('public/', '', $path));
            }
        } else {
            $images[] = asset('storage/' . str_replace('public/', '', $fotoToko));
        }
    } else {
        $images[] = asset('images/default-toko.png');
    }
    $hasMultiple = count($images) > 1;

    $record = $getRecord();
    $jamBuka  = $record?->jam_buka  ? \Carbon\Carbon::parse($record->jam_buka)->format('H:i')  : null;
    $jamTutup = $record?->jam_tutup ? \Carbon\Carbon::parse($record->jam_tutup)->format('H:i') : null;

    $isOpen = false;
    if ($jamBuka && $jamTutup) {
        $now   = \Carbon\Carbon::now()->format('H:i');
        $isOpen = $now >= $jamBuka && $now <= $jamTutup;
    }
@endphp

<div class="space-y-2">
    <div class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
        Foto Toko
    </div>
    <div x-data="{
        images: {{ Illuminate\Support\Js::from($images) }},
        activeSlide: 0,
        next() {
            this.activeSlide = this.activeSlide === this.images.length - 1 ? 0 : this.activeSlide + 1;
        },
        prev() {
            this.activeSlide = this.activeSlide === 0 ? this.images.length - 1 : this.activeSlide - 1;
        }
    }" class="relative w-full overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700" style="height: 320px;">
        <template x-for="(image, index) in images" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-900">
                <img :src="image"
                     alt="Foto Toko"
                     class="w-full h-full object-contain" />
            </div>
        </template>

        @if($hasMultiple)
        <!-- Prev Button -->
        <button x-show="images.length > 1" @click="prev()" type="button"
                class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full p-2 transition-all focus:outline-none z-10 shadow-lg">
            <x-heroicon-o-chevron-left style="width: 20px; height: 20px;" />
        </button>

        <!-- Next Button -->
        <button x-show="images.length > 1" @click="next()" type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full p-2 transition-all focus:outline-none z-10 shadow-lg">
            <x-heroicon-o-chevron-right style="width: 20px; height: 20px;" />
        </button>

        <!-- Indicators -->
        <div x-show="images.length > 1" class="absolute bottom-3 left-0 right-0 flex justify-center gap-2 z-10">
            <template x-for="(image, index) in images" :key="index">
                <button @click="activeSlide = index" type="button"
                        :class="activeSlide === index ? 'bg-white w-5' : 'bg-white/50 w-2.5'"
                        class="h-2.5 rounded-full transition-all duration-300 shadow"></button>
            </template>
        </div>

        <!-- Counter Badge -->
        <div x-show="images.length > 1"
             class="absolute top-3 right-3 bg-black/50 text-white text-xs font-medium px-2 py-1 rounded-full z-10">
            <span x-text="activeSlide + 1"></span>/<span x-text="images.length"></span>
        </div>
        @endif
    </div>

    {{-- Jam Operasional Badge --}}
    @if($jamBuka && $jamTutup)
    <div class="flex items-center gap-3 mt-3 px-1">
        {{-- Status dot --}}
        <span @class([
            'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold',
            'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' => $isOpen,
            'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' => !$isOpen,
        ])>
            <span @class([
                'inline-block w-2 h-2 rounded-full',
                'bg-green-500 animate-pulse' => $isOpen,
                'bg-red-500' => !$isOpen,
            ])></span>
            {{ $isOpen ? 'Buka Sekarang' : 'Tutup Sekarang' }}
        </span>

        {{-- Jam --}}
        <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
            <x-heroicon-o-clock style="width: 16px; height: 16px; color: #9ca3af;" />
            {{ $jamBuka }} – {{ $jamTutup }}
        </span>
    </div>
    @else
    <div class="flex items-center gap-1.5 mt-3 px-1 text-sm text-gray-400 dark:text-gray-500">
        <x-heroicon-o-clock style="width: 16px; height: 16px;" />
        <span>Jam operasional belum diatur</span>
    </div>
    @endif
</div>
