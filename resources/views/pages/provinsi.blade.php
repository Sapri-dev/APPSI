@extends('layouts.app')

@section('title', 'Provinsi Anggota - APPSI')

@push('styles')
<style>
    /* ===== PETA INDONESIA ===== */
    #map-section {
        background: linear-gradient(135deg, #e8f0fe 0%, #dce8ff 50%, #e4f0fb 100%);
    }
    .province-shape {
        fill: #3b5fc0;
        stroke: #ffffff;
        stroke-width: 0.8;
        cursor: pointer;
        transition: fill 0.2s ease, filter 0.2s ease;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15));
    }
    .province-shape:hover {
        fill: #E8A33D;
        filter: drop-shadow(0 3px 8px rgba(232,163,61,0.5));
    }
    .province-shape.active {
        fill: #E8A33D;
        filter: drop-shadow(0 3px 8px rgba(232,163,61,0.6));
    }
    #map-tooltip {
        pointer-events: none;
        position: absolute;
        background: rgba(0,22,71,0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(232,163,61,0.4);
        border-radius: 12px;
        padding: 12px 14px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        z-index: 100;
        min-width: 200px;
        max-width: 260px;
        display: none;
        transition: opacity 0.15s ease;
    }
    #map-tooltip.visible { display: block; }
    #map-container {
        position: relative;
        width: 100%;
        height: 380px;
    }
    #map-container svg {
        width: 100%;
        height: 100%;
    }
    .map-legend-dot {
        width: 12px; height: 12px; border-radius: 3px;
        display: inline-block; vertical-align: middle;
    }

    /* ===== PROVINCE CARD HIGHLIGHT ===== */
    .province-card {
        transition: all 0.25s ease;
    }
    .province-card.highlighted {
        border-color: #E8A33D !important;
        box-shadow: 0 0 0 2px rgba(232,163,61,0.4), 0 8px 20px rgba(0,22,71,0.15);
        transform: translateY(-2px);
    }

    /* ===== MARQUEE SCROLL ===== */
    #provinsi-track { animation: marquee-scroll 45s linear infinite; }
    .provinsi-paused { animation-play-state: paused !important; }
    @keyframes marquee-scroll {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>
@endpush

@section('content')

{{-- ========================================
     SECTION 1: PETA INDONESIA INTERAKTIF
     ======================================== --}}
<section id="map-section" class="w-full py-10 px-4">
    <div class="max-w-[1200px] mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#3b5fc0] block mb-1">Anggota Resmi</span>
                <h1 class="text-3xl font-extrabold text-primary">Provinsi Anggota Seluruh Indonesia</h1>
                <p class="text-slate-500 text-sm mt-1">Klik atau arahkan kursor ke provinsi untuk melihat detail</p>
            </div>
            {{-- Info aktif --}}
            <div id="map-info-box" class="hidden md:flex items-center gap-3 bg-white/80 backdrop-blur border border-slate-200 rounded-xl px-4 py-3 shadow-sm min-w-[220px]">
                <img id="map-info-lambang" src="{{ asset('images/placeholder-lambang.png') }}" alt="" class="w-10 h-12 object-contain shrink-0">
                <div>
                    <p id="map-info-nama" class="font-bold text-sm text-primary">—</p>
                    <p id="map-info-gub" class="text-xs text-amber-600 font-semibold">Pilih provinsi di peta</p>
                    <p id="map-info-kota" class="text-[11px] text-slate-400"></p>
                </div>
            </div>
        </div>

        {{-- Peta --}}
        <div class="relative bg-white/40 rounded-2xl border border-white/60 shadow-lg overflow-hidden p-2">
            <div id="map-container">
                {{-- D3 render peta di sini --}}
                <div id="map-loading" class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="w-10 h-10 border-4 border-[#3b5fc0] border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                        <p class="text-sm text-slate-500">Memuat peta Indonesia…</p>
                    </div>
                </div>
            </div>

            {{-- Tooltip --}}
            <div id="map-tooltip">
                <div class="flex items-center gap-3 mb-2">
                    <img id="tt-lambang" src="" alt="" class="w-8 h-10 object-contain shrink-0">
                    <div>
                        <p id="tt-nama" class="font-bold text-white text-sm leading-tight"></p>
                        <p id="tt-pulau" class="text-[11px] text-amber-400 font-semibold uppercase tracking-wide"></p>
                    </div>
                </div>
                <div class="border-t border-white/10 pt-2 mt-1 space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-400" style="font-size:14px;">person</span>
                        <p id="tt-gub" class="text-xs text-slate-200"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-400" style="font-size:14px;">location_city</span>
                        <p id="tt-kota" class="text-xs text-slate-300"></p>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 mt-2 text-center">Klik untuk sorot di daftar ↓</p>
            </div>

            {{-- Legend --}}
            <div class="absolute bottom-3 right-3 bg-white/80 backdrop-blur rounded-lg px-3 py-2 text-[10px] text-slate-600 flex items-center gap-3 shadow-sm border border-slate-100">
                <span class="flex items-center gap-1.5"><span class="map-legend-dot bg-[#3b5fc0]"></span> Provinsi Anggota</span>
                <span class="flex items-center gap-1.5"><span class="map-legend-dot bg-[#E8A33D]"></span> Dipilih</span>
            </div>
        </div>

    </div>
</section>

{{-- ========================================
     SECTION 2: GRID PROVINSI
     ======================================== --}}
<section class="py-10 px-4 max-w-[1200px] mx-auto space-y-8"
         x-data="{ search: '' }">

    {{-- Search bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="relative flex-1 max-w-sm">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">search</span>
            <input type="text" x-model="search" placeholder="Cari nama provinsi / gubernur…"
                class="w-full bg-white border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-2xs">
        </div>
        <p class="text-xs text-slate-400">Atau klik provinsi di peta atas ↑</p>
    </div>

    @foreach($perPulau as $pulau => $items)
        <div class="space-y-4"
             x-show="!search || {{ json_encode($items->pluck('nama')->concat($items->pluck('gubernur'))->toArray()) }}.some(item => item && item.toLowerCase().includes(search.toLowerCase()))">

            <h2 class="text-lg font-bold text-primary flex items-center gap-2 border-b border-slate-200 pb-2">
                <span class="w-3 h-3 rounded-full bg-secondary inline-block"></span>
                <span>Wilayah {{ $pulau }}</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($items as $p)
                    <div id="prov-card-{{ Str::slug($p->nama) }}"
                         x-show="!search || '{{ strtolower($p->nama . ' ' . $p->gubernur . ' ' . $p->ibu_kota) }}'.includes(search.toLowerCase())"
                         class="province-card bg-white border border-border-subtle p-4 rounded-xl shadow-xs flex items-center gap-4 hover:border-secondary cursor-default">
                        <img src="{{ $p->lambang_url }}" alt="{{ $p->nama }}"
                             class="w-12 h-14 object-contain shrink-0">
                        <div class="truncate">
                            <h3 class="font-bold text-sm text-primary truncate">{{ $p->nama }}</h3>
                            <p class="text-xs text-amber-600 font-semibold truncate">{{ $p->gubernur ?: 'Gubernur' }}</p>
                            <p class="text-[11px] text-slate-400 truncate">Ibu Kota: {{ $p->ibu_kota ?: '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</section>

@push('scripts')
{{-- D3.js + TopoJSON --}}
<script src="https://cdn.jsdelivr.net/npm/d3@7.9.0/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3.1.0/dist/topojson.min.js"></script>

<script>
(function() {
    // =====================================================
    // DATA PROVINSI dari Laravel (pass ke JS)
    // =====================================================
    const provinsiData = @json($provinsiJson);

    // =====================================================
    // MAPPING: nama GeoJSON -> nama di DB
    // GeoJSON menggunakan nama resmi BPS / GADM
    // =====================================================
    const namaMapping = {
        // Sumatera
        'Aceh': 'Aceh',
        'Sumatera Utara': 'Sumatera Utara',
        'Sumatera Barat': 'Sumatera Barat',
        'Riau': 'Riau',
        'Kepulauan Riau': 'Kepulauan Riau',
        'Jambi': 'Jambi',
        'Bengkulu': 'Bengkulu',
        'Sumatera Selatan': 'Sumatera Selatan',
        'Kepulauan Bangka Belitung': 'Bangka Belitung',
        'Bangka Belitung': 'Bangka Belitung',
        'Bangka-Belitung': 'Bangka Belitung',
        'Lampung': 'Lampung',
        // Jawa
        'Banten': 'Banten',
        'DKI Jakarta': 'DKI Jakarta',
        'Jawa Barat': 'Jawa Barat',
        'Jawa Tengah': 'Jawa Tengah',
        'DI Yogyakarta': 'DI Yogyakarta',
        'Yogyakarta': 'DI Yogyakarta',
        'Daerah Istimewa Yogyakarta': 'DI Yogyakarta',
        'Jawa Timur': 'Jawa Timur',
        // Bali & Nusa Tenggara
        'Bali': 'Bali',
        'Nusa Tenggara Barat': 'Nusa Tenggara Barat',
        'Nusa Tenggara Timur': 'Nusa Tenggara Timur',
        // Kalimantan
        'Kalimantan Barat': 'Kalimantan Barat',
        'Kalimantan Tengah': 'Kalimantan Tengah',
        'Kalimantan Selatan': 'Kalimantan Selatan',
        'Kalimantan Timur': 'Kalimantan Timur',
        'Kalimantan Utara': 'Kalimantan Utara',
        // Sulawesi
        'Sulawesi Utara': 'Sulawesi Utara',
        'Gorontalo': 'Gorontalo',
        'Sulawesi Tengah': 'Sulawesi Tengah',
        'Sulawesi Barat': 'Sulawesi Barat',
        'Sulawesi Selatan': 'Sulawesi Selatan',
        'Sulawesi Tenggara': 'Sulawesi Tenggara',
        // Maluku
        'Maluku': 'Maluku',
        'Maluku Utara': 'Maluku Utara',
        // Papua
        'Papua Barat': 'Papua Barat',
        'Papua Barat Daya': 'Papua Barat Daya',
        'Papua Tengah': 'Papua Tengah',
        'Papua Pegunungan': 'Papua Pegunungan',
        'Papua Selatan': 'Papua Selatan',
        'Papua': 'Papua',
    };

    // Build lookup dari DB data
    const dbLookup = {};
    provinsiData.forEach(p => { dbLookup[p.nama] = p; });

    function getDbData(geoName) {
        const mapped = namaMapping[geoName] || geoName;
        return dbLookup[mapped] || null;
    }

    // =====================================================
    // D3 MAP SETUP
    // =====================================================
    const container = document.getElementById('map-container');
    const tooltip   = document.getElementById('map-tooltip');
    const infoBox   = document.getElementById('map-info-box');

    const width  = container.clientWidth  || 900;
    const height = container.clientHeight || 380;

    const svg = d3.select('#map-container')
        .append('svg')
        .attr('viewBox', `0 0 ${width} ${height}`)
        .attr('preserveAspectRatio', 'xMidYMid meet');

    // Tambahkan filter drop shadow
    const defs = svg.append('defs');
    const filter = defs.append('filter').attr('id', 'province-shadow');
    filter.append('feDropShadow')
          .attr('dx', 0).attr('dy', 2)
          .attr('stdDeviation', 3)
          .attr('flood-color', 'rgba(0,0,0,0.2)');

    const mapGroup = svg.append('g');

    // Projection Mercator terpusat di Indonesia
    const projection = d3.geoMercator()
        .center([118, -3])
        .scale(width * 1.05)
        .translate([width / 2, height / 2]);

    const path = d3.geoPath().projection(projection);

    // State
    let activeEl = null;
    let activeCardId = null;

    function highlightCard(slug) {
        // Hapus highlight lama
        if (activeCardId) {
            const prev = document.getElementById('prov-card-' + activeCardId);
            if (prev) prev.classList.remove('highlighted');
        }
        // Set highlight baru
        activeCardId = slug;
        if (slug) {
            const card = document.getElementById('prov-card-' + slug);
            if (card) {
                card.classList.add('highlighted');
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    function showInfoBox(db) {
        if (!db) return;
        document.getElementById('map-info-lambang').src = db.lambang;
        document.getElementById('map-info-nama').textContent = db.nama;
        document.getElementById('map-info-gub').textContent = db.gubernur || 'Gubernur';
        document.getElementById('map-info-kota').textContent = db.ibu_kota ? 'Ibu Kota: ' + db.ibu_kota : '';
    }

    // =====================================================
    // LOAD GeoJSON
    // =====================================================
    const geoUrl = 'https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia.geojson';

    document.getElementById('map-loading').style.display = 'flex';

    d3.json(geoUrl).then(function(geoData) {
        document.getElementById('map-loading').remove();

        mapGroup.selectAll('path')
            .data(geoData.features)
            .enter()
            .append('path')
            .attr('d', path)
            .attr('class', 'province-shape')
            .attr('data-name', d => d.properties.state || d.properties.Propinsi || d.properties.name || '')
            .on('mousemove', function(event, d) {
                const geoName = d.properties.state || d.properties.Propinsi || d.properties.name || '';
                const db = getDbData(geoName);

                // Posisi tooltip
                const rect = container.getBoundingClientRect();
                const mx = event.clientX - rect.left;
                const my = event.clientY - rect.top;

                // Update tooltip content
                document.getElementById('tt-nama').textContent  = db ? db.nama  : geoName;
                document.getElementById('tt-gub').textContent   = db ? (db.gubernur || 'Gubernur') : '';
                document.getElementById('tt-kota').textContent  = db ? (db.ibu_kota ? 'Ibu Kota: ' + db.ibu_kota : '') : '';
                document.getElementById('tt-pulau').textContent = db ? db.pulau : '';
                document.getElementById('tt-lambang').src       = db ? db.lambang : '';
                document.getElementById('tt-lambang').style.display = db ? 'block' : 'none';

                // Posisikan tooltip
                let left = mx + 14;
                let top  = my - 30;
                const ttW = 260, ttH = 130;
                if (left + ttW > (rect.width - 10)) left = mx - ttW - 14;
                if (top + ttH > (rect.height - 10)) top = my - ttH - 14;
                if (top < 5) top = 5;

                tooltip.style.left = left + 'px';
                tooltip.style.top  = top + 'px';
                tooltip.classList.add('visible');
            })
            .on('mouseleave', function() {
                tooltip.classList.remove('visible');
            })
            .on('click', function(event, d) {
                const geoName = d.properties.state || d.properties.Propinsi || d.properties.name || '';
                const db = getDbData(geoName);

                // Toggle active path
                if (activeEl) activeEl.classList.remove('active');
                if (activeEl === this) {
                    activeEl = null;
                    highlightCard(null);
                    return;
                }
                this.classList.add('active');
                activeEl = this;

                if (db) {
                    showInfoBox(db);
                    highlightCard(db.slug);
                }
            });

        // Zoom & Pan
        const zoom = d3.zoom()
            .scaleExtent([0.7, 8])
            .on('zoom', (event) => {
                mapGroup.attr('transform', event.transform);
            });
        svg.call(zoom);

        // Reset zoom button
        const resetBtn = document.getElementById('map-reset-zoom');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                svg.transition().duration(500).call(
                    zoom.transform,
                    d3.zoomIdentity
                );
            });
        }

    }).catch(function(err) {
        console.error('Gagal memuat GeoJSON peta:', err);
        document.getElementById('map-loading').innerHTML =
            '<div class="text-center text-slate-400 p-8"><span class="material-symbols-outlined text-4xl block mb-2">map_off</span><p class="text-sm">Peta tidak dapat dimuat saat ini.</p></div>';
    });

})();
</script>
@endpush

@endsection
