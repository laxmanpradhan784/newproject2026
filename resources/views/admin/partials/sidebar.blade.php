<aside class="admin-sidebar police-sidebar" style="width: 250px; min-height: 87vh;">
    
<!-- Glowing User Badge -->
<div class="user-badge-section p-3 border-bottom border-secondary" style="background: linear-gradient(90deg, rgba(0,0,0,0.3) 0%, rgba(67,97,238,0.1) 100%);">
    <div class="d-flex align-items-center">
        <div class="user-avatar-glow position-relative me-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #4361ee, #7209b7); 
                        animation: pulse-glow 2s infinite;">
                <i class="bi bi-person-fill text-white"></i>
            </div>
            <div class="avatar-ring"></div>
        </div>
        <div>
            <div class="text-white fw-semibold" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                {{ auth()->user()->name }}
            </div>
            <span class="badge bg-gradient-danger px-2 py-1 mt-1" 
                  style="background: linear-gradient(45deg, #ff6b6b, #ee5a52); 
                         animation: badge-shine 3s infinite;
                         box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);">
                <i class="bi bi-shield-check me-1"></i>{{ strtoupper(auth()->user()->role) }}
            </span>
        </div>
    </div>
</div>

<style>
    /* Glowing pulse animation for avatar */
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 5px rgba(67, 97, 238, 0.5),
                        0 0 10px rgba(67, 97, 238, 0.3),
                        0 0 15px rgba(67, 97, 238, 0.1);
        }
        50% {
            box-shadow: 0 0 10px rgba(67, 97, 238, 0.8),
                        0 0 20px rgba(67, 97, 238, 0.5),
                        0 0 30px rgba(67, 97, 238, 0.2);
        }
    }
    
    /* Shine effect for badge */
    @keyframes badge-shine {
        0%, 100% {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            transform: scale(1);
        }
        50% {
            background: linear-gradient(45deg, #ff8787, #ff6b6b);
            transform: scale(1.02);
        }
    }
    
    /* Avatar ring animation */
    .avatar-ring {
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        border: 2px solid rgba(67, 97, 238, 0.3);
        border-radius: 50%;
        animation: ring-rotate 4s linear infinite;
    }
    
    @keyframes ring-rotate {
        0% {
            transform: rotate(0deg);
            border-color: rgba(67, 97, 238, 0.3);
        }
        25% {
            border-color: rgba(114, 9, 183, 0.3);
        }
        50% {
            border-color: rgba(67, 97, 238, 0.5);
        }
        75% {
            border-color: rgba(114, 9, 183, 0.5);
        }
        100% {
            transform: rotate(360deg);
            border-color: rgba(67, 97, 238, 0.3);
        }
    }
    
    /* Smooth hover effects */
    .user-avatar-glow:hover .rounded-circle {
        animation: pulse-glow 0.5s infinite;
    }
    
    .user-badge-section {
        transition: all 0.3s ease;
    }
    
    .user-badge-section:hover {
        background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, rgba(67,97,238,0.2) 100%);
        transform: translateX(5px);
    }
</style>


    <!-- Navigation Links - Police Style -->
    <div class="sidebar-nav p-3">
        <div class="section-title mb-3">
            <i class="bi bi-list-task me-2"></i>
            <span class="text-uppercase small fw-bold">NAVIGATION</span>
        </div>
        
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3 active">
                    <div class="nav-icon me-3">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div class="nav-text">DASHBOARD</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-count">NEW</span>
                    </div>
                </a>
            </li>

            <!-- Sliders -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.sliders')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="nav-text">SLIDER</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-count">152</span>
                    </div>
                </a>
            </li>

            <!-- categories -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.categories')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="nav-text">CATEGORIES</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-count">152</span>
                    </div>
                </a>
            </li>

            

            <!-- Products -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.products')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="nav-text">PRODUCTS</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-count">152</span>
                    </div>
                </a>
            </li>

            <!-- Contacts -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.contacts')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="nav-text">ENQUIRIES</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-alert">15</span>
                    </div>
                </a>
            </li>

            <!-- Users -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.users') }}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="nav-text">USERS</div>
                    <div class="ms-auto">
                        <span class="badge police-badge-count">89</span>
                    </div>
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.site-settings')}}" class="nav-link police-nav-link d-flex align-items-center px-3 py-2 rounded-3">
                    <div class="nav-icon me-3">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div class="nav-text">INFORMATION</div>
                    <div class="ms-auto">
                        <i class="bi bi-chevron-right small"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <!-- System Info -->
    <div class="system-info p-3 border-top border-secondary" style="background: rgba(0, 0, 0, 0.2);">
        <div class="section-title mb-2">
            <i class="bi bi-cpu me-2"></i>
            <span class="text-uppercase small fw-bold">SYSTEM</span>
        </div>
        <div class="system-stats">
            <div class="stat-item d-flex justify-content-between mb-1">
                <small class="text-muted">CPU Usage</small>
                <small class="text-success">42%</small>
            </div>
            <div class="stat-item d-flex justify-content-between mb-1">
                <small class="text-muted">Memory</small>
                <small class="text-warning">68%</small>
            </div>
            <div class="stat-item d-flex justify-content-between">
                <small class="text-muted">Uptime</small>
                <small class="text-info">24d 16h</small>
            </div>
        </div>
    </div>

    <!-- Emergency Logout -->
        <div class="emergency-section p-3">
            <form id="admin-emergency-logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-emergency w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-power me-2"></i>
                    <span>EMERGENCY LOGOUT</span>
                </button>
            </form>
        </div>

</aside>

<style>
    /* Police Sidebar */
    .police-sidebar {
        background: linear-gradient(180deg, #0f172a 0%, #1a1a2e 100%);
        color: white;
        border-right: 3px solid #4361ee;
        box-shadow: 5px 0 20px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
    }
    
    .police-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent, 
            #4361ee, 
            #4cc9f0, 
            #7209b7, 
            #4361ee, 
            transparent
        );
        animation: sidebarScan 4s linear infinite;
    }
    
    /* Police Shield Logo */
    .police-shield {
        position: relative;
    }
    
    .shield-bg {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #4361ee, #7209b7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 5px 20px rgba(114, 9, 183, 0.5);
        animation: shieldPulse 3s infinite;
    }
    
    .shield-ring {
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border: 2px solid #4cc9f0;
        border-radius: 50%;
        animation: ringRotate 10s linear infinite;
    }
    
    /* System Status */
    .system-status {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
    }
    
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        animation: statusPulse 2s infinite;
    }
    
    .status-dot.active {
        background: #10b981;
    }
    
    .status-text {
        color: #4cc9f0;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    /* User Badge */
    .police-badge {
        position: relative;
    }
    
    .badge-icon {
        background: linear-gradient(135deg, #4cc9f0, #4361ee);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .badge-rank {
        position: absolute;
        bottom: -5px;
        right: -5px;
        background: #f72585;
        color: white;
        font-size: 0.6rem;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: bold;
        border: 2px solid #1a1a2e;
    }
    
    .user-id {
        color: #94a3b8;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }
    
    .connection-status {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 3px;
    }
    
    .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    
    .dot.connected {
        background: #10b981;
        animation: blink 1.5s infinite;
    }
    
    /* Quick Access Buttons */
    .btn-access {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(67, 97, 238, 0.4);
        border-radius: 6px;
        color: #e2e8f0;
        padding: 8px 4px;
        transition: all 0.3s ease;
    }
    
    .btn-access:hover {
        background: rgba(67, 97, 238, 0.2);
        border-color: #4cc9f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 201, 240, 0.2);
    }
    
    .btn-access i {
        color: #4cc9f0;
        font-size: 1.2rem;
    }
    
    .btn-access span {
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    /* Navigation Links */
    .section-title {
        color: #94a3b8;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .police-nav-link {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(67, 97, 238, 0.2);
        color: #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .police-nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #4361ee;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .police-nav-link:hover {
        background: rgba(67, 97, 238, 0.15);
        border-color: rgba(76, 201, 240, 0.5);
        transform: translateX(5px);
    }
    
    .police-nav-link:hover::before {
        transform: translateX(0);
    }
    
    .police-nav-link.active {
        background: rgba(67, 97, 238, 0.25);
        border-color: #4361ee;
        color: white;
    }
    
    .police-nav-link.active::before {
        transform: translateX(0);
    }
    
    .nav-icon {
        color: #4cc9f0;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }
    
    .nav-text {
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    /* Badges */
    .police-badge-count {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: white;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .police-badge-alert {
        background: linear-gradient(135deg, #f72585, #b5179e);
        color: white;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: alertPulse 1.5s infinite;
    }
    
    /* System Stats */
    .system-stats {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        padding: 10px;
        border: 1px solid rgba(67, 97, 238, 0.2);
    }
    
    /* Emergency Button */
    .btn-emergency {
        background: linear-gradient(135deg, #f72585, #b5179e);
        border: 2px solid rgba(247, 37, 133, 0.4);
        color: white;
        border-radius: 8px;
        padding: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-emergency:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(247, 37, 133, 0.4);
        border-color: #f72585;
    }
    
    .btn-emergency::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-emergency:hover::before {
        left: 100%;
    }
    
    /* Animations */
    @keyframes sidebarScan {
        0% {
            background-position: -100% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }
    
    @keyframes shieldPulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 5px 20px rgba(114, 9, 183, 0.5);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(114, 9, 183, 0.7);
        }
    }
    
    @keyframes ringRotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    @keyframes statusPulse {
        0%, 100% {
            opacity: 1;
            box-shadow: 0 0 5px #10b981;
        }
        50% {
            opacity: 0.7;
            box-shadow: 0 0 10px #10b981;
        }
    }
    
    @keyframes alertPulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .police-sidebar {
            width: 70px;
        }
        
        .police-sidebar .nav-text,
        .police-sidebar .status-text,
        .police-sidebar .user-id,
        .police-sidebar .system-stats,
        .police-sidebar .btn-emergency span,
        .police-sidebar .section-title span,
        .police-sidebar .system-status span:last-child,
        .police-sidebar h5,
        .police-sidebar small {
            display: none;
        }
        
        .police-sidebar .police-shield {
            width: 40px;
            height: 40px;
        }
        
        .police-sidebar .shield-bg i {
            font-size: 1.2rem;
        }
        
        .police-sidebar .user-badge-section {
            padding: 10px;
        }
        
        .police-sidebar .quick-access {
            display: none;
        }
        
        .police-sidebar .badge-rank {
            display: none;
        }
    }
</style>