@extends('layouts.app')

@section('title', isset($pharmacy) ? 'Edit Pharmacy' : 'Create Pharmacy')

@section('content')
    <div class="container">
        <h1>{{ isset($pharmacy) ? 'Edit Pharmacy' : 'Create Pharmacy' }}</h1>

        <form action="{{ isset($pharmacy) ? route('pharmacies.update', $pharmacy) : route('pharmacies.store') }}" method="POST">
            @csrf
            @if(isset($pharmacy))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $pharmacy->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $pharmacy->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($pharmacy) ? 'Update' : 'Create' }} Pharmacy</button>
            <a href="{{ route('pharmacies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
