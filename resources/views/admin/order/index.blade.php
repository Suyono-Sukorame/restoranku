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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                            <th colspan="2">Aksi</th>
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
                                <!-- Badge Status -->
                                <span class="btn btn-primary btn-sm 
                                    {{ $order->status == 'paid' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning text-dark' : ($order->status == 'settlement' ? 'bg-primary text-white' : 'bg-danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->table_number ?? '-' }}</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td>{{ Str::limit($order->note, 20) ?? '-' }}</td>
                            <td>
                                <!-- Tombol Lihat -->
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info text-white mb-1">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                                <!-- Untuk Admin / Cashier -->
                            </td>
                            <td>
                                @if(in_array(Auth::user()->role->role_name, ['admin', 'cashier']))
                                    @if($order->status == 'pending' && strtolower($order->payment_method) == 'tunai')
                                        <form action="{{ route('orders.settlement', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success mb-1">
                                                <i class="bi bi-check-circle"></i> Terima Pembayaran
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <!-- Untuk Chef -->
                                @if(Auth::user()->role->role_name == 'chef')
                                    @if($order->status == 'settlement')
                                        <form action="{{ route('orders.cooked', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark mb-1">
                                                <i class="bi bi-check-circle"></i> Pesanan Siap
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
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


