@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Properties</h4>
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Property
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($properties->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($properties as $property)
                                        <tr>
                                            <td>
                                                @if($property->image)
                                                    <img src="{{ asset('storage/images/' . $property->image) }}" 
                                                         alt="{{ $property->name }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 80px; height: 60px;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $property->name }}</td>
                                            <td>{{ $property->address ?? 'N/A' }}</td>
                                            <td>${{ number_format($property->price ?? 0, 2) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('properties.show', $property->id) }}" 
                                                       class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('properties.edit', $property->id) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Delete"
                                                            onclick="confirmDelete({{ $property->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <form id="delete-form-{{ $property->id }}" 
                                                      action="{{ route('properties.destroy', $property->id) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $properties->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-home fa-3x text-muted mb-3"></i>
                            <h5>No properties found</h5>
                            <p class="text-muted">Create your first property to get started.</p>
                            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Property
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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