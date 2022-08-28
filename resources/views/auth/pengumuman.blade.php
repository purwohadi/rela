<div class="info-urgent bg-white p-3 rounded mb-3">
    <div class="pb-3">
    <a href="javascript:void(0)" class="btn-link text-danger ml-auto blink-me font-weight-bold font-italic lead">
        Pengumuman Terbaru
    </a>
    </div>
    <div class="panel-tag pengumman-baru-text text-justify mb-0">
        {{ $pengumuman_terbaru }}
    </div>
</div>
<div>
    @if ($pengumuman_list != null)
        @foreach($pengumuman_list as $row)
            <p class="text-justify pengumuman-box">
              {{ $row['pengumuman_text'] }}
            </p>
        @endforeach
    @else
        <p class="text-justify pengumuman-box">Tidak ada data</p>
    @endif
</div>
