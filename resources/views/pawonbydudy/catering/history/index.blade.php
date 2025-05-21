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
                                <td>ID Pesanan</td>
                                <td>Tanggal</td>
                                <td>Total Bayar</td>
                                <td>Status</td>
                                <td>Detail</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ date('d-m-Y H:i:s') }}</td>
                                <td>Rp. 10.000</td>
                                <td>
                                    <p class="rounded" style="background-color:rgb(0, 123, 255); color:rgb(255, 255, 255); padding: 5px;">Proses</p>
                                </td>
                                <td>
                                    <button class="btn btn-success">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection
