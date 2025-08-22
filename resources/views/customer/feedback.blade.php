@extends('customer.layouts.master')

<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Feedback</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item active text-primary">Berikan penilaian untuk pesanan Anda</li>
    </ol>
</div>

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">Feedback Pesanan</h3>
                        <form action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Order: {{ $order->order_code }}</label>
                                <p class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                    <label for="star{{ $i }}" class="star">⭐</label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Komentar</label>
                                <textarea name="comment" class="form-control" rows="4" 
                                          placeholder="Bagaimana pengalaman Anda?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.rating input {
    display: none;
}
.rating label {
    cursor: pointer;
    font-size: 2rem;
    color: #ddd;
}
.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: #ffc107;
}
</style>
@endsection