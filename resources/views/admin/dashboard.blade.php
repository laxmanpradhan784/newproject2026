@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-gradient text-primary mb-1">Dashboard Overview</h3>
            <p class="text-muted mb-0">Statistics from the last 30 days</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark">
                <iconify-icon icon="uil:calender" class="me-1"></iconify-icon>
                {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">
        
        <!-- Total Categories -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="p-3 rounded-circle bg-gradient-primary bg-opacity-10">
                            <iconify-icon icon="material-symbols:category" class="text-primary" style="font-size: 24px;"></iconify-icon>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary">+12%</span>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalCategories }}</h2>
                    <p class="text-muted mb-2">Categories</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                        Last 30 days
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="p-3 rounded-circle bg-gradient-success bg-opacity-10">
                            <iconify-icon icon="bi:box-seam" class="text-success" style="font-size: 24px;"></iconify-icon>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success">+24%</span>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalProducts }}</h2>
                    <p class="text-muted mb-2">Products</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                        Last 30 days
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Sliders -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="p-3 rounded-circle bg-gradient-warning bg-opacity-10">
                            <iconify-icon icon="ic:outline-slider" class="text-warning" style="font-size: 24px;"></iconify-icon>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning bg-opacity-10 text-warning">+8%</span>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalSliders }}</h2>
                    <p class="text-muted mb-2">Sliders</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"></div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                        Last 30 days
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="p-3 rounded-circle bg-gradient-info bg-opacity-10">
                            <iconify-icon icon="bi:people" class="text-info" style="font-size: 24px;"></iconify-icon>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info bg-opacity-10 text-info">+18%</span>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalUsers }}</h2>
                    <p class="text-muted mb-2">Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 70%"></div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                        Last 30 days
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Enquiries -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-circle bg-gradient-danger bg-opacity-10 me-3">
                                <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-danger" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">{{ $totalContacts }}</h2>
                                <p class="text-muted mb-0">Enquiries</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger bg-opacity-10 text-danger">+15%</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <small class="text-muted">
                                <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                                Last 30 days
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="text-success fw-medium">↑ 15% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100 card-hover bg-gradient-primary text-white">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-3">Performance Summary</h5>
                        <p class="mb-4 opacity-75">Overall platform growth in the last 30 days shows positive trends across all metrics.</p>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">{{ $totalCategories + $totalProducts + $totalSliders + $totalUsers + $totalContacts }}</h4>
                            <small class="opacity-75">Total Activities</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">{{ round(($totalCategories + $totalProducts + $totalSliders + $totalUsers + $totalContacts) / 30) }}</h4>
                            <small class="opacity-75">Daily Avg.</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-1">↑ 16%</h4>
                            <small class="opacity-75">Growth Rate</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .card-hover {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .text-gradient {
        background: linear-gradient(45deg, #4e54c8, #8f94fb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e54c8, #8f94fb) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #00b09b, #96c93d) !important;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f7971e, #ffd200) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #3494e6, #ec6ead) !important;
    }
    
    .bg-gradient-danger {
        background: linear-gradient(135deg, #ff416c, #ff4b2b) !important;
    }
    
    .progress {
        border-radius: 10px;
        background-color: rgba(0,0,0,0.05);
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
</style>

@endsection