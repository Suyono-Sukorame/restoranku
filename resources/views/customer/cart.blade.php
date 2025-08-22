@php
use Illuminate\Support\Str;
@endphp

@extends('customer.layouts.master')

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Belanja</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item active text-primary">Silahkan periksa pesanan Anda</li>
    </ol>
</div>
<!-- Single Page Header End -->

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">

        <h2 class="mb-4">Keranjang Belanja</h2>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Gambar</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotalAll = 0; @endphp

                    @forelse($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['qty'];
                            $subtotalAll += $subtotal;
                        @endphp
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    @php
                                        $imageSrc = asset('img_item_upload/no_image.jpg');
                                        if (isset($item['image'])) {
                                            if (filter_var($item['image'], FILTER_VALIDATE_URL)) {
                                                $imageSrc = $item['image'];
                                            } elseif (file_exists(public_path('img_item_upload/' . $item['image']))) {
                                                $imageSrc = asset('img_item_upload/' . $item['image']);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imageSrc }}" 
                                        class="img-fluid me-5 rounded-circle" 
                                        style="width: 80px; height: 80px;" 
                                        alt="{{ $item['name'] }}" 
                                        onerror="this.src='{{ asset('img_item_upload/no_image.jpg') }}'">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $item['name'] }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <div class="input-group quantity" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button type="button" 
                                                    class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                    onclick="updateQuantity('{{ $item['id'] }}', -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="qty-{{ $item['id'] }}" 
                                            value="{{ $item['qty'] }}" 
                                            class="form-control form-control-sm text-center border-0" readonly>
                                        <div class="input-group-btn">
                                            <button type="button" 
                                                    class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                    onclick="updateQuantity('{{ $item['id'] }}', 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-md rounded-circle bg-light border" onclick="return confirmDelete('Hapus produk ini dari keranjang?')">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Keranjang Anda masih kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($cart) > 0)
        @php
            $tax = $subtotalAll * 0.1; // contoh pajak 10%
            $total = $subtotalAll + $tax;
        @endphp

        <div class="d-flex justify-content-end">
            <a href="{{ route('cart.clear') }}" class="btn btn-danger" onclick="return confirmDelete('Apakah anda yakin ingin mengosongkan keranjang?')">Kosongkan Keranjang</a>
        </div>

        <div class="row g-4 justify-content-end mt-1">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h2 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h2>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal</h5>
                            <p class="mb-0" id="cart-subtotal">Rp {{ number_format($subtotalAll, 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 me-4">Pajak (10%)</p>
                            <div class="">
                                <p class="mb-0" id="cart-tax">Rp {{ number_format($tax, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top d-flex justify-content-between">
                        <h4 class="mb-0 ps-4 me-4">Total</h4>
                        <h5 class="mb-0 pe-4" id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="mb-3">
                        <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase mb-4" type="button">Lanjut ke Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('script')
<script>
    function confirmDelete(message) {
        return confirm(message);
    }
    
    function showToast(message, type = 'success') {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `${message} <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    
    function updateQuantity(itemId, change) {
        var qtyInput = document.getElementById('qty-' + itemId);
        var currentQty = parseInt(qtyInput.value);
        var newQty = currentQty + change;

        if (newQty <= 0) {
            if (confirm("Hapus item ini dari keranjang?")) {
                removeItemFromCart(itemId);
            }
            return;
        }

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: itemId,
                qty: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success === true) {
                qtyInput.value = newQty;
                updateCartDisplay(itemId, newQty);
                updateCartBadge();
                showToast('Jumlah item berhasil diperbarui', 'success');
            } else {
                showToast('Gagal update jumlah item', 'danger');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Terjadi kesalahan');
        });
    }


    function updateCartDisplay(itemId, newQty) {
        // Update subtotal untuk item ini
        const row = document.querySelector(`#qty-${itemId}`).closest('tr');
        const priceText = row.querySelector('td:nth-child(3) p').textContent;
        const price = parseInt(priceText.replace(/[^0-9]/g, ''));
        const newSubtotal = price * newQty;
        
        // Update total di row
        row.querySelector('td:nth-child(5) p').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newSubtotal);
        
        // Recalculate grand total
        recalculateTotal();
    }
    
    function recalculateTotal() {
        let grandSubtotal = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const totalCell = row.querySelector('td:nth-child(5) p');
            if (totalCell && totalCell.textContent.includes('Rp')) {
                const total = parseInt(totalCell.textContent.replace(/[^0-9]/g, ''));
                grandSubtotal += total;
            }
        });
        
        const tax = grandSubtotal * 0.1;
        const grandTotal = grandSubtotal + tax;
        
        // Update display menggunakan ID
        const subtotalElement = document.getElementById('cart-subtotal');
        const taxElement = document.getElementById('cart-tax');
        const totalElement = document.getElementById('cart-total');
        
        if (subtotalElement) subtotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandSubtotal);
        if (taxElement) taxElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(tax);
        if (totalElement) totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }
    
    function removeItemFromCart(itemId) {
        fetch("{{ url('/cart/remove') }}/" + itemId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success === true) {
                // Remove row from table
                const row = document.querySelector(`#qty-${itemId}`).closest('tr');
                row.remove();
                recalculateTotal();
                updateCartBadge();
                showToast('Item berhasil dihapus', 'success');
                
                // Check if cart is empty
                if (document.querySelectorAll('tbody tr').length === 0) {
                    location.reload();
                }
            } else {
                showToast('Gagal menghapus item', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat menghapus item', 'danger');
        });
    }
</script>
@endsection

