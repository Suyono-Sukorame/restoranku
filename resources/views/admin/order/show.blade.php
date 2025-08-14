@extends('admin.layouts.master')
@section('title', 'Detail Order')

@section('css')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .thumbnail-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #dee2e6;
    }
    .badge-status {
        font-size: 0.85rem;
        padding: 0.25em 0.5em;
        border-radius: 0.25rem;
    }
    .totals-row td {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Order: {{ $order->order_code }}</h3>
                <p class="text-subtitle text-muted">Informasi lengkap order dan item terkait.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary float-start float-lg-end">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Informasi Order</h5>
                <p><strong>User:</strong> {{ $order->user->fullname ?? '-' }}</p>
                <p><strong>Meja:</strong> {{ $order->table_number ?? '-' }}</p>
                <p><strong>Metode Bayar:</strong> {{ $order->payment_method ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge badge-status 
                        {{ $order->status == 'paid' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Catatan:</strong> {{ $order->note ?? '-' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <h5>Item Order</h5>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Item</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img 
                                    src="{{ $item->item->img && file_exists(public_path('assets/img/' . $item->item->img)) 
                                        ? asset('assets/img/' . $item->item->img) 
                                        : 'https://source.unsplash.com/60x60/?food' }}" 
                                    class="thumbnail-img"
                                    alt="Image of {{ $item->item->name ?? 'Item' }}">
                            </td>
                            <td>{{ $item->item->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ 'Rp' . number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ 'Rp' . number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach

                        <!-- Subtotal, Tax, Grand Total -->
                        <tr class="totals-row">
                            <td colspan="5" class="text-end">Subtotal:</td>
                            <td>{{ 'Rp' . number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="totals-row">
                            <td colspan="5" class="text-end">Tax:</td>
                            <td>{{ 'Rp' . number_format($order->tax, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="totals-row">
                            <td colspan="5" class="text-end">Grand Total:</td>
                            <td>{{ 'Rp' . number_format($order->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection
