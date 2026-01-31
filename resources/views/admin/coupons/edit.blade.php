@extends('admin.layouts.app')

@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon: ' . $coupon->code)

@section('actions')
    <div class="btn-group btn-group-sm">
        <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-info btn-sm">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-3">
                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-2">
                        <!-- Coupon Code -->
                        <div class="col-md-6 mb-2">
                            <label for="code" class="form-label small fw-bold mb-1">Coupon Code *</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code', $coupon->code) }}" required>
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
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $coupon->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12 mb-2">
                            <label for="description" class="form-label small fw-bold mb-1">Description</label>
                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Type & Value -->
                        <div class="col-md-4 mb-2">
                            <label for="discount_type" class="form-label small fw-bold mb-1">Discount Type *</label>
                            <select class="form-select form-select-sm @error('discount_type') is-invalid @enderror" 
                                    id="discount_type" name="discount_type" required>
                                <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>
                                <option value="fixed_amount" {{ old('discount_type', $coupon->discount_type) == 'fixed_amount' ? 'selected' : '' }}>
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
                                       id="discount_value" name="discount_value" 
                                       value="{{ old('discount_value', $coupon->discount_value) }}" required>
                                <span class="input-group-text" id="discount_suffix">
                                    {{ $coupon->discount_type == 'percentage' ? '%' : '₹' }}
                                </span>
                            </div>
                            @error('discount_value')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="max_discount_amount" class="form-label small fw-bold mb-1">Max Discount (₹)</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control form-control-sm @error('max_discount_amount') is-invalid @enderror" 
                                   id="max_discount_amount" name="max_discount_amount" 
                                   value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}">
                            <small class="text-muted small">Leave empty for no limit</small>
                            @error('max_discount_amount')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Validity Dates -->
                        <div class="col-md-6 mb-2">
                            <label for="start_date" class="form-label small fw-bold mb-1">Start Date *</label>
                            <input type="date" class="form-control form-control-sm @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" 
                                   value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="end_date" class="form-label small fw-bold mb-1">End Date *</label>
                            <input type="date" class="form-control form-control-sm @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" 
                                   value="{{ old('end_date', $coupon->end_date->format('Y-m-d')) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Usage Limits -->
                        <div class="col-md-6 mb-2">
                            <label for="usage_limit" class="form-label small fw-bold mb-1">Total Usage Limit</label>
                            <input type="number" min="1" 
                                   class="form-control form-control-sm @error('usage_limit') is-invalid @enderror" 
                                   id="usage_limit" name="usage_limit" 
                                   value="{{ old('usage_limit', $coupon->usage_limit) }}">
                            <small class="text-muted small">Leave empty for unlimited usage</small>
                            @error('usage_limit')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="usage_limit_per_user" class="form-label small fw-bold mb-1">Usage Limit Per User</label>
                            <input type="number" min="1" 
                                   class="form-control form-control-sm @error('usage_limit_per_user') is-invalid @enderror" 
                                   id="usage_limit_per_user" name="usage_limit_per_user" 
                                   value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}">
                            @error('usage_limit_per_user')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Minimum Order -->
                        <div class="col-12 mb-2">
                            <label for="min_order_amount" class="form-label small fw-bold mb-1">Minimum Order Amount (₹) *</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control form-control-sm @error('min_order_amount') is-invalid @enderror" 
                                   id="min_order_amount" name="min_order_amount" 
                                   value="{{ old('min_order_amount', $coupon->min_order_amount) }}" required>
                            @error('min_order_amount')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Scopes -->
                        <div class="col-md-4 mb-2">
                            <label for="user_scope" class="form-label small fw-bold mb-1">User Scope *</label>
                            <select class="form-select form-select-sm @error('user_scope') is-invalid @enderror" 
                                    id="user_scope" name="user_scope" required>
                                <option value="all" {{ old('user_scope', $coupon->user_scope) == 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="specific" {{ old('user_scope', $coupon->user_scope) == 'specific' ? 'selected' : '' }}>Specific Users</option>
                            </select>
                            @error('user_scope')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="category_scope" class="form-label small fw-bold mb-1">Category Scope *</label>
                            <select class="form-select form-select-sm @error('category_scope') is-invalid @enderror" 
                                    id="category_scope" name="category_scope" required>
                                <option value="all" {{ old('category_scope', $coupon->category_scope) == 'all' ? 'selected' : '' }}>All Categories</option>
                                <option value="specific" {{ old('category_scope', $coupon->category_scope) == 'specific' ? 'selected' : '' }}>Specific Categories</option>
                            </select>
                            @error('category_scope')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="product_scope" class="form-label small fw-bold mb-1">Product Scope *</label>
                            <select class="form-select form-select-sm @error('product_scope') is-invalid @enderror" 
                                    id="product_scope" name="product_scope" required>
                                <option value="all" {{ old('product_scope', $coupon->product_scope) == 'all' ? 'selected' : '' }}>All Products</option>
                                <option value="specific" {{ old('product_scope', $coupon->product_scope) == 'specific' ? 'selected' : '' }}>Specific Products</option>
                            </select>
                            @error('product_scope')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Specific Users -->
                        <div class="col-12 mb-2" id="users_section" style="display: {{ $coupon->user_scope == 'specific' ? 'block' : 'none' }};">
                            <label class="form-label small fw-bold mb-1">Select Users</label>
                            <select class="form-select form-select-sm @error('users') is-invalid @enderror" 
                                    id="users" name="users[]" multiple style="height: 120px; font-size: 0.875rem;">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ in_array($user->id, old('users', $coupon->users->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                        <div class="col-12 mb-2" id="categories_section" style="display: {{ $coupon->category_scope == 'specific' ? 'block' : 'none' }};">
                            <label class="form-label small fw-bold mb-1">Select Categories</label>
                            <select class="form-select form-select-sm @error('categories') is-invalid @enderror" 
                                    id="categories" name="categories[]" multiple style="height: 120px; font-size: 0.875rem;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ in_array($category->id, old('categories', $coupon->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                        <div class="col-12 mb-2" id="products_section" style="display: {{ $coupon->product_scope == 'specific' ? 'block' : 'none' }};">
                            <label class="form-label small fw-bold mb-1">Select Products</label>
                            <select class="form-select form-select-sm @error('products') is-invalid @enderror" 
                                    id="products" name="products[]" multiple style="height: 120px; font-size: 0.875rem;">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ in_array($product->id, old('products', $coupon->products->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                                <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $coupon->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="expired" {{ old('status', $coupon->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12 mt-3 pt-2 border-top">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Update Coupon
                            </button>
                            <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-secondary btn-sm">
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
                        <div class="h4 text-primary mb-1" id="preview_code">{{ $coupon->code }}</div>
                        <h6 id="preview_name" class="mb-2">{{ $coupon->name }}</h6>
                    </div>
                    
                    <div class="mb-2">
                        <span class="small text-muted">Discount:</span>
                        <div id="preview_discount" class="fw-bold">
                            @if($coupon->discount_type == 'percentage')
                                {{ $coupon->discount_value }}%
                            @else
                                ₹{{ number_format($coupon->discount_value, 2) }}
                            @endif
                            @if($coupon->max_discount_amount)
                                <span class="text-warning small">(max ₹{{ number_format($coupon->max_discount_amount, 2) }})</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <span class="small text-muted">Minimum Order:</span>
                        <div id="preview_min_order" class="fw-bold">₹{{ number_format($coupon->min_order_amount, 2) }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <span class="small text-muted">Validity:</span>
                        <div id="preview_validity" class="fw-bold">{{ $coupon->start_date->format('d M Y') }} - {{ $coupon->end_date->format('d M Y') }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <span class="small text-muted">Usage:</span>
                        <div id="preview_usage" class="fw-bold small">
                            @if($coupon->usage_limit)
                                {{ $coupon->usage_limit }} total uses, {{ $coupon->usage_limit_per_user }} per user
                            @else
                                Unlimited
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <span class="small text-muted">Applicable To:</span>
                        <div id="preview_scope" class="fw-bold small">
                            {{ $coupon->user_scope == 'all' ? 'All users' : 'Specific users' }},
                            {{ $coupon->category_scope == 'all' ? 'All categories' : 'Specific categories' }},
                            {{ $coupon->product_scope == 'all' ? 'All products' : 'Specific products' }}
                        </div>
                    </div>
                    
                    <div class="mt-3 pt-2 border-top">
                        <span class="small text-muted">Description:</span>
                        <div id="preview_description" class="small">
                            {{ $coupon->description ?? 'No description provided.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Current Statistics -->
        <div class="card mt-3">
            <div class="card-header py-2">
                <h6 class="mb-0">Current Statistics</h6>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-primary mb-1">{{ $coupon->usages_count }}</h4>
                            <small class="text-muted">Total Uses</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success mb-1">
                                @if($coupon->usage_limit)
                                    {{ number_format(($coupon->usages_count / $coupon->usage_limit) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </h4>
                            <small class="text-muted">Usage Rate</small>
                        </div>
                    </div>
                </div>
                @if($coupon->usage_limit)
                    <div class="mt-2">
                        <div class="progress" style="height: 8px;">
                            @php
                                $usagePercentage = min(100, ($coupon->usages_count / $coupon->usage_limit) * 100);
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $usagePercentage }}%">
                            </div>
                        </div>
                        <div class="text-center small mt-1">
                            {{ $coupon->usages_count }} / {{ $coupon->usage_limit }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Help Card -->
        {{-- <div class="card mt-3">
            <div class="card-header py-2">
                <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Editing Tips</h6>
            </div>
            <div class="card-body p-3">
                <ul class="mb-0 small">
                    <li>Changing scope will <strong>reset</strong> selected items</li>
                    <li>Users can't use coupon beyond their limit</li>
                    <li>Expired coupons automatically disable</li>
                    <li>Usage stats are updated in real-time</li>
                </ul>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate coupon code
        document.getElementById('generateCode').addEventListener('click', function() {
            fetch('{{ route("admin.coupons.generate-code") }}')
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
                document.getElementById('preview_discount').innerHTML = `${value}% off`;
                if (max) {
                    document.getElementById('preview_discount').innerHTML += ` <span class="text-warning small">(max ₹${max})</span>`;
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
                    day: '2-digit', month: 'short', year: 'numeric' 
                });
                const endDate = new Date(end).toLocaleDateString('en-GB', { 
                    day: '2-digit', month: 'short', year: 'numeric' 
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