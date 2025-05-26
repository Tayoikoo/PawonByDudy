@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar Pesanan</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID Order</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Pengirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr class="text-center">
                    <td>{{ $order->id_order }}</td>
                    <td>{{ $order->user->username }}</td>
                    <td>{{ $order->user->hp ?? '-' }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('d-m-Y H:i:s') }}</td>
                    <td>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @switch($order->status)
                            @case('pending')
                                <p class="rounded" style="background-color:rgb(255, 193, 7); color:white; padding: 5px;">
                                    {{ ucfirst($order->status) }}
                                </p>
                                @break

                            @case('paid')
                                <p class="rounded" style="background-color:rgb(40, 167, 69); color:white; padding: 5px;">
                                    {{ ucfirst($order->status) }}
                                </p>
                                @break

                            @default
                                <p class="rounded" style="background-color:gray; color:white; padding: 5px;">
                                    {{ ucfirst($order->status) }}
                                </p>
                        @endswitch
                    </td>
                    <td>
                        {{ $order->pengirim->nama_pengirim ?? "-" }}
                    </td>                    
                    <td>
                        <a href="{{ route('pawonbydudy.order.invoice', ['id_order' => $order->id_order]) }}" class="btn btn-primary" target="_blank">
                            Cetak Invoice
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada pesanan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>           
    </div>
</div>

@endsection
