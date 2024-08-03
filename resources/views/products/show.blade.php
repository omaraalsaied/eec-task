@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image_url }}" class="img-fluid rounded" alt="{{ $product->title }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->title }}</h1>
            <p class="lead">{{ $product->description }}</p>
            <hr>
            <p><strong>Base Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Quantity in Stock:</strong> {{ $product->quantity }}</p>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit Product</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2>Availability in Pharmacies</h2>
            @if($product->pharmacies->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pharmacy Name</th>
                            <th>Address</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->pharmacies as $pharmacy)
                            <tr>
                                <td>{{ $pharmacy->name }}</td>
                                <td>{{ $pharmacy->address }}</td>
                                <td>${{ number_format($pharmacy->pivot->price ?? $product->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>This product is not available in any pharmacies.</p>
            @endif
        </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2>Product Details</h2>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $product->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ number_format($product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $product->created_at->format('F j, Y, g:i a') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $product->updated_at->format('F j, Y, g:i a') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
</div>
@endsection
