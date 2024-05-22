<!-- resources/views/products/my.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Products</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($products->isEmpty())
            <p>You have not added any products yet.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <td>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </td>
    </div>
@endsection
