@extends('pawonbydudy.layout.layout')

@section('content')
<div class="container mt-5 text-center">
    <h2>Konfirmasi Pembayaran</h2>
    <p>Silakan klik tombol di bawah untuk melakukan pembayaran.</p>

    <button id="pay-button" class="btn btn-success btn-lg mt-3">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        console.log('Tombol diklik');
        console.log('Snap object:', window.snap);
        console.log('SnapToken:', '{{ $snapToken }}');

        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                console.log(result);
                window.location.href = "{{ route('pawonbydudy.order.finish', ['id_order' => $order->id_order]) }}"
                + "?payment_type=" + encodeURIComponent(result.payment_type)
                + "&transaction_id=" + encodeURIComponent(result.transaction_id)
                + "&status_code=" + encodeURIComponent(result.status_code);
            },
            onPending: function (result) {
                alert("Menunggu pembayaran...");
                console.log(result);
            },
            onError: function (result) {
                alert("Pembayaran gagal!");
                console.log(result);
                window.location.href = "{{ route('pawonbydudy.checkout') }}";                 
            },
            onClose: function () {
                alert("Kamu menutup popup sebelum menyelesaikan pembayaran.");
                window.location.href = "{{ route('pawonbydudy.checkout') }}"; 
            }
        });
    });
</script>
@endsection