@extends('admin.layouts.app')

@section('title', 'Home Sliders')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-primary mb-1">Home Page Sliders</h3>
            <p class="text-muted mb-0">Manage your homepage slider content</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSliderModal">
            <i class="bi bi-plus-circle me-1"></i>
            Add New Slider
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

   <!-- Sliders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="border-0 ps-4" style="width: 100px;">Preview</th>
                            <th class="border-0">Title</th>
                            <th class="border-0">Subtitle</th>
                            <th class="border-0">Button</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="border-0 text-end pe-4" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                        <tr class="hover-row">
                            <td class="ps-4 pt-3">
                                <div class="position-relative" style="width: 80px; height: 60%;">
                                    @if(file_exists(public_path('uploads/sliders/'.$slider->image)))
                                    <img src="{{ asset('uploads/sliders/'.$slider->image) }}" 
                                         class="rounded border" 
                                         style="width: 100%; height: 100%; object-fit: cover;"
                                         alt="{{ $slider->title }}">
                                    @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" 
                                         style="width: 100%; height: 100%;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    @endif
                                    @if($slider->status == 'active')
                                    <span class="badge bg-success position-absolute top-0 start-0 translate-middle">
                                        <i class="bi bi-check"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $slider->title }}</div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ Str::limit($slider->subtitle, 40) }}</div>
                            </td>
                            <td>
                                @if($slider->button_text)
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $slider->button_text }}
                                </span>
                                @else
                                <span class="text-muted small">No button</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $slider->status == 'active' ? 'bg-success' : 'bg-secondary' }} py-1 px-3">
                                    {{ ucfirst($slider->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSliderModal"
                                            onclick="editSlider({{ json_encode($slider) }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteSliderModal"
                                            onclick="setDeleteId({{ $slider->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5">
                                    <i class="bi bi-images text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-3">No sliders found. Add your first slider!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Add Slider Modal -->
<div class="modal fade" id="addSliderModal" tabindex="-1" aria-labelledby="addSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data" id="addSliderForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSliderModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add New Slider
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter slider title" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="Enter slider subtitle">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control" placeholder="e.g., Shop Now">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Link</label>
                            <input type="url" name="button_link" class="form-control" placeholder="https://example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slider Image *</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Recommended size: 1920x800px</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Add Slider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slider Modal -->
<div class="modal fade" id="editSliderModal" tabindex="-1" aria-labelledby="editSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sliders.update') }}" enctype="multipart/form-data" id="editSliderForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editSliderId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSliderModalLabel">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Slider
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" id="editSubtitle" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" id="editButtonText" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Link</label>
                            <input type="url" name="button_link" id="editButtonLink" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slider Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Current Image</label>
                            <div class="current-image-preview border rounded p-3 text-center bg-light">
                                <img id="currentImage" src="" alt="Current Image" 
                                     style="max-height: 150px; max-width: 100%;" class="rounded">
                                <div class="mt-2" id="noImageMessage" style="display: none;">
                                    <i class="bi bi-image text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted">No image uploaded</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Update Slider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSliderModal" tabindex="-1" aria-labelledby="deleteSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sliders.delete', ':id') }}" id="deleteSliderForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteSliderModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-trash-fill text-danger" style="font-size: 64px;"></i>
                        <h5 class="mt-3">Are you sure?</h5>
                        <p class="text-muted">This slider will be permanently deleted. This action cannot be undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Slider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-row:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.03);
        transition: background-color 0.2s ease;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .badge.bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .current-image-preview {
        background-color: #f8f9fa;
        min-height: 100px;
    }
    
    .btn-outline-primary, .btn-outline-danger {
        border-width: 1px;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-sm i {
        font-size: 14px;
    }
</style>
<style>
.table-responsive::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
function editSlider(slider) {
    // Set form values
    document.getElementById('editSliderId').value = slider.id;
    document.getElementById('editTitle').value = slider.title;
    document.getElementById('editSubtitle').value = slider.subtitle || '';
    document.getElementById('editButtonText').value = slider.button_text || '';
    document.getElementById('editButtonLink').value = slider.button_link || '';
    document.getElementById('editStatus').value = slider.status;
    
    // Set current image preview
    const imageUrl = '{{ asset("uploads/sliders/") }}/' + slider.image;
    const imageElement = document.getElementById('currentImage');
    const noImageMessage = document.getElementById('noImageMessage');
    
    // Check if image exists
    fetch(imageUrl)
        .then(response => {
            if (response.ok) {
                imageElement.src = imageUrl;
                imageElement.style.display = 'block';
                noImageMessage.style.display = 'none';
            } else {
                imageElement.style.display = 'none';
                noImageMessage.style.display = 'block';
            }
        })
        .catch(() => {
            imageElement.style.display = 'none';
            noImageMessage.style.display = 'block';
        });
}

function setDeleteId(id) {
    const form = document.getElementById('deleteSliderForm');
    form.action = '{{ route("admin.sliders.delete", ":id") }}'.replace(':id', id);
}

// Clear form when add modal is closed
document.getElementById('addSliderModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('addSliderForm').reset();
});

// Show image preview for file inputs
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            const parentDiv = this.closest('.col-md-6');
            let preview = parentDiv.querySelector('.image-preview');
            
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'image-preview mt-2';
                parentDiv.appendChild(preview);
            }
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 150px;" class="rounded border">`;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection