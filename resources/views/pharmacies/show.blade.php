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
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price in This Pharmacy</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pharmacy->products as $product)
                        <tr>
                            <td> <a href="{{ route('products.show', $product) }}">{{ $product->title }} </a></td>
                            <td>{{ Str::limit($product->description, 100) }}</td>
                            <td>${{ number_format($product->pivot->price, 2) }}</td>
                            <td>
                                <form action="{{ route('pharmacies.remove-product', $pharmacy) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this product?')">Remove</button>
                                </form>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPriceModal{{ $product->id }}">
                                    Edit Price
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Price Modal -->
                        <div class="modal fade" id="editPriceModal{{ $product->id }}" tabindex="-1" aria-labelledby="editPriceModalLabel{{ $product->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPriceModalLabel{{ $product->id }}">Edit Price for {{ $product->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('pharmacies.update-product-price', [$pharmacy, $product]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="price{{ $product->id }}" class="form-label">New Price</label>
                                                <input type="number" class="form-control" id="price{{ $product->id }}" name="price" value="{{ $product->pivot->price }}" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update Price</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4">No products in this pharmacy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @php
            $existing_products = $pharmacy->products->pluck('id')->toArray();
            $availableProducts = \App\Models\Product::whereNotIn('id', $existing_products)->get();
        @endphp

        <h3 class="mt-4">Add Product</h3>
        <form action="{{ route('pharmacies.add-product', $pharmacy) }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <select name="product_id" class="form-select" required>
                    <option value="">Select a product</option>
                    @foreach($availableProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <div class="col-md-4">
                    <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" required>
                </div>
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
