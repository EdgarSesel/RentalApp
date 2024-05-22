
{{-- In resources/views/products/index.blade.php --}}

@extends('layouts.app') {{-- Assuming you have a main layout file --}}

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-md-6">
            {{-- Search Form --}}
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h1>Products</h1>

    {{-- Sorting Dropdown --}}
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="form-group">
                    <select name="sort" class="form-control" onchange="this.form.submit()">
                        <option value="name|asc" {{ request('sort')=='name|asc' ? 'selected' : '' }}>Name Ascending</option>
                        <option value="name|desc" {{ request('sort')=='name|desc' ? 'selected' : '' }}>Name Descending</option>
                        <option value="price|asc" {{ request('sort')=='price|asc' ? 'selected' : '' }}>Price Ascending</option>
                        <option value="price|desc" {{ request('sort')=='price|desc' ? 'selected' : '' }}>Price Descending</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Products List --}}
    @foreach ($products as $product)

    <div class="row mb-4">
        <div class="col-md-4">

            {{-- Assuming you have a path to your product images --}}
            @foreach ($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" style="width: 75%; height: auto;">
            @endforeach
        </div>
        <div class="col-md-8">

            <h5><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h5>
            <p>{{ $product->description }}</p>
            <p>${{ number_format($product->price, 2) }}</p>
        </div>
    </div>
@endforeach

</div>
    <div class="d-flex justify-content-center">
        {{ $products->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
