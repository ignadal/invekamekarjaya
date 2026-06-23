<div class="flex justify-center p-4" style="width: 100%; height: 100%;">
    @if($foto)
        <img src="/storage/{{ $foto }}" alt="Foto Nota" style="width: 100%; height: 100%; object-fit: contain;" class="rounded-lg shadow-lg">
    @else
        <p class="text-gray-500">Tidak ada foto nota.</p>
    @endif
</div>
