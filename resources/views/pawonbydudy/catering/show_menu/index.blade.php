@extends('pawonbydudy.layout.layout')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <!-- Gambar -->
        <div class="col-md-4 text-center">
            <img src="{{ $menuCatering->foto ? asset('storage/' . $menuCatering->foto) : asset('img/icons/default.png') }}"
                 alt="{{ $menuCatering->nama }}" class="img-fluid rounded mb-3">
            <form action="" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100">Masuk ke Keranjang</button>
            </form>
        </div>

        <!-- Informasi Paket -->
        <div class="col-md-8 mt-4">
            <h2>{{ $menuCatering->nama }}</h2>
            <hr>
            <p class="fw-bold fs-4">Harga: Rp {{ number_format($menuCatering->harga, 0, ',', '.') }}</p>
            <hr>
            <h2 class="text-center">Deskripsi</h2>
            <div class="text-break">
                @php echo $menuCatering->deskripsi @endphp
            </div>
        </div>
    </div>
    <hr>
    <!-- Komentar -->
    <div class="row">
        <div class="col-md-12">
            <h4>Komentar</h4>
            <form action="#" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tulis komentar</label>
                    <textarea class="form-control" id="ckeditor" name="komentar" placeholder="Masukkan komentar"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Review Komentar</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
