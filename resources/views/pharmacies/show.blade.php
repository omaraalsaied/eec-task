@extends('layouts.app')

@section('title', $pharmacy->name)

@section('content')
    <div class="container">
        <h1>{{ $pharmacy->name }}</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Address</h5>
                <p class="card-text">{{ $pharmacy->address }}</p>
            </div>
        </div>

        <h2>Products</h2>
        <div class="row">
            @forelse($pharmacy->products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('pharmacies.remove-product', $pharmacy) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No products in this pharmacy.</p>
                </div>
            @endforelse
        </div>

        <h3 class="mt-4">Add Product</h3>
        <form action="{{ route('pharmacies.add-product', $pharmacy) }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <select name="product_id" class="form-select" required>
                    <option value="">Select a product</option>
                    @foreach(App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="btn btn-warning">Edit Pharmacy</a>
            <form action="{{ route('pharmacies.destroy', $pharmacy) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pharmacy?')">Delete Pharmacy</button>
            </form>
            <a href="{{ route('pharmacies.index') }}" class="btn btn-secondary">Back to Pharmacies</a>
        </div>
    </div>
@endsection
