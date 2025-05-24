@extends('pawonbydudy.layout.layout')

@section('content') 
<div class="container-fluid">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h5 class="fw-bold mt-4">Checkout Catering</h5>
            </div>
            <div class="col-md-12">
                <h6 class="fw-bold">Daftar Pesanan</h6>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <tbody>
                            @forelse ($order->orderItems as $item)
                            <tr>
                                <td class="d-flex flex-wrap align-items-center">
                                    <img class="rounded shadow-sm me-3 img-fluid" style="max-width:60px;" 
                                        src="{{ $item->menu_catering->foto ? asset('storage/' . $item->menu_catering->foto) : asset('img/icons/default.png') }}">

                                    <div class="d-flex flex-column flex-md-row flex-grow-1 justify-content-between">
                                        <span class="fw-bold">{{ $item->menu_catering->nama ?? 'Menu Tidak Ditemukan' }}</span>
                                        <span class="fw-bold text-primary">Rp. {{ number_format($item->menu_catering->harga ?? 0, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 mt-md-0 mx-4">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity(this)" data-id="{{ $item->id_item }}">
                                            <img src="{{ asset('bootstrap-icons/dash.svg') }}" alt="Delete" width="20" height="20">
                                        </button>

                                        <input type="text" name="jumlah" class="form-control form-control-sm text-center jumlah-input" 
                                            style="width: 60px;" value="{{ $item->jumlah }}" min="1" data-id="{{ $item->id_item }}">

                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="increaseQuantity(this)" data-id="{{ $item->id_item }}">
                                            <img src="{{ asset('bootstrap-icons/plus.svg') }}" alt="Delete" width="20" height="20">
                                        </button>

                                        <form method="POST" action="{{ route('pawonbydudy.order_delete', $item->id_item) }}" class="ms-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <img src="{{ asset('bootstrap-icons/trash.svg') }}" alt="Delete" width="20" height="20">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="1" class="text-center">Belum Ada Pesanan untuk saat ini</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>                
                </div>  
                <div class="mt-4 text-end">
                    <h5 class="fw-bold">Total Harga: <span class="text-primary">Rp. {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</span></h5>
                    <button type="submit" class="btn btn-outline-primary btn-lg">
                        Checkout
                    </button>                    
                </div>
            </div>
        </div>        
    </div>
</div>
<script>
    document.querySelectorAll('.jumlah-input').forEach(input => {
        input.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            const newJumlah = parseInt(this.value);
            const totalHargaDisplay = document.querySelector('h5 span.text-primary');

            // Basic validation
            if (isNaN(newJumlah) || newJumlah < 1) {
                this.value = 1;
                return;
            }

            fetch(`/checkout/update/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ jumlah: newJumlah })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.value = data.jumlah;
                    totalHargaDisplay.textContent = 'Rp. ' + data.total_harga;
                }
            });
        });
    });

    function increaseQuantity(button) {
        const id = button.getAttribute('data-id');
        const inputField = button.parentElement.querySelector('input[name="jumlah"]');
        const totalHargaDisplay = document.querySelector('h5 span.text-primary');

        fetch(`/checkout/increase/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                inputField.value = data.jumlah;
                totalHargaDisplay.textContent = 'Rp. ' + data.total_harga;
            }
        });
    }

    function decreaseQuantity(button) {
        const id = button.getAttribute('data-id');
        const inputField = button.parentElement.querySelector('input[name="jumlah"]');
        const totalHargaDisplay = document.querySelector('h5 span.text-primary');

        fetch(`/checkout/decrease/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                inputField.value = data.jumlah;
                totalHargaDisplay.textContent = 'Rp. ' + data.total_harga;
            }
        });
    }
</script>

@endsection
