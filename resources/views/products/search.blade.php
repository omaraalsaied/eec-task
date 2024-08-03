@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results for "{{ $query }}"</h1>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> <a href="{{route('products.show', $product)}}"> {{ $product->title }} </a></h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <!-- Add more product details as needed -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $products->appends(['query' => $query])->links() }}
    @else
        <p>No products found.</p>
    @endif
</div>
@endsection
