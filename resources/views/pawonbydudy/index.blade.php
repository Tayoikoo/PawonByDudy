@extends('pawonbydudy.layout.layout')
<!-- Section = bagian atau isi  -->
@section('content') 
<style>
    .card-hover {
        position: relative;
        overflow: hidden;
    }

    .card-hover .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: 0.3s ease-in-out;
    }

    .card-hover:hover .hover-overlay {
        opacity: 1;
    }

    .lihat-btn {
        background-color: #ffffff;
        color: #000000;
        border: none;
        padding: 0.5rem 1rem;
        font-weight: bold;
        border-radius: 0.25rem;
    }

    .lihat-btn:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <img src="{{ asset('img/icons/icon.png') }}" width="256px" height="256px" class="me-2">
        </div>
        <div class="row">
            <b class="fs-2 text-black">Favorit</b>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <img src="{{ asset('img/icons/ricebowl.png') }}" width="64px" height="64px" class="me-3">
                    <div>
                        <b class="text-dark">Serba 10rb</b><br>
                        <span class="text-muted">Paket Nasi box dengan harga 10 ibu yang terdiri dari banyak pilihan menu Rice Bowl</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <img src="{{ asset('img/icons/nasikuning.png') }}" width="64px" height="64px" class="me-3">
                    <div>
                        <b class="text-dark">Aneka Nasi Kuning</b><br>
                        <span class="text-muted">Nasi Kuning Box, Tumpeng Mini, Nasi Bento Anak, Tumpeng Besar</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <img src="{{ asset('img/icons/snackbox.png') }}" width="64px" height="64px" class="me-3">
                    <div>
                        <b class="text-dark">Aneka Snack Box</b><br>
                        <span class="text-muted">Paket snack box pilihan untuk melengkapi acara anda</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <img src="{{ asset('img/icons/rice.png') }}" width="64px" height="64px" class="me-3">
                    <div>
                        <b class="text-dark">Nasi Tumpeng Paket Hemat</b><br>
                        <span class="text-muted">Paket nasi tumpeng dengan harga terjangkau untuk acara spesial anda </span>
                    </div>
                </div>
            </div>                                    
        </div>
        @php
            $hasMenu = $packet->filter(fn($paket) => $paket->menu_catering->where('status', 1)->isNotEmpty())->isNotEmpty();
        @endphp

        @if ($hasMenu)
            @foreach ($packet as $paket)
                @if ($paket->menu_catering->where('status', 1)->isNotEmpty())
                    <div class="col-md-12 mt-4">
                        <b class="fs-2 text-black">{{ $paket->nama_paket }}</b>
                        <div class="row">
                            @foreach ($paket->menu_catering->where('status', 1) as $menu)
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="card h-100 card-hover">
                                        <div class="ratio ratio-16x9">
                                            <img class="card-img-top object-fit-cover" src="{{ $menu->foto ? asset('storage/' . $menu->foto) : asset('img/icons/default.png') }}" alt="{{ $menu->nama }}">
                                            <div class="hover-overlay">
                                                <a href="{{ route('pawonbydudy.showinfopaket', $menu->id_catering) }}" class="lihat-btn text-decoration-none">Lihat</a>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <h5 class="card-title fs-6 mb-1">{{ $menu->nama }}</h5>
                                            <p class="card-text text-muted mb-0">Harga: Rp. {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <hr>
            <b class="fs-2 text-black text-center">Menu Kosong, harap tunggu update</b>
        @endif

    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 text-center">
            <b class="fs-2 text-center">Lokasi Kami</b>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <div style="width: 100%; max-width: 900px;">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1314563159467!2d107.06684967402549!3d-6.246402261160537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f007ef11b9f%3A0x3b2dde1b84239eaf!2sPawon%20byDudy!5e0!3m2!1sen!2sid!4v1746172996625!5m2!1sen!2sid"  style="border:0;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection