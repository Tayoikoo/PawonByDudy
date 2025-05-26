<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pesanan #{{ $order->id_order }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 14px; 
            position: relative; 
            margin: 40px;
        }

        /* Watermark image behind all content */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 300px;        /* Adjust size */
            height: auto;
            opacity: 0.1;        /* Make it very subtle */
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;          /* Behind everything */
        }

        .content {
            position: relative;
            z-index: 10;          /* Above watermark */
            background: transparent; /* Ensure watermark visible behind */
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background: white;     /* So text is readable on top */
            position: relative;    /* keep stacking context */
            z-index: 10;
        }


        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
        }

        th { 
            background-color: #eee; 
        }
    </style>
</head>
<body>
    {{-- Watermark image --}}
    <img src="{{ public_path('img/icons/icon.png') }}" class="watermark" alt="Watermark Icon"/>

    <div class="content">
        <h2>PawonByDudy</h2>
        <h2>Invoice Pesanan #{{ $order->id_order }}</h2>

        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('d-m-Y H:i:s') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Alamat:</strong> {{ $order->alamat }}, {{ $order->pos }}</p>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menu_catering->nama ?? 'Menu tidak ditemukan' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total Harga</strong></td>
                    <td><strong>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
