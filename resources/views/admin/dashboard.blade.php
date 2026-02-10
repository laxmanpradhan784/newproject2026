@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-2">
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

            <!-- Total Orders -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-circle bg-gradient-success bg-opacity-10">
                                <iconify-icon icon="bi:cart-check" class="text-success"
                                    style="font-size: 24px;"></iconify-icon>
                            </div>
                            <div class="text-end">
                                @php
                                    use App\Models\Order;

                                    // Count orders created in the last 30 days
                                    $recentOrdersCount = Order::where('created_at', '>=', now()->subDays(30))->count();

                                    // Count orders created in the previous 30 days (31-60 days ago)
                                    $previousOrdersCount = Order::whereBetween('created_at', [
                                        now()->subDays(60),
                                        now()->subDays(30),
                                    ])->count();

                                    // Calculate growth percentage (avoid division by zero)
                                    if ($previousOrdersCount > 0) {
                                        $growthPercentage = round(
                                            (($recentOrdersCount - $previousOrdersCount) / $previousOrdersCount) * 100,
                                        );
                                    } else {
                                        $growthPercentage = $recentOrdersCount > 0 ? 100 : 0;
                                    }

                                    // Determine badge color based on growth
                                    if ($growthPercentage > 0) {
                                        $badgeClass = 'bg-success bg-opacity-10 text-success';
                                        $badgeText = '+' . $growthPercentage . '%';
                                    } elseif ($growthPercentage < 0) {
                                        $badgeClass = 'bg-danger bg-opacity-10 text-danger';
                                        $badgeText = $growthPercentage . '%';
                                    } else {
                                        $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                        $badgeText = '0%';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalOrders ?? Order::count() }}</h2>
                        <p class="text-muted mb-2">Total Orders</p>
                        <div class="progress" style="height: 4px;">
                            @php
                                // Calculate progress bar width based on pending orders percentage
                                $totalOrdersCount = $totalOrders ?? Order::count();
                                $pendingOrdersCount = Order::where('status', 'pending')->count();
                                $progressWidth =
                                    $totalOrdersCount > 0
                                        ? min(100, round(($pendingOrdersCount / $totalOrdersCount) * 100))
                                        : 0;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressWidth }}%">
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <small class="text-muted">
                                <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                                Today: {{ $todayOrders ?? Order::whereDate('created_at', today())->count() }}
                            </small>
                            <small class="text-danger">
                                Pending: {{ $pendingOrders ?? Order::where('status', 'pending')->count() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Summary -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-circle bg-gradient-primary bg-opacity-10">
                                <iconify-icon icon="bi:credit-card" class="text-primary"
                                    style="font-size: 24px;"></iconify-icon>
                            </div>
                            <div class="text-end">
                                @php
                                    use App\Models\Payment;

                                    // Count payments from last 30 days
                                    $recentPayments = Payment::where('created_at', '>=', now()->subDays(30))->count();
                                    $previousPayments = Payment::whereBetween('created_at', [
                                        now()->subDays(60),
                                        now()->subDays(30),
                                    ])->count();

                                    // Calculate growth
                                    if ($previousPayments > 0) {
                                        $growth = round(
                                            (($recentPayments - $previousPayments) / $previousPayments) * 100,
                                        );
                                    } else {
                                        $growth = $recentPayments > 0 ? 100 : 0;
                                    }

                                    // Badge styling
                                    if ($growth > 0) {
                                        $badgeClass = 'bg-success bg-opacity-10 text-success';
                                        $badgeText = '+' . $growth . '%';
                                    } elseif ($growth < 0) {
                                        $badgeClass = 'bg-danger bg-opacity-10 text-danger';
                                        $badgeText = $growth . '%';
                                    } else {
                                        $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                        $badgeText = '0%';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1">{{ Payment::count() }}</h2>
                        <p class="text-muted mb-2">Total Payments</p>
                        <div class="progress" style="height: 4px;">
                            @php
                                $totalPayments = Payment::count();
                                $successfulPayments = Payment::where('status', 'captured')->count();
                                $progressWidth =
                                    $totalPayments > 0 ? round(($successfulPayments / $totalPayments) * 100) : 0;
                            @endphp
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressWidth }}%">
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <small class="text-muted">
                                <iconify-icon icon="uil:check-circle" class="me-1"></iconify-icon>
                                Success: {{ $successfulPayments }}
                            </small>
                            <small class="text-danger">
                                Failed: {{ Payment::where('status', 'failed')->count() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Returns Overview -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-circle bg-gradient-warning bg-opacity-10">
                                <iconify-icon icon="bi:arrow-return-left" class="text-warning"
                                    style="font-size: 24px;"></iconify-icon>
                            </div>
                            <div class="text-end">
                                @php
                                    use App\Models\ReturnRequest;

                                    $recentReturns = ReturnRequest::where(
                                        'created_at',
                                        '>=',
                                        now()->subDays(30),
                                    )->count();
                                    $previousReturns = ReturnRequest::whereBetween('created_at', [
                                        now()->subDays(60),
                                        now()->subDays(30),
                                    ])->count();

                                    if ($previousReturns > 0) {
                                        $growth = round((($recentReturns - $previousReturns) / $previousReturns) * 100);
                                    } else {
                                        $growth = $recentReturns > 0 ? 100 : 0;
                                    }

                                    if ($growth > 0) {
                                        $badgeClass = 'bg-danger bg-opacity-10 text-danger';
                                        $badgeText = '+' . $growth . '%';
                                    } elseif ($growth < 0) {
                                        $badgeClass = 'bg-success bg-opacity-10 text-success';
                                        $badgeText = $growth . '%';
                                    } else {
                                        $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                        $badgeText = '0%';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1">{{ ReturnRequest::count() }}</h2>
                        <p class="text-muted mb-2">Total Returns</p>
                        <div class="progress" style="height: 4px;">
                            @php
                                $totalReturns = ReturnRequest::count();
                                $pendingReturns = ReturnRequest::where('status', 'pending')->count();
                                $progressWidth = $totalReturns > 0 ? round(($pendingReturns / $totalReturns) * 100) : 0;
                            @endphp
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progressWidth }}%">
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <small class="text-muted">
                                <iconify-icon icon="uil:clock" class="me-1"></iconify-icon>
                                Pending: {{ $pendingReturns }}
                            </small>
                            <small class="text-success">
                                Resolved:
                                {{ ReturnRequest::whereIn('status', ['refunded', 'replaced', 'completed', 'approved'])->count() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-circle bg-gradient-primary bg-opacity-10">
                                <iconify-icon icon="material-symbols:category" class="text-primary"
                                    style="font-size: 24px;"></iconify-icon>
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
                                <iconify-icon icon="bi:box-seam" class="text-success"
                                    style="font-size: 24px;"></iconify-icon>
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
                                <iconify-icon icon="ic:outline-slider" class="text-warning"
                                    style="font-size: 24px;"></iconify-icon>
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

            <!-- Coupons Overview -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-circle bg-gradient-info bg-opacity-10">
                                <iconify-icon icon="bi:tag" class="text-info" style="font-size: 24px;"></iconify-icon>
                            </div>
                            <div class="text-end">
                                @php
                                    use App\Models\Coupon;

                                    $activeCoupons = Coupon::where('status', 'active')->count();
                                    $totalCoupons = Coupon::count();
                                    $activePercentage =
                                        $totalCoupons > 0 ? round(($activeCoupons / $totalCoupons) * 100) : 0;
                                @endphp
                                <span class="badge bg-info bg-opacity-10 text-info">{{ $activePercentage }}% Active</span>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalCoupons }}</h2>
                        <p class="text-muted mb-2">Total Coupons</p>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $activePercentage }}%"></div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <small class="text-muted">
                                <iconify-icon icon="uil:check-circle" class="me-1"></iconify-icon>
                                Active: {{ $activeCoupons }}
                            </small>
                            <small class="text-warning">
                                Expiring:
                                {{ Coupon::where('status', 'active')->where('end_date', '<=', now()->addDays(7))->count() }}
                            </small>
                        </div>
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
                                    <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-danger"
                                        style="font-size: 24px;"></iconify-icon>
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
                            <p class="mb-4 opacity-75">Overall platform growth in the last 30 days shows positive trends
                                across all metrics.</p>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="fw-bold mb-1">
                                    {{ $totalCategories + $totalProducts + $totalSliders + $totalUsers + $totalContacts }}
                                </h4>
                                <small class="opacity-75">Total Activities</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-bold mb-1">
                                    {{ round(($totalCategories + $totalProducts + $totalSliders + $totalUsers + $totalContacts) / 30) }}
                                </h4>
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

            {{-- <!-- Performance Summary Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100 card-hover bg-gradient-primary text-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-3">Platform Performance</h5>
                            <p class="mb-4 opacity-75">Real-time performance metrics for the last 30 days</p>
                        </div>

                        @php
                            // Remove the "use" statements and use full namespace or existing variables

                            // Calculate total activities using variables passed from controller
                            $totalActivitiesCount =
                                $totalCategories + $totalProducts + $totalSliders + $totalUsers + $totalContacts;

                            // Get counts from database for recent activities
                            $recentCategories = \App\Models\Category::where(
                                'created_at',
                                '>=',
                                now()->subDays(30),
                            )->count();
                            $recentProducts = \App\Models\Product::where(
                                'created_at',
                                '>=',
                                now()->subDays(30),
                            )->count();
                            $recentSliders = \App\Models\Slider::where('created_at', '>=', now()->subDays(30))->count();
                            $recentUsers = \App\Models\User::where('role', '!=', 'admin')
                                ->where('created_at', '>=', now()->subDays(30))
                                ->count();
                            $recentContacts = \App\Models\Contact::where(
                                'created_at',
                                '>=',
                                now()->subDays(30),
                            )->count();

                            $recentTotal =
                                $recentCategories + $recentProducts + $recentSliders + $recentUsers + $recentContacts;

                            // Calculate previous period activities (31-60 days ago)
                            $previousCategories = \App\Models\Category::whereBetween('created_at', [
                                now()->subDays(60),
                                now()->subDays(30),
                            ])->count();
                            $previousProducts = \App\Models\Product::whereBetween('created_at', [
                                now()->subDays(60),
                                now()->subDays(30),
                            ])->count();
                            $previousSliders = \App\Models\Slider::whereBetween('created_at', [
                                now()->subDays(60),
                                now()->subDays(30),
                            ])->count();
                            $previousUsers = \App\Models\User::where('role', '!=', 'admin')
                                ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
                                ->count();
                            $previousContacts = \App\Models\Contact::whereBetween('created_at', [
                                now()->subDays(60),
                                now()->subDays(30),
                            ])->count();

                            $previousTotal =
                                $previousCategories +
                                $previousProducts +
                                $previousSliders +
                                $previousUsers +
                                $previousContacts;

                            // Calculate growth percentage
                            if ($previousTotal > 0) {
                                $growthPercentage = round((($recentTotal - $previousTotal) / $previousTotal) * 100);
                            } else {
                                $growthPercentage = $recentTotal > 0 ? 100 : 0;
                            }

                            // Calculate daily average
                            $dailyAverage = $recentTotal > 0 ? round($recentTotal / 30) : 0;

                            // Get additional metrics
                            $recentOrders = \App\Models\Order::where('created_at', '>=', now()->subDays(30))->count();
                            $recentRevenue =
                                \App\Models\Payment::where('status', 'captured')
                                    ->where('created_at', '>=', now()->subDays(30))
                                    ->sum('amount') / 100;

                            $previousRevenue =
                                \App\Models\Payment::where('status', 'captured')
                                    ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
                                    ->sum('amount') / 100;

                            $revenueGrowth =
                                $previousRevenue > 0
                                    ? round((($recentRevenue - $previousRevenue) / $previousRevenue) * 100)
                                    : ($recentRevenue > 0
                                        ? 100
                                        : 0);

                            // Top activity areas
                            $activityAreas = [
                                ['name' => 'Products', 'count' => $recentProducts],
                                ['name' => 'Users', 'count' => $recentUsers],
                                ['name' => 'Orders', 'count' => $recentOrders],
                                ['name' => 'Contacts', 'count' => $recentContacts],
                            ];

                            // Sort by count descending
                            usort($activityAreas, function ($a, $b) {
                                return $b['count'] - $a['count'];
                            });

                            // Take top 3
                            $topActivities = array_slice($activityAreas, 0, 3);
                        @endphp

                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <h4 class="fw-bold mb-1">{{ $totalActivitiesCount }}</h4>
                                <small class="opacity-75">Total Entities</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-bold mb-1">{{ $dailyAverage }}</h4>
                                <small class="opacity-75">Daily Activities</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-bold mb-1">
                                    @if ($growthPercentage > 0)
                                        ↑{{ $growthPercentage }}%
                                    @elseif($growthPercentage < 0)
                                        ↓{{ abs($growthPercentage) }}%
                                    @else
                                        0%
                                    @endif
                                </h4>
                                <small class="opacity-75">Growth Rate</small>
                            </div>
                        </div>

                        <!-- Recent Activity Highlights -->
                        <div class="mt-3 pt-3 border-top border-white border-opacity-25">
                            <small class="opacity-75 d-block mb-2">Recent Highlights (30 days)</small>
                            <div class="row g-2">
                                @if ($recentRevenue > 0)
                                    <div class="col-6">
                                        <div class="p-2 rounded-2 bg-white bg-opacity-10">
                                            <small
                                                class="d-block fw-medium">₹{{ number_format($recentRevenue, 0) }}</small>
                                            <small class="opacity-75">Revenue</small>
                                            @if ($revenueGrowth > 0)
                                                <small class="d-block text-success">↑{{ $revenueGrowth }}%</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($recentOrders > 0)
                                    <div class="col-6">
                                        <div class="p-2 rounded-2 bg-white bg-opacity-10">
                                            <small class="d-block fw-medium">{{ $recentOrders }}</small>
                                            <small class="opacity-75">Orders</small>
                                        </div>
                                    </div>
                                @endif

                                @foreach ($topActivities as $activity)
                                    @if ($activity['count'] > 0)
                                        <div class="col-4">
                                            <div class="p-2 rounded-2 bg-white bg-opacity-10">
                                                <small class="d-block fw-medium">{{ $activity['count'] }}</small>
                                                <small class="opacity-75">{{ $activity['name'] }}</small>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <small class="opacity-75">
                                    <iconify-icon icon="uil:chart-growth" class="me-1"></iconify-icon>
                                    {{ $recentTotal }} activities in 30 days
                                </small>
                                <small class="opacity-75">
                                    Updated: {{ now()->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

    </div>

    <style>
        .card-hover {
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
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
            background-color: rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            border-radius: 10px;
        }

        .bg-opacity-10 {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }
    </style>

@endsection
