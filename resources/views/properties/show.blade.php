@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $property->name }}</h4>
                    <div>
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $property->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($property->image)
                                <img src="{{ asset('storage/images/' . $property->image) }}" 
                                     alt="{{ $property->name }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 300px;">
                                    <i class="fas fa-home fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Property Details</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $property->name }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $property->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>${{ number_format($property->price ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $property->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Description</h5>
                        <p>{{ $property->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-form-{{ $property->id }}" 
      action="{{ route('properties.destroy', $property->id) }}" 
      method="POST" 
      style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function confirmDelete(propertyId) {
    if (confirm('Are you sure you want to delete this property? This action cannot be undone.')) {
        document.getElementById('delete-form-' + propertyId).submit();
    }
}
</script>
@endpush
@endsection