@extends('pawonbydudy.layout.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Akun Anda</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pawonbydudy.akun.update', ['id_user' => $user->id_user]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label"><strong>Username</strong></label>
                            <input type="text" class="form-control" id="username" value="{{ $user->username }}" name="username" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><strong>Nomor Telepon</strong></label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}" value="{{ $user->hp }}" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
