@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <p>${{ number_format($product->price, 2) }}</p>

        @foreach ($product->images as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" style="width: 30%; height: auto;">
        @endforeach

        @if($product->user)
            <p>Added by: {{ $product->user->name }}</p>
        @else
            <p>Added by: Unknown</p>
        @endif
        <td>
            <a href="{{ route('products.rent', $product->id) }}" class="btn btn-primary">Rent</a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </td>

    </div>

@endsection
