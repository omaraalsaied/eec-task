@extends('layouts.app')

@section('title', 'Pharmacies')

@section('content')
    <div class="container">
        <h1 class="mb-4">Pharmacies</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('pharmacies.create') }}" class="btn btn-primary mb-3">Add New Pharmacy</a>

        <div class="row">
            @foreach($pharmacies as $pharmacy)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pharmacy->name }}</h5>
                            <p class="card-text">{{ $pharmacy->address }}</p>
                            <a href="{{ route('pharmacies.show', $pharmacy) }}" class="btn btn-info">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $pharmacies->links() }}
        </div>
    </div>
@endsection
