@extends('pawonbydudy.layout.layout')

@section('content') 
<div class="container mt-4">
    <h2 class="text-center mb-4">{{ $packet->nama_paket }}</h2>
    @if ($menuCatering->count())
    
        <div class="row">
            @foreach ($menuCatering->get() as $menu)
                <div class="col-6 col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="ratio ratio-4x3">
                            <img src="{{ $menu->foto ? asset('storage/' . $menu->foto) : asset('img/icons/default.png') }}"
                                 alt="{{ $menu->nama }}"
                                 class="card-img-top object-fit-cover">
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
