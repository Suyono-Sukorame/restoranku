@extends('admin.layouts.master')
@section('title', 'Orders')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatables.css') }}">
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .badge-status {
        font-size: 0.85rem;
        padding: 0.25em 0.5em;
        border-radius: 0.25rem;
    }
    @media (max-width: 576px) {
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Pesanan</h3>
                <p class="text-subtitle text-muted">Kelola semua pesanan yang masuk.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('orders.create') }}" class="btn btn-primary float-start float-lg-end">
                    <i class="bi bi-plus"></i> Tambah Pesanan
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table1" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Order</th>
                            <th>User</th>
                            <th>Subtotal</th>
                            <th>Tax</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Meja</th>
                            <th>Metode Bayar</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->fullname ?? '-' }}</td>
                            <td>{{ 'Rp' . number_format($order->subtotal, 0, ',', '.') }}</td>
                            <td>{{ 'Rp' . number_format($order->tax, 0, ',', '.') }}</td>
                            <td>{{ 'Rp' . number_format($order->grand_total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-status 
                                    {{ $order->status == 'paid' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->table_number ?? '-' }}</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td>{{ Str::limit($order->note, 20) ?? '-' }}</td>
                            <td>
                                <span. class="btn btn-sm btn-primary">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm text-white">
                                    <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </span>
                                @if (Auth::user()->role->role_name == 'admin' || Auth::user()->role->role_name == 'cashier')
                                    @if ($order->status == 'pending' && $order->payment_method == 'tunai')
                                        <form action="{{ route('orders.settlement', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check-circle"></i> Terima Pembayaran
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection
