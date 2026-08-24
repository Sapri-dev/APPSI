@extends('layouts.app')

@section('title', 'Sejarah APPSI')

@section('content')
<section class="py-10 md:py-14 px-4 max-w-[850px] mx-auto">

    {{-- Main Card Sejarah APPSI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        
        {{-- Header: Ikon Gedung + SEJARAH APPSI --}}
        <div class="px-6 py-5 flex items-center gap-3 border-b border-dotted border-slate-300">
            <span class="material-symbols-outlined text-blue-700 text-2xl" style="font-variation-settings:'FILL' 1;">
                account_balance
            </span>
            <h1 class="text-blue-700 font-extrabold text-base md:text-lg tracking-wider uppercase">
                SEJARAH APPSI
            </h1>
        </div>

        {{-- Body Content --}}
        <div class="p-6 md:p-10 flex flex-col items-start">
            
            {{-- Logo Bulat APPSI --}}
            <div class="mb-6">
                <img src="{{ asset('images/Logo-appsi.png') }}"
                     alt="Logo APPSI"
                     style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; object-position: left center;
                            box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: white; border: 1px solid #f1f5f9; display: block;">
            </div>

            {{-- Judul --}}
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-3">
                Sejarah APPSI
            </h2>

            {{-- Teks Resmi --}}
            <p class="text-slate-600 text-base md:text-[17px] leading-relaxed">
                APPSI dibentuk sebagai wadah koordinasi dan sinergi Pemerintah Provinsi se-Indonesia dalam memperkuat peran gubernur, menyuarakan aspirasi daerah, serta mendukung penyelenggaraan pemerintahan dan pembangunan nasional dalam bingkai Negara Kesatuan Republik Indonesia
            </p>

        </div>

    </div>

</section>
@endsection

