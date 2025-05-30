@props(['src', 'alt' => '', 'class' => ''])

@if($src)
    @php
        $imageUrl = Str::startsWith($src, 'public/')
            ? Storage::url(Str::after($src, 'public/'))
            : Storage::url($src);
    @endphp

    <div class="{{ $class }}">
        <img src="{{ $imageUrl }}"
             alt="{{ $alt }}"
             class="rounded-lg shadow-sm object-cover w-full h-full"
             onerror="this.src='/images/placeholder.jpg'; this.onerror=null;">
    </div>
@else
    <div class="bg-gray-100 rounded-lg p-4 text-center {{ $class }}">
        <p class="text-gray-500">No image available</p>
    </div>
@endif
