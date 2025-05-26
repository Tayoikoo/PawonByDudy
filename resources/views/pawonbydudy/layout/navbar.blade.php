<nav class="navbar navbar-dark fixed-top" style="background: linear-gradient(180deg,rgb(1, 197, 89),rgb(8, 204, 8));">
    <div class="container-fluid">
        <a class="navbar-brand text-white d-flex align-items-center" style="font-family: Righteous;" href="#">
            <img src="{{ asset('img/icons/icon.png') }}" width="48px" height="48px" class="me-2">
            <span>PawonByDudy</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pawonbydudy.index') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="adminMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori Paket
                    </a>
                    <ul class="dropdown-menu dropdown-custom animate-dropdown" aria-labelledby="adminMenu" style="background-color:rgb(0, 197, 76);">          
                        @if(isset($paket) && $paket->count())
                            @foreach($paket as $category)
                                <li>
                                    <a class="dropdown-item text-white" href="{{ route('pawonbydudy.listkategori', $category->id_paket) }}">
                                        {{ $category->nama_paket }}
                                    </a>
                                </li>
                            @endforeach
                        @endif                        
                    </ul>
                </li>                          
            @auth('web')
                @php
                    $user = Auth::guard('web')->user();
                    $id = $user->id_user;
                    $username = $user->username;
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Keranjang
                    </a>                    
                    <ul class="dropdown-menu dropdown-custom animate-dropdown" aria-labelledby="userMenu" style="background: linear-gradient(180deg,rgb(1, 197, 89),rgb(8, 204, 8));">
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy.checkout') }}">Checkout</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy.history_order') }}">History Pesanan</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pawonbydudy.akun', ['id_user' => $id]) }}">Akun Saya ({{ $username }})</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form-web').submit();">Logout</a>
                    <form id="logout-form-web" action="{{ route('pawonbydudy.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @elseif(auth('admin')->check())
                @php
                    $adminName = Auth::guard('admin')->user()->username;
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="adminMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Menu Admin ({{ $adminName }})
                    </a>
                    <ul class="dropdown-menu dropdown-custom animate-dropdown" aria-labelledby="adminMenu" style="background-color:rgb(0, 197, 76);">
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_admin.admin.index') }}">Daftar Admin</a>
                        </li>                        
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_user.user.index') }}">Daftar User</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_paket.paket.index') }}">Daftar Paket</a>
                        </li>                        
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_catering.catering.index') }}">Daftar Menu Catering</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_pengirim.pengirim.index') }}">Daftar Pengirim</a>
                        </li>                        
                        <li>
                            <a class="dropdown-item text-white" href="{{ route('pawonbydudy_order.order.index') }}">Daftar Order</a>
                        </li>                        
                    </ul>
                </li>                
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">Logout</a>
                    <form id="logout-form-admin" action="{{ route('pawonbydudy.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pawonbydudy.showlogin') }}">Login</a>
                </li>
            @endauth       
            </ul>
        </div>
    </div>
</nav>

<!-- Keluar App -->
<form id="keluar-app" action="{{ route('pawonbydudy.logout') }}" method="POST" class="d-none">
    @csrf
</form>
<style>
    .dropdown-custom {
        background-color:rgb(0, 255, 60); 
        border: none;
        display: none; 
        opacity: 0;
        transform: translateY(-10px); 
        transition: all 0.3s ease-in-out; 
    }

    .dropdown-custom.show {
        display: block; 
        opacity: 1;
        transform: translateY(0); 
    }

    .dropdown-custom .dropdown-item {
        color: white;
    }

    .dropdown-custom .dropdown-item:hover {
        background-color:rgb(0, 255, 60); 
        color: white;
    }
</style>
<!-- Keluar App end -->