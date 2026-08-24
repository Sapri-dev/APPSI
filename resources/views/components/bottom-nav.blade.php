{{-- Bottom Navigation Bar - Floating Pill Style --}}
@php
    $isHome    = request()->routeIs('home');
    $isBerita  = request()->routeIs('berita', 'artikel');
    $isPustaka = request()->routeIs('pustaka');
    $isOrg     = request()->routeIs('sekretariat', 'dewan-penasehat', 'dewan-pengurus', 'dewan-pakar', 'sejarah');
    $isKontak  = request()->routeIs('hubungi');
@endphp

<style>
    @keyframes popupSlideUp {
        from { opacity: 0; transform: translateY(16px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes popupSlideDown {
        from { opacity: 1; transform: translateY(0) scale(1); }
        to   { opacity: 0; transform: translateY(16px) scale(0.97); }
    }
    .popup-panel {
        animation: popupSlideUp 0.2s cubic-bezier(0.22,1,0.36,1) forwards;
    }
    .popup-panel.closing {
        animation: popupSlideDown 0.15s ease forwards;
    }
    .nav-popup-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 12px;
        text-decoration: none;
        transition: background 0.12s ease;
    }
    .nav-popup-item:hover { background: #f8fafc; }
    .nav-popup-item.active-item { background: #f0f4ff; }
    .nav-popup-label {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        flex: 1;
    }

    /* ── Mobile-only nav overrides ──────────────────── */
    @media (max-width: 767px) {
        #bottom-nav {
            bottom: 14px !important;
            padding: 5px 5px !important;
            gap: 1px !important;
            max-width: calc(100vw - 20px) !important;
        }
        #bottom-nav a.nav-item,
        #bottom-nav button.nav-item {
            padding: 4px 8px !important;
            min-width: 46px !important;
        }
        #bottom-nav .nav-icon-wrap {
            width: 32px !important;
            height: 32px !important;
        }
        #bottom-nav .nav-icon-wrap .material-symbols-outlined {
            font-size: 18px !important;
        }
        #bottom-nav .nav-label {
            font-size: 8px !important;
            margin-top: 2px !important;
        }
        #bottom-nav .nav-logo {
            padding: 4px !important;
            margin-right: 1px !important;
        }
    }
</style>

{{-- Backdrop --}}
<div id="nav-backdrop"
     onclick="closeAllNavPopups()"
     style="position:fixed; inset:0; z-index:38; display:none; backdrop-filter:blur(2px); background:rgba(0,22,71,0.15);">
</div>

{{-- ═══════════════════════════════════════════
     POPUP 1 — TENTANG APPSI
     ═══════════════════════════════════════════ --}}
<div id="tentang-panel"
     style="position:fixed; bottom:0; left:0; right:0; z-index:39;
            display:none; justify-content:center; padding-bottom:96px;">
    <div id="tentang-inner" class="popup-panel"
         style="width:280px;
                background: white;
                border-radius: 20px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 32px rgba(0,22,71,0.13), 0 1px 4px rgba(0,0,0,0.05);
                padding: 8px;">

            <a href="{{ route('sejarah') }}" class="nav-popup-item {{ request()->routeIs('sejarah') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->routeIs('sejarah') ? '#001647' : '#64748b' }}; {{ request()->routeIs('sejarah') ? "font-variation-settings:'FILL' 1;" : '' }}">history_edu</span>
                <span class="nav-popup-label">Sejarah APPSI</span>
                @if(request()->routeIs('sejarah'))<span class="material-symbols-outlined" style="color:#001647; font-size:15px; font-variation-settings:'FILL' 1;">check_circle</span>@endif
            </a>

            <a href="{{ route('dewan-pengurus') }}" class="nav-popup-item {{ request()->routeIs('dewan-pengurus') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->routeIs('dewan-pengurus') ? '#001647' : '#64748b' }}; {{ request()->routeIs('dewan-pengurus') ? "font-variation-settings:'FILL' 1;" : '' }}">manage_accounts</span>
                <span class="nav-popup-label">Dewan Pengurus</span>
                @if(request()->routeIs('dewan-pengurus'))<span class="material-symbols-outlined" style="color:#001647; font-size:15px; font-variation-settings:'FILL' 1;">check_circle</span>@endif
            </a>

            <a href="{{ route('dewan-penasehat') }}" class="nav-popup-item {{ request()->routeIs('dewan-penasehat') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->routeIs('dewan-penasehat') ? '#001647' : '#64748b' }}; {{ request()->routeIs('dewan-penasehat') ? "font-variation-settings:'FILL' 1;" : '' }}">supervised_user_circle</span>
                <span class="nav-popup-label">Dewan Penasehat</span>
                @if(request()->routeIs('dewan-penasehat'))<span class="material-symbols-outlined" style="color:#001647; font-size:15px; font-variation-settings:'FILL' 1;">check_circle</span>@endif
            </a>

            <a href="{{ route('dewan-pakar') }}" class="nav-popup-item {{ request()->routeIs('dewan-pakar') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->routeIs('dewan-pakar') ? '#001647' : '#64748b' }}; {{ request()->routeIs('dewan-pakar') ? "font-variation-settings:'FILL' 1;" : '' }}">psychology</span>
                <span class="nav-popup-label">Dewan Pakar</span>
                @if(request()->routeIs('dewan-pakar'))<span class="material-symbols-outlined" style="color:#001647; font-size:15px; font-variation-settings:'FILL' 1;">check_circle</span>@endif
            </a>

            <a href="{{ route('sekretariat') }}" class="nav-popup-item {{ request()->routeIs('sekretariat') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->routeIs('sekretariat') ? '#001647' : '#64748b' }}; {{ request()->routeIs('sekretariat') ? "font-variation-settings:'FILL' 1;" : '' }}">corporate_fare</span>
                <span class="nav-popup-label">Sekretariat</span>
                @if(request()->routeIs('sekretariat'))<span class="material-symbols-outlined" style="color:#001647; font-size:15px; font-variation-settings:'FILL' 1;">check_circle</span>@endif
            </a>

    </div>
</div>


{{-- ═══════════════════════════════════════════
     POPUP 2 — PUSTAKA APPSI
     ═══════════════════════════════════════════ --}}
<div id="pustaka-panel"
     style="position:fixed; bottom:0; left:0; right:0; z-index:39;
            display:none; justify-content:center; padding-bottom:96px;">
    <div id="pustaka-inner" class="popup-panel"
         style="width:280px;
                background: white;
                border-radius: 20px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 32px rgba(0,22,71,0.13), 0 1px 4px rgba(0,0,0,0.05);
                padding: 8px;">

            <a href="{{ route('pustaka', 'uu') }}" class="nav-popup-item {{ request()->is('pustaka/uu*') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/uu*') ? '#001647' : '#64748b' }};">gavel</span>
                <span class="nav-popup-label">Undang-Undang</span>
            </a>

            <a href="{{ route('pustaka', 'adart') }}" class="nav-popup-item {{ request()->is('pustaka/adart*') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/adart*') ? '#001647' : '#64748b' }};">menu_book</span>
                <span class="nav-popup-label">AD/ART</span>
            </a>

            <a href="{{ route('pustaka', 'rekomendasi') }}" class="nav-popup-item {{ request()->is('pustaka/rekomendasi*') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/rekomendasi*') ? '#001647' : '#64748b' }};">policy</span>
                <span class="nav-popup-label">Rekomendasi</span>
            </a>

            <a href="{{ route('pustaka', 'sk') }}" class="nav-popup-item {{ request()->is('pustaka/sk*') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/sk*') ? '#001647' : '#64748b' }};">verified</span>
                <span class="nav-popup-label">Surat Keputusan</span>
            </a>

            <a href="{{ route('pustaka', 'berita_acara') }}" class="nav-popup-item {{ request()->is('pustaka/berita_acara*') ? 'active-item' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/berita_acara*') ? '#001647' : '#64748b' }};">description</span>
                <span class="nav-popup-label">Berita Acara</span>
            </a>

            {{-- Data BPS: Inline di Mobile & Trigger Flyout di Desktop --}}
            <div style="border-radius:12px; overflow:hidden; transition:background 0.15s;" id="bps-wrapper">
                <div onclick="handleBpsClick(event)"
                     class="nav-popup-item"
                     id="bps-trigger-btn"
                     style="cursor:pointer; display:flex; align-items:center; gap:10px; padding:9px 12px;">
                    <span class="material-symbols-outlined" style="font-size:20px; color:{{ request()->is('pustaka/data_bps*') ? '#001647' : '#64748b' }};">bar_chart</span>
                    <span class="nav-popup-label">Data BPS</span>
                    <span id="bps-chevron" class="material-symbols-outlined"
                          style="color:#94a3b8; font-size:18px; transition: transform 0.2s ease;">chevron_right</span>
                </div>

                {{-- Submenu Inline untuk Mobile (Layar HP) --}}
                <div id="bps-accordion-content" style="display:none; padding:4px 10px 10px; background:#f8fafc; border-radius:0 0 12px 12px;">
                    <div style="display:flex; gap:6px;">
                        @foreach(['2018','2019','2020'] as $tahun)
                        <a href="{{ route('pustaka', ['kategori' => 'data_bps', 'tahun' => $tahun]) }}"
                           style="flex:1; text-align:center; padding:6px 0; border-radius:8px; font-size:12px; font-weight:700;
                                  text-decoration:none; transition:all 0.15s;
                                  {{ request()->get('tahun') == $tahun
                                        ? 'background:#001647; color:white; box-shadow:0 2px 6px rgba(0,22,71,0.25);'
                                        : 'background:white; color:#334155; border:1px solid #e2e8f0;' }}"
                           onmouseover="if('{{ request()->get('tahun') }}'!=='{{ $tahun }}'){this.style.background='#f1f5f9'}"
                           onmouseout="if('{{ request()->get('tahun') }}'!=='{{ $tahun }}'){this.style.background='white'}">
                            {{ $tahun }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════
     SIDE FLYOUT — TAHUN DATA BPS (DESKTOP)
     ═══════════════════════════════════════════ --}}
<div id="bps-flyout"
     style="position:fixed; bottom:0; z-index:40;
            display:none; padding-bottom:96px;
            pointer-events:none;"
     class="left-0 right-0 justify-center">
    <div id="bps-flyout-inner"
         style="pointer-events:auto;
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 32px rgba(0,22,71,0.13), 0 1px 4px rgba(0,0,0,0.05);
                padding: 8px;
                width: 140px;
                animation: popupSlideUp 0.2s cubic-bezier(0.22,1,0.36,1) forwards;">

        <p style="font-size:9px; font-weight:700; letter-spacing:0.1em; color:#94a3b8;
                  text-transform:uppercase; padding: 4px 12px 6px; margin:0;">Pilih Tahun</p>

        @foreach(['2018','2019','2020'] as $tahun)
        <a href="{{ route('pustaka', ['kategori' => 'data_bps', 'tahun' => $tahun]) }}"
           style="display:flex; align-items:center; gap:8px;
                  padding: 9px 12px; border-radius: 10px;
                  text-decoration:none; transition: background 0.12s;
                  {{ request()->get('tahun') == $tahun ? 'background:#f0f4ff;' : '' }}"
           onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='{{ request()->get('tahun') == $tahun ? '#f0f4ff' : 'transparent' }}'">
            <span class="material-symbols-outlined"
                  style="font-size:16px; color:{{ request()->get('tahun') == $tahun ? '#001647' : '#94a3b8' }};
                         {{ request()->get('tahun') == $tahun ? "font-variation-settings:'FILL' 1;" : '' }}">calendar_today</span>
            <span style="font-size:13px; font-weight:700;
                         color:{{ request()->get('tahun') == $tahun ? '#001647' : '#334155' }};">{{ $tahun }}</span>
            @if(request()->get('tahun') == $tahun)
            <span class="material-symbols-outlined" style="color:#001647; font-size:13px; margin-left:auto; font-variation-settings:'FILL' 1;">check_circle</span>
            @endif
        </a>
        @endforeach

    </div>
</div>


{{-- ═══════════════════════════════════════════
     FLOATING PILL BOTTOM NAV
     ═══════════════════════════════════════════ --}}
<nav id="bottom-nav"
     style="position:fixed; bottom:20px; left:50%; transform:translateX(-50%);
            z-index:50; display:flex; align-items:center;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 9999px;
            padding: 6px 8px;
            box-shadow: 0 8px 40px rgba(0,22,71,0.14), 0 2px 10px rgba(0,22,71,0.07);
            border: 1px solid rgba(0,0,0,0.07);
            gap: 2px;
            max-width: calc(100vw - 2rem);
            width: max-content;">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="nav-logo"
       style="display:flex; align-items:center; flex-shrink:0;
              border: 1.5px solid #e2e8f0; border-radius: 9999px;
              padding: 5px 12px 5px 6px; margin-right: 4px; text-decoration:none;">
        {{-- Mobile: icon bulat saja --}}
        <img src="{{ asset('images/Logo-appsi.png') }}" alt="APPSI" class="md:hidden"
             style="height:36px; width:36px; object-fit:cover; object-position:left center; border-radius:50%;">
        {{-- Desktop: logo penuh --}}
        <img src="{{ asset('images/Logo-appsi.png') }}" alt="APPSI" class="hidden md:block"
             style="height:36px; width:auto; object-fit:contain; max-width:180px;">
    </a>

    {{-- Beranda --}}
    <a href="{{ route('home') }}" class="nav-item"
       style="display:flex; flex-direction:column; align-items:center; justify-content:center;
              padding: 5px 14px; border-radius: 9999px; min-width:60px;
              text-decoration:none; transition: all 0.2s;">
        <span class="nav-icon-wrap" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;
                     border-radius:9999px; transition: background 0.2s;
                     {{ $isHome ? 'background:#001647;' : 'background:transparent;' }}">
            <span class="material-symbols-outlined"
                  style="font-size:20px; color: {{ $isHome ? '#fff' : '#64748b' }};
                         {{ $isHome ? "font-variation-settings:'FILL' 1;" : '' }}">home</span>
        </span>
        <span class="nav-label" style="font-size:9px; font-weight:600; letter-spacing:0.04em; margin-top:3px; line-height:1;
                     text-transform:uppercase; color: {{ $isHome ? '#001647' : '#94a3b8' }};">Beranda</span>
    </a>

    {{-- Tentang --}}
    <button type="button" onclick="toggleTentangPopup(event)" class="nav-item"
            style="display:flex; flex-direction:column; align-items:center; justify-content:center;
                   padding: 5px 14px; border-radius: 9999px; min-width:60px;
                   border:0; background:transparent; cursor:pointer; transition: all 0.2s;"
            id="btn-tentang">
        <span class="nav-icon-wrap" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;
                     border-radius:9999px; transition: background 0.2s;
                     {{ $isOrg ? 'background:#001647;' : 'background:transparent;' }}">
            <span class="material-symbols-outlined"
                  style="font-size:20px; color: {{ $isOrg ? '#fff' : '#64748b' }};
                         {{ $isOrg ? "font-variation-settings:'FILL' 1;" : '' }}">info</span>
        </span>
        <span class="nav-label" style="font-size:9px; font-weight:600; letter-spacing:0.04em; margin-top:3px; line-height:1;
                     text-transform:uppercase; color: {{ $isOrg ? '#001647' : '#94a3b8' }};">Tentang</span>
    </button>

    {{-- Pustaka --}}
    <button type="button" onclick="togglePustakaPopup(event)" class="nav-item"
            style="display:flex; flex-direction:column; align-items:center; justify-content:center;
                   padding: 5px 14px; border-radius: 9999px; min-width:60px;
                   border:0; background:transparent; cursor:pointer; transition: all 0.2s;"
            id="btn-pustaka">
        <span class="nav-icon-wrap" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;
                     border-radius:9999px; transition: background 0.2s;
                     {{ $isPustaka ? 'background:#001647;' : 'background:transparent;' }}">
            <span class="material-symbols-outlined"
                  style="font-size:20px; color: {{ $isPustaka ? '#fff' : '#64748b' }};
                         {{ $isPustaka ? "font-variation-settings:'FILL' 1;" : '' }}">menu_book</span>
        </span>
        <span class="nav-label" style="font-size:9px; font-weight:600; letter-spacing:0.04em; margin-top:3px; line-height:1;
                     text-transform:uppercase; color: {{ $isPustaka ? '#001647' : '#94a3b8' }};">Pustaka</span>
    </button>

    {{-- Berita --}}
    <a href="{{ route('berita') }}" class="nav-item"
       style="display:flex; flex-direction:column; align-items:center; justify-content:center;
              padding: 5px 14px; border-radius: 9999px; min-width:60px;
              text-decoration:none; transition: all 0.2s;">
        <span class="nav-icon-wrap" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;
                     border-radius:9999px; transition: background 0.2s;
                     {{ $isBerita ? 'background:#001647;' : 'background:transparent;' }}">
            <span class="material-symbols-outlined"
                  style="font-size:20px; color: {{ $isBerita ? '#fff' : '#64748b' }};
                         {{ $isBerita ? "font-variation-settings:'FILL' 1;" : '' }}">newspaper</span>
        </span>
        <span class="nav-label" style="font-size:9px; font-weight:600; letter-spacing:0.04em; margin-top:3px; line-height:1;
                     text-transform:uppercase; color: {{ $isBerita ? '#001647' : '#94a3b8' }};">Berita</span>
    </a>

    {{-- Kontak --}}
    <a href="{{ route('hubungi') }}" class="nav-item"
       style="display:flex; flex-direction:column; align-items:center; justify-content:center;
              padding: 5px 14px; border-radius: 9999px; min-width:60px;
              text-decoration:none; transition: all 0.2s;">
        <span class="nav-icon-wrap" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;
                     border-radius:9999px; transition: background 0.2s;
                     {{ $isKontak ? 'background:#001647;' : 'background:transparent;' }}">
            <span class="material-symbols-outlined"
                  style="font-size:20px; color: {{ $isKontak ? '#fff' : '#64748b' }};
                         {{ $isKontak ? "font-variation-settings:'FILL' 1;" : '' }}">call</span>
        </span>
        <span class="nav-label" style="font-size:9px; font-weight:600; letter-spacing:0.04em; margin-top:3px; line-height:1;
                     text-transform:uppercase; color: {{ $isKontak ? '#001647' : '#94a3b8' }};">Kontak</span>
    </a>

</nav>

{{-- Global Search Modal --}}
<div id="nav-search-modal"
     style="position:fixed; inset:0; z-index:999; display:none; align-items:flex-start; justify-content:center;
            padding-top: 96px; padding-left:16px; padding-right:16px;
            background: rgba(0,22,71,0.45); backdrop-filter: blur(4px);"
     onclick="if(event.target===this) closeNavSearch()">
    <div style="background:white; border-radius:20px; box-shadow: 0 20px 60px rgba(0,22,71,0.25);
                width:100%; max-width:560px; overflow:hidden; animation: popupSlideUp 0.22s ease;">
        <form action="{{ route('berita') }}" method="GET"
              style="display:flex; align-items:center; gap:12px; padding: 16px 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="#001647" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input id="nav-search-input" name="q" type="text" placeholder="Cari berita, informasi APPSI..."
                   autocomplete="off"
                   style="flex:1; font-size:15px; color:#1e293b; border:none; outline:none; background:transparent; padding:4px 0;">
            <button type="button" onclick="closeNavSearch()"
                    style="color:#94a3b8; border:none; background:none; cursor:pointer; padding:4px; transition:color 0.15s;"
                    onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </form>
        <div style="border-top: 1px solid #f1f5f9; padding: 10px 20px 14px; display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
            <span style="font-size:11px; color:#94a3b8; font-weight:500;">Pencarian cepat:</span>
            <a href="{{ route('berita') }}" style="font-size:12px; font-weight:600; color:#001647; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Berita Terbaru</a>
            <span style="color:#cbd5e1; font-size:12px;">·</span>
            <a href="{{ route('pustaka', 'adart') }}" style="font-size:12px; font-weight:600; color:#001647; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">AD/ART</a>
            <span style="color:#cbd5e1; font-size:12px;">·</span>
            <a href="{{ route('pustaka', 'uu') }}" style="font-size:12px; font-weight:600; color:#001647; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Undang-Undang</a>
            <span style="color:#cbd5e1; font-size:12px;">·</span>
            <a href="{{ route('pustaka', 'data_bps') }}" style="font-size:12px; font-weight:600; color:#001647; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Data BPS</a>
            <span style="color:#cbd5e1; font-size:12px;">·</span>
            <a href="{{ route('hubungi') }}" style="font-size:12px; font-weight:600; color:#001647; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Kontak</a>
        </div>
    </div>
</div>

<script>
    var _tentangOpen = false;
    var _pustakaOpen = false;

    function toggleTentangPopup(e) {
        e.stopPropagation();
        if (_pustakaOpen) closePustakaPopup();
        _tentangOpen ? closeTentangPopup() : openTentangPopup();
    }

    function togglePustakaPopup(e) {
        e.stopPropagation();
        if (_tentangOpen) closeTentangPopup();
        _pustakaOpen ? closePustakaPopup() : openPustakaPopup();
    }

    function openTentangPopup() {
        var panel    = document.getElementById('tentang-panel');
        var backdrop = document.getElementById('nav-backdrop');

        backdrop.style.display = 'block';
        panel.style.display = 'flex';
        _tentangOpen = true;
    }

    function closeTentangPopup() {
        var panel    = document.getElementById('tentang-panel');
        var inner    = document.getElementById('tentang-inner');
        var backdrop = document.getElementById('nav-backdrop');

        inner.classList.add('closing');
        setTimeout(function () {
            panel.style.display = 'none';
            inner.classList.remove('closing');
            if (!_pustakaOpen) backdrop.style.display = 'none';
        }, 160);
        _tentangOpen = false;
    }

    function openPustakaPopup() {
        var panel    = document.getElementById('pustaka-panel');
        var backdrop = document.getElementById('nav-backdrop');

        backdrop.style.display = 'block';
        panel.style.display = 'flex';
        _pustakaOpen = true;
    }

    function closePustakaPopup() {
        var panel    = document.getElementById('pustaka-panel');
        var inner    = document.getElementById('pustaka-inner');
        var backdrop = document.getElementById('nav-backdrop');

        // Close desktop flyout if open
        var flyout = document.getElementById('bps-flyout');
        if (flyout) flyout.style.display = 'none';

        // Close mobile accordion if open
        var content = document.getElementById('bps-accordion-content');
        var chevron = document.getElementById('bps-chevron');
        var wrapper = document.getElementById('bps-wrapper');
        if (content) content.style.display = 'none';
        if (chevron) chevron.style.transform = 'rotate(0deg)';
        if (wrapper) wrapper.style.background = 'transparent';

        inner.classList.add('closing');
        setTimeout(function () {
            panel.style.display = 'none';
            inner.classList.remove('closing');
            if (!_tentangOpen) backdrop.style.display = 'none';
        }, 160);
        _pustakaOpen = false;
    }

    function closeAllNavPopups() {
        if (_tentangOpen) closeTentangPopup();
        if (_pustakaOpen) closePustakaPopup();
    }

    function handleBpsClick(e) {
        e.stopPropagation();

        // 1. Jika Layar HP / Mobile (< 768px): Gunakan Inline Accordion
        if (window.innerWidth < 768) {
            var flyout = document.getElementById('bps-flyout');
            if (flyout) flyout.style.display = 'none';

            var content = document.getElementById('bps-accordion-content');
            var chevron = document.getElementById('bps-chevron');
            var wrapper = document.getElementById('bps-wrapper');

            if (content.style.display === 'block') {
                content.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
                wrapper.style.background = 'transparent';
            } else {
                content.style.display = 'block';
                chevron.style.transform = 'rotate(90deg)';
                wrapper.style.background = '#f8fafc';
            }
        } 
        // 2. Jika Layar Desktop (>= 768px): Gunakan Side Flyout Popup
        else {
            var content = document.getElementById('bps-accordion-content');
            if (content) content.style.display = 'none';

            var flyout = document.getElementById('bps-flyout');
            var inner  = document.getElementById('bps-flyout-inner');

            if (flyout.style.display === 'flex') {
                inner.classList.add('closing');
                setTimeout(function() {
                    flyout.style.display = 'none';
                    inner.classList.remove('closing');
                }, 150);
            } else {
                var pustakaInner = document.getElementById('pustaka-inner');
                var rect = pustakaInner.getBoundingClientRect();

                flyout.style.display = 'flex';
                flyout.style.justifyContent = 'flex-start';
                flyout.style.left = '0';
                flyout.style.right = '0';

                var flyoutLeft = rect.right + 8;
                var flyoutWidth = 148;
                if (flyoutLeft + flyoutWidth > window.innerWidth - 8) {
                    flyoutLeft = rect.left - flyoutWidth - 8;
                }

                inner.style.transform = 'none';
                inner.style.position = 'fixed';
                inner.style.left = flyoutLeft + 'px';
                inner.style.bottom = '96px';
                inner.style.animation = 'none';
                requestAnimationFrame(function() {
                    inner.style.animation = 'popupSlideUp 0.2s cubic-bezier(0.22,1,0.36,1) forwards';
                });
            }
        }
    }

    function openNavSearch() {
        closeAllNavPopups();
        var modal = document.getElementById('nav-search-modal');
        modal.style.display = 'flex';
        setTimeout(function() {
            document.getElementById('nav-search-input').focus();
        }, 50);
    }

    function closeNavSearch() {
        document.getElementById('nav-search-modal').style.display = 'none';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllNavPopups();
            closeNavSearch();
        }
        if ((e.ctrlKey && e.key === 'k') || (e.key === '/' && document.activeElement.tagName !== 'INPUT')) {
            e.preventDefault();
            openNavSearch();
        }
    });
</script>
