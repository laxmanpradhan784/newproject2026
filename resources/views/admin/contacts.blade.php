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

        <!-- Messages Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr class="bg-light bg-gradient border-bottom border-3">
                                <th class="ps-4 py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-person text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Name</span>
                                            <small class="text-muted">Contact</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-envelope text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Email</span>
                                            <small class="text-muted">Address</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-chat-left-text text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Subject</span>
                                            <small class="text-muted">Topic</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 35%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-card-text text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Message</span>
                                            <small class="text-muted">Content</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 10%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-calendar text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Date</span>
                                            <small class="text-muted">Received</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="pe-4 py-3 align-middle fw-semibold text-dark text-end" style="width: 10%;">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-gear text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column text-end">
                                            <span class="fw-semibold">Actions</span>
                                            <small class="text-muted">Manage</small>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <td class="ps-4 py-3 align-middle">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 42px; height: 42px;">
                                                <i class="bi bi-person fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark mb-1">{{ $contact->name }}</div>
                                                @if ($contact->phone)
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="bi bi-telephone text-muted small"></i>
                                                        <small class="text-muted">{{ $contact->phone }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <a href="mailto:{{ $contact->email }}"
                                            class="text-decoration-none d-flex align-items-center gap-3 p-2 rounded-3 hover-bg-light"
                                            style="transition: all 0.2s;">
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 42px; height: 42px;">
                                                <i class="bi bi-envelope fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark mb-1">{{ $contact->email }}</div>
                                            </div>
                                        </a>
                                    </td>

                                    <style>
                                        .hover-bg-light:hover {
                                            background-color: rgba(0, 0, 0, 0.03);
                                        }
                                    </style>
                                    <td class="py-3 align-middle">
                                        <div class="d-flex flex-column">
                                            <span
                                                class="badge bg-secondary bg-opacity-10 text-dark border border-secondary py-2 px-3 mb-1">
                                                <i class="bi me-1"></i>
                                                {{ Str::limit($contact->subject, 20) }}
                                            </span>
                                            @if (strlen($contact->subject) > 20)
                                                <small class="text-muted" data-bs-toggle="tooltip"
                                                    data-bs-title="{{ $contact->subject }}">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Full subject on hover
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <div class="message-preview">
                                            <div class="d-flex align-items-start gap-2">
                                                <i class="bi bi-chat-left-quote text-muted mt-1 flex-shrink-0"></i>
                                                <div>
                                                    <span
                                                        class=" badge bg-secondary bg-opacity-10 text-dark border border-secondary py-2 px-3 mb-1 text-dark">{{ Str::limit($contact->message, 80) }}</span>
                                                    @if (strlen($contact->message) > 80)
                                                        <button type="button"
                                                            class="btn btn-link btn-sm text-primary p-0 ms-1"
                                                            data-bs-toggle="modal" data-bs-target="#viewMessageModal"
                                                            onclick="viewMessage({{ json_encode($contact) }})">
                                                            <i class="bi bi-chevron-right ms-1"></i>Read more
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="bg-light border rounded-pill py-2 px-3 mb-2">
                                                <div class="text-center">
                                                    <div class="fw-semibold text-dark">
                                                        {{ $contact->created_at->format('d M') }}</div>
                                                    <small
                                                        class="text-muted">{{ $contact->created_at->format('Y') }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="bi bi-clock text-muted"></i>
                                                <small
                                                    class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#viewMessageModal"
                                                onclick="viewMessage({{ json_encode($contact) }})">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteMessageModal"
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
    <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel"
        aria-hidden="true">
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
                            <p class="text-muted">This message will be permanently deleted. This action cannot be undone.
                            </p>
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
            document.getElementById('replyEmail').href =
                `mailto:${contact.email}?subject=Re: ${encodeURIComponent(contact.subject)}`;
        }

        function setDeleteId(id) {
            const form = document.getElementById('deleteMessageForm');
            form.action = '{{ route('admin.contacts.delete', ':id') }}'.replace(':id', id);
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
