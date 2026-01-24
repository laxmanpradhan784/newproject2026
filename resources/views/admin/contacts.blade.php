@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Contact Messages</h3>
            <p class="text-muted mb-0">Manage customer inquiries and messages</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary me-2">
                <i class="bi bi-envelope me-1"></i>
                {{ $contacts->count() }} Messages
            </span>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Messages Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="border-0 ps-4" style="width: 15%;">Name</th>
                            <th class="border-0" style="width: 15%;">Email</th>
                            <th class="border-0" style="width: 15%;">Subject</th>
                            <th class="border-0" style="width: 35%;">Message</th>
                            <th class="border-0" style="width: 10%;">Date</th>
                            <th class="border-0 text-end pe-4" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr>
                            <td class="ps-4 pt-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $contact->name }}</div>
                                        @if($contact->phone)
                                        <small class="text-muted">{{ $contact->phone }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-dark">
                                    {{ Str::limit($contact->subject, 20) }}
                                </span>
                            </td>
                            <td>
                                <div class="message-preview">
                                    {{ Str::limit($contact->message, 80) }}
                                    @if(strlen($contact->message) > 80)
                                    <button type="button" class="btn btn-link btn-sm p-0 ms-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewMessageModal"
                                            onclick="viewMessage({{ json_encode($contact) }})">
                                        Read more
                                    </button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $contact->created_at->format('d M Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewMessageModal"
                                            onclick="viewMessage({{ json_encode($contact) }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteMessageModal"
                                            onclick="setDeleteId({{ $contact->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5">
                                    <i class="bi bi-envelope text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-3">No contact messages found</p>
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

<!-- View Message Modal -->
<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMessageModalLabel">
                    <i class="bi bi-envelope me-2"></i>
                    Message Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Sender Information</h6>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-person" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0" id="viewName"></h5>
                                        <div id="viewEmail" class="text-muted"></div>
                                        <small class="text-muted" id="viewPhone"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Message Details</h6>
                                <div class="mb-2">
                                    <strong>Subject:</strong>
                                    <span id="viewSubject" class="ms-2"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Date:</strong>
                                    <span id="viewDate" class="ms-2"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Time:</strong>
                                    <span id="viewTime" class="ms-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Message Content</h6>
                    </div>
                    <div class="card-body">
                        <div class="message-content p-3 bg-light rounded" id="viewMessageContent">
                            <!-- Message will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="replyEmail" class="btn btn-primary">
                    <i class="bi bi-reply me-1"></i>
                    Reply via Email
                </a>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Message Modal -->
<div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="{{ route('admin.contacts.delete', ':id') }}" id="deleteMessageForm">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteMessageModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-trash-fill text-danger" style="font-size: 64px;"></i>
                        <h5 class="mt-3">Delete Message?</h5>
                        <p class="text-muted">This message will be permanently deleted. This action cannot be undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" onclick="confirmDeleteMessage()">
                        <i class="bi bi-trash me-1"></i>
                        Delete Message
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function viewMessage(contact) {
    // Set sender information
    document.getElementById('viewName').textContent = contact.name;
    document.getElementById('viewEmail').textContent = contact.email;
    document.getElementById('viewEmail').innerHTML = `<a href="mailto:${contact.email}">${contact.email}</a>`;
    document.getElementById('viewPhone').textContent = contact.phone ? `Phone: ${contact.phone}` : '';
    
    // Set message details
    document.getElementById('viewSubject').textContent = contact.subject;
    document.getElementById('viewDate').textContent = new Date(contact.created_at).toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
    document.getElementById('viewTime').textContent = new Date(contact.created_at).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Set message content with line breaks
    document.getElementById('viewMessageContent').textContent = contact.message;
    
    // Set reply email link
    document.getElementById('replyEmail').href = `mailto:${contact.email}?subject=Re: ${encodeURIComponent(contact.subject)}`;
}

function setDeleteId(id) {
    const form = document.getElementById('deleteMessageForm');
    form.action = '{{ route("admin.contacts.delete", ":id") }}'.replace(':id', id);
}

function confirmDeleteMessage() {
    const form = document.getElementById('deleteMessageForm');
    window.location.href = form.action;
}
</script>

<style>
.message-preview {
    line-height: 1.5;
    max-height: 60px;
    overflow: hidden;
}

.message-content {
    white-space: pre-wrap;
    word-wrap: break-word;
    line-height: 1.6;
}

.card.border-0.bg-light {
    background-color: #f8f9fa !important;
}
</style>

@endsection