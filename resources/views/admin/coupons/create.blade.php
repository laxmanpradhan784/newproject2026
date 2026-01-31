@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('page-title', 'Create New Coupon')

@section('actions')
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-3">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf

                        <div class="row g-2">
                            <!-- Coupon Code -->
                            <div class="col-md-6 mb-2">
                                <label for="code" class="form-label small fw-bold mb-1">Coupon Code *</label>
                                <div class="input-group input-group-sm">
                                    <input type="text"
                                        class="form-control form-control-sm @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code') }}" required>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="generateCode">
                                        Generate
                                    </button>
                                </div>
                                <small class="text-muted small">Unique code customers will enter at checkout</small>
                                @error('code')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Coupon Name -->
                            <div class="col-md-6 mb-2">
                                <label for="name" class="form-label small fw-bold mb-1">Coupon Name *</label>
                                <input type="text"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-2">
                                <label for="description" class="form-label small fw-bold mb-1">Description</label>
                                <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="2">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Discount Type & Value -->
                            <div class="col-md-4 mb-2">
                                <label for="discount_type" class="form-label small fw-bold mb-1">Discount Type *</label>
                                <select class="form-select form-select-sm @error('discount_type') is-invalid @enderror"
                                    id="discount_type" name="discount_type" required>
                                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>
                                        Percentage (%)
                                    </option>
                                    <option value="fixed_amount"
                                        {{ old('discount_type') == 'fixed_amount' ? 'selected' : '' }}>
                                        Fixed Amount (₹)
                                    </option>
                                </select>
                                @error('discount_type')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="discount_value" class="form-label small fw-bold mb-1">Discount Value *</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" min="0.01"
                                        class="form-control form-control-sm @error('discount_value') is-invalid @enderror"
                                        id="discount_value" name="discount_value" value="{{ old('discount_value') }}"
                                        required>
                                    <span class="input-group-text" id="discount_suffix">%</span>
                                </div>
                                @error('discount_value')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="max_discount_amount" class="form-label small fw-bold mb-1">Max Discount
                                    (₹)</label>
                                <input type="number" step="0.01" min="0"
                                    class="form-control form-control-sm @error('max_discount_amount') is-invalid @enderror"
                                    id="max_discount_amount" name="max_discount_amount"
                                    value="{{ old('max_discount_amount') }}">
                                <small class="text-muted small">Leave empty for no limit</small>
                                @error('max_discount_amount')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Validity Dates -->
                            <div class="col-md-6 mb-2">
                                <label for="start_date" class="form-label small fw-bold mb-1">Start Date *</label>
                                <input type="date"
                                    class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                                    required>
                                @error('start_date')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="end_date" class="form-label small fw-bold mb-1">End Date *</label>
                                <input type="date"
                                    class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date"
                                    value="{{ old('end_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Usage Limits -->
                            <div class="col-md-6 mb-2">
                                <label for="usage_limit" class="form-label small fw-bold mb-1">Total Usage Limit</label>
                                <input type="number" min="1"
                                    class="form-control form-control-sm @error('usage_limit') is-invalid @enderror"
                                    id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}">
                                <small class="text-muted small">Leave empty for unlimited usage</small>
                                @error('usage_limit')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="usage_limit_per_user" class="form-label small fw-bold mb-1">Usage Limit Per
                                    User</label>
                                <input type="number" min="1"
                                    class="form-control form-control-sm @error('usage_limit_per_user') is-invalid @enderror"
                                    id="usage_limit_per_user" name="usage_limit_per_user"
                                    value="{{ old('usage_limit_per_user', 1) }}">
                                @error('usage_limit_per_user')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Minimum Order -->
                            <div class="col-12 mb-2">
                                <label for="min_order_amount" class="form-label small fw-bold mb-1">Minimum Order Amount
                                    (₹) *</label>
                                <input type="number" step="0.01" min="0"
                                    class="form-control form-control-sm @error('min_order_amount') is-invalid @enderror"
                                    id="min_order_amount" name="min_order_amount"
                                    value="{{ old('min_order_amount', 0) }}" required>
                                @error('min_order_amount')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Scopes -->
                            <div class="col-md-4 mb-2">
                                <label for="user_scope" class="form-label small fw-bold mb-1">User Scope *</label>
                                <select class="form-select form-select-sm @error('user_scope') is-invalid @enderror"
                                    id="user_scope" name="user_scope" required>
                                    <option value="all" {{ old('user_scope') == 'all' ? 'selected' : '' }}>All Users
                                    </option>
                                    <option value="specific" {{ old('user_scope') == 'specific' ? 'selected' : '' }}>
                                        Specific Users</option>
                                </select>
                                @error('user_scope')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="category_scope" class="form-label small fw-bold mb-1">Category Scope *</label>
                                <select class="form-select form-select-sm @error('category_scope') is-invalid @enderror"
                                    id="category_scope" name="category_scope" required>
                                    <option value="all" {{ old('category_scope') == 'all' ? 'selected' : '' }}>All
                                        Categories</option>
                                    <option value="specific" {{ old('category_scope') == 'specific' ? 'selected' : '' }}>
                                        Specific Categories</option>
                                </select>
                                @error('category_scope')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="product_scope" class="form-label small fw-bold mb-1">Product Scope *</label>
                                <select class="form-select form-select-sm @error('product_scope') is-invalid @enderror"
                                    id="product_scope" name="product_scope" required>
                                    <option value="all" {{ old('product_scope') == 'all' ? 'selected' : '' }}>All
                                        Products</option>
                                    <option value="specific" {{ old('product_scope') == 'specific' ? 'selected' : '' }}>
                                        Specific Products</option>
                                </select>
                                @error('product_scope')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Specific Users -->
                            <div class="col-12 mb-2" id="users_section" style="display: none;">
                                <label class="form-label small fw-bold mb-1">Select Users</label>
                                <select class="form-select form-select-sm @error('users') is-invalid @enderror"
                                    id="users" name="users[]" multiple style="height: 120px; font-size: 0.875rem;">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted small">Hold Ctrl to select multiple users</small>
                                @error('users')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Specific Categories -->
                            <div class="col-12 mb-2" id="categories_section" style="display: none;">
                                <label class="form-label small fw-bold mb-1">Select Categories</label>
                                <select class="form-select form-select-sm @error('categories') is-invalid @enderror"
                                    id="categories" name="categories[]" multiple
                                    style="height: 120px; font-size: 0.875rem;">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted small">Hold Ctrl to select multiple categories</small>
                                @error('categories')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Specific Products -->
                            <div class="col-12 mb-2" id="products_section" style="display: none;">
                                <label class="form-label small fw-bold mb-1">Select Products</label>
                                <select class="form-select form-select-sm @error('products') is-invalid @enderror"
                                    id="products" name="products[]" multiple
                                    style="height: 120px; font-size: 0.875rem;">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                                            {{ $product->name }} (₹{{ number_format($product->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted small">Hold Ctrl to select multiple products</small>
                                @error('products')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-2">
                                <label for="status" class="form-label small fw-bold mb-1">Status *</label>
                                <select class="form-select form-select-sm @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-3 pt-2 border-top">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Create Coupon
                                </button>
                                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-sm">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header py-2">
                    <h6 class="mb-0">Coupon Preview</h6>
                </div>
                <div class="card-body p-3">
                    <div class="coupon-preview">
                        <div class="text-center mb-2">
                            <div class="h4 text-primary mb-1" id="preview_code">COUPON_CODE</div>
                            <h6 id="preview_name" class="mb-2">Coupon Name</h6>
                        </div>

                        <div class="mb-2">
                            <span class="small text-muted">Discount:</span>
                            <div id="preview_discount" class="fw-bold">10% off</div>
                        </div>

                        <div class="mb-2">
                            <span class="small text-muted">Minimum Order:</span>
                            <div id="preview_min_order" class="fw-bold">₹0.00</div>
                        </div>

                        <div class="mb-2">
                            <span class="small text-muted">Validity:</span>
                            <div id="preview_validity" class="fw-bold">01 Jan 2024 - 31 Dec 2024</div>
                        </div>

                        <div class="mb-2">
                            <span class="small text-muted">Usage:</span>
                            <div id="preview_usage" class="fw-bold">Unlimited</div>
                        </div>

                        <div class="mb-2">
                            <span class="small text-muted">Applicable To:</span>
                            <div id="preview_scope" class="fw-bold small">All users, categories & products</div>
                        </div>

                        <div class="mt-3 pt-2 border-top">
                            <span class="small text-muted">Description:</span>
                            <div id="preview_description" class="small">
                                No description provided.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-3">
                <div class="card-header py-2">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Quick Tips</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="mb-0 small">
                        <li>Use <strong>Percentage</strong> for % off discounts</li>
                        <li>Use <strong>Fixed Amount</strong> for flat ₹ discounts</li>
                        <li>Set <strong>Max Discount</strong> to limit % discounts</li>
                        <li>Leave usage limit empty for unlimited</li>
                        <li>All dates are inclusive</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate coupon code
            document.getElementById('generateCode').addEventListener('click', function() {
                fetch('{{ route('admin.coupons.generate-code') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('code').value = data.code;
                        updatePreview();
                    });
            });

            // Toggle scope sections
            document.getElementById('user_scope').addEventListener('change', toggleScopeSections);
            document.getElementById('category_scope').addEventListener('change', toggleScopeSections);
            document.getElementById('product_scope').addEventListener('change', toggleScopeSections);

            // Update preview on input change
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            function toggleScopeSections() {
                // User scope
                if (document.getElementById('user_scope').value === 'specific') {
                    document.getElementById('users_section').style.display = 'block';
                } else {
                    document.getElementById('users_section').style.display = 'none';
                }

                // Category scope
                if (document.getElementById('category_scope').value === 'specific') {
                    document.getElementById('categories_section').style.display = 'block';
                } else {
                    document.getElementById('categories_section').style.display = 'none';
                }

                // Product scope
                if (document.getElementById('product_scope').value === 'specific') {
                    document.getElementById('products_section').style.display = 'block';
                } else {
                    document.getElementById('products_section').style.display = 'none';
                }
            }

            function updatePreview() {
                // Code
                const code = document.getElementById('code').value || 'COUPON_CODE';
                document.getElementById('preview_code').textContent = code;

                // Name
                const name = document.getElementById('name').value || 'Coupon Name';
                document.getElementById('preview_name').textContent = name;

                // Discount
                const type = document.getElementById('discount_type').value;
                const value = document.getElementById('discount_value').value || '0';
                const max = document.getElementById('max_discount_amount').value;

                if (type === 'percentage') {
                    document.getElementById('preview_discount').textContent = `${value}% off`;
                    if (max) {
                        document.getElementById('preview_discount').textContent += ` (max ₹${max})`;
                    }
                } else {
                    document.getElementById('preview_discount').textContent = `₹${value} off`;
                }

                // Min Order
                const min = document.getElementById('min_order_amount').value || '0';
                document.getElementById('preview_min_order').textContent = `₹${min}`;

                // Validity
                const start = document.getElementById('start_date').value;
                const end = document.getElementById('end_date').value;
                if (start && end) {
                    const startDate = new Date(start).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                    const endDate = new Date(end).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                    document.getElementById('preview_validity').textContent = `${startDate} - ${endDate}`;
                }

                // Usage
                const limit = document.getElementById('usage_limit').value;
                const perUser = document.getElementById('usage_limit_per_user').value || '1';
                let usageText = 'Unlimited';
                if (limit) {
                    usageText = `${limit} total uses`;
                    if (perUser && perUser > 1) {
                        usageText += `, ${perUser} per user`;
                    }
                }
                document.getElementById('preview_usage').textContent = usageText;

                // Scope
                let scopeParts = [];
                if (document.getElementById('user_scope').value === 'specific') {
                    scopeParts.push('Specific users');
                } else {
                    scopeParts.push('All users');
                }

                if (document.getElementById('category_scope').value === 'specific') {
                    scopeParts.push('Specific categories');
                } else {
                    scopeParts.push('All categories');
                }

                if (document.getElementById('product_scope').value === 'specific') {
                    scopeParts.push('Specific products');
                } else {
                    scopeParts.push('All products');
                }

                document.getElementById('preview_scope').textContent = scopeParts.join(', ');

                // Description
                const desc = document.getElementById('description').value;
                document.getElementById('preview_description').textContent = desc || 'No description provided.';

                // Update discount suffix
                document.getElementById('discount_suffix').textContent = type === 'percentage' ? '%' : '₹';
            }

            // Initialize
            toggleScopeSections();
            updatePreview();
        });
    </script>
@endpush
