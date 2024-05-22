<!-- resources/views/user_products.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>User's Products</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (count($products) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>In Stock</th>
                    <th>Rents</th> <!-- Add 'Status' column -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->in_stock}}</td>
                        <td>
                            @if($product->rents->count() > 0) <!-- Check if product has any rents -->
                                @foreach($product->rents as $rent) <!-- Loop through rents -->
                                    {{ $rent->rent_start_date }} - {{ $rent->rent_end_date }}<br> <!-- Display rent dates -->
                                @endforeach
                            @else
                                No rents yet <!-- Display 'Available' if product has no rents -->
                            @endif
                        </td>
                        <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>

                @endforeach
                <td>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </td>
            </tbody>
        </table>
    @else
        <p>No products found</p>
        <td>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </td>
    @endif
@endsection
