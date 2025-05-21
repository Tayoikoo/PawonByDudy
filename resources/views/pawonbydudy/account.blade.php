@extends('pawonbydudy.layout.layout')

@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow p-4 text-white" style="background: linear-gradient(145deg,rgb(0, 255, 64),rgb(12, 212, 2)); border-radius: 20px; width: 100%; max-width: 400px;">
       
        <!-- Login Form -->
        <div id="loginForm">
            <form action="{{ route('pawonbydudy.login') }}" method="POST">
                @csrf
                <div class="text-center mb-4">
                    <h1 class="h2">Login</h1>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Masukkan Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan Email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Masukkan Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100" style="font-family: Righteous;">Login</button>

                <div class="text-center mt-3">
                    <a href="javascript:void(0);" onclick="toggleForm()" class="text-white">Daftar Sekarang</a>
                </div>
            </form>
        </div>

        <div id="registerForm" class="d-none">
            <form action="{{ route('pawonbydudy.register') }}" method="POST">
                @csrf
                <div class="text-center mb-4">
                    <h1 class="h2">Register</h1>
                </div>

                <div class="mb-3">
                    <label for="reg_username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="reg_username" placeholder="Buat Username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror                    
                </div>

                <div class="mb-3">
                    <label for="reg_email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="reg_email" placeholder="Masukkan Email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror                 
                </div>

                <div class="mb-3">
                    <label for="reg_password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="reg_password" placeholder="Buat Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror                    
                </div>

                <div class="mb-3">
                    <label for="reg_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="reg_password_confirmation" placeholder="Ulangi Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror                    
                </div>
                
                <button type="submit" class="btn btn-success w-100" style="font-family: Righteous;">Register</button>

                <div class="text-center mt-3">
                    <a href="javascript:void(0);" onclick="toggleForm()" class="text-white">Sudah punya akun? Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleForm() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        loginForm.classList.toggle('d-none');
        registerForm.classList.toggle('d-none');
    }
</script>
@endsection
