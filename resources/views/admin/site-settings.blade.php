@extends('admin.layouts.app')

@section('title', 'Site-informations')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h3 class="fw-bold text-primary mb-2">Site Settings</h3>
            <p class="text-muted mb-0">Manage your website settings and social media links</p>
        </div>
        <button type="submit" form="settingsForm" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Save Settings
        </button>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Please fix the errors below
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Settings Form -->
    <form method="POST" action="{{ route('admin.site.update') }}" id="settingsForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            
            <!-- LEFT COLUMN: Social Media Links -->
            <div class="col-lg-6 mb-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-share me-2"></i> Social Media Links
                        </h5>
                        <p class="text-muted small mb-0">Connect your social media profiles</p>
                    </div>
                    <div class="card-body">
                        
                        <!-- Facebook -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-facebook me-2 text-primary" style="font-size: 1.2rem;"></i>
                                Facebook
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="facebook" 
                                       class="form-control border-start-0 @error('facebook') is-invalid @enderror" 
                                       value="{{ old('facebook', $site->facebook ?? '') }}" 
                                       placeholder="https://facebook.com/yourpage">
                            </div>
                            @error('facebook')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Twitter -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-twitter me-2 text-info" style="font-size: 1.2rem;"></i>
                                Twitter
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="twitter" 
                                       class="form-control border-start-0 @error('twitter') is-invalid @enderror" 
                                       value="{{ old('twitter', $site->twitter ?? '') }}" 
                                       placeholder="https://twitter.com/yourhandle">
                            </div>
                            @error('twitter')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Instagram -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-instagram me-2 text-danger" style="font-size: 1.2rem;"></i>
                                Instagram
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="instagram" 
                                       class="form-control border-start-0 @error('instagram') is-invalid @enderror" 
                                       value="{{ old('instagram', $site->instagram ?? '') }}" 
                                       placeholder="https://instagram.com/yourprofile">
                            </div>
                            @error('instagram')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- LinkedIn -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-linkedin me-2 text-primary" style="font-size: 1.2rem;"></i>
                                LinkedIn
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="linkedin" 
                                       class="form-control border-start-0 @error('linkedin') is-invalid @enderror" 
                                       value="{{ old('linkedin', $site->linkedin ?? '') }}" 
                                       placeholder="https://linkedin.com/company/yourcompany">
                            </div>
                            @error('linkedin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- YouTube -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-youtube me-2 text-danger" style="font-size: 1.2rem;"></i>
                                YouTube
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="youtube" 
                                       class="form-control border-start-0 @error('youtube') is-invalid @enderror" 
                                       value="{{ old('youtube', $site->youtube ?? '') }}" 
                                       placeholder="https://youtube.com/yourchannel">
                            </div>
                            @error('youtube')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Pinterest -->
                        <div class="mb-2">
                            <label class="form-label fw-medium d-flex align-items-center">
                                <i class="bi bi-pinterest me-2 text-danger" style="font-size: 1.2rem;"></i>
                                Pinterest
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="pinterest" 
                                       class="form-control border-start-0 @error('pinterest') is-invalid @enderror" 
                                       value="{{ old('pinterest', $site->pinterest ?? '') }}" 
                                       placeholder="https://pinterest.com/yourprofile">
                            </div>
                            @error('pinterest')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- RIGHT COLUMN: Contact Details -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-telephone me-2"></i> Contact Details
                        </h5>
                        <p class="text-muted small mb-0">Update your business contact information</p>
                    </div>
                    <div class="card-body">
                        
                        <!-- Phone Numbers -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Primary Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-phone text-primary"></i>
                                    </span>
                                    <input type="text" 
                                           name="phone_1" 
                                           class="form-control border-start-0 @error('phone_1') is-invalid @enderror" 
                                           value="{{ old('phone_1', $site->phone_1 ?? '') }}" 
                                           placeholder="+91 9876543210">
                                </div>
                                @error('phone_1')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Secondary Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-phone text-primary"></i>
                                    </span>
                                    <input type="text" 
                                           name="phone_2" 
                                           class="form-control border-start-0 @error('phone_2') is-invalid @enderror" 
                                           value="{{ old('phone_2', $site->phone_2 ?? '') }}" 
                                           placeholder="+91 9876543211">
                                </div>
                                @error('phone_2')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Email Addresses -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Support Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email" 
                                           name="email_support" 
                                           class="form-control border-start-0 @error('email_support') is-invalid @enderror" 
                                           value="{{ old('email_support', $site->email_support ?? '') }}" 
                                           placeholder="support@example.com">
                                </div>
                                @error('email_support')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Business Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email" 
                                           name="email_business" 
                                           class="form-control border-start-0 @error('email_business') is-invalid @enderror" 
                                           value="{{ old('email_business', $site->email_business ?? '') }}" 
                                           placeholder="business@example.com">
                                </div>
                                @error('email_business')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">
                                <i class="bi bi-geo-alt me-1"></i> Business Address
                            </label>
                            <textarea name="address" 
                                      class="form-control @error('address') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="Enter your complete business address">{{ old('address', $site->address ?? '') }}</textarea>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Map Location -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">
                                <i class="bi bi-map me-1"></i> Google Maps Location
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-link text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="map_location" 
                                       class="form-control border-start-0 @error('map_location') is-invalid @enderror" 
                                       value="{{ old('map_location', $site->map_location ?? '') }}" 
                                       placeholder="https://maps.google.com/?q=Your+Address">
                            </div>
                            @error('map_location')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted">Paste your Google Maps embed or share URL</small>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- Add smooth animations -->
<style>
    .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #4361ee;
    }
    
    .input-group-text {
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within .input-group-text {
        background-color: rgba(67, 97, 238, 0.1);
        border-color: #4361ee;
    }
    
    .card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }
    
    .card-header {
        border-bottom: 2px solid #f8f9fa;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Social media icon colors */
    .bi-facebook { color: #1877f2; }
    .bi-twitter { color: #1da1f2; }
    .bi-instagram { 
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .bi-linkedin { color: #0a66c2; }
    .bi-youtube { color: #ff0000; }
    .bi-pinterest { color: #e60023; }
</style>

@endsection