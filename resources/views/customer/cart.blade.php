@extends('customer.layouts.master')

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
                                    @if(!empty($item['image']))
                                        <img src="{{ asset('img_item_upload/' . $item['image']) }}" 
                                            class="img-fluid me-5 rounded-circle" 
                                            style="width: 80px; height: 80px;" 
                                            alt="{{ $item['name'] }}">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" 
                                            class="img-fluid me-5 rounded-circle" 
                                            style="width: 80px; height: 80px;" 
                                            alt="No Image">
                                    @endif
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $item['name'] }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center mt-4" style="width: 120px;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm w-50 me-2">
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </form>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-md rounded-circle bg-light border" onclick="return confirm('Hapus produk ini dari keranjang?')">
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

        <div class="row g-4 justify-content-end mt-1">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h2 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h2>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal</h5>
                            <p class="mb-0">Rp {{ number_format($subtotalAll, 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 me-4">Pajak (10%)</p>
                            <div class="">
                                <p class="mb-0">Rp {{ number_format($tax, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top d-flex justify-content-between">
                        <h4 class="mb-0 ps-4 me-4">Total</h4>
                        <h5 class="mb-0 pe-4">Rp {{ number_format($total, 0, ',', '.') }}</h5>
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
    function updateQuantity(itemId, change) {
        var qtyInput = document.getElementById('qty-' + itemId);
        var currentQty = parseInt(qtyInput.value);
        var newQty = currentQty + change;

        if (newQty <= 0) {
            if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
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
                location.reload();
            } else {
                alert('Gagal memperbarui keranjang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
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
                location.reload();
            } else {
                alert('Gagal menghapus item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus item');
        });
    }
</script>
@endsection

