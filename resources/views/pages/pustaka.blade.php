
@extends('layouts.app')

@section('title', 'Pustaka - ' . $aktifLabel . ' - APPSI')

@push('styles')
<style>
    .a4-document-sheet {
        position: relative;
        background: #FFFFFF;
        aspect-ratio: 1 / 1.414;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 6px 18px -4px rgba(0, 22, 71, 0.08);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
        cursor: pointer;
    }
    .a4-document-sheet:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 8px 16px -2px rgba(0,0,0,0.08), 0 20px 32px -8px rgba(0, 22, 71, 0.18);
    }
    .a4-document-sheet::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0;
        width: 0; height: 0;
        border-style: solid;
        border-width: 0 0 16px 16px;
        border-color: transparent transparent #cbd5e1 transparent;
        z-index: 25;
        pointer-events: none;
    }

    /* Skeleton shimmer animation */
    @keyframes pdfShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .pdf-skeleton-shimmer {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: pdfShimmer 1.8s infinite;
    }

    /* ===== DFLIP MODAL OVERLAY ===== */
    #df-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: #181818;
        display: none;
    }
    #df-modal-overlay.show {
        display: block;
    }
    #df_manual_book {
        width: 100vw !important;
        height: 100vh !important;
        position: absolute;
        inset: 0;
        top: 0;
    }
    #df-modal-header {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100001;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        background: linear-gradient(to bottom, rgba(0,0,0,0.88) 0%, rgba(0,0,0,0.55) 70%, transparent 100%);
        gap: 12px;
        pointer-events: auto;
    }
    #df-modal-header .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }
    #df-modal-kategori {
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: #F59E0B;
        color: #0f172a;
        white-space: nowrap;
        flex-shrink: 0;
    }
    #df-modal-title {
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
        text-shadow: 0 1px 4px rgba(0,0,0,0.5);
    }
    #df-modal-header .header-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    #df-modal-download {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #F59E0B;
        color: #0f172a;
        font-weight: 800;
        font-size: 12px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        transition: background 0.15s, transform 0.1s;
        white-space: nowrap;
    }
    #df-modal-download:hover {
        background: #FBBF24;
        transform: scale(1.03);
    }
    #df-modal-download:active {
        transform: scale(0.97);
    }
    #df-modal-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #ffffff;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        flex-shrink: 0;
    }
    #df-modal-close:hover {
        background: rgba(220,38,38,0.85);
        transform: scale(1.05);
    }

    /* DFlip Dark Toolbar Styling */
    .df-ui-wrapper {
        background-color: #222222 !important;
        box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.6) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .df-ui-controls {
        background: transparent !important;
    }
    .df-ui-btn {
        background-color: #2a2a2a !important;
        color: #d1d5db !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        transition: all 0.15s ease !important;
    }
    .df-ui-btn:hover {
        background-color: #3b3b3b !important;
        color: #ffd180 !important;
    }
    .df-ui-page {
        background-color: #1e1e1e !important;
        color: #ffffff !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
    }
    .df-ui-page input {
        background-color: #1e1e1e !important;
        color: #ffffff !important;
        border: 1px solid #444444 !important;
    }
    .df-ui-page input:focus {
        color: #ffffff !important;
        opacity: 1 !important;
        border-color: #ffd180 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-[1240px] mx-auto px-4 md:px-8 py-6 space-y-6">

    {{-- Header & Breadcrumbs --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200/80 pb-4">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant font-label-caps text-label-caps text-xs mb-1">
                <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a class="hover:text-primary transition-colors" href="{{ route('pustaka', 'semua') }}">Pustaka</a>
                @if($kategori !== 'semua')
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-primary font-bold">{{ $aktifLabel }}</span>
                @endif
            </nav>
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary tracking-tight">
                {{ $aktifLabel }}
                @if($tahun)
                    <span class="text-secondary font-semibold text-xl">Tahun {{ $tahun }}</span>
                @endif
            </h1>
        </div>

        <div class="flex items-center gap-3">
            {{-- Sub-Filter Tahun (Tampil Otomatis Jika Ada Dokumen Bertahun di Kategori Ini) --}}
            @if(isset($tahunList) && $tahunList->isNotEmpty())
            <div class="flex items-center gap-1.5 overflow-x-auto hide-scrollbar bg-slate-100 p-1.5 rounded-xl border border-slate-200">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-2 shrink-0">Tahun:</span>
                <a href="{{ route('pustaka', $kategori) . ($search ? '?q=' . urlencode($search) : '') }}"
                   class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all shrink-0 {{ empty($tahun) ? 'bg-primary text-white shadow-2xs' : 'text-slate-600 hover:bg-white' }}">
                    Semua
                </a>
                @foreach($tahunList as $thn)
                    @php
                        $isThnActive = ($tahun == $thn);
                        $thnUrl = route('pustaka', $kategori) . '?tahun=' . $thn . ($search ? '&q=' . urlencode($search) : '');
                    @endphp
                    <a href="{{ $thnUrl }}"
                       class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all shrink-0 {{ $isThnActive ? 'bg-primary text-white shadow-2xs' : 'text-slate-600 hover:bg-white' }}">
                        {{ $thn }}
                    </a>
                @endforeach
            </div>
            @endif

            <span class="text-xs font-bold text-slate-500 bg-white px-3 py-2 rounded-xl border border-slate-200 shrink-0">
                {{ $dokumen->count() }} Dokumen
            </span>
        </div>
    </div>

    {{-- Document Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($dokumen as $doc)
        @php
            $docUrl = $doc->file ? asset('storage/' . $doc->file) : $doc->file_url;
            $tagColor = match($doc->kategori) {
                'adart'        => 'bg-amber-50 text-amber-700 border-amber-200',
                'uu'           => 'bg-purple-50 text-purple-700 border-purple-200',
                'data_bps'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'rekomendasi'  => 'bg-blue-50 text-blue-700 border-blue-200',
                'sk'           => 'bg-rose-50 text-rose-700 border-rose-200',
                'berita_acara' => 'bg-slate-100 text-slate-700 border-slate-200',
                default        => 'bg-slate-50 text-slate-700 border-slate-200',
            };
        @endphp

        <div class="bg-surface-white border border-border-subtle rounded-3xl p-4 sm:p-5 shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">

            {{-- Document Sheet (Live PDF Thumbnail) --}}
            <div class="cursor-pointer" onclick="openPdfViewer({{ json_encode($doc) }})">
                <div class="a4-document-sheet select-none relative bg-slate-100">
                    <div class="pdf-thumb-wrapper w-full h-full relative flex items-center justify-center overflow-hidden" data-pdf-url="{{ $docUrl }}" data-doc-title="{{ $doc->judul }}" data-kategori-badge="{{ $doc->label_kategori }}">
                        
                        {{-- Loading Skeleton Placeholder --}}
                        <div class="pdf-skeleton absolute inset-0 flex flex-col items-center justify-between p-4 bg-slate-50 text-slate-400 z-10 transition-opacity duration-300">
                            <div class="w-full flex items-center justify-between border-b border-slate-200 pb-2">
                                <div class="w-6 h-6 rounded-full bg-slate-200 pdf-skeleton-shimmer"></div>
                                <div class="w-16 h-2 rounded bg-slate-200 pdf-skeleton-shimmer"></div>
                            </div>
                            <div class="w-full space-y-2 text-center my-auto px-2">
                                <div class="w-10 h-10 rounded-xl bg-slate-200 pdf-skeleton-shimmer mx-auto flex items-center justify-center text-slate-400 mb-2">
                                    <span class="material-symbols-outlined text-xl">description</span>
                                </div>
                                <div class="w-3/4 h-2.5 rounded bg-slate-200 pdf-skeleton-shimmer mx-auto"></div>
                                <div class="w-1/2 h-2 rounded bg-slate-200 pdf-skeleton-shimmer mx-auto"></div>
                                <span class="text-[9px] font-semibold text-slate-400 block pt-1">Memuat naskah...</span>
                            </div>
                            <div class="w-full pt-2 border-t border-slate-200 flex justify-between items-center text-[7px] text-slate-400 font-mono">
                                <span>Hal 1</span>
                                <span>APPSI</span>
                            </div>
                        </div>

                        {{-- PDF Live First Page Canvas --}}
                        <canvas class="pdf-thumb-canvas w-full h-full object-cover relative z-10 opacity-0 transition-opacity duration-500"></canvas>

                        {{-- Interactive Hover Overlay --}}
                        <div class="absolute inset-0 z-20 bg-slate-950/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center text-white p-3 gap-2">
                            <div class="w-10 h-10 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                <span class="material-symbols-outlined text-xl font-bold">auto_stories</span>
                            </div>
                            <span class="text-[10px] font-bold tracking-wide bg-slate-900/85 px-3 py-1 rounded-full border border-white/20 shadow-md">
                                Lihat
                            </span>
                        </div>

                        {{-- Category Badge on Top-Right --}}
                        <div class="absolute top-2.5 right-2.5 z-20 pointer-events-none">
                            <span class="px-2 py-0.5 rounded-md text-[8px] font-black uppercase tracking-wider {{ $tagColor }} shadow-xs border">
                                {{ $doc->label_kategori }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Meta & Actions --}}
            <div class="mt-4 space-y-3 pt-2 border-t border-slate-100 flex-1 flex flex-col justify-between">
                <div>
                    <h4 class="font-headline-sm text-sm font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 leading-snug cursor-pointer" onclick="openPdfViewer({{ json_encode($doc) }})">{{ $doc->judul }}</h4>
                    <div class="flex items-center gap-3 mt-1.5 text-xs text-on-surface-variant font-medium">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm text-secondary">calendar_today</span><span>Tahun {{ $doc->tahun ?: '-' }}</span></span>
                        <span>•</span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm text-slate-400">download</span><span>{{ number_format($doc->unduhan) }}x diunduh</span></span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="button" onclick="openPdfViewer({{ json_encode($doc) }})" class="w-full py-2 px-3 bg-primary hover:bg-primary/90 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-1.5 shadow-xs transition-all active:scale-95 cursor-pointer">
                        <span class="material-symbols-outlined text-base">visibility</span>
                        <span>Lihat</span>
                    </button>
                    @if($doc->file_download_url)
                    <a href="{{ route('pustaka.download', $doc->id) }}" class="w-full py-2 px-3 bg-amber-50 hover:bg-amber-100 text-secondary border border-amber-200/80 font-bold text-xs rounded-xl flex items-center justify-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-base">download</span>
                        <span>Unduh</span>
                    </a>
                    @else
                    <span class="w-full py-2 px-3 bg-slate-100 text-slate-400 font-medium text-xs rounded-xl text-center">N/A</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-surface-white border border-dashed border-border-subtle rounded-3xl space-y-3">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400">
                <span class="material-symbols-outlined text-3xl">description</span>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum ada dokumen untuk kategori ini</h3>
        </div>
        @endforelse
    </div>

</div>


{{-- ===== DFLIP MODAL ===== --}}
<div id="df-modal-overlay">
    <!-- Top Action Bar Inside Viewer -->
    <div id="df-modal-header">
        <div class="header-left">
            <span id="df-modal-kategori">Dokumen</span>
            <h3 id="df-modal-title">Judul Dokumen</h3>
        </div>
        <div class="header-right">
            <a id="df-modal-download" href="#">
                <span class="material-symbols-outlined" style="font-size:16px;font-variation-settings:'FILL' 1">download</span>
                <span>Unduh PDF</span>
            </a>
            <button id="df-modal-close" onclick="closeDfViewer()" title="Tutup (ESC)">
                <span class="material-symbols-outlined" style="font-size:18px">close</span>
            </button>
        </div>
    </div>
    <div id="df_manual_book"></div>
</div>

{{-- DFlip Dependencies --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/dflip.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/themify-icons.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Define global DFlip asset location so worker, sounds & fonts resolve correctly
    window.dFlipLocation = "https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/";
</script>
<script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/libs/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js"></script>

<script>
(function () {
    // 1. DFlip Flipbook Modal Viewer
    var dfBook   = null;
    var overlay  = document.getElementById('df-modal-overlay');
    var bookEl   = document.getElementById('df_manual_book');

    window.openPdfViewer = function (doc) {
        var url = doc.file ? ('/storage/' + doc.file) : doc.file_url;
        if (!url) return;
        if (url.indexOf('?') === -1) { url += '?t=' + Date.now(); }

        var downloadUrl = doc.id ? ('/pustaka/unduh/' + doc.id) : (doc.file ? ('/storage/' + doc.file) : doc.file_url);

        var downloadBtn = document.getElementById('df-modal-download');
        var titleEl = document.getElementById('df-modal-title');
        var catEl = document.getElementById('df-modal-kategori');

        if (downloadBtn) {
            downloadBtn.href = downloadUrl;
        }
        if (titleEl) {
            titleEl.textContent = doc.judul || 'Dokumen Pustaka';
        }
        if (catEl) {
            catEl.textContent = doc.label_kategori || 'Dokumen';
        }

        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';

        if (dfBook && typeof dfBook.destroy === 'function') {
            try { dfBook.destroy(); } catch(e) {}
            dfBook = null;
        }

        $(bookEl).empty().removeData();

        setTimeout(function () {
            var options = {
                webgl               : true,
                duration            : 700,
                height              : '100%',
                backgroundColor     : '#181818',
                backgroundImage     : '',
                soundEnable         : true,
                autoEnableOutline   : false,
                autoEnableThumbnail : false,
                enableDownload      : true,
                downloadURL         : downloadUrl,
                allControls         : 'altPrev,pageNumber,altNext,play,outline,thumbnail,zoomIn,zoomOut,fullScreen,download,sound',
                text: {
                    toggleSound        : 'Suara',
                    toggleThumbnails   : 'Thumbnail',
                    toggleOutline      : 'Daftar Isi',
                    previousPage       : 'Halaman Sebelumnya',
                    nextPage           : 'Halaman Berikutnya',
                    firstPage          : 'Halaman Pertama',
                    lastPage           : 'Halaman Terakhir',
                    downloadPDF        : 'Unduh PDF',
                    fullscreen         : 'Layar Penuh',
                    share              : 'Bagikan',
                    close              : 'Tutup',
                }
            };

            dfBook = $(bookEl).flipBook(url, options);
        }, 50);
    };

    window.closeDfViewer = function () {
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        if (dfBook && typeof dfBook.destroy === 'function') {
            try { dfBook.destroy(); } catch(e) {}
            dfBook = null;
        }
        $(bookEl).empty().removeData();
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('show')) {
            closeDfViewer();
        }
    });

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeDfViewer();
    });

    // 2. High-Performance Live PDF First-Page Thumbnail Renderer
    document.addEventListener('DOMContentLoaded', function () {
        var pdfLib = window.pdfjsLib || window.PDFJS;
        if (!pdfLib) return;

        if (pdfLib.GlobalWorkerOptions) {
            pdfLib.GlobalWorkerOptions.workerSrc = window.dFlipLocation + 'js/libs/pdf.worker.min.js';
        } else if (window.PDFJS) {
            window.PDFJS.workerSrc = window.dFlipLocation + 'js/libs/pdf.worker.min.js';
        }

        var pdfWrappers = document.querySelectorAll('.pdf-thumb-wrapper[data-pdf-url]');

        function renderFallback(wrapper) {
            var skeleton = wrapper.querySelector('.pdf-skeleton');
            var docTitle = wrapper.getAttribute('data-doc-title') || 'Dokumen Resmi';
            var cat = wrapper.getAttribute('data-kategori-badge') || 'Naskah';
            if (skeleton) {
                skeleton.innerHTML = `
                    <div class="flex flex-col items-center justify-between p-3 text-center h-full w-full bg-white">
                        <div class="w-full pb-1 border-b border-slate-200 text-center">
                            <span class="text-[7.5px] font-black uppercase text-slate-800 tracking-wider">APPSI</span>
                        </div>
                        <div class="my-auto space-y-1.5 px-1">
                            <span class="material-symbols-outlined text-2xl text-amber-600 block mx-auto">menu_book</span>
                            <span class="text-[8.5px] font-bold text-slate-800 line-clamp-3 leading-tight uppercase">${docTitle}</span>
                        </div>
                        <div class="w-full pt-1 border-t border-slate-100 flex justify-between text-[7px] text-slate-400 font-mono">
                            <span>${cat}</span>
                            <span>PDF</span>
                        </div>
                    </div>
                `;
                skeleton.style.opacity = '1';
            }
        }

        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var wrapper = entry.target;
                    obs.unobserve(wrapper);

                    var url = wrapper.getAttribute('data-pdf-url');
                    var canvas = wrapper.querySelector('.pdf-thumb-canvas');
                    var skeleton = wrapper.querySelector('.pdf-skeleton');

                    if (!url || !canvas) return;

                    var getDocPromise;
                    if (pdfLib.getDocument) {
                        getDocPromise = pdfLib.getDocument({
                            url: url,
                            rangeChunkSize: 65536,
                            disableAutoFetch: true,
                            disableStream: false
                        }).promise || pdfLib.getDocument(url);
                    } else {
                        renderFallback(wrapper);
                        return;
                    }

                    getDocPromise.then(function (pdf) {
                        return pdf.getPage(1);
                    }).then(function (page) {
                        var baseViewport = page.getViewport({ scale: 1 });
                        var containerWidth = wrapper.clientWidth || 240;
                        // Sharp render for high-DPI displays
                        var dpr = Math.min(window.devicePixelRatio || 1.5, 2.5);
                        var scale = (containerWidth / (baseViewport.width || 1)) * dpr;
                        var viewport = page.getViewport({ scale: Math.max(scale, 1.2) });

                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var ctx = canvas.getContext('2d');
                        var renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };

                        return page.render(renderContext).promise.then(function () {
                            canvas.classList.remove('opacity-0');
                            canvas.classList.add('opacity-100');
                            if (skeleton) {
                                skeleton.style.opacity = '0';
                                setTimeout(function () {
                                    if (skeleton && skeleton.parentNode) {
                                        skeleton.style.display = 'none';
                                    }
                                }, 350);
                            }
                        });
                    }).catch(function (err) {
                        console.warn('PDF thumbnail failed for:', url, err);
                        renderFallback(wrapper);
                    });
                }
            });
        }, {
            rootMargin: '300px 0px',
            threshold: 0.01
        });

        pdfWrappers.forEach(function (wrapper) {
            observer.observe(wrapper);
        });
    });
})();
</script>
@endsection
