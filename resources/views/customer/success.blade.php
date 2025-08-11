@extends('customer.layouts.master')

@section('title', 'Pesanan Berhasil!')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="receipt border p-4 bg-white shadow" style="width: 450px; margin-top: 5rem;">
            <h5 class="text-center mb-2">Pesanan berhasil dibuat</h5>

            @if ($order->payment_method == 'tunai' && $order->status == 'pending')
                <p class="text-center">
                    <span class="badge bg-danger">Menunggu Pembayaran</span>
                </p>
            @elseif ($order->payment_method == 'qris' && $order->status == 'pending')
                <p class="text-center">
                    <span class="badge bg-primary">Menunggu konfirmasi pembayaran</span>
                </p>
            @else
                <p class="text-center">
                    <span class="badge bg-primary">Pembayaran berhasil, pesanan segera diproses</span>
                </p>
            @endif

            <hr>

            <h4 class="fw-bold text-center">Kode bayar <br> 
                <span class="text-primary">{{ $order->order_code }}</span>
            </h4>

            <hr>

            <h5 class="mb-3 text-center">Detail Pesanan</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-end">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                    @endphp

                    @foreach ($orderItems as $orderItem)
                        @php
                            $itemTotal = $orderItem->price * $orderItem->quantity;
                            $subtotal += $itemTotal;
                        @endphp
                        <tr>
                            <td>{{ \Illuminate\Support\Str::limit($orderItem->item->name, 25) }} ({{ $orderItem->quantity }})</td>
                            <td class="text-end">Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $tax = $subtotal * 0.10; // Pajak 10%
                        $total = $subtotal + $tax;
                    @endphp
                    <tr>
                        <th>Subtotal</th>
                        <th class="text-end">Rp{{ number_format($subtotal, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th>Pajak (10%)</th>
                        <th class="text-end">Rp{{ number_format($tax, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th class="text-end">Rp{{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
            @if ($order->payment_method == 'tunai')
                <p class="text-center">
                    Tunjukan kode ini ke kasir untuk menyelesaikan pembayaran, Jangan lupa senyum yaa..
                </p>
            @elseif ($order->payment_method == 'qris')
                <p class="text-center">
                    Yeay! Pembayaran sukses, Duduk manis ya, pesanan kamu segera kami proses!
                </p>
            @else
                <p class="text-center">
                    Terima kasih atas pesanan Anda!
                </p>
            @endif
            <hr>
            <a href="{{ route('menu') }}" class="btn btn-primary w-100">Kembali ke menu</a>
        </div>
    </div>
</div>
@endsection
