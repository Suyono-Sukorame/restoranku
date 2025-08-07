@extends('customer.layouts.master')

@section('content')

      <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-3">
                            <div class="col-lg">
                                <div class="row g-4 justify-content-center">

                                    @foreach ($items as $item)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ $item->img ? asset('img_item_upload/' . $item->img) : asset('img_item_upload/no_image.jpg') }}" 
                                                    class="img-fluid w-100 rounded-top" 
                                                    alt="Image of {{ $item->name ?? 'Item' }}" 
                                                    onerror="this.onerror=null;this.src='{{ asset($item->img) }}';">
                                            </div>
                                            @php
                                                $badgeClass = 'bg-primary';

                                                if ($item->category->cat_name == 'Makanan') {
                                                    $badgeClass = 'bg-warning';
                                                } elseif ($item->category->cat_name == 'Minuman') {
                                                    $badgeClass = 'bg-info';
                                                }
                                            @endphp

                                            <div class="text-white px-3 py-1 rounded position-absolute {{ $badgeClass }}" style="top: 10px; left: 10px;">
                                                {{ $item->category->cat_name }}
                                            </div>

                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $item->name }}</h4>
                                                <p class="text-limited">{{ $item->description }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ 'Rp' . number_format($item->price, 0, ',', '.') }}</p>
                                                    <a href="javascript:void(0);" onclick="addToCart({{ $item->id }})" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah Keranjang
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->


@endsection