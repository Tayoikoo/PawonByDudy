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
                            <tr>
                                <td class="d-flex flex-wrap align-items-center">
                                    <img class="rounded shadow-sm me-3 img-fluid" style="max-width:60px;" src="{{ asset('img/testbowl.jpeg') }}">
                                    
                                    <div class="d-flex flex-column flex-md-row flex-grow-1 justify-content-between">
                                        <span class="fw-bold">"order->menu_catering->nama"</span>
                                        <span class="fw-bold text-primary">Rp. order->menu_catering->harga</span>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 mt-md-0 mx-4">
                                        <!-- <form method="POST" action=""> -->
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity(this)">
                                                <img src="{{ asset('bootstrap-icons/dash.svg') }}" alt="Delete" width="20" height="20">
                                            </button>
                                            <input type="text" name="jumlah" class="form-control form-control-sm text-center" style="width: 60px;" value="1" min="1">
                                            <button type="submit" class="btn btn-outline-success btn-sm" onclick="increaseQuantity(this)">
                                                <img src="{{ asset('bootstrap-icons/plus.svg') }}" alt="Delete" width="20" height="20">
                                            </button>
                                        <!-- </form> -->
                                        <form method="POST" action="" class="ms-3">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <img src="{{ asset('bootstrap-icons/trash.svg') }}" alt="Delete" width="20" height="20">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>                
                </div>  
                <div class="mt-4 text-end">
                    <h5 class="fw-bold">Total Harga: <span class="text-primary">Rp. 10.000</span></h5>
                    <button type="submit" class="btn btn-outline-primary btn-lg">
                        Checkout
                    </button>                    
                </div>                
            </div>
        </div>        
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quantityInputs = document.querySelectorAll('input[name="jumlah"]');

        quantityInputs.forEach(input => {
            input.addEventListener("input", function () {
                let value = parseInt(this.value);
                if (isNaN(value) || value < 1) {
                    this.value = 1;
                }
            });
        });
    });

    function increaseQuantity(button) {
        let inputField = button.previousElementSibling;
        let value = parseInt(inputField.value);
        inputField.value = isNaN(value) ? 1 : value + 1;
    }

    function decreaseQuantity(button) {
        let inputField = button.nextElementSibling;
        let value = parseInt(inputField.value);
        if (!isNaN(value) && value > 1) {
            inputField.value = value - 1;
        }
    }

</script>
@endsection
