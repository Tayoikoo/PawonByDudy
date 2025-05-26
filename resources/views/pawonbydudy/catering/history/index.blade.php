@extends('pawonbydudy.layout.layout')

@section('content') 
<div class="container-fluid">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h5 class="fw-bold mt-4">History Pesanan</h5>
            </div>

            <div class="col-md-12">
                <div class="table-responsive mt-4 text-center">
                    <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No Pesanan</td>
                            <td>Tanggal</td>
                            <td>Total Bayar</td>
                            <td>Status</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id_order }}</td>
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
        </div>        
    </div>
</div>
@endsection