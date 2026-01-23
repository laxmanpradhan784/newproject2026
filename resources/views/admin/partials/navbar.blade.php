<nav class="navbar navbar-expand-lg police-navbar" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-bottom: 3px solid #4361ee;">
    <div class="container-fluid px-3">
        <!-- Left: Menu Toggle -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler police-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <div class="police-badge">
                    <i class="bi bi-list"></i>
                </div>
                <span class="ms-2 d-none d-md-inline">MENU</span>
            </button>
            
            <!-- Quick Stats -->
            <div class="quick-stats d-none d-lg-flex">
                <div class="stat-item">
                    <div class="stat-label">ALERTS</div>
                    <div class="stat-value text-danger">3</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">ONLINE</div>
                    <div class="stat-value text-success">42</div>
                </div>
            </div>
        </div>
        
        <!-- Center: Police Shield Brand -->
        <a class="navbar-brand mx-auto police-brand" href="/">
            <div class="shield-container">
                <div class="shield-icon">
                    <i class="bi bi-shield-shaded"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-main">ADMIN COMMAND</span>
                    <span class="brand-sub">SECURE PORTAL</span>
                </div>
            </div>
            <div class="security-status">
                <span class="status-dot bg-success"></span>
                <span class="status-text">SYSTEM SECURE</span>
            </div>
        </a>
        
        <!-- Right: Control Panel -->
        <div class="police-controls">
            <!-- Notifications -->
            <div class="notification-badge">
                <button class="btn police-btn-icon" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="notification-count">5</span>
                </button>
            </div>
            
            <!-- Search -->
            <div class="search-box d-none d-md-block">
                <div class="input-group input-group-sm">
                    <span class="input-group-text police-input-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control police-input" placeholder="Search...">
                </div>
            </div>
            
            <!-- User Dropdown -->
            <div class="dropdown police-dropdown ms-3">
                <button class="btn police-user-btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <div class="user-badge">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="user-info ms-2 text-start">
                        <div class="user-name">ADMIN OFFICER</div>
                        <div class="user-role">SUPER ADMIN</div>
                    </div>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end police-dropdown-menu">
                    <li class="dropdown-header">
                        <div class="d-flex align-items-center">
                            <div class="user-badge-sm me-2">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold">ADMIN USER</div>
                                <small class="text-muted">ID: ADMIN-001</small>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider police-divider"></li>
                    <li>
                        <a class="dropdown-item police-dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person me-2"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item police-dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item police-dropdown-item" href="#">
                            <i class="bi bi-shield-lock me-2"></i>
                            <span>Security</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider police-divider"></li>
                    <li>
                        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item police-dropdown-item police-logout" href="#"
                        onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            <span>Logout System</span>
                            <span class="badge badge-pulse">SECURE</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Police Style Navbar */
    .police-navbar {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        padding: 8px 0;
        position: relative;
        z-index: 1030;
    }
    
    .police-navbar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            #4361ee, 
            #4cc9f0, 
            #7209b7, 
            #4361ee, 
            transparent
        );
        animation: scan 3s linear infinite;
    }
    
    /* Menu Toggle */
    .police-toggler {
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(67, 97, 238, 0.6);
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        color: #e2e8f0;
        font-weight: 500;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .police-toggler:hover {
        background: rgba(67, 97, 238, 0.15);
        border-color: #4cc9f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 201, 240, 0.3);
    }
    
    .police-badge {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    /* Quick Stats */
    .quick-stats {
        margin-left: 15px;
        border-left: 1px solid rgba(67, 97, 238, 0.3);
        padding-left: 15px;
    }
    
    .stat-item {
        margin: 0 10px;
        text-align: center;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.7rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    
    .stat-value {
        font-weight: 700;
        font-size: 1.1rem;
        text-shadow: 0 0 10px currentColor;
    }
    
    /* Police Shield Brand */
    .police-brand {
        padding: 5px 25px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 12px;
        border: 2px solid rgba(67, 97, 238, 0.4);
        position: relative;
        transition: all 0.3s ease;
    }
    
    .police-brand:hover {
        background: rgba(0, 0, 0, 0.4);
        border-color: #4cc9f0;
        box-shadow: 0 5px 20px rgba(76, 201, 240, 0.3);
    }
    
    .shield-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .shield-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #4361ee, #7209b7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 15px rgba(114, 9, 183, 0.4);
        animation: pulse 2s infinite;
    }
    
    .brand-text {
        display: flex;
        flex-direction: column;
        text-align: left;
    }
    
    .brand-main {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 2px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.7);
    }
    
    .brand-sub {
        color: #4cc9f0;
        font-size: 0.75rem;
        letter-spacing: 2.5px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .security-status {
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        background: rgba(22, 33, 62, 0.9);
        padding: 2px 8px;
        border-radius: 10px;
        border: 1px solid rgba(76, 201, 240, 0.3);
    }
    
    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin-right: 5px;
        animation: blink 1.5s infinite;
    }
    
    .status-text {
        color: #4cc9f0;
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    /* Control Panel */
    .police-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .police-btn-icon {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(67, 97, 238, 0.4);
        border-radius: 6px;
        color: #e2e8f0;
        padding: 8px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .police-btn-icon:hover {
        background: rgba(67, 97, 238, 0.2);
        color: white;
        transform: translateY(-2px);
    }
    
    .notification-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #f72585;
        color: white;
        font-size: 0.65rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: 2px solid #1a1a2e;
    }
    
    /* Search Box */
    .search-box {
        width: 200px;
    }
    
    .police-input-icon {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(67, 97, 238, 0.5);
        border-right: none;
        color: #4cc9f0;
    }
    
    .police-input {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(67, 97, 238, 0.5);
        border-left: none;
        color: white;
        font-size: 0.85rem;
    }
    
    .police-input::placeholder {
        color: #94a3b8;
    }
    
    /* User Dropdown */
    .police-user-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(76, 201, 240, 0.4);
        border-radius: 8px;
        padding: 6px 12px;
        color: white;
        transition: all 0.3s ease;
    }
    
    .police-user-btn:hover {
        background: rgba(76, 201, 240, 0.15);
        border-color: #4cc9f0;
    }
    
    .user-badge {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #4cc9f0, #4361ee);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .user-name {
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .user-role {
        color: #4cc9f0;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    
    /* Dropdown Menu */
    .police-dropdown-menu {
        background: #1a1a2e;
        border: 2px solid #4361ee;
        border-radius: 10px;
        padding: 10px;
        margin-top: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
        min-width: 240px;
        backdrop-filter: blur(10px);
    }
    
    .dropdown-header {
        padding: 10px 15px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        margin-bottom: 8px;
    }
    
    .user-badge-sm {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #4cc9f0, #4361ee);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }
    
    .police-dropdown-item {
        color: #e2e8f0;
        padding: 10px 12px;
        border-radius: 6px;
        margin: 2px 0;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .police-dropdown-item:hover {
        background: rgba(67, 97, 238, 0.25);
        color: white;
        transform: translateX(5px);
    }
    
    .police-dropdown-item i {
        color: #4cc9f0;
        width: 20px;
    }
    
    .badge-pulse {
        background: linear-gradient(135deg, #4361ee, #7209b7);
        color: white;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
        margin-left: auto;
        animation: pulse 2s infinite;
    }
    
    .police-divider {
        border-color: rgba(67, 97, 238, 0.3);
        margin: 8px 0;
    }
    
    .police-logout {
        color: #f72585 !important;
        font-weight: 600;
        border: 1px solid rgba(247, 37, 133, 0.3);
        background: rgba(247, 37, 133, 0.1);
    }
    
    /* Animations */
    @keyframes scan {
        0% {
            background-position: -100% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }
    
    @keyframes pulse {
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
    @media (max-width: 992px) {
        .quick-stats {
            display: none !important;
        }
        
        .search-box {
            display: none !important;
        }
        
        .brand-text {
            display: none;
        }
        
        .security-status {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .user-info {
            display: none;
        }
        
        .police-user-btn {
            padding: 6px 8px;
        }
        
        .police-brand {
            padding: 5px 10px;
        }
    }
</style>