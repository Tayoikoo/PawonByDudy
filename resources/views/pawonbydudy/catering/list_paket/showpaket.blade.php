@extends('pawonbydudy.layout.layout')

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
        text-decoration: none;
    }

    .lihat-btn:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">{{ $packet->nama_paket }}</h2>
    @if ($menuCatering->count())
        <div class="row">
            @foreach ($menuCatering->get() as $menu)
                <div class="col-6 col-md-3 mb-4">
                    <div class="card h-100 card-hover">
                        <div class="ratio ratio-4x3 position-relative">
                            <img src="{{ $menu->foto ? asset('storage/' . $menu->foto) : asset('img/icons/default.png') }}"
                                 alt="{{ $menu->nama }}"
                                 class="card-img-top object-fit-cover">
                            <div class="hover-overlay">
                            <a href="{{ route('pawonbydudy.showinfopaket', $menu->paket->id_paket) }}" class="lihat-btn text-decoration-none">Lihat</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-6">{{ $menu->nama }}</h5>
                            <p class="card-text text-muted">Harga: Rp. {{ number_format($menu->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning text-center">
            Belum ada menu untuk paket ini.
        </div>
    @endif
</div>
@endsection
