@extends('customer.layouts.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Keranjang Belanja</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp

                @forelse(session('cart', []) as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" width="60" class="me-3 rounded">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="60" class="me-3 rounded">
                                @endif
                                <span>{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm w-50 me-2">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini dari keranjang?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Keranjang Anda masih kosong</td>
                    </tr>
                @endforelse
            </tbody>

            @if(!empty(session('cart')))
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th colspan="2">Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('menu') }}" class="btn btn-outline-primary">Lanjutkan Belanja</a>
        @if(!empty(session('cart')))
            <a href="{{ route('checkout') }}" class="btn btn-success">Lanjut ke Checkout</a>
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

