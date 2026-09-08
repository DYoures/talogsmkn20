<div id="global-transition-overlay" aria-hidden="true">
    {{-- 5 × 10 mosaic. During hold, its tiles form five seamless panels. --}}
    <div class="voxel-mosaic-grid">
        @for($row = 0; $row < 10; $row++)
            @for($column = 0; $column < 5; $column++)
                <span class="voxel-tile" data-row="{{ $row }}" data-column="{{ $column }}"></span>
            @endfor
        @endfor
    </div>
    <div class="voxel-seams" aria-hidden="true">
        @for($column = 0; $column < 5; $column++)
            <span class="voxel-seam"></span>
        @endfor
    </div>
</div>
