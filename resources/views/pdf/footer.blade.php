<div style="position: relative; bottom: 0; left: 0; right: 0; height: 75px; background-color: rgba(255, 0, 0, 0.1);">
    @foreach ($logos as $logo)
        @if ($logo->section == 'footer')
            <div class="logo" style="top: {{ $logo->position_y ?? 10 }}px; left: {{ $logo->position_x ?? 10 }}px; width: {{ $logo->width ?? 50 }}px; height: {{ $logo->height ?? 50 }}px;">
                <img src="data:image/png;base64,{{ base64_encode($logo->image_data) }}" alt="Logo">
            </div>
        @endif
    @endforeach
</div>


